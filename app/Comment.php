<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $primaryKey = 'id';
	protected $table = 'comments';

	protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type','message', 'thumbs_up'
    ];

    public function thumbsUp() {
    	return $this->hasMany('App\Reaction', 'actionable_id');
    }

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
