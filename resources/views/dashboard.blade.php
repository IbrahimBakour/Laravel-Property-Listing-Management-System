@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Total Properties</h3>
        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">
            @if (auth()->user()->isAdmin())
                {{ \App\Models\Property::count() }}
            @else
                {{ auth()->user()->properties()->count() }}
            @endif
        </p>
    </div>

    @if (auth()->user()->isAdmin())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Total Agents</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                {{ \App\Models\User::where('role', 'agent')->count() }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Total Users</h3>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                {{ \App\Models\User::where('role', 'user')->count() }}
            </p>
        </div>
    @endif
</div>

<!-- User Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Email</h3>
        <p class="text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Member Since</h3>
        <p class="text-gray-600 dark:text-gray-400">{{ auth()->user()->created_at->format('M d, Y') }}</p>
    </div>
</div>

<!-- Quick Links -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Quick Links</h2>
    <div class="flex gap-4">
        <a href="{{ route('properties.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            Browse Properties
        </a>
        <a href="{{ route('profile.show') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold">
            Edit Profile
        </a>
    </div>
</div>
@endsection
