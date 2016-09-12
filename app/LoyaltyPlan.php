<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPlan extends Model
{
    //
    protected $table = 'loyalty_plan';

    protected $fillable = [
        'before_price', 'start_date', 'finish_date'
    ];

    public function plan()
    {
    	return $this->morphMany('App\Plan', 'planable');	
    }
}
