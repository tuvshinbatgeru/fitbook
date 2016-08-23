<?php

namespace App;

use App\ClubFollowers;
use App\Photo;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
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

    public function photos()
    {
        return $this->hasMany('App\Photo', 'object_id');
    }

    public function photosWithoutAvatar()
    {
        return $this->hasMany('App\Photo', 'object_id')
                    ->whereNotIn('type', [2 , 3]);
    }

    public function avatars()
    {
        return $this->photos()->whereIn('type', [2 , 3]);
    }

    public function avatarSmall()
    {
        return $this->photos()->where('type', '=', 2)->first();
    }

    public function avatarMedium()
    {
        return $this->photos()->where('type', '=', 3)->first();
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

    public function activities()
    {
        return $this->belongsToMany('App\Club', 'user_activity', 'user_id', 'club_id')
                    ->withPivot('start_time', 'finish_time', 'duration')
                    ->withTimestamps();
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

    public function deletePrevAvatar()
    {
        $avatars = $this->avatars;
        if($avatars->isEmpty()) return $this;

        foreach ($avatars as $avatar) {
            $avatar->deleteWithPicture();
        }

        return $this;
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
}
