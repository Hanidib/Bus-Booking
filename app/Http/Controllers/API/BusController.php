<?php

namespace App\Http\Controllers\API;

use App\Models\Bus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusRequest;
use App\Models\Seat;

class BusController extends Controller
{
    public function index()
    {
        return response()->json(Bus::with('seats')->get());
    }

    public function store(BusRequest $request)
    {
        $bus = Bus::create($request->validated());
        return response()->json($bus, 201);
    }

    public function show(Bus $bus)
    {
        return response()->json($bus->load('seats'));
    }

    public function update(BusRequest $request, Bus $bus)
    {
        $bus->update($request->validated());
        return response()->json($bus);
    }

    public function destroy(Bus $bus)
    {

        $bus->seats()->delete();
        $bus->delete();
        return response()->json(['message' => 'Bus deleted successfully']);
    }

    public function availableSeats($busId)
    {
        $seats = Seat::where('busId', $busId)
            ->where('isAvailable', true)
            ->get();
        return response()->json($seats);
    }
}
