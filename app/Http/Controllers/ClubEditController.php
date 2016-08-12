<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class ClubEditController extends Controller
{
    const AS_MANAGER = 1;
    const AS_TEACHER = 2;
    const AS_TRAINER = 3;

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($club_id, Request $request)
    {
    	if(!Auth::user()->canEditable($club_id)->exists())
    		return redirect('/' . $club_id);

        $club = Club::getClubByClubId($club_id);
     	return view('clubedit')->with(compact('club'));
    }

    public function index(Club $club, Request $request)
    {
        return Response::json([
            'club' => $club,
            'members_count' => $club->members()->count(),
            'requests_count' => $club->requests()->count(),
        ]);
    }

    public function member(Club $club)
    {
        return $club->members;
    }

    public function request(Club $club)
    {
        return $club->requests;
    }

    public function requestResponse(Request $request, Club $club, User $user)
    {
        $user->removeClubRequest($club);
        $requestType = $request->requestType;
        $roleType = $request->roleType;

        if($requestType == 'Accepted')
        {
            $user->joinClub($club, $roleType + 1);
        }

        if($requestType == 'Rejected')
        {

        }

        return Response::json(['result' => '200']);
    }
}
