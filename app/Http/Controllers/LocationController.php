<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Handler;
use App\Location as Location;

use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{

    //Only authenticated users can delete a Location
    public function __construct()
    {
        $this->middleware('auth.basic', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of Locations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Return all Locations
        try {
            // Cache 20seconds
            $locations = Cache::remember('cachelocations', 20 / 60, function () {
                return Location::simplePaginate(10);
            });

            //With cache and pagination
            return response()->json(['status' => 'success', 'next' => $locations->nextPageUrl(), 'previous' => $locations->previousPageUrl(), 'data' => $locations->items()], 200);

            //With cache.
            //return response()->json(['status' => 'success', 'data' => $locations], 200);
            //Without cache
            //return response()->json(['status' => 'success', 'data' => Location::all()], 200);
        } catch (Handler $e) {
            return response()->json(['error' => 'Error finding locations'], 400);
        }
    }

    /**
     * Display the specified Location.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            //Find Location by id
            $location = Location::find($id);

            //If the Location does not exist, return an error.
            if (!$location) {
                return response()->json(['errors' => array(['code' => 404, 'message' => 'Not found Location with this id.'])], 404);
            }

            return response()->json(['status' => 'ok', 'data' => $location], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Error finding the Location'], 400);
        }
    }


    /**
     * Update the specified Location in storage.
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

            $location = Location::find($id);

            // Check if the Location exists.
            if (!$location) {
                return response()->json(['errors' => array(['code' => 404, 'message' => 'Not found Location with this id.'])], 404);
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
                    $location->name = $name;
                    $flag = true;
                }

                if ($image) {
                    $location->image = $image;
                    $flag = true;
                }

                if ($location) {
                    $location->location = $location;
                    $flag = true;
                }

                if ($status) {
                    $location->status = $status;
                    $flag = true;
                }

                if ($flag) {
                    // Save the Location in Database.
                    $location->save();
                    return response()->json(['status' => 'ok', 'data' => $location], 200);
                } else {
                    return response()->json(['errors' => array(['code' => 304, 'message' => 'Not Modified Location.'])], 304);
                }
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Error finding the Location'], 400);
        }
    }


    /**
     * Remove the specified Location from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            //
            try {

                $location = Location::find($id);

                // Error if this location is not found
                if (!$location) {
                    return response()->json(['errors' => array(['code' => 404, 'message' => 'Not found Location with this id.'])], 404);
                }

                // Deleting the location
                $location->delete();

                return response()->json(['code' => 204, 'message' => 'Location deleted.'], 204);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Error finding the Location'], 400);
            }
        } else
            return response('Unauthorized.', 401);
    }
}
