<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Opportunity;

class AbilityController extends BaseController
{
    public function abilities(){
        $oportunities = Opportunity::where('inactive', 0)->whereNotNull(['longitude', 'latitude'])->select('id', 'name', 'longitude', 'latitude', 'image')->get();
        // dd($oportunities[0]->getImagePath());
        $response = [];
        foreach($oportunities as $key => $op){
            $response[$key] = [
                    'name' => $op->name,
                    'longitude' => $op->longitude,
                    'latitude' => $op->latitude,
                    'image' => asset('/storage/' . $op->getImagePath()),
                    'url' => route('opportunity', $op->id)
                ];
        }

        return view('client.ability.abilities', compact('response'));
    }
    public function library(){
        return view('test.library');
    }
}
