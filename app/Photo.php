<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

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

    public function attachTag($tagId)
    {
        if($this->tags()->where('id','=', $tagId)->first()) return;
        return $this->tags()->attach($tagId);
    }

    public function attachTagIfnotExist($tagId)
    {
        if($this->tags()->where('id','=', $tagId)->exists()) return;
        return $this->tags()->attach($tagId);   
    }

    static public function attachTagById($id, $tagId)
    {
        $photo = static::findOrFail($id);
        $photo->attachTag($tagId);
    }

    public function deleteWithPicture()
    {        
        $files = explode('/', $this->url);
        File::delete(public_path() . '/images/users/thumbnails/' . $files[count($files) - 1]);
        $this->delete();
    }

    public function equalAsString($otherId)
    {
        if (strcmp(strval($this->id), strval($otherId)) == 0) {
            return true;
        }
        return false;
    }
}
