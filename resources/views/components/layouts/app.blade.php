<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'University Document Hub' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles()
    <style> [x-cloak] { display: none !important; } </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div x-data="{ 
            sidebarOpen: window.innerWidth >= 768,
            sidebarCollapsed: false 
        }"
        @resize.window="sidebarOpen = window.innerWidth >= 768"
        class="flex h-screen overflow-hidden">

        <!-- Mobile Sidebar Overlay (Semi-transparent Backdrop) -->
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-20 md:hidden bg-black/50 backdrop-blur-sm"
            aria-hidden="true">
        </div>

        <!-- Sidebar Component -->
        <x-partials.sidebar />

        <!-- Main Content Area -->
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