@extends('layouts.app')

@section('title', 'Edit Property')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Property</h2>

    <form action="{{ route('properties.update', $property) }}" method="POST" class="max-w-2xl">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $property->title) }}" required class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('title') border-red-500 @enderror">
            @error('title')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea id="description" name="description" required class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('description') border-red-500 @enderror" rows="4">{{ old('description', $property->description) }}</textarea>
            @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Price -->
        <div class="mb-6">
            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price (PKR)</label>
            <input type="number" id="price" name="price" value="{{ old('price', $property->price) }}" required min="0" step="0.01" class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('price') border-red-500 @enderror">
            @error('price')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Property Type -->
        <div class="mb-6">
            <label for="property_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Property Type</label>
            <select id="property_type_id" name="property_type_id" required onchange="toggleResidentialFields()" class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('property_type_id') border-red-500 @enderror">
                <option value="">Select Property Type</option>
                @foreach ($propertyTypes as $type)
                    <option value="{{ $type->id }}" @selected(old('property_type_id', $property->property_type_id) == $type->id) data-slug="{{ $type->slug }}">
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('property_type_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Location -->
        <div class="mb-6">
            <label for="location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location</label>
            <select id="location_id" name="location_id" required class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('location_id') border-red-500 @enderror">
                <option value="">Select Location</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}" @selected(old('location_id', $property->location_id) == $location->id)>
                        {{ $location->city }}, {{ $location->state }}
                    </option>
                @endforeach
            </select>
            @error('location_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Area -->
        <div class="mb-6">
            <label for="area" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Area (sqft)</label>
            <input type="number" id="area" name="area" value="{{ old('area', $property->area) }}" required min="0" class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('area') border-red-500 @enderror">
            @error('area')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Bedrooms (Conditional) -->
        <div class="mb-6 residential-field" style="display: none;">
            <label for="bedrooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bedrooms</label>
            <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0" class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            @error('bedrooms')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Bathrooms (Conditional) -->
        <div class="mb-6 residential-field" style="display: none;">
            <label for="bathrooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bathrooms</label>
            <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0" class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            @error('bathrooms')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Status -->
        <div class="mb-6">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
            <select id="status" name="status" required class="w-full px-4 py-2 border  dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('status') border-red-500 @enderror">
                <option value="For Sale" @selected(old('status', $property->status) == 'For Sale')>For Sale</option>
                <option value="For Rent" @selected(old('status', $property->status) == 'For Rent')>For Rent</option>
                <option value="Sold" @selected(old('status', $property->status) == 'Sold')>Sold</option>
            </select>
            @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Submit -->
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update Property
            </button>
            <a href="{{ route('properties.show', $property) }}" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
const residentialTypes = ['house', 'apartment', 'condo', 'townhouse'];

function toggleResidentialFields() {
    const typeSelect = document.getElementById('property_type_id');
    const selectedOption = typeSelect.options[typeSelect.selectedIndex];
    const slug = selectedOption.dataset.slug;
    const fields = document.querySelectorAll('.residential-field');

    if (residentialTypes.includes(slug)) {
        fields.forEach(field => field.style.display = 'block');
    } else {
        fields.forEach(field => field.style.display = 'none');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', toggleResidentialFields);
</script>
@endsection
