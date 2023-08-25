<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\ReportedDisease;
use App\Http\Requests\DiseaseRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //
    public function reportedDiseases(){
        $diseases = reportedDisease::orderBy('id','desc')->get();
        foreach($diseases as $disease){
            $disease->user;
            
        }
        return response()->json([
            'success' => true,
            'diseases' => $diseases
        ]);
      
    }

    public function showReportedById($id) {
        $diseases = reportedDisease::find($id);
        return response()->json(['diseases'=>$diseases], 200);
    }
    public function store(Request $request){

        $disease = new reportedDisease;

        try{
            $disease->disease_category = $request->disease_category;
            $disease->confindence = $request->confindence;
            $image = '';
            if($request->image!=''){
                
                $image = time().'.jpg';
               
                file_put_contents('storage/reported_diseases/'.$image,base64_decode($request->image));
                $disease->image = $image;
            }
            $disease->save();
            return response()->json([
                'message' => "Post successfully created."
            ],200);;
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }
    }
}
