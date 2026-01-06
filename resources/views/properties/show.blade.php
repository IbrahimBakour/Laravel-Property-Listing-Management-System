@extends('layouts.app')

@section('title', $property->title)

@section('content')
<div class="grid grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="col-span-2">
        <!-- Image Gallery -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 overflow-hidden">
            @if ($property->primaryMedia)
                <img src="{{ asset($property->primaryMedia->file_path) }}" alt="{{ $property->title }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                    <span class="text-gray-600 dark:text-gray-400">No Image</span>
                </div>
            @endif
        </div>

        <!-- Property Details -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $property->title }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $property->location->city }}, {{ $property->location->state }}</p>
                </div>
                <span class="px-4 py-2 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-lg font-semibold">
                    {{ $property->status }}
                </span>
            </div>

            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-6">PKR {{ number_format($property->price) }}</p>

            <div class="grid grid-cols-3 gap-4 mb-6">
                @if ($property->bedrooms > 0)
                    <div class="border border-gray-200 dark:border-gray-700 rounded p-4">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Bedrooms</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $property->bedrooms }}</p>
                    </div>
                @endif

                @if ($property->bathrooms > 0)
                    <div class="border border-gray-200 dark:border-gray-700 rounded p-4">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Bathrooms</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $property->bathrooms }}</p>
                    </div>
                @endif

                <div class="border border-gray-200 dark:border-gray-700 rounded p-4">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Area</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($property->area) }} sqft</p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Property Type</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $property->propertyType->name }}</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $property->description }}</p>
            </div>
        </div>

        <!-- Agent Info -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Agent Information</h2>
            <div class="flex items-center gap-4">
                <div>
                    <p class="text-gray-900 dark:text-white font-semibold">{{ $property->agent->name }}</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $property->agent->email }}</p>
                    @if ($property->agent->phone)
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $property->agent->phone }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Actions -->
        @auth
            @can('update', $property)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                    <a href="{{ route('properties.edit', $property) }}" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 block text-center mb-2">
                        Edit Property
                    </a>
                    <form method="POST" action="{{ route('properties.destroy', $property) }}" onsubmit="return confirm('Are you sure?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Delete Property
                        </button>
                    </form>
                </div>
            @endcan
        @endauth

        <!-- Additional Media -->
        @if ($property->media->count() > 1)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Gallery</h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($property->media->skip(1) as $media)
                        <img src="{{ asset($media->file_path) }}" alt="Gallery" class="w-full h-24 object-cover rounded">
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
