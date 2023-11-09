<?php

namespace App\Http\Controllers\API\V1;

use App\Events\TripAccepted;
use App\Events\TripEnded;
use App\Events\TripLocationUpdated;
use App\Events\TripStarted;
use App\Http\Controllers\Controller;
use App\Models\Trips;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'destination_name' => 'required'
        ]);

        return  $request->user()->trips()->create(
            $request->only([
                'origin',
                'destination',
                'destination_name'
            ])
        );
    }

    public function show(Request $request, Trips $trips)
    {
        if ($trips->user->id === $request->user()->id) {
            return $trips;
        }

        if ($trips->driver && $request->user()->driver) {
            if ($trips->driver->id === $request->user()->driver->id) {
                return $trips;
            }
        }

        return response()->json(['message' => 'Can not find this trip.', 404]);
    }

    public function accept(Request $request, Trips $trips) 
    {
        $request->validate([
            'driver_location' => 'required',
        ]);

        $trips->update([
            'driver_id' => $request->user()->id,
            'driver_location' => $request->driver_location,
        ]);

        $trips->load('driver.user');

        TripAccepted::dispatch($trips, $request->user());

        return $trips;
    }

    public function start(Request $request, Trips $trips) 
    {
        $trips->update([
            'is_started' => true,
        ]);

        $trips->load('driver.user');

        TripStarted::dispatch($trips, $request->user());

        return $trips;
    }

    public function end(Request $request, Trips $trips) 
    {
        $trips->update([
            'is_complete' => true,
        ]);

        $trips->load('driver.user');

        TripEnded::dispatch($trips, $request->user());

        return $trips;
    }

    public function location(Request $request, Trips $trips) 
    {
        $request->validate([
            'driver_location' => 'required'
        ]);

        $trips->update([
            'driver_location' => $request->driver_location,
        ]);

        $trips->load('driver.user');
        
        TripLocationUpdated::dispatch($trips, $request->user());

        return $trips;
    }
}
