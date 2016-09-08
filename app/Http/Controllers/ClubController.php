<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    public function info(Club $club)
    {
    	if(!Auth::check())
    	{
    		return Response::json ([
    				'club' => $club,
    				'teacher_status' => 'teacher',
    				'follow_status' => 'follow',
    				'request_status' => 'trainer'
    			]);
    	}
				
		$member = $club->members()->where('user_id', '=', Auth::user()->id)->first();

    	if($member)
    	{
    		$follow_status = 'unfollow';
    		$teacher_status = 'deteacher';

    		if(self::isManager($member)) $request_status = 'manager';
    		if(self::isTeacher($member)) $request_status = 'teacher';
    		if(self::isMember($member))
    		{
    			$request_status = 'member';
    			$teacher_status = 'teacher';
    		}
    	}
    	else
    	{
	    	$request_status = Auth::user()->hasClubRequest($club->id) ? "untrainer" : "trainer";
	    	$follow_status = Auth::user()->isFollowed($club->id) ? "unfollow" : "follow";
	    	$teacher_status = "teacher";
    	}

    	return Response::json ([
    			'club' => $club,
    			'teacher_status' => $teacher_status,
    			'follow_status' => $follow_status,
    			'request_status' => $request_status,
    	]);
    }

    public function members(Club $club, $type)
    {
        return Response::json([
            'code' => 0,
            'result' => $club->members()->where('type', '=', $type)->get(),
            'max_id' => $club->nextTeacherViewOrder() - 1,
        ]);
        return $club->members()->where('type', '=', $type)
                    ->get();
    }
    
    public function toggleTeacherViewOrder($clubId, User $first, User $second, Request $request)
    {
        $first->toggleViewOrder($request->type == 'upper' ? 'upper' : 'down', $clubId);
        $second->toggleViewOrder($request->type == 'upper' ? 'down' : 'upper', $clubId);
    }

    public function getTeachers(Club $club, Request $request)
    {
        $selected = explode(',', $request->selected);
        $teachers = Club::teachers($club->id);

        foreach ($teachers as $teacher) {
            $teacher->selected = false;

            if(empty($selected)) {
                continue;
            }

            for($i = 0; $i < count($selected); $i ++) {
                if ($teacher->equalAsString($selected[$i])) {
                    $teacher->selected = true;
                }
            }
        }
        
        return $teachers;
    }

    private function isManager($member)
    {
    	return $member->pivot->type == 2 ? true : false;
    }

    private function isTeacher($member)
    {
    	return $member->pivot->type == 1 ? true : false;
    }

    private function isMember($member)
    {
    	return $member->pivot->type == 3 ? true : false;
    }

    public function index($clubId)
    {
    	$club = Club::isAvailableClub($clubId);

        if(!$club) abort(404);
        $id = $club->id;

        $widgets = $club->activeWidgets();
        $widget_content = array();

        foreach ($widgets as $widget) {
            switch ($widget->section_id) {
                case 1:
                    $widget_header = $widget->content_map;
                    break;
                case 2:
                    array_push($widget_content, $widget->content_map);
                    break;
                case 3:
                    $widget_footer = $widget->content_map;
                    break;
                default:
                    break;
            }
        }

		return view('club')->with(compact('widget_header', 'widget_content','widget_footer', 'id'));
    }
}
