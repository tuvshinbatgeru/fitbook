<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
    protected $table = 'photos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'object_id', 'ext', 'image', 'ratio', 'size'
    ];

    public $timestamps = false;

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function equalAsString($otherId)
    {
        if (strcmp(strval($this->id), strval($otherId)) == 0) {
            return true;
        }
        return false;
    }
}
