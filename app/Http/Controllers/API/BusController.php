<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        return response()->json($buses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'busNumber' => 'required|unique:buses,busNumber',
            'busType' => 'required|string',
            'totalSeats' => 'required|integer|min:1',
        ]);

        $bus = Bus::create([
            'busNumber' => $request->busNumber,
            'busType' => $request->busType,
            'totalSeats' => $request->totalSeats,
        ]);

        return response()->json([
            'message' => 'Bus created successfully.',
            'bus' => $bus
        ], 201);
    }

    public function show($id)
    {
        $bus = Bus::findOrFail($id);
        return response()->json($bus);
    }

    public function update(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);

        $request->validate([
            'busNumber' => 'required|unique:buses,busNumber,' . $bus->busId . ',busId',
            'busType' => 'required|string',
            'totalSeats' => 'required|integer|min:1',
        ]);

        $bus->update([
            'busNumber' => $request->busNumber,
            'busType' => $request->busType,
            'totalSeats' => $request->totalSeats,
        ]);

        return response()->json([
            'message' => 'Bus updated successfully.',
            'bus' => $bus
        ]);
    }

    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);
        $bus->delete();

        return response()->json([
            'message' => 'Bus deleted successfully.'
        ]);
    }
}
