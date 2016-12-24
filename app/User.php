<?php

namespace App;

use App\ClubFollowers;
use App\Photo;
use App\Tag;
use App\Follower;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Laravel\Scout\Searchable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract
{
    use EntrustUserTrait;
    use Authenticatable, CanResetPassword;
    use Searchable, HasApiTokens;
    use Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'socialite_id','socialite_type', 'avatar_url', 'is_active', 'birthday','gender'
    ];

    const MEDIUM_SIZE = 168;
    const SMALL_SIZE = 50;
    const THUMBNAIL_PATH = '/images/users/thumbnails/';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function graph()
    {
        return $this->photos()->where('type', 2);
    }

    static public function findByUsername($username)
    {
        return static::where('username', '=', $username)->first();
    }

    public function uploadPhotos($photos)
    {
        $this->photos()->saveMany($photos);
    }

    public function uploadPhoto(App\Photos $photo)
    {
        $order->products()->saveMany($products);
    }

    public function subscriptionPlans()
    {
        return $this->belongsToMany('App\Plan', 'subscriptions', 'user_id', 'plan_id')
                    ->withPivot('id', 'club_id','begin_date', 'end_date');
    }

    public function subscriptionClubs()
    {
        return $this->belongsToMany('App\Club', 'subscriptions', 'user_id', 'club_id')
                    ->withPivot('begin_date', 'end_date');
    }

    public function watchedPlans()
    {
        return $this->belongsToMany('App\Plan', 'plan_visitor', 'user_id', 'plan_id')
                    ->withPivot('hits', 'visit_date')
                    ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id');
    }

    public function myPhotos()
    {
        return $this->belongsToMany('App\Photo', 'user_photos')
                    ->withPivot('top', 'left', 'type')
                    ->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany('App\Photo', 'object_id');
    }

    public function photosWithoutAvatar()
    {
        return $this->hasMany('App\Photo', 'object_id')
                    ->whereNotIn('type', [2 , 3]);
    }

    public function coverPhoto()
    {
        return $this->myPhotos()->wherePivot('type', 1);
    }

    public function avatars()
    {
        return $this->photos()->whereIn('type', [2 , 3]);
    }

    public function avatarSmall()
    {
        return $this->photos()->where('type', 2);
    }

    public function avatarMedium()
    {
        return $this->photos()->where('type', '=', 3);
    }

    public function canEditable($club_id)
    {
        return $this->clubsAsManager()->where('club.club_id','=', $club_id);
    }

    static public function checkUserAvailable($username)
    {
        return static::where('username','=', $username)->first() ? true : false;
    }

    public function clubRequests()
    {
        return $this->belongsToMany('App\Club', 'requests', 'user_id', 'club_id')
                    ->withPivot('type','description')
                    ->withTimestamps();
    }

    public function following()
    {
        return $this->hasMany('App\Follower', 'user_id');
    }

    public function followers()
    {
        return $this->morphToMany('App\User', 'followable', 'followers');
    }

    public function clubAsReception()
    {
        return $this->belongsToMany('App\Club', 'members', 'user_id', 'club_id')->where('type', '=', 3);
    }

    public function clubsAsManager()
    {
        return $this->belongsToMany('App\Club', 'members', 'user_id', 'club_id')->where('type', '=', 2);
    }

    public function mentions()
    {
        $relations = DB::table('mentionables')
                 ->where('mentionable_id', $this->id)
                 ->orderBy('created_at', 'DESC')
                 ->get();

        foreach ($relations as $key => $relation) {
            $instance = new $relation->mention_type;
            $query = $instance->newQuery();
            $relation->mentioned = $query->find($relation->mention_id);
        }

        return $relations;
    }

    public function activities()
    {
        return $this->belongsToMany('App\Subscriptions', 'user_activity', 'user_id', 'subscription_id')->withPivot('start_time', 'finish_time', 'duration')
             ->withTimestamps();
    }

    public function reactions()
    {
        return $this->hasMany('App\Reaction', 'user_id');
    }

    public function clubs()
    {
        return $this->belongsToMany('App\Club','members','user_id', 'club_id')
                    ->withPivot('type', 'since_date', 'view_order')
                    ->withTimestamps();
    }

    public function onlineClubs()
    {
        return $this->belongsToMany('App\Club', 'online_members', 'user_id', 'club_id')
                    ->withPivot('subscription_id', 'start_time')
                    ->withTimestamps();
    }

    public function hasClubRequest($club_id)
    {
        return count($this->clubRequests()->where('id', '=', $club_id)->get()) == 0 ? false : true;
    }

    public function isFollowed($club_id)
    {
        return $this->following()->where('followable_id','=', $club_id)->exists() ? true : false;
    }

    public function removeClubRequest($club)
    {
        if($this->hasClubRequest($club->id))
        {
            $this->clubRequests()->detach($club->id);
            return Response::json(['result' => 'Success', 'type' => 'APPROVE']);
        }
    }

    static public function setWatchedPlan($user, $planId)
    {
        if($user->isWatchedBefore($planId)) {
            \Illuminate\Support\Facades\DB::table('plan_visitor')
                ->where('plan_id', $planId)
                ->where('user_id', $user->id)
                ->where('visit_date', Carbon::now()->toDateString())
                ->increment('hits', 1);   

            return;
        }

        $user->watchedPlans()->attach($planId, [
            'hits' => 1,
            'visit_date' => Carbon::now()->toDateString(),
        ]);
    }

    public function isWatchedBefore($planId)
    {
        return $this->watchedPlans()
                    ->where('plan_id', $planId)
                    ->where('visit_date', Carbon::now()->toDateString())
                    ->exists();
    }


    public function toggleReaction($action, $obj)
    {
        return  $this->reactionExists($action, $obj) ? 
                $this->detachReaction($action, $obj) : 
                $this->attachReaction($action, $obj) ;
    }

    private function reactionExists($action, $obj)
    {
        return $this->reactions()   
                    ->where('action_id', $action->id)
                    ->where('action_type', get_class($action))
                    ->where('actionable_id', $obj->id)
                    ->where('actionable_type', get_class($obj))
                    ->exists();
    }

    public function detachReaction($action, $obj)
    {
        DB::table('reactions')
                    ->where('action_id', $action->id)
                    ->where('action_type', get_class($action))
                    ->where('actionable_id', $obj->id)
                    ->where('actionable_type', get_class($obj))
                    ->delete();

        return false;
    }

    private function attachReaction($action, $obj)
    {
        $instance = new \App\Reaction;
        $instance->user_id = $this->id;
        $instance->action_id = $action->id;
        $instance->action_type = get_class($action);
        $instance->actionable_id = $obj->id;
        $instance->actionable_type = get_class($obj);
        $instance->save();

        return true;
    }

    public function toggleClubRequest($club, $type = null, $description = null)
    {
        if($this->hasClubRequest($club->id))
        {
            $this->clubRequests()->detach($club->id);
            return Response::json(['result' => 'Success', 'type' => $type == 2 ? 'teacher' : 'trainer']);
        }


        if(\App\Http\Controllers\ClubController::isTeacher($type)) {
            Notification::send($club->managers, new \App\Notifications\TeacherRequestRecieved($this, $club, Carbon::now(), $description));
        }

        $this->clubRequests()->attach($club->id, [
                'type' => $type, 
                'description' => $description,
        ]);

        return Response::json(['result' => 'Success', 'type' => $type == 2 ? 'unteacher' : 'untrainer']);
    }

    public function toggleFollow($id, $followable)
    {
        $follow = \App\Follower::where('user_id', $this->id)
                  ->where('followable_id', $id)
                  ->where('followable_type', $followable);

        if($follow->exists()) 
        {
            $follow->delete();

            return Response::json([
                'code' => 0,
                'result' => 'follow',
            ]);
        } 

        $instance = new \App\Follower;
        $instance->user_id = $this->id;
        $instance->followable_id = $id;
        $instance->followable_type = $followable;

        $instance->save();

        return Response::json([
            'code' => 0, 
            'result' => 'unfollow'
        ]);
    }

    public function attachMorph()
    {
        
    }

    public function joinClub($club, $type)
    {
        $view_order = 0;

        if($type == 1) {
            $view_order = $club->nextTeacherViewOrder();
        }

        return $this->clubs()->attach($club->id, [
            'type' => $type, 
            'since_date' => Carbon::now(),
            'view_order' => $view_order,
        ]);
    }

    public function deletePrevAvatar()
    {
        $avatars = $this->avatars;
        if($avatars->isEmpty()) return $this;

        foreach ($avatars as $avatar) {
            $avatar->deleteWithPicture();
        }

        return $this;
    }

    public function saveCover(Photo $photo, $top = 0, $left = 0)
    {
        $photo->attachTag(Tag::COVER_ID);

        $this->deletePrevCover();

        return $this->myPhotos()->attach($photo->id, [
            'type' => 1,
            'top' => $top,
            'left' => $left,
        ]);
    }

    private function deletePrevCover() {
        $this->myPhotos()->newPivotStatement()->where('type',1)->delete();
    }

    public function saveAvatar($photo)
    {
        $photo->attachTag(Tag::PROFILE_ID);
        $this->avatar_url = $photo->url;
        $this->save();
        
        $small = Image::make($photo->url);
        $medium = Image::make($photo->url);

        $smallHash = md5('avatar'. $this->username . 'small');
        $small->resize(self::SMALL_SIZE, self::SMALL_SIZE)
              ->save(public_path(). self::THUMBNAIL_PATH . $smallHash . '.' . $photo->ext);

        $mediumHash = md5('avatar'. $this->username . 'medium');
        $medium->resize(self::MEDIUM_SIZE, self::MEDIUM_SIZE)
               ->save(public_path(). self::THUMBNAIL_PATH . $mediumHash . '.' . $photo->ext);

        $small->destroy();
        $medium->destroy();

        $smallPhoto = self::savePhoto($smallHash, 2, $photo->ext);
        $mediumPhoto = self::savePhoto($mediumHash, 3, $photo->ext);

        return $mediumPhoto;
    }

    private function savePhoto($hash, $type, $ext)
    {
        $photo = new Photo;
        $photo->type = $type;
        $photo->object_id = $this->id;
        $photo->size = 0;
        $photo->ext = $ext;
        $photo->ratio = 1;
        $photo->url = App::make('url')->to('/') 
                                        . self::THUMBNAIL_PATH 
                                        . $hash
                                        . '.' 
                                        . $ext;
        $photo->save();

        return $photo;
    }

    public function decreaseViewOrder($clubId)
    {
        $pivot = $this->clubs()->where('id', '=', $clubId)->first();
        $pivot->pivot->view_order = $pivot->pivot->view_order - 1;
        $pivot->pivot->save();
    }

    public function increaseViewOrder($clubId)
    {
        $pivot = $this->clubs()->where('id', '=', $clubId)->first();
        $pivot->pivot->view_order = $pivot->pivot->view_order + 1;
        $pivot->pivot->save();
    }

    public function toggleViewOrder($type, $clubId)
    {
        if($type == 'upper') 
            return self::increaseViewOrder($clubId);
        
        return self::decreaseViewOrder($clubId);
    }

    // MByte
    public function maxFileUpload()
    {
        return 100;
    }

    public function equalAsString($otherId)
    {
        if (strcmp(strval($this->id), strval($otherId)) == 0) {
            return true;
        }
        return false;
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        ];
    }

    private function isLogged()
    {
        return \Illuminate\Support\Facades\Auth::check();
    }
}
