<?php

namespace App\Http\Controllers\API;

use App\Models\Seat;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeatRequest;

class SeatController extends Controller
{
    public function index()
    {
        return response()->json(Seat::with('bus')->get());
    }

    public function store(SeatRequest $request)
    {
        $seat = Seat::create($request->validated());
        return response()->json($seat, 201);
    }

    public function show(Seat $seat)
    {
        return response()->json($seat->load('bus'));
    }

    public function update(SeatRequest $request, Seat $seat)
    {
        $seat->update($request->validated());
        return response()->json($seat);
    }

    public function destroy(Seat $seat)
    {
        $seat->delete();
        return response()->json(['message' => 'Seat has been deleted'], 200);
    }
}
