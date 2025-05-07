<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeatRequest;
use App\Models\Seat;

class SeatController extends Controller
{
    public function index()
    {
        return response()->json(Seat::all());
    }

    public function store(SeatRequest $request)
    {
        $seat = Seat::create($request->validated());
        return response()->json(['message' => 'Seat created', 'data' => $seat], 201);
    }

    public function show($id)
    {
        $seat = Seat::findOrFail($id);
        return response()->json($seat);
    }

    public function update(SeatRequest $request, $id)
    {
        $seat = Seat::findOrFail($id);
        $seat->update($request->validated());
        return response()->json(['message' => 'Seat updated', 'data' => $seat]);
    }

    public function destroy($id)
    {
        $seat = Seat::findOrFail($id);
        $seat->delete();
        return response()->json(['message' => 'Seat deleted']);
    }
}
