<?php

namespace App\Http\Controllers;

use App\Club;
use App\Events\PlanAddedEvent;
use App\Http\Requests;
use App\LoyaltyPlan;
use App\Photo;
use App\Plan;
use App\PrimaryPlan;
use App\Reaction;
use App\Tag;
use App\Transformers\PlanTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Response;

class PlanController extends Controller
{
    protected $planTransformer;

    static public $lookup = [
        'primary' => 'App\PrimaryPlan',
        'loyalty' => 'App\LoyaltyPlan',
    ];

    function __construct(PlanTransformer $planTransformer)
    {
        $this->planTransformer = $planTransformer;
    }

    public function search(Request $request)
    {
        
    }

    public function toggleReaction(Plan $plan, Request $request)
    {
        $action = Reaction::makeModel($request->action_type);

        $response = Auth::user()->toggleReaction($action, $plan);        

        return Response::json([
            'code' => 0,
            'type' => $response,
            'message' => 'Hearthed :D', 
        ]);
    }

    public function simpleSearch(Club $club, Request $request)
    {
        $param = $request->q;
        $plans = Plan::where(function ($query) use ($param) {
            $query->where('name', 'like', '%'.$param.'%')
                  ->orWhere('description', 'like', '%'.$param.'%');
        })->get();

        return Response::json([
            'result' => $plans,
        ]);
    }

    public function teachers(Plan $plan)
    {
        return Response::json([
            'code' => 0,
            'result' => $plan->teachers()->with('avatarSmall')->get(),
        ]);
    }

    public function comments(Plan $plan)
    {
        $comments = $plan->comments()
                         ->with('user.avatarSmall')
                         ->withCount('thumbsup')
                         ->orderBy('thumbsup_count', 'DESC')
                         ->paginate(5);

        return Response::json([
            'code' => 0,
            'result' => $comments,
        ]);
    }

    public function forWidgets(Club $club, Request $request)
    {
        $plans = self::$lookup[$request->type]::with(['plan' => function ($query) use ($club) {
            $query->where('club_id', '=', $club->id)
                  ->with('pinnedPhotos', 'teachers', 'services', 'trainings');
        }])->get();

        return Response::json([
            'result' => $plans,
        ]);
    }

    public function index(Club $club, \App\Filters\PlanFilters $filters)
    {
        $query = $club->plans()
                ->with('planable', 'services', 'pinnedPhotos')
                ->withCount('heartsActions', 'comments', 'histories', 'visitors', 'subscriptions', 'teachers')
                ->where('planable_type', self::$lookup[$filters->getRequest()->type]);
        
        $plans = Plan::filter($query, $filters)->paginate(6);

        foreach ($plans->items() as $plan) {
            $plan->firstTwoTeachers;
        }

        return Response::json([
            'result' => $plans,
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

    public function store(Request $request)
    {
        $decode = json_decode($request->data);
        $data = $this->planTransformer->transform($decode);

        if(Plan::where('name', '=', $data['name'])->exists()) 
        return Response::json([
            'code' => 1,
            'message' => 'Plan name duplicated',
        ]); 

        $planable = self::createPlanable($data);

        $plan = new Plan($data);
        $plan->price = $data['isPrimary'] ? $data['price'] : $data['discount'];
        
        $planable->save();
        $planable->plan()->save($plan);
        $plan->planable = $planable;

        $photo_id_array = [];
        
        for ($i = 0; $i < count($decode->pictures); $i++) {

            $photo_id_array[$decode->pictures[$i]->id] = [
                'pinned' => isset($decode->pictures[$i]->pinned) && $decode->pictures[$i]->pinned ? 'Y' : 'N',
                'top_percentage' => isset($decode->pictures[$i]->pinned) && $decode->pictures[$i]->pinned ? $decode->crop : 0,
            ];  
            
            Photo::attachTagById($decode->pictures[$i]->id, Tag::TRAINING_ID);
        }

        $plan->trainings()->sync($decode->trainings);
        $plan->photos()->sync($photo_id_array);
        $plan->teachers()->sync($decode->teachers);
        $plan->services()->sync($decode->services);

        //event(new PlanAddedEvent($plan));

        return Response::json([
            'code' => 0,
            'message' => 'Successfully added plan.',
            'result' => $plan,
        ], 200);
    }

    public function show(Plan $plan)
    {
        $plan->pinnedPhotos;
        $plan->teachers;
        $plan->services;
        $plan->trainings;
        $plan->planable;
        $plan->photos;
        $plan->hearth_count = $plan->reactions()->where('action_id', 1)->count();

        if(Auth::check()) {
            \App\User::setWatchedPlan(Auth::user(), $plan->id);
        }

        return view('club.plan')->with(compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
        $plan->pinnedPhotos;
        $plan->teachers;
        $plan->services;
        $plan->trainings;
        $plan->planable;
        $plan->photos;

        return Response::json([
            'code' => '0',
            'result' => $plan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePlan(Request $request)
    {
        $decode = json_decode($request->data);
        $data = $this->planTransformer->transform($decode);

        if(Plan::where('name', $data['name'])
               ->where('id', '<>', $data['id']->exists()))
            return Response::json([
                'code' => 1,
                'message' => 'Plan name duplicated',
            ]);

        $before = new \App\Adjustment;
        $after = new \App\Adjustment;

        $plan = Plan::find($data['id']);
        $planable = $plan->planable;
        $planable->start_date = $data['start_date'];

        if($data['isPrimary']) {
            $planable->price = $data['price'];
        } else {
            $planable->finish_date = $data['finish_date'];
            $planable->before_price = $data['price'];
        }


        $plan->planable = $planable;
        $plan->name = $data['name'];
        $plan->description = $data['description'];
        $plan->length = $data['length'];
        $plan->frequency_type = $data['frequency_type'];
        $plan->trainerless = $data['trainerless'];
        $plan->trainer_count = $data['trainer_count'];

        $planable->save();
        $plan->save();

        $photo_id_array = [];
        for ($i = 0; $i < count($decode->pictures); $i++) {

            if($decode->pictures[$i]->pinned == 'Y') {
                $photo_id_array[$decode->pictures[$i]->id] = [
                  'pinned' => $decode->pictures[$i]->pinned ? 'Y' : 'N',
                  'top_percentage' => $decode->pictures[$i]->pinned ? $decode->crop : 0,
                ];  
            }
            
            Photo::attachTagById($decode->pictures[$i]->id, Tag::TRAINING_ID);
        }

        $plan->trainings()->sync($decode->trainings);
        $plan->photos()->sync($photo_id_array);
        $plan->teachers()->sync($decode->teachers);
        $plan->services()->sync($decode->services);

        $plan->histories()->attach(\Illuminate\Support\Facades\Auth::user()->id, [
            'before' => $before->toJson(),
            'after' => $after->toJson(),
        ]);

        //event(new PlanAddedEvent($plan));

        return Response::json([
            'code' => 0,
            'message' => 'Successfully added plan.',
            'result' => $plan,
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

    private function createPlanable(array $data)
    {
        if($data['isPrimary']) {
            $plan = new PrimaryPlan;
        }
        else {
            $plan = new LoyaltyPlan;
            $plan->before_price = $data['price'];
            $plan->finish_date = $data['finish_date'];
        }

        $plan->start_date = $data['start_date'];
        $plan->save();

        return $plan;
    }
}
