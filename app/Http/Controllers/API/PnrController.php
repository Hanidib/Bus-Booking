<?php

namespace App\Http\Controllers\API;

use App\Models\Pnr;
use App\Http\Controllers\Controller;
use App\Http\Requests\PnrRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PnrController extends Controller
{
    public function index()
    {
        return response()->json(Pnr::with('booking')->get());
    }

    public function store(Request $request)
    {
        // Step 1: Validate the bookingId
        $validated = $request->validate([
            'bookingId' => 'required|exists:bookings,bookingId',
        ]);

        // Step 2: Create the PNR with validated bookingId
        $pnr = Pnr::create([
            'bookingId' => $validated['bookingId'],
            'pnrCode' => strtoupper(Str::random(8)), // Generate a random PNR code
            'issuedAt' => now(),
        ]);

        return response()->json(['pnr' => $pnr], 201);
    }


    public function show(Pnr $pnr)
    {
        return response()->json($pnr->load('booking'));
    }

    public function update(PnrRequest $request, Pnr $pnr)
    {
        $pnr->update($request->validated());
        return response()->json($pnr);
    }

    public function destroy(Pnr $pnr)
    {
        $pnr->delete();
        return response()->json(['message' => 'PNR has been deleted'], 200);
    }
}
