<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('properties.index') }}" class="text-xl font-bold text-blue-600">
                    Property Listing
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('properties.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Properties
                    </a>

                    @if (auth()->user()->isAgent() || auth()->user()->isAdmin())
                        <a href="{{ route('properties.create') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            Add Property
                        </a>
                    @endif

                    <div class="relative group">
                        <button class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            {{ auth()->user()->name }}
                        </button>
                        <div class="hidden group-hover:block absolute right-0 bg-white dark:bg-gray-700 shadow rounded">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                Dashboard
                            </a>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
