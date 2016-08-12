<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    //
    public function info($clubId)
    {
    	$club = Club::where('club_id','=', $clubId)->first();

    	if(!Auth::check())
    	{
    		return Response::json ([
    				'club' => $club,
    				'teacher_status' => 'APPROVE',
    				'follow_status' => 'APPROVE',
    				'request_status' => 'APPROVE'
    			]);
    	}
				
		$member = $club->members()->where('user_id', '=', Auth::user()->id)->first();

    	if($member)
    	{
    		$follow_status = 'FOLLOWER';
    		$teacher_status = 'DENIED';

    		if(self::isManager($member)) $request_status = 'MANAGER';
    		if(self::isTeacher($member)) $request_status = 'TEACHER';
    		if(self::isMember($member))
    		{
    			$request_status = 'MEMBER';
    			$teacher_status = 'APPROVE';
    		}
    	}
    	else
    	{
	    	$request_status = Auth::user()->hasClubRequest($club->id) ? "EXIST" : "APPROVE";
	    	$follow_status = Auth::user()->isFollowed($club->id) ? "FOLLOWER" : "APPROVE";
	    	$teacher_status = "APPROVE";
    	}

    	return Response::json ([
    			'club' => $club,
    			'teacher_status' => $teacher_status,
    			'follow_status' => $follow_status,
    			'request_status' => $request_status,
    	]);
    }

    public function getTeachers(Club $club, Request $request)
    {
         return Club::teachers($club->id);
    }

    private function isManager($member)
    {
    	return $member->pivot->type == 1 ? true : false;
    }

    private function isTeacher($member)
    {
    	return $member->pivot->type == 2 ? true : false;
    }

    private function isMember($member)
    {
    	return $member->pivot->type == 3 ? true : false;
    }

    public function index($clubId)
    {
    	if(!Club::isAvailableClub($clubId)) abort(404);

    	$widget_header = "header-default";
		$widget_footer = "widgets.footer.default";
		$widget_content = array();

		switch ($clubId) {
			case 'flexgym':
				array_push($widget_content, 'widgets.content.default');
				break;
			case 'goldengym':
				array_push($widget_content, 'widgets.content.default');
				break;
			default:
				array_push($widget_content, 'widgets.content.default');
				break;
		}
		return view('club')->with(compact('widget_header', 'widget_content','widget_footer', 'clubId'));
    }
}
