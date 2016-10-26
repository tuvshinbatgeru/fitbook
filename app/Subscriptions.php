<?php

namespace App;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    //
    protected $table = 'subscriptions';
    protected $fillable = [
        'club_id', 'user_id', 'plan_id','begin_date', 'end_date'
    ];

    static public function filter($query, QueryFilter $filters)
    {
    	return $filters->apply($query);
    }

    public function plan()
    {
    	return $this->belongsTo('App\Plan');
    }

    public function club()
    {
        return $this->belongsTo('App\Club');
    }    
}
