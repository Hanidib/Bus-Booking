<?php

namespace App\Http\Controllers\API;

use App\Models\Route;
use App\Http\Controllers\Controller;
use App\Http\Requests\RouteRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RouteController extends Controller
{
    public function index()
    {
        return response()->json(Route::all());
    }

    public function store(RouteRequest $request)
    {
        $validated = $request->validated();

        // Ensure time is in correct format
        if (isset($validated['departureTime'])) {
            $validated['departureTime'] = $this->formatTime($validated['departureTime']);
        }

        $route = Route::create($validated);
        return response()->json($route, 201);
    }

    public function show(Route $route)
    {
        return response()->json($route);
    }

    public function update(RouteRequest $request, Route $route)
    {
        $validated = $request->validated();

        // Handle time format conversion
        if (isset($validated['departureTime'])) {
            try {
                // Try to parse various time formats
                $time = \Carbon\Carbon::createFromFormat(
                    'H:i',
                    $validated['departureTime']
                )->format('H:i');

                $validated['departureTime'] = $time;
            } catch (\Exception $e) {
                // If standard format fails, try to parse any time string
                try {
                    $validated['departureTime'] = \Carbon\Carbon::parse(
                        $validated['departureTime']
                    )->format('H:i');
                } catch (\Exception $e) {
                    // If parsing completely fails, keep original time
                    unset($validated['departureTime']);
                }
            }
        }

        $route->update($validated);
        return response()->json($route);
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return response()->json(['message' => 'Route has been deleted'], 200);
    }

    public function search(Request $request)
    {
        $query = Route::query();

        if ($request->has('departure')) {
            $query->where('departure', 'like', '%' . $request->departure . '%');
        }

        if ($request->has('destination')) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        if ($request->has('departureDate')) {
            $query->whereDate('departureDate', $request->departureDate);
        }

        $routes = $query->get();

        return response()->json($routes);
    }

    public function buses($routeId)
    {
        $route = Route::with('buses')->findOrFail($routeId);
        return response()->json($route->buses);
    }

    /**
     * Format time to H:i format (24-hour without seconds)
     */
    protected function formatTime($time)
    {
        try {
            return Carbon::parse($time)->format('H:i');
        } catch (\Exception $e) {
            return '00:00'; // Default value if parsing fails
        }
    }

    /**
     * Get available routes based on date and available seats
     */
    public function availableRoutes(Request $request)
    {
        $request->validate([
            'date' => 'sometimes|date',
            'min_seats' => 'sometimes|integer|min:1'
        ]);

        $query = Route::query();

        if ($request->has('date')) {
            $query->whereDate('departureDate', $request->date);
        }

        if ($request->has('min_seats')) {
            $query->where('availableSeats', '>=', $request->min_seats);
        }

        return response()->json($query->get());
    }
}
