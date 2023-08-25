<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login','App\\Http\\Controllers\api\UserController@login');

Route::post('register','App\\Http\\Controllers\api\ReportersController@register');

// Route::post('/disease/store','App\\Http\\Controllers\CategoryController@store');

Route::middleware(['auth:api'])->group(function (){
    // user
    Route::get('user','App\\Http\\Controllers\api\UserController@index');
    Route::post('logout','App\\Http\\Controllers\api\UserController@logout');

    //diseases
    Route::post('/disease/store','App\\Http\\Controllers\api\DiseaseController@store');
    Route::get('/diseases','App\\Http\\Controllers\api\DiseaseController@diseases');
    Route::post('/disease/report','App\\Http\\Controllers\api\DiseaseController@create');
    Route::get('/disease/{id}/show','App\\Http\\Controllers\api\DiseaseController@show');
    Route::post('/disease/delete','App\\Http\\Controllers\api\DiseaseController@delete');
    Route::get('/latest','App\\Http\\Controllers\api\DiseaseController@latest');
    
    Route::get('/count/diseases','App\\Http\\Controllers\api\DiseaseController@count');

    //cooperative

    Route::post('/cooperative/store','App\\Http\\Controllers\api\CooperativeController@store');
    Route::get('/cooperatives','App\\Http\\Controllers\api\CooperativeController@allCooperatives');
    Route::post('/cooperative/report','App\\Http\\Controllers\api\CooperativeController@create');
    Route::get('/cooperative/{id}/show','App\\Http\\Controllers\api\CooperativeController@show');
    Route::post('/cooperative/delete','App\\Http\\Controllers\api\CooperativeController@delete');
    Route::get('/cooperative/latest','App\\Http\\Controllers\api\CooperativeController@latest');
    
    Route::get('/count/cooperative','App\\Http\\Controllers\api\CooperativeController@count');

    //predicted diseases
    Route::post('/predicted/update','App\\Http\\Controllers\api\PredictedDiseaseController@update');
    Route::post('/predicted/delete','App\\Http\\Controllers\api\PredictedDiseaseController@delete');
    Route::get('/predicteddiseases','App\\Http\\Controllers\api\PredictedDiseaseController@predictedDiseases');
    Route::get('/pdiseases','App\\Http\\Controllers\api\PredictedDiseaseController@pDiseases');
    Route::post('/predicted/report','App\\Http\\Controllers\api\PredictedDiseaseController@create');
    Route::get('/predicted/{id}/show','App\\Http\\Controllers\api\PredictedDiseaseController@show');
    Route::get('/count/predictedDisease','App\\Http\\Controllers\api\PredictedDiseaseController@count');

    //reported Diseases
    Route::get('/reportedDiseases','App\\Http\\Controllers\api\CategoryController@reportedDiseases');
    Route::get('/disease/{id}/reportedById','App\\Http\\Controllers\api\CategoryController@showReportedById');

});

Route::get('/get','App\\Http\\Controllers\api\DiseaseController@getDisease');
// Route::post('disease', ['App\\Http\\Controllers\DiseaseController'::class, 'store']);