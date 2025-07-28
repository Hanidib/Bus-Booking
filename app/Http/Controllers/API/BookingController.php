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
        $validated = $request->validated();

        // 🔍 Check if the seat is available
        $seat = Seat::find($validated['seatId']);
        if (!$seat || !$seat->isAvailable) {
            return response()->json([
                'message' => 'This seat is already booked or does not exist.'
            ], 400); // Bad Request
        }

        // ✅ Create booking
        $booking = Booking::create([
            'userId' => $validated['userId'],
            'routeId' => $validated['routeId'],
            'seatId' => $validated['seatId'],
            'bookingDate' => now(),
            'status' => 'confirmed',
        ]);

        // ❌ Mark seat as unavailable
        $seat->isAvailable = false;
        $seat->save();

        // ✅ Create PNR
        $pnr = Pnr::create([
            'bookingId' => $booking->bookingId,
            'pnrCode' => strtoupper(uniqid('PNR')),
            'issuedAt' => now()
        ]);

        return response()->json([
            'booking' => $booking,
            'pnr' => $pnr
        ], 201);
    }



    public function show(Booking $booking)
    {
        return response()->json($booking->load(['user', 'seat', 'route']));
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
