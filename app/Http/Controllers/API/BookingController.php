<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index()
    {
        return Booking::with(['user', 'seat'])->get();
    }

    public function store(BookingRequest $request)
    {
        $booking = Booking::create($request->validated());
        return response()->json(['message' => 'Booking created', 'data' => $booking], 201);
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'seat'])->findOrFail($id);
        return response()->json($booking);
    }

    public function update(BookingRequest $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->validated());
        return response()->json(['message' => 'Booking updated', 'data' => $booking]);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return response()->json(['message' => 'Booking deleted']);
    }
}
