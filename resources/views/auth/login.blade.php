@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('email') border-red-500 @enderror">
            @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
            <input type="password" id="password" name="password" required class="w-full px-4 py-2 border dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('password') border-red-500 @enderror">
            @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-6">
            <label for="remember" class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="rounded">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Remember me</span>
            </label>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold">
            Login
        </button>
    </form>

    <p class="mt-4 text-center text-gray-600 dark:text-gray-400">
        Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register here</a>
    </p>
</div>
@endsection
