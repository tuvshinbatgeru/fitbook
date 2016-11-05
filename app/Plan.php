<?php

namespace App;

use App\Filters\QueryFilter;
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

    public function graph()
    {
        return $this->pinnedPhotos();
    }

    static public function filter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function visitors()
    {
        return $this->belongsToMany('App\User', 'plan_visitor', 'plan_id', 'user_id')
                    ->withPivot('hits', 'visit_date')
                    ->withTimestamps();
    }

    public function photos()
    {
    	return $this->belongsToMany('App\Photo', 'plan_photos', 'plan_id', 'photo_id')
    			->withPivot('pinned','top', 'left')
    			->withTimestamps();
    }

    public function pinnedPhotos()
    {
        return $this->belongsToMany('App\Photo', 'plan_photos', 'plan_id', 'photo_id')->withPivot('top', 'pinned', 'left')
                ->where('pinned', '=', 'Y');
    }

    public function subscriptions()
    {
        return $this->belongsToMany('App\User', 'subscriptions', 'plan_id', 'user_id')->withPivot('club_id', 'begin_date', 'end_date')
                ->withTimestamps();
    }

    public function heartsActions()
    {
        return $this->reactions()->where('action_type', 'App\HeartAction');   
    }

    public function reactions()
    {
        return $this->hasMany('App\Reaction', 'actionable_id');
    }

    public function teachers()
    {
    	return $this->belongsToMany('App\User', 'plan_teacher', 'plan_id', 'teacher_id')
    			->withTimestamps();
    }

    public function firstTwoTeachers()
    {
        return $this->belongsToMany('App\User', 'plan_teacher', 'plan_id', 'teacher_id')
            ->take(2);
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

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function histories()
    {
        return $this->belongsToMany('App\User', 'plan_adjustments', 'plan_id', 'user_id')
                ->withPivot('before', 'after')
                ->withTimestamps();   
    }
}
