<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Activity;
use App\Library;
use App\LibraryCategory;
use App\StudyCabinet;
use App\StudyCabinetMedia;

class LibraryController extends BaseController
{
    public function index(){
        return view('client.library.index');
    }

    public function in(){
        $activities = StudyCabinet::with('medias')->where('status', 1)->orderBy('id', 'desc')->get();
        
        $researches = Library::where('research', 1)->where('status', 1)->orderBy('id', 'desc')->get();
        
        $library_categories = LibraryCategory::with('children')->whereNull('category_id')->orderBy('id', 'asc')->get();

        $literatures = [];
        if(count($library_categories) > 0){
            $literatures = Library::where('research', 0)->where('status', 1)->where('category_id', $library_categories[0]->id)->orderBy('id', 'desc')->get();
        }
        
        return view('client.library.in', compact('activities', 'researches', 'literatures', 'library_categories'));
    }

    public function getLibraryByCartegory(Request $request){
        $category_id = $request->category;
        $items = Library::where('research', 0)->where('status', 1)->where('category_id', $category_id)->orderBy('id', 'desc')->get();
        $response = [];

        if(count($items) > 0){
            foreach($items as $item){
                $response[] = [
                        'name' => $item->name,
                        'file' => $item->file && asset($item->file),
                        'created_at' => date_format($item->created_at, 'Y.m.d')
                    ];
            }
            return response()->json([
                    'status' => 1,
                    'items' => json_encode($response, JSON_UNESCAPED_UNICODE)
                ]);
        }

        return response()->json([
                    'status' => 0,
                ]);
    }


    public function addLibrary(){
        $userInfo = User::auth();
        $user = $userInfo['user'];
        $guard = $userInfo['guard'];

        $lib_categories = LibraryCategory::whereNull('category_id')->get();

        return view('addLibrary',[
            'user' => $user,
            'guard' => $guard,
            'lib_categories' => $lib_categories
        ]);
    }

    public function storeLibrary(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'lib_cat' => 'required',
            'file' => 'required'
        ]);
        $name = [
            'ka' => $request->name,
            'en' => $request->name
        ];
        $library = new Library();

        $library->name = $name;
        $library->category_id = $request->lib_cat;

        $user = User::auth();
        
        if($user['guard'] == 'web'){
            $library->user_id = $user['user']->id;
        }else{
            $library->company_id = $user['user']->id;
        }
        $folderName = 'library_files';

        $imagePath = $request->file[0]->store($folderName, 'public');
        $imagePath = '/storage/' . $imagePath;

        $library->file = $imagePath;
        $library->save();

        return redirect()->back();

    }

    public function StoreResearch(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'file' => 'required'
        ]);
        $name = [
            'ka' => $request->name,
            'en' => $request->name
        ];
        $library = new Library();

        $library->name = $name;
        $library->research = 1;

        $user = User::auth();

        $user = User::auth();
        if($user['guard'] == 'web'){
            $library->user_id = $user['user']->id;
        }else{
            $library->company_id = $user['user']->id;
        }

        $folderName = 'research_files';

        $imagePath = $request->file[0]->store($folderName, 'public');
        $imagePath = '/storage/' . $imagePath;

        $library->file = $imagePath;
        $library->save();

        return redirect()->back();
    }
    
    public function StoreStudyCabinet(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'duration' => 'max:255',
            'team_size' => 'max:255',
            'activity_size' => 'max:255',
            'activity_level' => 'max:255',
            'file' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);
        
        $name = [
            'ka' => $request->name,
            'en' => $request->name
        ];
        $description = [
            'ka' => $request->description,
            'en' => $request->description
        ];
        
        $study = new StudyCabinet();
        
        $study->name = $name;
        $study->description = $description;
        $study->duration = $request->duration;
        $study->team_size = $request->team_size;
        $study->activity_size = $request->activity_size;
        $study->activity_level = $request->activity_level;
        
        $user = User::auth();

        $user = User::auth();
        if($user['guard'] == 'web'){
            $study->user_id = $user['user']->id;
        }else{
            $study->company_id = $user['user']->id;
        }
        
        $folderName = 'study_cabinet';
            
        $imagepath = $request->image->store($folderName, 'public');
        $imagepath = '/storage/' . $imagepath;      
        
        $study->image = $imagepath;
        
        $study->save();
        foreach($request->file as $file){
            $filepath = $file->store($folderName, 'public');
            $filepath = '/storage/' . $filepath;
            $form_data = [
                    'study_id' => $study->id,
                    'media_url' => $filepath
                ];
            StudyCabinetMedia::create($form_data);    
        }
        
        return redirect()->back();
    }


}
