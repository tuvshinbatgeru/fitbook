<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class FileManagerController extends Controller
{
    //
    public function resizeImage()
    {
    	return view('resizeImage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImagePost(Request $request)
    {
	    /*$this->validate($request, [
	    	'title' => 'required',
        ]);*/

        $images = $request->file('image');

        foreach ($images as $image) {

        	$im = file_get_contents($image);
        	$ext = pathinfo($image, PATHINFO_EXTENSION);
			$imageUrl = 'data:image/' . $ext . ';base64,' . base64_encode($im);

        	$photo = new Photos;
        	$photo->type = 1;
        	$photo->object_id = Auth::user()->id;
        	$photo->image = $imageUrl;
        	$photo->ext = $ext;
        	$photo->save();
        }

        return back()
        	->with('success','Image Upload successful')
        	->with('imageUrl', $imageUrl);

        dd($imdata);
        dd(file_get_contents($image[0]));
        dd($image);
        /*$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
     
   
        $destinationPath = public_path('thumbnail');

        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
		    $constraint->aspectRatio();
		})->save($destinationPath.'/'.$input['imagename']);

        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imagename']);*/

        //$this->postImage->add($input);

        return back()
        	->with('success','Image Upload successful')
        	->with('imageName',$input['imagename']);
    }
}
