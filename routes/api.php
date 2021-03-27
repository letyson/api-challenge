<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LocationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1/')->group(function () {


    //Route::prefix('v1/')->group(['middleware' => ['web', 'cors']], function () {
    //Route resource Character
    Route::resource('character', 'CharacterController', ['only' => ['index', 'show', 'update']]);

    //Route resource Location
    Route::resource('location', 'LocationController', ['only' => ['index', 'show', 'update']]);

    /*
    Route::get('/locations', 'LocationController@index');
    Route::get('/location/{id}', 'LocationController@show');
    Route::patch('/location/{id}', 'LocationController@update');
    Route::delete('/location/{id}', 'LocationController@delete')->middleware('auth');
 */
});
/*
Route::prefix('api/v1/')->group(['middleware' => ['web', 'auth']], function () {
    Route::resource('character', 'CharacterController', ['only' => ['destroy']]);
});
 */

// Reset state before starting test
Route::post('/reset', 'ResetController@reset');
