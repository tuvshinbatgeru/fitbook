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
use Illuminate\Support\Facades\Log;
use Response;

class PlanController extends Controller
{
    protected $planTransformer;

    static public $lookup = [
        'primary' => PrimaryPlan::class,
        'loyalty' => LoyaltyPlan::class,
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

    public function comments(Plan $plan)
    {
        $comments = $plan->comments()
                         ->with('user')
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

    public function index(Club $club, Request $request)
    {
        $plans = self::$lookup[$request->type]::with(['plan' => function ($query) use ($club) {
            $query->where('club_id', '=', $club->id)
                  ->with('pinnedPhotos', 'teachers', 'services', 'trainings');
        }])->get();

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

    public function store(Club $club, Request $request)
    {
        $decode = json_decode($request->data);
        $data = $this->planTransformer->transform($decode);

        $planable = self::createPlanable($data);

        $plan = new Plan($data);
        $plan->price = $data['isPrimary'] ? $data['price'] : $data['discount'];
        $planable->plan()->save($plan);

        $planable->plan[0] = $plan;

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

        event(new PlanAddedEvent($plan));

        return Response::json([
            'code' => 0,
            'message' => 'Successfully added plan.',
            'result' => $planable,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        $plan->pinnedPhotos;
        $plan->teachers;
        $plan->services;
        $plan->trainings;
        $plan->planable;
        $plan->photos;
        $plan->hearth_count = $plan->reactions()->where('action_id', 1)->count();

        return view('club.plan')->with(compact('plan'));
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

    private function createPlanable(array $data)
    {
        if($data['isPrimary']) {
            $plan = new PrimaryPlan;
        }
        else {
            $plan = new LoyaltyPlan;
            $plan->before_price = $data['price'];
            $plan->finish_date = Carbon::now();
        }

        $plan->start_date = Carbon::now();
        $plan->save();

        return $plan;
    }
}
