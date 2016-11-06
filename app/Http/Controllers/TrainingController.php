<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use App\Photo;
use App\Tag;
use App\Training;
use App\Transformers\TrainingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class TrainingController extends Controller
{
    /*
    * @var App\Transformers\TrainingTransformer
    */
    protected $trainingTransformer;

    function __construct(TrainingTransformer $trainingTransformer)
    {
        $this->trainingTransformer = $trainingTransformer;
    }

    public function index()
    {
        
    }

    public function forContext(Club $club, Request $request)
    {
        $decode = json_decode($request->data);
        $trainings = $club->trainings()->with('pinnedPhotos', 'teachers')->get();

        foreach ($trainings as $training) {

            $training->selected = false;

            if(empty($decode->selected)) {
                continue;
            }

            for($i = 0; $i < count($decode->selected); $i ++) {
                if($decode->selected[$i] == $training->id)
                    $training->selected = true;
            }
        }

        return Response::json([
            'result' => $trainings,
        ], 200);
    }
    
    public function clubTrainings(Club $club, Request $request)
    {
        $genre = $request->genre;
        $queryStr = $club->trainings();
        $queryStr = $queryStr->with('genres');
        
        if(empty($genre)) {
            
        } else {
            $queryStr = $queryStr->whereHas('genres', function ($query) use ($genre){
                $query->where('name_en', $genre);
            });
        }

        $queryStr = $queryStr->with('pinnedPhotos')
                             ->withCount('histories', 'teachers');

        $trainings = $queryStr->paginate(6);

        foreach ($trainings->items() as $training) {
            $training->firstTwoTeachers;
        }

        return Response::json([
            'result' => $trainings,
        ], 200);
    }

    public function adjustments(Training $training)
    {
        return Response::json([
            'code' => 0,
            'result' => $training->histories,
        ]);
    }

    public function teachers(Training $training)
    {
        return Response::json([
            'code' => 0,
            'result' => $training->teachers()->with('avatarSmall')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $decode = json_decode($request->data);
        $data = $this->trainingTransformer->transform($decode);
        if(Training::where('name', '=', $data['name'])->exists()) 
        return Response::json([
            'code' => 1,
            'message' => 'Training name duplicated',
        ]); 

        $training = new Training($data);
        $training->save();

        $photo_id_array = [];
        for ($i = 0; $i < count($decode->pictures); $i++) {
            $photo_id_array[$decode->pictures[$i]->id] = [
                'pinned' => $this->isPinned($decode->pictures[$i]) ? 'Y' : 'N',
                'top' => $this->isPinned($decode->pictures[$i]) ? $data['top'] : 0,
                'left' => $this->isPinned($decode->pictures[$i]) ? $data['left'] : 0,
            ];

            Photo::attachTagById($decode->pictures[$i]->id, Tag::TRAINING_ID);
        }

        $training->photos()->sync($photo_id_array);
        $training->teachers()->sync($decode->teachers);


        /**
            Teacher used by training notification
        */

        $training->genres()->sync($decode->genres);
        
        Club::find($training->club_id)->capabilities()->syncWithoutDetaching($decode->genres);

        return Response::json([
            'code' => 0,
            'message' => 'Successfully added training',
            'result' => $training,
        ], 200);
    }

    public function isPinned($photo)
    {
        return isset($photo->pinned) && $photo->pinned ? true : false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        $training->teachers;
        $training->genres;
        $training->photos;

        return Response::json([
            'code' => 0,
            'result' => $training,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateTraining(Request $request)
    {
        $decode = json_decode($request->data);
        $data = $this->trainingTransformer->transform($decode);

        if(Training::where('name', '=', $data['name'])->
                where('id', '<>' , $data['id'])->exists()) 
        return Response::json([
            'code' => 1,
            'message' => 'Training name duplicated',
        ]); 

        $training = Training::find($data['id']);

        $before = new \App\Adjustment;
        $after = new \App\Adjustment;

        if($training->name != $data['name']) {
            $before->name = $training->name;
            $after->name = $data['name'];
            $training->name = $data['name'];
        }

        if($training->description != $data['description']) {
            $before->description = $training->description;
            $after->description = $data['description'];
            $training->description = $data['description'];
        }

        $training->save();

        $photo_id_array = [];
        for ($i = 0; $i < count($decode->pictures); $i++) {
            $photo_id_array[$decode->pictures[$i]->id] = [
                'pinned' => $this->isPinned($decode->pictures[$i]) ? 'Y' : 'N',
                'top' => $this->isPinned($decode->pictures[$i]) ? $data['top'] : 0,
                'left' => $this->isPinned($decode->pictures[$i]) ? $data['left'] : 0,
            ];

            Photo::attachTagById($decode->pictures[$i]->id, Tag::TRAINING_ID);
        }

        $training->photos()->sync($photo_id_array);

        $changes = $this->teachersDirty($training, $decode->teachers);
        
        if(count($changes['attached']) > 0) {
            $after->attached_teachers = $changes['attached'];  
        }

        if(count($changes['detached']) > 0) {
            $after->detached_teachers = $changes['detached'];  
        }

        $training->genres()->sync($decode->genres);
        Club::find($training->club_id)->capabilities()->syncWithoutDetaching($decode->genres);

        $training->histories()->attach(\Illuminate\Support\Facades\Auth::user()->id, [
            'before' => $before->toJson(),
            'after' => $after->toJson(),
        ]);

        return Response::json([
            'code' => 0,
            'message' => 'Successfully added training',
            'result' => $training,
        ], 200);
    }

    public function teachersDirty(Training $training, $ids)
    {
        $changes = [
            'attached' => [], 'detached' => [],
        ];

        $current = $training->teachers()->pluck('id')->all();
        
        $detach = array_diff($current, $ids);

        if (count($detach) > 0) {
            $this->detach($training->id, $detach);
            $changes['detached'] = $detach;
        }

        $changes = array_merge(
            $changes, $this->attachNew($ids, $current, false)
        );

        if (count($changes['attached']) > 0) {
            $training->teachers()->attach($changes['attached']);
        }

        return $changes;
    }

    protected function attachNew(array $records, array $current, $touch = true)
    {   
        $changes = ['attached' => []];

        foreach ($records as $id) {
            if (!in_array($id, $current)) {
                $changes['attached'][] = is_numeric($id) ? (int) $id : (string) $id;
            }
        }

        return $changes;
    }

    public function detach($trainingId, $ids)
    {
        $query = DB::table('training_teacher')
                    ->where('training_id', $trainingId)
                    ->whereIn('user_id', $ids)
                    ->delete();
        return $query;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
