<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags';

    public function photos()
    {
        return $this->morphedByMany('App\Photo', 'taggable');
    }
}
