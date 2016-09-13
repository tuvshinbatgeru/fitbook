<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Subscriptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $subscription = Subscriptions::create([
            'club_id' => $decode->clubId,
            'user_id' => $decode->userId,
            'plan_id' => $decode->planId,
            'begin_date' => Carbon::createFromFormat('d/m/Y', $decode->startDate),
            'end_date' => Carbon::createFromFormat('d/m/Y', $decode->finishDate),
        ]);

        $subscription->save();

        return Response::json([
            'code' => 0,
            'result' => $subscription,
            'message' => 'Successfully add subscription',
        ]);
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
