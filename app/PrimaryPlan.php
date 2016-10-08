<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrimaryPlan extends Model
{
    //
    protected $table = 'primary_plan';

    protected $fillable = [
    	'start_date'
    ];

    public function plan()
    {
    	return $this->morphOne('App\Plan', 'planable');	
    }
}
