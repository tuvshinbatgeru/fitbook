<?php

namespace App\Http\Controllers;

use App\Club;
use App\ClubFollowers;
use App\Events\UserOutTraining;
use App\Filters\SubscriptionFilters;
use App\Http\Requests;
use App\Photo;
use App\Subscriptions;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query;
        $users = User::search($query->get('query'))->get();
        
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

    public function menus(User $user)
    {

        return Response::json([
            'code' => 0,
            'menus' => $user->clubs,
            'subscriptions' => $user->subscriptionPlans
        ]);
    }

    public function mentions(User $user)
    {
        return Response::json([
            'code' => 0,
            'result' => $user->mentions(),
        ]);
    }

    public function notifications(User $user)
    {
        return Response::json([
            'code' => 0,
            'result' => $user->notifications,
        ]);        
    }

    public function subscriptions(User $user, SubscriptionFilters $filters)
    {
        $query = $user->subscriptionPlans()->with('pinnedPhotos');

        return Response::json([
            'code' => 0,
            'result' => Subscriptions::filter($query, $filters)->get(),
        ]);
    } 

    public function userActivity(User $user, Request $request)
    {
        return Response::json([
            'code' => 0,
            'result' => $user->activities,
        ]);
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

    public function inUser(User $user, Request $request)
    {
        if(!($request->exists('clubId') && $request->exists('subscriptionId'))) {
            return Response::json([
                'code' => 1,
                'message' => 'Illegal operation !!!!',
            ]);
        }

        $currentTime = Carbon::now();
        
        $user->onlineClubs()->attach($request->clubId, [
            'start_time' => $currentTime,
            'subscription_id' => $request->subscriptionId,
        ]);

        return Response::json([
            'code' => 0,
            'result' => $user,
            'start_time' => $currentTime,
            'message' => $user->username . ' trainer starts to training.',
        ]);
    }

    public function outUser(User $user, Request $request)
    {
        if(!($request->exists('clubId') && $request->exists('subscriptionId'))) {
            return Response::json([
                'code' => 1,
                'message' => 'Illegal operation !!!!',
            ]);
        }

        $user->onlineClubs()->detach($request->clubId, [
            'subscription_id' => $request->subscriptionId
        ]);

        event(new UserOutTraining($user, $request->clubId, $request->subscriptionId, $request->startTime));

        return Response::json([
            'code' => 0,
            'message' => $user->username . ' trainer finished training.',
        ]);
    }
}
