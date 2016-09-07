<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use App\LoyaltyPlan;
use App\Photo;
use App\Plan;
use App\PrimaryPlan;
use App\Tag;
use App\Transformers\PlanTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function index(Club $club, Request $request)
    {
        $plans = self::$lookup[$request->type]::with(['plan' => function ($query) use ($club) {
            $query->where('club_id', '=', $club->id);
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

        for ($i = 0; $i < count($decode->pictures); $i++) {
            $plan->photos()->attach(intval($decode->pictures[$i]->id), ['pinned' => $decode->pictures[$i]->pinned ? 'Y' : 'N']);
            Photo::attachTagById($decode->pictures[$i]->id, Tag::PLAN_ID);
        }

        $plan->teachers()->sync($decode->teachers);
        $plan->services()->sync($decode->services);

        $plan->teachers;
        $plan->photos = $plan->pinnedPhoto();

        return Response::json([
            'result' => $plan,
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
