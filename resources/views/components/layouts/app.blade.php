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
<body class="bg-gray-100 font-sans">
    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <x-partials.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <x-partials.header />

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @livewireScripts()
</body>
</html>