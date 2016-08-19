<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    //
    protected $primaryKey = 'id';
	protected $table = 'training';

	protected $fillable = [
        'club_id', 'name', 'description','price', 'priceless', 'is_active', 'pinned'
    ];

    public function photos()
    {
    	return $this->belongsToMany('App\Photo', 'training_photos', 'training_id', 'photo_id')
    			->withPivot('pinned')
    			->withTimestamps();
    }

    public function teachers()
    {
    	return $this->belongsToMany('App\User', 'training_teacher', 'training_id', 'user_id')
    			->withTimestamps();
    }
}
