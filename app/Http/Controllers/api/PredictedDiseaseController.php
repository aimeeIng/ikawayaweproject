<?php

namespace App\Http\Controllers\api;

use App\Models\PredictedDisease;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PredictedDiseaseController extends Controller
{
    public function ReportingDisease(Request $request, $id)
        {
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            
            $Manager_id = auth()->user()->id;
            $cooperative_id = DB::table('cooperative_user')
                                ->where('user_id', $Manager_id)
                                ->value('cooperative_id');
            
            $reported_disease = new ReportedDisease();
            $reported_disease->cooperative_id = $cooperative_id;
            $reported_disease->disease_id = $id;
            $reported_disease->disease_category = Disease::where('id', $id)->value('category');
            // Set the latitude and longitude values in the reported disease
            $reported_disease->latitude = $latitude;
            $reported_disease->longitude = $longitude;

            if ($reported_disease->save()) {
                return redirect()->back()->with('success', 'Disease reported successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong, disease not reported');
            }
        }

        public function count() {
            //$count = Disease::count();
            $count = PredictedDisease::where('user_id', Auth::user()->id)->count();
            return response()->json(['count'=>$count], 200);
        }


    public function create(Request $request){

        $predictedDisease = new PredictedDisease;
        $predictedDisease->user_id = Auth::user()->id;
        $predictedDisease->classified = $request->classified;
        $predictedDisease->confidence = $request->confidence;
        $predictedDisease->latitude = $request->latitude;
        $predictedDisease->longitude = $request->longitude;

        if($request->image != ''){
            $image = time().'.jpg';
            file_put_contents('storage/reported_disease/'.$image,base64_decode($request->image));
            $predictedDisease->image = $image;
        }
        $predictedDisease->save();
        $predictedDisease->user;
        return response()->json([
            'success' => true,
            'message' => 'posted',
            'predictedDisease' => $predictedDisease
        ]);
    }

    public function update(Request $request){
        $predictedDisease = PredictedDisease::find($request->id);
        if(Auth::user()->id != $request->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $predictedDisease->classified = $request->classified;
        $predictedDisease->confidence = $request->confidence;
        $predictedDisease->update();
        return response()->json([
            'success' => true,
            'message' => 'PredictedDisease updated '
        ]);
    }

    public function delete(Request $request){
        $predictedDisease = PredictedDisease::find($request->id);
        if(Auth::user()->id != $request->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        if($predictedDisease->image != ''){
            Storage::delete('public/reported_disease/'.$predictedDisease->predictedDisease);
        }
        $predictedDisease->delete();
        return response()->json([
            'success' => true,
            'message' => 'Disease deleted Successfully'
        ]);
    }
     public function latest(Request $request){
        $diseases = PredictedDisease::whereDate('created_at', \DB::raw('CURDATE()'))->get();
        return response()->json(['diseases'=>$diseases], 200);
    }

    public function predictedDiseases(){
        $predictedDiseases = PredictedDisease::orderBy('id','desc')->get();
        foreach($predictedDiseases as $predictedDisease){
            $predictedDisease->user;
            
        }
        return response()->json([
            'success' => true,
            'PredictedDisease' => $predictedDisease
        ]);
      
    }
    public function pDiseases(){
        $diseases = PredictedDisease::orderBy('id','desc')->get();
        foreach($diseases as $disease){
            $disease->user;
            
        }
        return response()->json([
            'success' => true,
            'diseases' => $diseases
        ]);
      
    }
}
