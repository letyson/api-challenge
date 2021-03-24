<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('/characters', 'Api\CharacterController@getCharacters');
Route::post('/character', 'Api\CharacterController@createCharacter');
Route::put('/character/{id}', 'Api\CharacterController@updateCharacter');
Route::delete('/character/{id}', 'Api\CharacterController@deleteCharacter');

Route::get('/locations', 'Api\LocationController@getLocations');
Route::post('/location', 'Api\LocationController@createLocation');
Route::put('/location/{id}', 'Api\LocationController@updateLocation');
Route::delete('/location/{id}', 'Api\LocationController@deleteLocation');


// Reset state before starting test
Route::post('/reset', 'ResetController@reset');
