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

	public function onlineUsers()
	{
		return $this->belongsToMany('App\User', 'online_members', 'club_id', 'user_id')
					->withPivot('subscription_id','start_time');
	}

	public function plans()
	{
		return $this->hasMany('App\Plan');
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
		return $this->belongsToMany('App\User','members','club_id', 'user_id')
					->withPivot('type', 'since_date', 'view_order')
					->withTimestamps();
	}

	public function managers()
	{
		return $this->members()->where('type', 2);
	}

	static public function teachers($clubId)
	{
		return static::find($clubId)->members()->where('type', '=', 1)->get();
	}

	public function services()
	{
		return $this->belongsToMany('App\Service', 'club_services', 'club_id', 'service_id')
					->withPivot('photo_id')
					->withTimestamps();
	}

	public function widgets()
	{
		return $this->belongsToMany('App\Widget', 'club_widgets', 'club_id', 'widget_id')
					->withPivot('view_order', 'expired_date', 'licensed', 'is_active')
					->withTimestamps();
	}

	public function activeWidgets()
	{
		return $this->widgets()->where('is_active', '=', 'Y')->get();
	}

	public function nextTeacherViewOrder()
	{
		$query = $this->members()
					  ->where('type', '=', 1);	

		if(!$query->exists()) return 1;
		return $query->orderBy('view_order', 'DESC')->first()->pivot->view_order + 1;
	}
}
