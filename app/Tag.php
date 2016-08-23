<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags';

    const TRAINING_ID = 1;
    const PLAN_ID = 2;
    const PROFILE_ID = 3;

    public function photos()
    {
        return $this->morphedByMany('App\Photo', 'taggable');
    }
}
