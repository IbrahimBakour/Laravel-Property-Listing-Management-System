@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Profile</h2>

    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Profile Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Name</p>
                <p class="text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                <p class="text-gray-900 dark:text-white">{{ auth()->user()->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Role</p>
                <p class="text-gray-900 dark:text-white">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
            @if (auth()->user()->phone)
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Phone</p>
                    <p class="text-gray-900 dark:text-white">{{ auth()->user()->phone }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Update Password</h3>
        <form method="POST" action="{{ route('password.update') }}" class="max-w-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password</label>
                <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold">
                Update Password
            </button>
        </form>
    </div>
</div>
@endsection
