<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
    	\Log::info('request = '. $request->useCircleDetector);
    	\Log::info('center = '. $request->center);
    	\Log::info('radius = '. $request->radius);
    	return Club::latest()->get();
    	/*return Club::latest()->where('is_active','=', 'Y')->get();*/
    }
}
