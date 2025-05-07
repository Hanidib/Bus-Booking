<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RouteRequest;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        return response()->json($routes);
    }

    public function store(RouteRequest $request)
    {
        $route = Route::create($request->validated());

        return response()->json([
            'message' => 'Route created successfully.',
            'route' => $route,
        ], 201);
    }

    public function show($id)
    {
        $route = Route::findOrFail($id);
        return response()->json($route);
    }

    public function update(RouteRequest $request, $id)
    {
        $route = Route::findOrFail($id);
        $route->update($request->validated());

        return response()->json([
            'message' => 'Route updated successfully.',
            'route' => $route,
        ]);
    }

    public function destroy($id)
    {
        $route = Route::findOrFail($id);
        $route->delete();

        return response()->json([
            'message' => 'Route deleted successfully.',
        ]);
    }
}
