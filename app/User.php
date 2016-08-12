<?php

namespace App;

use App\ClubFollowers;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Response;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract
{
    use EntrustUserTrait;
    use Authenticatable, CanResetPassword;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'socialite_id','socialite_type', 'avatar_url', 'is_active', 'birthday','gender', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function uploadPhotos($photos)
    {
        $this->photos()->saveMany($photos);
    }

    public function uploadPhoto(App\Photos $photo)
    {
        $order->products()->saveMany($products);
    }

    public function photos()
    {
        return $this->hasMany('App\Photos', 'object_id');
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

    public function followedClubs()
    {
        return $this->belongsToMany('App\Club', 'followers', 'user_id', 'club_id')->withTimestamps();
    }

    public function clubsAsManager()
    {
        return $this->belongsToMany('App\Club', 'members', 'user_id', 'club_id')->where('type', '=', 1);
    }

    public function clubs()
    {
        return $this->belongsToMany('App\Club','members','user_id', 'club_id')->withPivot('type', 'since_date')->withTimestamps();
    }

    public function hasClubRequest($club_id)
    {
        return count($this->clubRequests()->where('id', '=', $club_id)->get()) == 0 ? false : true;
    }

    public function isFollowed($club_id)
    {
        return count($this->followedClubs()->where('id','=', $club_id)->get()) == 0 ? false : true;
    }

    public function removeClubRequest($club)
    {
        if($this->hasClubRequest($club->id))
        {
            $this->clubRequests()->detach($club->id);
            return Response::json(['result' => 'Success', 'type' => 'APPROVE']);
        }
    }

    public function toggleClubRequest($club, $type = null, $description = null)
    {
        if($this->hasClubRequest($club->id))
        {
            $this->clubRequests()->detach($club->id);
            return Response::json(['result' => 'Success', 'type' => 'APPROVE']);
        }

        $this->clubRequests()->attach($club->id, ['type' => $type, 'description' => $description]);
        return Response::json(['result' => 'Success', 'type' => 'EXIST']);
    }

    public function toggleClubFollow($club)
    {
        $follow = ClubFollowers::firstOrNew([
            'user_id' => $this->id,
            'club_id' => $club->id,
        ]);

        if($follow->exists) 
        {
            $this->followedClubs()->detach($club->id);
            return Response::json(['result' => 'Success', 'type' => 'APPROVE']);
        } 

        $this->followedClubs()->attach($club->id);
        return Response::json(['result' => 'Success', 'type' => 'FOLLOWER']);
    }

    public function joinClub($club, $type)
    {
        return $this->clubs()->attach($club->id, ['type' => $type, 'since_date' => Carbon::now()]);
    }
}
