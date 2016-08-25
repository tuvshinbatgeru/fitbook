<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $primaryKey = 'id';
	protected $table = 'plan';

	protected $fillable = [
        'club_id', 'name', 'description','is_active', 'type', 'plan_type', 'trainerless'
        , 'price', 'trainer_count', 'length'
    ];

    public function photos()
    {
    	return $this->belongsToMany('App\Photo', 'plan_photos', 'plan_id', 'photo_id')
    			->withPivot('pinned')
    			->withTimestamps();
    }

    public function teachers()
    {
    	return $this->belongsToMany('App\User', 'plan_teacher', 'plan_id', 'user_id')
    			->withTimestamps();
    }
}
