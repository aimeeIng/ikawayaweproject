<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\Cooperative;
use Illuminate\Support\Str;


class CooperativeController extends Controller
{
    public function allCooperatives(){
        $cooperatives = Cooperative::orderBy('id','desc')->get();
        foreach($cooperatives as $cooperative){
            $cooperative->user;
            
        }
        return response()->json([
            'success' => true,
            'cooperatives' => $cooperatives
        ]);
      
    }

    public function count() {
        $count = Cooperative::count();
        return response()->json(['count'=>$count], 200);
    }
}
