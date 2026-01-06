<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Location;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PropertyController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $properties = Property::with(['agent', 'propertyType', 'location', 'media'])
            ->paginate(12);
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        $this->authorize('create', Property::class);
        $propertyTypes = PropertyType::all();
        $locations = Location::all();
        return view('properties.create', compact('propertyTypes', 'locations'));
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

        $propertyType = PropertyType::find($validated['property_type_id']);
        $isResidential = in_array($propertyType->slug, ['house', 'apartment', 'condo', 'townhouse']);

        if (!$isResidential) {
            $validated['bedrooms'] = 0;
            $validated['bathrooms'] = 0;
        }

        $validated['agent_id'] = auth()->id();
        $property = Property::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $storedPath = $image->store('properties', 'public');
                Media::create([
                    'property_id' => $property->id,
                    'file_path' => 'storage/' . $storedPath,
                    'file_type' => $image->getMimeType(),
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Property created successfully.');
    }

    public function show(Property $property)
    {
        $property->load(['agent', 'propertyType', 'location', 'media']);
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        $propertyTypes = PropertyType::all();
        $locations = Location::all();
        return view('properties.edit', compact('property', 'propertyTypes', 'locations'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

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

        $propertyType = PropertyType::find($validated['property_type_id']);
        $isResidential = in_array($propertyType->slug, ['house', 'apartment', 'condo', 'townhouse']);

        if (!$isResidential) {
            $validated['bedrooms'] = 0;
            $validated['bathrooms'] = 0;
        }

        $property->update($validated);

        if ($request->hasFile('images')) {
            $hasPrimary = $property->media()->where('is_primary', true)->exists();
            foreach ($request->file('images') as $index => $image) {
                $storedPath = $image->store('properties', 'public');
                Media::create([
                    'property_id' => $property->id,
                    'file_path' => 'storage/' . $storedPath,
                    'file_type' => $image->getMimeType(),
                    'is_primary' => $hasPrimary ? false : $index === 0,
                ]);
            }
        }

        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();
        return redirect()
            ->route('properties.index')
            ->with('success', 'Property deleted successfully.');
    }
}
