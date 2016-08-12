<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    //
    protected $primaryKey = 'id';
	protected $table = 'training';

	protected $fillable = [
        'club_id', 'name', 'description','price', 'priceless', 'is_active'
    ];
}
