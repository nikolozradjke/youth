<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Validator;

class CKEditorUploadController extends Controller
{
    function uploadImage(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validation->passes()) {
            $image = $request->file('upload');

            $fname = Storage::disk('public')->put("ck", $image);
            return response()->json([
                'uploaded' => 1,
                'fileName' => $fname,
                'url' => asset('/storage/'. $fname),
            ]);
        } else {
            return response()->json([
                "uploaded" => 0,
                "error" => ["message" => "Error while Uploading. File Should be [jpeg,png,jpg,gif] and max size of 2MB"]
            ]);
        }
    }
}
