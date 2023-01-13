<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewController extends Controller
{
    public function store(Request $request){
        
        $store = Review::create([
            'dificulty' => $request->dificulty,
            'age' => $request->age,
            'improvement' => implode(",", $request->improvement),
            'pages' => $request->pages,
            'review' => $request->review
        ]);

        if($store)
        {
            return redirect()->back();
            // return response()->json([
            //     'status' => 1,
            //     'desc' => trans('web.review_success')
            // ]);
        }
        
        return response()->json([
                'status' => 0,
                'desc' => trans('web.review_error')
            ]);
        
    }
}
