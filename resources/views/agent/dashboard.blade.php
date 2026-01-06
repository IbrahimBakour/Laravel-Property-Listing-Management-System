@extends('layouts.app')

@section('title', 'Agent Dashboard - Property Listing Management System')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Agent Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400">Welcome, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Agent Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Your Properties</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ auth()->user()->properties()->count() }}</p>
        </div>
      
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Available Properties</h3>
            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                {{ auth()->user()->properties()->where('status', 'available')->count() }}
            </p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <a href="{{ route('properties.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            + Add New Property
        </a>
    </div>

    <!-- Your Properties -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Your Properties</h2>
        @if(auth()->user()->properties()->exists())
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900 dark:text-white">Title</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900 dark:text-white">Price</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(auth()->user()->properties()->latest()->take(10)->get() as $property)
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $property->title }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white font-semibold">${{ number_format($property->price, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 inline-block text-sm rounded
                                        @if($property->status === 'available') dark:text-green-200
                                        @elseif($property->status === 'sold')
                                        @else bg-blue-100 text-blue-800 dark:bg-blue-900
                                        @endif
                                    ">
                                        @if($property->status === 'available')
                                            For Sale
                                        @elseif($property->status === 'rented')
                                            For Rent
                                        @else
                                            Sold
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('properties.edit', $property) }}" class="text-blue-600 hover:underline text-sm mr-3">Edit</a>
                                    <form method="POST" action="{{ route('properties.destroy', $property) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400">You haven't listed any properties yet. <a href="{{ route('properties.create') }}" class="text-blue-600 hover:underline">Create one now</a></p>
        @endif
    </div>
@endsection
