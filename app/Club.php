<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    //
    protected $primaryKey = 'id';
	protected $table = 'club';

	protected $fillable = [
        'club_id', 'short_name', 'full_name','address', 'description', 'lat', 'lng','is_active'
    ];

	static public function isAvailableClub($club_id)
	{
		return static::where('club_id','=', $club_id)->first();
	}

	static public function getClubByClubId($club_id)
	{
		return static::where('club_id','=', $club_id)->first();
	}

	public function trainings()
	{
		return $this->hasMany('App\Training');
	}

	public function followers()
	{
		return $this->belongsToMany('App\User', 'followers', 'club_id', 'user_id');
	}

	public function requests()
	{
		return $this->belongsToMany('App\User', 'requests', 'club_id', 'user_id')->withPivot('type', 'description')->withTimestamps();;
	}

	public function members()
	{
		return $this->belongsToMany('App\User','members','club_id', 'user_id')->withPivot('type', 'since_date')->withTimestamps();
	}

	static public function teachers($clubId)
	{
		return static::find($clubId)->members()->where('type', '=', 2)->get();
	}

	public function widgets()
	{
		return $this->belongsToMany('App\Widget', 'widgets', 'user_id', 'widgets_id');
	}
}
