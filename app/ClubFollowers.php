<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubFollowers extends Model
{
    //
	protected $table = 'followers';

	protected $fillable = [
        'club_id', 'user_id'
    ];
}
