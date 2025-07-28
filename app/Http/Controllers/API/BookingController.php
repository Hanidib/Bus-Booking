<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Seat;
use App\Models\Pnr;



class BookingController extends Controller
{
    public function index()
    {
        return response()->json(Booking::with(['user', 'seat.bus', 'route'])->get());
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

    public function update(BookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        return response()->json($booking);
    }

    public function destroy(Booking $booking)
    {

        // ❌ Delete booking
        $booking->delete();
        return response()->json(['message' => 'Booking has been deleted'], 200);
    }
}
