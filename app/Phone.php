<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //
    protected $table = 'phones';
    protected $fillable = [
    	'club_id', 'value', 'postal_code'
    ];
}
