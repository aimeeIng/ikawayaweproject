<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\Disease;
use App\Http\Requests\DiseaseRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DiseaseController extends Controller
{
   
    public function getDisease(){
        $images=Disease::orderBy('id','DESC')->get();
        return response()->json($images);
    }
    public function diseasesbyid(){
        $diseases = Disease::orderBy('id','desc')->get();
        foreach($diseases as $disease){
            $disease->user;
            
        }
        return response()->json([
            'success' => true,
            'PredictedDisease' => $disease
        ]);
      
    }

    public function diseases(){
        $diseases = Disease::orderBy('id','desc')->get();
        foreach($diseases as $disease){
            $disease->user;
            
        }
        return response()->json([
            'success' => true,
            'diseases' => $diseases
        ]);
      
    }
    public function count() {
        $count = Disease::count();
        return response()->json(['count'=>$count], 200);
    }
    
    public function show($id) {
        $diseases = Disease::find($id);
        return response()->json(['diseases'=>$diseases], 200);
    }

    public function store(Request $request){
        $disease = new Disease;
        try{
            // $disease->user_id = Auth::user()->id;
            $disease->disease_name = $request->disease_name;
            $disease->category = $request->category;
            $image = '';
            $disease->description = $request->description;
            if($request->image!=''){
                
                $image = time().'.jpg';
                
                file_put_contents('storage/diseases/'.$image,base64_decode($request->image));
                $disease->image = $image;
            }
            $disease->save();
            return response()->json([
                'message' => "Post successfully created."
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }

        
    }
    public function latest(Request $request){
        $diseases = Disease::latest()->take(2)->get();
        // foreach($diseases as $disease){
        //     $disease->user;
            
        // }
        return response()->json(['diseases'=>$diseases], 200);
    }
    
    public function delete(Request $request){
        $disease = Disease::find($request->id);
        // if(Auth::user()->id != $request->id){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'unauthorized access'
        //     ]);
        // }
        if($disease->photo != ''){
            Storage::delete('public/diseases/'.$disease->disease);
        }
        $disease->delete();
        return response()->json([
            'success' => true,
            'message' => 'Disease deleted '
        ]);
    }
}

    

