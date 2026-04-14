<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Cloudinary\Cloudinary;

class PhotoController extends Controller
{
    //
    public function index()
    {
        $photos = Photo::latest()->get();
        return view('welcome', compact('photos'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,heic,heif,webp,svg,bmp,tiff,mp4,mov,avi,wmv,mkv,webm|max:51200'
        ]);

        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));

        $uploadResult = $cloudinary->uploadApi()->upload(
            $request->file('image')->getRealPath(), ['folder' => 'photos']
        );

        $original_url = $uploadResult['secure_url'];
        $display_url = preg_replace('/\.[^.]+$/', '.jpg', $original_url);

        Photo::create([
            'title' => $request->title,
            'file_path' => $display_url,
            'public_id' => $uploadResult['public_id']
        ]);

        return back();

    }


    public function destroy($id){

        $photo = Photo::findOrFail($id);

        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));

        $cloudinary->uploadApi()->destroy($photo->public_id);

        $photo->delete();

        return back();
    }

}
