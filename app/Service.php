<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $table = 'service';

    static public function verifiedServices()
    {
    	return static::where('verified', '=', 'Y')->get();
    }

    /*public function check($array)
    {
    	for($i = 0; $i < $array->lenght(); $i ++)
    	{
    		if($this->id == $array[$i]->id) {
    			continue;
    		}

    			
    	}
    }*/

    public function compareById($id)
    {
    	return $this->id == $id;	
    }
}
