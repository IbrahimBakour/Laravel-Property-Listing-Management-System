@extends('layouts.app')

@section('title', 'Properties')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Properties</h2>
        @auth
            @if (auth()->user()->isAgent() || auth()->user()->isAdmin())
                <a href="{{ route('properties.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Add Property
                </a>
            @endif
        @endauth
    </div>

    @if ($properties->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach ($properties as $property)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                    @if ($property->primaryMedia)
                        <img src="{{ asset($property->primaryMedia->file_path) }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                            <span class="text-gray-600 dark:text-gray-400">No Image</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $property->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ Str::limit($property->description, 100) }}</p>

                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">PKR {{ number_format($property->price) }}</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded text-sm">
                                {{ $property->status }}
                            </span>
                        </div>

                        <div class="grid grid-cols-3 gap-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                            <div>
                                <span class="font-semibold">{{ $property->bedrooms }}</span> Bedrooms
                            </div>
                            <div>
                                <span class="font-semibold">{{ $property->bathrooms }}</span> Bathrooms
                            </div>
                            <div>
                                <span class="font-semibold">{{ number_format($property->area) }}</span> sqft
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $property->location->city }}, {{ $property->location->state }}</p>

                        <a href="{{ route('properties.show', $property) }}" class="w-full px-4 py-2 bg-blue-600 text-white text-center rounded hover:bg-blue-700 block">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
            {{ $properties->links() }}
        </div>
    @else
        <div class="p-6 text-center text-gray-600 dark:text-gray-400">
            <p>No properties found.</p>
        </div>
    @endif
</div>
@endsection
