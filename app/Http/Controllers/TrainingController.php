<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use App\Photo;
use App\Tag;
use App\Training;
use App\Transformers\TrainingTransformer;
use Illuminate\Http\Request;
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
        $trainings = $club->trainings()->with('pinnedPhotos','genres')->withCount('teachers', 'histories')->paginate(2);

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
                'pinned' => isset($decode->pictures[$i]->pinned) && $decode->pictures[$i]->pinned ? 'Y' : 'N',
                'top_percentage' => isset($decode->pictures[$i]->pinned) && $decode->pictures[$i]->pinned ? $decode->crop : 0,
            ];

            Photo::attachTagById($decode->pictures[$i]->id, Tag::TRAINING_ID);
        }

        $training->photos()->sync($photo_id_array);
        $training->teachers()->sync($decode->teachers);
        $training->genres()->sync($decode->genres);

        return Response::json([
            'code' => 0,
            'message' => 'Successfully added training',
            'result' => $training,
        ], 200);
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
                'pinned' => isset($decode->pictures[$i]->pinned) && $decode->pictures[$i]->pinned ? 'Y' : 'N',
                'top_percentage' => isset($decode->pictures[$i]->pinned) && $decode->pictures[$i]->pinned ? $decode->crop : 0,
            ];

            Photo::attachTagById($decode->pictures[$i]->id, Tag::TRAINING_ID);
        }

        $training->photos()->sync($photo_id_array);
        $training->teachers()->sync($decode->teachers);
        $training->genres()->sync($decode->genres);

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
