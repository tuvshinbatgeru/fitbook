<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Photo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Response;

class FileManagerController extends Controller
{
    public function test(Request $request)
    {
        dd($request->all());    
    }

    public function files(Request $request)
    {	
        $selected = explode(',', $request->selected);
        $maxSize = Auth::user()->maxFileUpload();
        $photos = Auth::user()->photosWithoutAvatar;
        $actualSize = 0;

        foreach ($photos as $photo) {
           	$photo->tags;
           	$actualSize += $photo->size;
            $photo->selected = false;

            if(empty($selected)) {
                continue;
            }

            for($i = 0; $i < count($selected); $i ++) {
                if ($photo->equalAsString($selected[$i])) {
                    $photo->selected = true;
                }
            }
        }   

		return Response::json([
        	'files' => $photos,
        	'actualSize' => self::castToMByte($actualSize),
        	'maxSize' => $maxSize,
        ]);
    }

    private function castToMByte($byte)
    {
        return self::customRound($byte / 1024 / 1024, 2);
        
    }

    private function customRound($byte, $precision)
    {
        return round($byte, $precision, PHP_ROUND_HALF_DOWN);
    }

    public function upload(Request $request)
    {	
        $messages = [
            'image.*' => 'Image type must be Jpeg, jpg, png and gif',
            'size' => "photo's size long enought"
        ];

        $validator = Validator::make($request->all(), [
            'image.*' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ], $messages);

        if ($validator->fails()) {
        	return Response::json([
        			'result' => 'failed', 
        			'errors' => $validator->errors()->getMessages(),
        		]);
        }

        $photos = [];

        foreach ($request->file('image') as $image) 
        {
            $image_url = self::generatePhotoId($image);
            $img = Image::make($image->getRealPath());
            $img->save(public_path() 
                      . '/images/users/' 
                      . $image_url);

            $photo = new Photo;
            $photo->type = 1;
            $photo->ext = explode('/', $image->getmimeType())[1];
            $photo->object_id = Auth::user()->id;
            $photo->size = $image->getSize(); 
            $photo->ratio = self::calcRatio($image); 
            $photo->url = App::make('url')->to('/') . '/images/users/' . $image_url;
            $photo->save();
            $photo->selected = true;
            $photos = $photo;
        }
        
        return Response::json([
        		'result' => 'success',
        		'data' => $photos,
        ]);
    }   

    private function calcRatio($image)
    {
        $detail = getimagesize($image);
        return $detail[1] / $detail[0];  
    }

    private function generatePhotoId($image)
    {
        return md5(Auth::user()->id . 'user')
            . strtotime(Carbon::now()) 
            . $image->getClientOriginalName();
    }
}
