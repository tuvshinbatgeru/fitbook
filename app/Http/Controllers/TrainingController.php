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

    
    public function index(Club $club, Request $request)
    {
        $decode = json_decode($request->data);
        $trainings = $club->trainings;
        $trainings->load('teachers', 'pinnedPhotos');

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
    public function store(Club $club, Request $request)
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
            $photo_id_array[$decode->pictures[$i]->id] = ['pinned' => $decode->pictures[$i]->pinned ? 'Y' : 'N'];
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
    public function show($id)
    {
        //
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
