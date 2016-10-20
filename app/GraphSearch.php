<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GraphSearch extends Model
{
    //
    protected $table = 'graph_search';

    public function searchable()
    {
    	return $this->morphTo();
    }
}
