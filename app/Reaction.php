<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    //
    protected $table = 'reactions';

    protected $fillable = [
        'user_id', 'action_id', 'action_type','actionable_id', 'actionable_type'
    ];

    static public function makeModel($type, $id = 1)
    {
    	$table = 'App\\' . $type;
    	$instance = new $table;
    	$instance->id = $id;

    	return $instance;
    }
}
