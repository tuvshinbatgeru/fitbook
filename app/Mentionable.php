<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentionable
{
	public function mentionedBy($mentionable, $obj)
    {
        Illuminate\Support\Facades\DB::table('mentionables')->insert([
            'mention_id' => $mentionable->id, 
            'mention_type' => get_class($mentionable),   
            'mentionable_id' => $obj->id, 
            'mentionable_type' => get_class($obj),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
}
