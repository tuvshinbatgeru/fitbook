<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mentionable
{
	static public function mentionedBy($mentionable, $obj)
    {
        DB::table('mentionables')->insert([
            'mention_id' => $mentionable->id, 
            'mention_type' => get_class($mentionable),   
            'mentionable_id' => $obj->id, 
            'mentionable_type' => get_class($obj),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
