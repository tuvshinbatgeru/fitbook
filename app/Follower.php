<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    //
    protected $table = 'followers';
    protected $fillable = [
        'user_id', 'followable_id', 'followable_type'
    ];

    public function followable()
    {
        return $this->morphTo();
    }
}
