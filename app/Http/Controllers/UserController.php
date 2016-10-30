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
use App\Follower;
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
            'subscriptions' => $user->subscriptionPlans()->with('pinnedPhotos')->get(),
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

    public function dateActivities(User $user, Request $request)
    {
        $activities = $user->activities()
                        ->wherePivot('start_time', '>', $request->date. ' 00:00:01')
                        ->wherePivot('start_time', '<', $request->until. ' 00:00:01')
                        ->with('plan', 'club')
                        ->get();

        return Response::json([
            'code' => 0,
            'result' => $activities,
        ]);
    }

    public function userActivity(User $user, Request $request)
    {
        $activities = \Illuminate\Support\Facades\DB::table('user_activity')
                        ->where('user_id', $user->id)
                        ->where('start_time', '>', $request->year . '-01-01 00:00:01')
                        ->where('start_time', '<', ($request->year + 1) . '-01-01 00:00:01')
                        ->select('start_time', 'duration')
                        ->get();

        return Response::json([
            'code' => 0,
            'result' => $activities,
        ]);
    }

    public function followingCount(User $user)
    {
        return Response::json([
            'code' => 0,
            'result' => $user->following()->count()
        ]);
    }

    public function followings(User $user)
    {
        $following = $user->following()->with('followable')->paginate(10);
        
        foreach ($following->items() as $follow) {
            $follow->state = "unfollow";
        }

        return Response::json([
            'code' => 0,
            'result' => $following
        ]);
    }

    public function toggleFollow(Request $request)
    {
    	if(!Auth::check()) 
        return Response::json([
            'code' => '2',
            'message' => 'Must be logged in',
        ]);

        if(empty($request->followable) || empty($request->id)) {
            return Response::json([
                'code' => 10,
                'message' => 'Error during follow',
            ]);
        }

    	return Auth::user()->toggleFollow($request->id, $request->followable);
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
