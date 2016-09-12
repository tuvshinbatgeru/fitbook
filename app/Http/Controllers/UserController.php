<?php

namespace App\Http\Controllers;

use App\Club;
use App\ClubFollowers;
use App\Http\Requests;
use Response;
use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query;
        $users = User::search($query)->get();
        
        return Response::json([
            'result' => $users,
        ]);
    }   
    //
    public function index($username)
    {
        $user = User::findByUsername($username);
        $editable = false;
        if(Auth::check() && Auth::user()->username == $username)
            $editable = true;
        return view('user')->with(compact('user', 'editable'));
    }

    public function edit($username)
    {
        if(Auth::user()->username != $username) abort(404);

        $user = User::findByUsername($username);
        $activities = $user->activities()->paginate(15);
        return view('auth.profile.edit')->with(compact('user', 'activities'));
    }

    public function storeAvatar(Photo $photo)
    {
        $mediumAvatar = Auth::user()->deletePrevAvatar()
                    ->saveAvatar($photo);

        return Response::json([
                'result' => 'OK',
                'avatar' => $mediumAvatar->url,
            ], 200);
    }

    public function followedClubs(User $user)
    {
        $followedClubs = $user->followedClubs;

        foreach ($followedClubs as $club) {
            $club->state = "unfollow";
        }

        return Response::json([
            'result' => 'OK',
            'data' => $followedClubs,
        ]);
    }

    public function toggleFollow(Club $club)
    {
    	if(!Auth::check()) return Response::json(['result' => 'Login']);
    	return Auth::user()->toggleClubFollow($club);
    }

    public function toggleRequest(Request $request, Club $club)
    {
    	if(!Auth::check()) return Response::json(['result' => 'Login']);
    	return Auth::user()->toggleClubRequest($club, $request->type, $request->description);
    }
}
