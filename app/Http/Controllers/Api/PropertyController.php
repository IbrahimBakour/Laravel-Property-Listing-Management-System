<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\LocationResource;
use App\Models\Property;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PropertyController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Property::with(['agent', 'propertyType', 'location', 'media']);

        if ($request->has('location')) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->where('city', 'ilike', "%{$request->location}%");
            });
        }

        if ($request->has('property_type')) {
            $query->where('property_type_id', $request->property_type);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        $sort = $request->input('sort', '-created_at');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $field = ltrim($sort, '-');

        $query->orderBy($field, $direction);

        return PropertyResource::collection($query->paginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Property::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'required|integer|min:0',
            'status' => 'required|in:For Sale,For Rent,Sold',
            'property_type_id' => 'required|exists:property_types,id',
            'location_id' => 'required|exists:locations,id',
            'images' => 'sometimes|array',
            'images.*' => 'sometimes|file|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['agent_id'] = auth()->id();
        $property = Property::create($validated);

        return new PropertyResource($property->load(['agent', 'propertyType', 'location', 'media']));
    }

    public function show(Property $property)
    {
        return new PropertyResource($property->load(['agent', 'propertyType', 'location', 'media']));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'bedrooms' => 'sometimes|nullable|integer|min:0',
            'bathrooms' => 'sometimes|nullable|integer|min:0',
            'area' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:For Sale,For Rent,Sold',
            'property_type_id' => 'sometimes|exists:property_types,id',
            'location_id' => 'sometimes|exists:locations,id',
            'images' => 'sometimes|array',
            'images.*' => 'sometimes|file|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $property->update($validated);

        return new PropertyResource($property->load(['agent', 'propertyType', 'location', 'media']));
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();
        return response()->json(['message' => 'Property deleted successfully']);
    }
}
