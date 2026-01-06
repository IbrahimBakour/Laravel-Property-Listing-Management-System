<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class LocationController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Location::withCount('properties');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('city', 'ilike', "%{$search}%")
                  ->orWhere('state', 'ilike', "%{$search}%");
            });
        }

        return LocationResource::collection($query->paginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin', auth()->user());

        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $location = Location::create($validated);
        return new LocationResource($location);
    }

    public function show(Location $location)
    {
        return new LocationResource($location->loadCount('properties'));
    }

    public function update(Request $request, Location $location)
    {
        $this->authorize('isAdmin', auth()->user());

        $validated = $request->validate([
            'city' => 'sometimes|string|max:255',
            'state' => 'sometimes|string|max:255',
            'country' => 'sometimes|string|max:255',
            'zip_code' => 'sometimes|nullable|string|max:20',
        ]);

        $location->update($validated);
        return new LocationResource($location->loadCount('properties'));
    }

    public function destroy(Location $location)
    {
        $this->authorize('isAdmin', auth()->user());
        $location->delete();
        return response()->json(['message' => 'Location deleted successfully']);
    }
}
