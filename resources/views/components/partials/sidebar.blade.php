<!-- resources/views/components/partials/sidebar.blade.php -->

<!-- Invisible backdrop: click outside closes sidebar, NO visual effect -->
<div
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    class="fixed inset-0 z-[25] md:hidden"
    style="background: none;"
    aria-hidden="true"
></div>

<aside
    x-show="sidebarOpen"
    x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'"
    class="bg-university-red text-white fixed md:static inset-y-0 left-0 z-30 overflow-y-auto transition-all duration-300 shadow-lg flex flex-col"
    x-data="{ activeLink: 'dashboard' }"
    style="display: none;">

    <!-- Brand -->
    <div class="flex items-center justify-center h-20 border-b border-red-900 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z"/>
            </svg>
            <span x-show="!sidebarCollapsed" x-transition class="text-2xl font-bold">
                DocHub
            </span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-3 flex-1 overflow-y-auto pb-20">

        <!-- Dashboard -->
        <a href="#"
           @click.prevent="activeLink = 'dashboard'"
           class="flex items-center py-3 px-4 mb-2 rounded-lg
                  border-l-4 border-transparent
                  transition-all duration-200
                  hover:opacity-80"
           :class="activeLink === 'dashboard' ? 'border-white font-semibold' : ''">

            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                      d="M3 12l2-2 7-7 7 7"/>
            </svg>

            <span x-show="!sidebarCollapsed" x-transition class="ml-3">
                Dashboard
            </span>
        </a>

        <!-- Documents -->
        <a href="#"
           @click.prevent="activeLink = 'documents'"
           class="flex items-center py-3 px-4 mb-2 rounded-lg
                  border-l-4 border-transparent
                  transition-all duration-200
                  hover:opacity-80"
           :class="activeLink === 'documents' ? 'border-white font-semibold' : ''">

            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414"/>
            </svg>

            <span x-show="!sidebarCollapsed" x-transition class="ml-3">
                Documents
            </span>
        </a>

        <!-- Upload -->
        <a href="#"
           @click.prevent="activeLink = 'upload'"
           class="flex items-center py-3 px-4 mb-2 rounded-lg
                  border-l-4 border-transparent
                  transition-all duration-200
                  hover:opacity-80"
           :class="activeLink === 'upload' ? 'border-white font-semibold' : ''">

            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                      d="M15 13l-3-3-3 3m3-3v12"/>
            </svg>

            <span x-show="!sidebarCollapsed" x-transition class="ml-3">
                Upload
            </span>
        </a>

        <!-- Categories -->
        <a href="#"
           @click.prevent="activeLink = 'categories'"
           class="flex items-center py-3 px-4 mb-2 rounded-lg
                  border-l-4 border-transparent
                  transition-all duration-200
                  hover:opacity-80"
           :class="activeLink === 'categories' ? 'border-white font-semibold' : ''">

            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                      d="M7 3h5l7 7-7 7H7L3 12V7a4 4 0 014-4z"/>
            </svg>

            <span x-show="!sidebarCollapsed" x-transition class="ml-3">
                Categories
            </span>
        </a>

        <!-- Users -->
        <a href="#"
           @click.prevent="activeLink = 'users'"
           class="flex items-center py-3 px-4 mb-2 rounded-lg
                  border-l-4 border-transparent
                  transition-all duration-200
                  hover:opacity-80"
           :class="activeLink === 'users' ? 'border-white font-semibold' : ''">

            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                      d="M12 4a4 4 0 110 8 4 4 0 010-8zm-8 16a6 6 0 0116 0"/>
            </svg>

            <span x-show="!sidebarCollapsed" x-transition class="ml-3">
                Users
            </span>
        </a>

        <!-- Reports -->
        <a href="#"
           @click.prevent="activeLink = 'reports'"
           class="flex items-center py-3 px-4 mb-2 rounded-lg
                  border-l-4 border-transparent
                  transition-all duration-200
                  hover:opacity-80"
           :class="activeLink === 'reports' ? 'border-white font-semibold' : ''">

            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                      d="M9 17V7m4 10V3m4 14V11"/>
            </svg>

            <span x-show="!sidebarCollapsed" x-transition class="ml-3">
                Reports
            </span>
        </a>

        <hr class="my-4 border-red-900" x-show="!sidebarCollapsed">

        <!-- Settings -->
        <a href="#"
           @click.prevent="activeLink = 'settings'"
           class="flex items-center py-3 px-4 mb-2 rounded-lg
                  border-l-4 border-transparent
                  transition-all duration-200
                  hover:opacity-80"
           :class="activeLink === 'settings' ? 'border-white font-semibold' : ''">

            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                      d="M12 15a3 3 0 100-6"/>
            </svg>

            <span x-show="!sidebarCollapsed" x-transition class="ml-3">
                Settings
            </span>
        </a>

    </nav>

    <!-- Collapse -->
    <div class="border-t border-red-900 p-4 flex-shrink-0">
        <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="w-full text-sm font-medium opacity-80 hover:opacity-100 transition">
            Collapse
        </button>
    </div>
</aside>