<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $primaryKey = 'id';
	protected $table = 'plan';

	protected $fillable = [
        'club_id', 'frequency_type','planable_id', 'planable_type','trainerless', 'name', 'description', 'price'
        , 'trainer_count', 'length', 'is_active'
    ];

    public function photos()
    {
    	return $this->belongsToMany('App\Photo', 'plan_photos', 'plan_id', 'photo_id')
    			->withPivot('pinned')
    			->withTimestamps();
    }

    public function pinnedPhotos()
    {
        return $this->belongsToMany('App\Photo', 'plan_photos', 'plan_id', 'photo_id')
                ->where('pinned', '=', 'Y');
    }

    public function teachers()
    {
    	return $this->belongsToMany('App\User', 'plan_teacher', 'plan_id', 'teacher_id')
    			->withTimestamps();
    }

    public function services()
    {
        return $this->belongsToMany('App\Service', 'plan_service', 'plan_id', 'club_service_id')
                ->withTimestamps();
    }

    public function trainings()
    {
        return $this->belongsToMany('App\Training', 'plan_training', 'plan_id', 'training_id')
                ->withTimestamps();
    }

    public function pinnedPhoto()
    {
        return $this->photos()->where('pinned', '=', 'Y')->get();
    }

    public function planable()
    {
        return $this->morphTo();
    }
}
