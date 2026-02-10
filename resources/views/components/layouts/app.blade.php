<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'University Document Hub' }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles()
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div x-data="{ 
        sidebarOpen: window.innerWidth >= 768,
        sidebarCollapsed: false 
    }" 
    @resize.window="sidebarOpen = window.innerWidth >= 768"
    class="flex h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen && window.innerWidth < 768" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 md:hidden"
             style="display: none;">
        </div>

        <!-- Sidebar -->
        <x-partials.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <x-partials.header />

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @livewireScripts()
</body>
</html>