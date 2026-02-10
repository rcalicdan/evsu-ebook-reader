<!-- resources/views/components/partials/sidebar.blade.php -->
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
            <svg class="h-8 w-8 flex-shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="text-white text-2xl font-bold">DocHub</span>
        </div>
    </div>

    <!-- Navigation - Scrollable Area -->
    <nav class="mt-6 px-3 flex-1 overflow-y-auto pb-20">
        <!-- Dashboard -->
        <a href="#" 
           @click.prevent="activeLink = 'dashboard'"
           class="flex items-center py-3 px-4 rounded-lg transition-all duration-200 mb-2 group relative"
           :class="activeLink === 'dashboard' ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-5'">
            <svg class="h-6 w-6 flex-shrink-0 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="ml-3 font-medium text-white relative z-10">Dashboard</span>
        </a>

        <!-- Documents -->
        <a href="#" 
           @click.prevent="activeLink = 'documents'"
           class="flex items-center py-3 px-4 rounded-lg transition-all duration-200 mb-2 group relative"
           :class="activeLink === 'documents' ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-5'">
            <svg class="h-6 w-6 flex-shrink-0 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="ml-3 font-medium text-white relative z-10">Documents</span>
        </a>

        <!-- Upload -->
        <a href="#" 
           @click.prevent="activeLink = 'upload'"
           class="flex items-center py-3 px-4 rounded-lg transition-all duration-200 mb-2 group relative"
           :class="activeLink === 'upload' ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-5'">
            <svg class="h-6 w-6 flex-shrink-0 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="ml-3 font-medium text-white relative z-10">Upload</span>
        </a>

        <!-- Categories -->
        <a href="#" 
           @click.prevent="activeLink = 'categories'"
           class="flex items-center py-3 px-4 rounded-lg transition-all duration-200 mb-2 group relative"
           :class="activeLink === 'categories' ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-5'">
            <svg class="h-6 w-6 flex-shrink-0 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="ml-3 font-medium text-white relative z-10">Categories</span>
        </a>

        <!-- Users -->
        <a href="#" 
           @click.prevent="activeLink = 'users'"
           class="flex items-center py-3 px-4 rounded-lg transition-all duration-200 mb-2 group relative"
           :class="activeLink === 'users' ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-5'">
            <svg class="h-6 w-6 flex-shrink-0 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="ml-3 font-medium text-white relative z-10">Users</span>
        </a>

        <!-- Reports -->
        <a href="#" 
           @click.prevent="activeLink = 'reports'"
           class="flex items-center py-3 px-4 rounded-lg transition-all duration-200 mb-2 group relative"
           :class="activeLink === 'reports' ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-5'">
            <svg class="h-6 w-6 flex-shrink-0 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="ml-3 font-medium text-white relative z-10">Reports</span>
        </a>

        <!-- Divider -->
        <hr class="my-4 border-red-900" x-show="!sidebarCollapsed">

        <!-- Settings -->
        <a href="#" 
           @click.prevent="activeLink = 'settings'"
           class="flex items-center py-3 px-4 rounded-lg transition-all duration-200 mb-2 group relative"
           :class="activeLink === 'settings' ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-5'">
            <svg class="h-6 w-6 flex-shrink-0 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="ml-3 font-medium text-white relative z-10">Settings</span>
        </a>
    </nav>

    <!-- Collapse Toggle Button - Fixed at Bottom -->
    <div class="border-t border-red-900 p-4 flex-shrink-0">
        <button @click="sidebarCollapsed = !sidebarCollapsed" 
                class="w-full flex items-center justify-center py-3 px-4 rounded-lg text-white hover:bg-white hover:bg-opacity-5 transition-all duration-200"
                :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'">
            <!-- Collapse Icon (shown when sidebar is expanded) -->
            <svg x-show="!sidebarCollapsed" 
                 class="h-5 w-5 text-white" 
                 fill="none" 
                 viewBox="0 0 24 24" 
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <!-- Expand Icon (shown when sidebar is collapsed) -->
            <svg x-show="sidebarCollapsed" 
                 class="h-5 w-5 text-white" 
                 fill="none" 
                 viewBox="0 0 24 24" 
                 stroke="currentColor" 
                 style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
            <span x-show="!sidebarCollapsed" 
                  x-transition
                  class="ml-2 font-medium text-sm text-white">Collapse</span>
        </button>
    </div>
</aside>