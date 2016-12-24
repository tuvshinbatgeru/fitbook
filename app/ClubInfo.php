<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubInfo extends Model
{
    //
    protected $table = 'club_info';

    protected $fillable = [
    	'club_id', 'is_fulltime', 'open_time',
    	'close_time'
    ];
}
