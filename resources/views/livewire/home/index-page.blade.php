<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVSU Reader - Document Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        @keyframes float {
            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-glow {
            0%,
            100% {
                box-shadow: 0 0 20px rgba(139, 0, 0, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(139, 0, 0, 0.6);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out;
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        .delay-600 {
            animation-delay: 0.6s;
        }

        /* University red gradient */
        .bg-university-gradient {
            background: linear-gradient(135deg, #8B0000 0%, #A52A2A 50%, #8B0000 100%);
        }

        .text-university-red {
            color: #8B0000;
        }

        .border-university-red {
            border-color: #8B0000;
        }

        .bg-university-red {
            background-color: #8B0000;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #8B0000;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #A52A2A;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- Navigation -->
    <nav class="bg-[#8B0000] border-b border-white/10 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-[#8B0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">EVSU Reader</h1>
                        <p class="text-xs text-white/70">Document Management</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-white/80 hover:text-white transition-colors font-medium">
                        Features
                    </a>
                    <a href="#about" class="text-white/80 hover:text-white transition-colors font-medium">
                        About
                    </a>
                    <a href="#contact" class="text-white/80 hover:text-white transition-colors font-medium">
                        Contact
                    </a>
                </div>

                <!-- Auth Button -->
                <div>
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center px-6 py-2.5 bg-white text-[#8B0000] rounded-lg font-semibold text-sm hover:shadow-lg transition-all duration-300 hover:scale-105">
                            Dashboard
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-6 py-2.5 bg-white text-[#8B0000] rounded-lg font-semibold text-sm hover:shadow-lg transition-all duration-300 hover:scale-105">
                            Sign In
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-white overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 right-20 w-96 h-96 bg-red-50 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 left-20 w-96 h-96 bg-red-50 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left content -->
                <div class="space-y-8 animate-slide-up">
                    <!-- Badge -->
                    <div class="inline-flex items-center space-x-2 px-4 py-2 bg-red-50 border border-[#8B0000]/20 rounded-full">
                        <div class="w-2 h-2 bg-[#8B0000] rounded-full animate-pulse"></div>
                        <span class="text-[#8B0000] text-sm font-semibold">Eastern Visayas State University</span>
                    </div>

                    <!-- Heading -->
                    <div class="space-y-4">
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 leading-tight">
                            SCHOOL OF ENGINEERING
                            <span class="text-[#8B0000] block">EVSU Reader</span>
                        </h1>
                        <p class="text-xl text-gray-600 leading-relaxed max-w-xl">
                        A Centralized Document Management System for the School of Engineering
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        @guest
                            <a href="{{ route('login') }}"
                                class="group inline-flex items-center justify-center px-8 py-4 bg-university-gradient text-white rounded-lg font-bold text-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                                Get Started
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @endguest

                        <a href="#features"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-gray-300 text-gray-700 rounded-lg font-bold text-lg hover:border-[#8B0000] hover:text-[#8B0000] transition-all duration-300">
                            Learn More
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div class="text-center">
                            <div class="text-3xl font-black text-[#8B0000]">1000+</div>
                            <div class="text-sm text-gray-600 font-medium mt-1">Documents</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-black text-[#8B0000]">500+</div>
                            <div class="text-sm text-gray-600 font-medium mt-1">Students</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-black text-[#8B0000]">200+</div>
                            <div class="text-sm text-gray-600 font-medium mt-1">Teachers</div>
                        </div>
                    </div>
                </div>

                <!-- Right visual -->
                <div class="relative animate-float hidden lg:block">
                    <div class="relative">
                        <!-- Main card -->
                        <div
                            class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-200 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                            <div class="space-y-6">
                                <!-- Document icon -->
                                <div class="w-20 h-20 bg-university-gradient rounded-xl flex items-center justify-center animate-pulse-glow">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <!-- Mock content -->
                                <div class="space-y-3">
                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                    <div class="h-4 bg-gray-200 rounded w-full"></div>
                                    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                                </div>

                                <!-- QR Code placeholder -->
                                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center">
                                    <div class="w-32 h-32 bg-white rounded-lg border-2 border-gray-300 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating badge -->
                        <div
                            class="absolute -top-4 -right-4 bg-university-gradient text-white px-6 py-3 rounded-full shadow-xl font-bold text-sm animate-pulse">
                            Verified ✓
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="py-20 md:py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left content -->
                <div class="space-y-6">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        Transforming Academic
                        <span class="text-[#8B0000] block">Document Management</span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        EVSU Reader is designed specifically for School of Engineering department to modernize how
                        academic records are stored, accessed, and managed. Our platform combines cutting-edge
                        technology with user-friendly design.
                    </p>

                    <!-- Benefits list -->
                    <div class="space-y-4 pt-4">
                        <div class="flex items-start space-x-4">
                            
                        </div>

                        <div class="flex items-start space-x-4">
                            <div
                                class="w-10 h-10 bg-[#8B0000]/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-[#8B0000]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-1">24/7 Accessibility</h4>
                                <p class="text-gray-600">Access your documents anytime, anywhere, from any device.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div
                                class="w-10 h-10 bg-[#8B0000]/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-[#8B0000]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-1">Complete Audit Trail</h4>
                                <p class="text-gray-600">Full transparency with detailed logs of all document activities.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

    



<!-- ============================================ -->

<!-- OPTION 4: Dashboard-Style Card (RECOMMENDED) -->
<div class="relative">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
        <!-- Header Bar -->
        <div class="bg-gradient-to-r from-[#8B0000] to-[#A52A2A] px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="text-white">
                    <div class="text-sm font-semibold">Performance Dashboard</div>
                    <div class="text-xs opacity-80">Real-time Metrics</div>
                </div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                <span class="text-white text-xs font-bold">100%</span>
            </div>
        </div>

        <!-- Main Image Content -->
        <div class="p-6">
            <img src="/images/cere.webp" 
                 alt="EVSU Digital Transformation Dashboard" 
                 class="w-full h-auto rounded-xl shadow-lg border border-gray-100">
        </div>

        <!-- Footer Stats -->
        <div class="px-6 pb-6">
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-100">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-[#8B0000]">95%</div>
                        <div class="text-xs text-gray-600 mt-1">Documents</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-[#8B0000]">98%</div>
                        <div class="text-xs text-gray-600 mt-1">Users</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-[#8B0000]">92%</div>
                        <div class="text-xs text-gray-600 mt-1">Efficiency</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->


>

        <!-- Clean Stats Grid -->
        
        </div>
    </div>
</div>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-university-gradient rounded-3xl p-12 md:p-16 text-center shadow-2xl">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Ready to Get Started?
                </h2>
                <p class="text-xl text-white/80 mb-8 max-w-2xl mx-auto">
                    Join hundreds of users already managing their documents more efficiently with EVSU Reader.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @guest
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#8B0000] rounded-lg font-bold text-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                            Sign In Now
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#8B0000] rounded-lg font-bold text-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                            Go to Dashboard
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @endauth

                    <a href="#features"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white rounded-lg font-bold text-lg hover:bg-white/20 transition-all duration-300">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-[#8B0000] text-white py-16 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Brand -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#8B0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">EVSU Reader</span>
                    </div>
                    <p class="text-white/70 text-sm">
                        Modern document management for academic institutions.
                    </p>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-white/70 hover:text-white transition-colors">Features</a>
                        </li>
                        <li><a href="#about" class="text-white/70 hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="text-white/70 hover:text-white transition-colors">Pricing</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-white/70 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-white/70 hover:text-white transition-colors">Support</a></li>
                        <li><a href="#" class="text-white/70 hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Contact</h4>
                    <ul class="space-y-2 text-white/70 text-sm">
                        <li>Eastern Visayas State University</li>
                        <li>Tacloban City, Philippines</li>
                        <li>
                            <a href="mailto:support@evsu.edu.ph"
                                class="hover:text-white transition-colors">support@evsu.edu.ph</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="pt-8 border-t border-white/10">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-white/70 text-sm">
                        &copy; 2026 EVSU Reader. Develop By Reymart Calicdan and Antonio D. Macasa Jr.
                    </p>
                    <div class="flex items-center space-x-6">
                        <a href="#" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>