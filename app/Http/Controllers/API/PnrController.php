<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PnrRequest;
use App\Models\Pnr;

class PnrController extends Controller
{
    public function index()
    {
        return response()->json(Pnr::all());
    }

    public function store(PnrRequest $request)
    {
        $pnr = Pnr::create($request->validated());
        return response()->json(['message' => 'PNR created', 'data' => $pnr]);
    }

    public function show($id)
    {
        $pnr = Pnr::findOrFail($id);
        return response()->json($pnr);
    }

    public function update(PnrRequest $request, $id)
    {
        $pnr = Pnr::findOrFail($id);
        $pnr->update($request->validated());
        return response()->json(['message' => 'PNR updated', 'data' => $pnr]);
    }

    public function destroy($id)
    {
        $pnr = Pnr::findOrFail($id);
        $pnr->delete();
        return response()->json(['message' => 'PNR deleted']);
    }
}
