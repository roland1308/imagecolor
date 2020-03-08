<?php

namespace App\Http\Controllers;

use App\FileUpload;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        if ($request->get('image')) {
            $image = $request->get('image');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('image'))->save(public_path('images/') . $name);
        }

        //NO NEED TO ADD INTO DB
        // $image = new FileUpload();
        // $image->image_name = $name;
        // $image->save();

        return response()->json(['success' => public_path('images/') . $name], 200);
    }

    public function check(Request $request)
    {
        $resultado =  "image = new Imagick()";
        if (extension_loaded('imagick')) {
            $resultado = "SIIII";
        }

        return response()->json(['success' => $resultado], 200);
    }
}
