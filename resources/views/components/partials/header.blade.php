<!-- resources/views/components/partials/header.blade.php -->
<header class="bg-white shadow-sm border-b-4 border-university-red sticky top-0 z-10">
    <div class="flex justify-between items-center py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-4">
            <!-- Mobile Menu Toggle -->
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 md:hidden transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page Title or Breadcrumb -->
            <h1 class="text-xl font-semibold text-gray-800">Document Hub</h1>
        </div>

        <!-- Right Side Header Content -->
        <div class="flex items-center space-x-4">
            <!-- User Menu -->
            <div x-data="{ userMenuOpen: false }" class="relative">
                <button @click="userMenuOpen = !userMenuOpen" 
                        class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none transition-colors">
                    <div class="h-8 w-8 rounded-full bg-university-red text-white flex items-center justify-center font-semibold">
                        U
                    </div>
                    <svg class="h-4 w-4 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="userMenuOpen" 
                     @click.away="userMenuOpen = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                     style="display: none;">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <hr class="my-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>