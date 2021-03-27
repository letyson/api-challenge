<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Handler;
use App\Character as Character;

use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{

    //Only authenticated users can delete a Character
    public function __construct()
    {
        $this->middleware('auth.basic', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of Characters.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Return all Characters
        try {
            // Cache 20seconds
            $characters = Cache::remember('cachecharacters', 20 / 60, function () {
                return Character::simplePaginate(10);
            });

            //With cache and pagination
            return response()->json(['status' => 'success', 'next' => $characters->nextPageUrl(), 'previous' => $characters->previousPageUrl(), 'data' => $characters->items()], 200);

            //With cache.
            //return response()->json(['status' => 'success', 'data' => $characters], 200);
            //Without cache
            //return response()->json(['status' => 'success', 'data' => Character::all()], 200);
        } catch (Handler $e) {
            return response()->json(['error' => 'Error finding characters'], 400);
        }
    }

    /**
     * Display the specified Character.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            //Find Character by id
            $character = Character::find($id);

            //If the Character does not exist, return an error.
            if (!$character) {
                return response()->json(['errors' => array(['code' => 404, 'message' => 'Not found Character with this id.'])], 404);
            }

            return response()->json(['status' => 'ok', 'data' => $character], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Error finding the Character'], 400);
        }
    }


    /**
     * Update the specified Character in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if (!$id) {
            return response()->json(['error' => 'There was an error in your request, please try again'], 400);
        }

        try {

            $character = Character::find($id);

            // Check if the Character exists.
            if (!$character) {
                return response()->json(['errors' => array(['code' => 404, 'message' => 'Not found Character with this id.'])], 404);
            }

            //Fields received.
            $name = $request->input('name');
            $status = $request->input('status');
            $location = $request->input('location');
            $image = $request->input('image');
            /*
        $species = $request->input('species');
        $type = $request->input('type');
        $gender = $request->input('gender');
        $origin = $request->input('origin');
        $episode = $request->input('episode');
         */


            if ($request->method() === 'PATCH') {
                //Flag to control what fields are changed (PATCH method)
                $flag = false;

                // Updating the changed fields
                if ($name) {
                    $character->name = $name;
                    $flag = true;
                }

                if ($image) {
                    $character->image = $image;
                    $flag = true;
                }

                if ($location) {
                    $character->location = $location;
                    $flag = true;
                }

                if ($status) {
                    $character->status = $status;
                    $flag = true;
                }

                if ($flag) {
                    // Save the Character in Database.
                    $character->save();
                    return response()->json(['status' => 'ok', 'data' => $character], 200);
                } else {
                    return response()->json(['errors' => array(['code' => 304, 'message' => 'Not Modified Character.'])], 304);
                }
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Error finding the Character'], 400);
        }
    }


    /**
     * Remove the specified Character from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            //
            try {

                $character = Character::find($id);

                // Error if this character is not found
                if (!$character) {
                    return response()->json(['errors' => array(['code' => 404, 'message' => 'Not found Character with this id.'])], 404);
                }

                // Deleting the character
                $character->delete();

                return response()->json(['code' => 204, 'message' => 'Character deleted.'], 204);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Error finding the Character'], 400);
            }
        } else
            return response('Unauthorized.', 401);
    }
}
