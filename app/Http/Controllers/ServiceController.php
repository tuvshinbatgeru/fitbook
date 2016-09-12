<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class ServiceController extends Controller
{
    public function index(Club $club)
    {
    	$services = $club->services;

    	foreach ($services as $service) {
    		$service->selected = false;
    	}

        return Response::json([
        	'result' => $services,
        ]);
    }

    public function list(Request $request)
    {
    	$decode = json_decode($request->data);
    	$services = Service::verifiedServices();

    	foreach ($services as $service) {
    		$service->selected = false;

    		if(empty($decode->selected)) {
    			continue;
    		}

    		for($i = 0; $i < count($decode->selected); $i ++) {
                if ($service->id == $decode->selected[$i]->id) {
                    $service->selected = true;
                }
            }
    	}

    	return Response::json([
    		'result' => $services,
    	]);
    }

    public function modifyClubServices(Club $club, Request $request)
    {
        $decode = json_decode($request->data);
        $club->services()->sync($decode->choosed);

        return Response::json([
            'result' => $club->services,
        ]);
    }

    public function calcAttachList()
    {
            
    }

    public function calcDettachList()
    {
        
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
    public function store()
    {
        
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
