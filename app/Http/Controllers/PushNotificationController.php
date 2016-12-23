<?php

namespace App\Http\Controllers;

use App\Events\PushNotificationEvent;
use App\Http\Requests;
use Illuminate\Http\Request;
use Response;

class PushNotificationController extends Controller
{
    //
    public function pushNotification(Request $request)
    {	
    	if(empty($request->title)) {
    		return Response::json([
    			'code' => 1,
    			'message' => "Push notification's must have title"
    		]);
    	}

    	event(new PushNotificationEvent(
    		$request->title,
    		$request->direction,
    		$request->lang,
    		$request->body,
    		$request->tag,
    		$request->icon
    	));

        return Response::json([
            'code' => 0, 
            'message' => 'Success'
        ]);
    }
}
