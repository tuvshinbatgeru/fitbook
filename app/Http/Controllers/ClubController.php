<?php

namespace App\Http\Controllers;

use App\Club;
use App\Filters\RouterFilters;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class ClubController extends Controller
{   
    //Begin Club Pages

    public function memberPage($clubId, RouterFilters $request)
    {
        $club = Club::isAvailableClub($clubId);
        if(!$club) abort(404);

        $filters = $request->toObjectArray();

        //dd($filters);

        $id = $club->id;
        $widget_content = 'member-default';
        $menu = 'member'; 

        $isOwner = 'N';

        if($this->checkManager($club)) {
            $isOwner = 'Y';
        }


        return view('club')->with(compact('widget_content', 'id', 'menu', 'filters', 'isOwner'));
    }

    public function planPage($clubId)
    {
        $club = Club::isAvailableClub($clubId);
        if(!$club) abort(404);

        $id = $club->id;
        $widget_content = 'plan-default';
        $menu = 'plan'; 

        return view('club')->with(compact('widget_content', 'id', 'menu'));        
    }

    public function trainingPage($clubId)
    {
        $club = Club::isAvailableClub($clubId);
        if(!$club) abort(404);

        $id = $club->id;
        $widget_content = 'training-default';
        $menu = 'plan'; 

        return view('club')->with(compact('widget_content', 'id', 'menu'));   
    }
    //End Club Pages


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

    		if(self::isManager($member->pivot->type)) $request_status = 'manager';
    		if(self::isTeacher($member->pivot->type)) $request_status = 'teacher';
            if(self::isReception($member->pivot->type)) $request_status = 'reception';
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

    public function onlineUsers(Club $club)
    {
        return Response::json([
            'code' => 0,
            'result' => $club->onlineUsers,
        ]);
    }

    public function planCounts(Club $club)
    {
        $rets = $club->plans()
             ->orderBy('planable_type', 'DESC')
             ->groupBy('planable_type')
             ->select('planable_type', \Illuminate\Support\Facades\DB::raw('count(1) as total'))
             ->get();

        return Response::json([
            'code' => 0,
            'general_count' => isset($rets[0]) ? $rets[0]->total : 0,
            'loyalty_count' => isset($rets[1]) ? $rets[1]->total : 0,
        ]);
    }

    public function capabilities(Club $club)
    {
        return Response::json([
            'code' => 0,
            'result' => $club->capabilities,
        ]);
    }

    public function genres(Club $club)
    {
        return Response::json([
            'code' => 0,
            'result' => $club->genres,
        ]);
    }

    private function memberToNumber($type)
    {
        switch ($type) {
            case "teacher":
                return 1;
            case "reception":
                return 3;
            case "manager":
                return 2;
            default:
                break;
        }

    }

    public function members(Club $club, Request $request)
    {
        switch($request->status_type) {
            case "request":
                $query = $club->requests();
                break;
            case "active":
                $query = $club->members();
                break;
            case "archive":
                break;
            default:
                break;
        }

        $query = $query->withCount('following','followers');

        if(isset($request->type)) {
            $query = $query->wherePivot('type', $this->memberToNumber($request->type));
        }

        if(isset($request->date)) {
            $query = $query->orderBy('since_date', $request->date);
        }

        $members = $query->get();

        foreach ($members as $member) {
            $member->is_online = true;
            $member->last_online = Carbon::now();
        }

        return Response::json([
            'code' => 0,
            'result' => $members,
            'max_id' => $club->nextTeacherViewOrder() - 1,
        ]);
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

    static public function isManager($type)
    {
    	return $type == 2 ? true : false;
    }

    static public function isReception($type)
    {
        return $type == 3 ? true : false;
    }

    private function checkManager($club) {
        if(!Auth::check()) return false;

        return $club->isManager(Auth::user()->id);
    }

    static public function isTeacher($type)
    {
    	return $type == 1 ? true : false;
    }

    public function index($clubId, Request $request)
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

        $widget_content = 'home-default';
        $menu = 'home'; 

		return view('club')->with(compact('widget_header', 'widget_content','widget_footer', 'id', 'menu'));
    }
}
