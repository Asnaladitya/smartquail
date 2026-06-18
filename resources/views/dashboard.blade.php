<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — Monitoring Kandang Puyuh IoT</title>
    <link rel="icon" href="{{ asset('images/smartquail_logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif']
                    },
                    animation: {
                        'blink': 'blink 1.5s infinite',
                        'slide-in': 'slideIn 0.3s ease-out forwards',
                        'slide-out': 'slideOut 0.3s ease-in forwards',
                    },
                    keyframes: {
                        blink: {
                            '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                            '50%': { opacity: '0.6', transform: 'scale(0.98)' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(100%) translateY(-20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0) translateY(0)', opacity: '1' }
                        },
                        slideOut: {
                            '0%': { transform: 'translateX(0)', opacity: '1' },
                            '100%': { transform: 'translateX(120%)', opacity: '0' }
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); }
        .pulse-ring { animation: pulseRing 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulseRing {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            50% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
        }
        .pulse-ring-active { animation: pulseRingActive 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulseRingActive {
            0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5); }
            50% { box-shadow: 0 0 0 15px rgba(34, 197, 94, 0); }
        }
        /* Navbar scroll effect */
        .navbar-scrolled {
            background: rgba(20, 83, 45, 0.95) !important;
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2), 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        /* Footer gradient line */
        .footer-gradient {
            background: linear-gradient(90deg, #e5e7eb, #9ca3af, #e5e7eb);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen relative flex flex-col">

    {{-- Top Navigation Bar - Fixed & Responsive --}}
    <nav id="mainNavbar" class="bg-gradient-to-r from-green-900 via-green-800 to-emerald-950 shadow-lg shadow-green-950/20 fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">
                {{-- Logo & Title --}}
                <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-shrink">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                        <img src="{{ asset('images/smartquail_logo.png') }}" alt="SmartQuail Logo" class="w-full h-full object-contain">
                    </div>
                    <span class="text-white font-extrabold text-sm sm:text-lg tracking-tight truncate">Monitoring Kandang Puyuh IoT</span>
                </div>
                
                {{-- Right side controls --}}
                <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
                    {{-- IoT Status Badge --}}
                    <div class="flex items-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1 sm:py-1.5 bg-white/10 rounded-lg backdrop-blur-sm border border-white/5">
                        <div class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-green-400 animate-pulse"></div>
                        <span class="text-green-200 text-[10px] sm:text-xs font-semibold hidden xs:inline">IoT Server</span>
                        <span class="text-green-200 text-[10px] sm:text-xs font-semibold xs:hidden">Online</span>
                    </div>
                    {{-- Logout Button --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-1 sm:gap-1.5 px-2.5 sm:px-3.5 py-1.5 sm:py-2 bg-red-500/20 hover:bg-red-500/30 text-red-200 hover:text-white rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-semibold transition-all duration-200 border border-red-500/10 active:scale-95">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Spacer for fixed navbar --}}
    <div class="h-14 sm:h-16"></div>

    {{-- Main Container --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 flex-grow">

        {{-- Welcome Toast (appears once on login, then fades) --}}
        <div id="welcomeToast" class="mb-4 bg-gradient-to-r from-green-800 to-emerald-700 rounded-xl px-4 py-3 text-white shadow-md border border-green-700/50 flex items-center justify-between gap-3 transition-all duration-500 opacity-0 translate-y-2" style="display:none;">
            <div class="flex items-center gap-2.5">
                <span class="text-lg">👋</span>
                <p class="text-sm font-semibold">Selamat Datang, {{ Auth::user()->name }}!</p>
            </div>
            <button onclick="dismissWelcome()" class="text-white/60 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Date/Time Bar --}}
        <div class="mb-5 flex items-center justify-between">
            <h1 class="text-base font-bold text-gray-800 tracking-tight">Dashboard Monitoring</h1>
            <div class="flex items-center gap-2.5 px-3.5 py-2 bg-white rounded-xl border border-gray-100 shadow-sm">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-semibold text-gray-600" id="currentTime">Loading jam...</span>
            </div>
        </div>

        {{-- Telemetry Sensor Grid (Suhu, Kelembapan, Amonia, Telur) --}}
<div class="mb-4 flex items-center justify-between">
    <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
        </svg>
        Telemetri Sensor Real-Time
    </h2>
            <div class="flex items-center gap-1.5 text-xs text-gray-400 font-semibold bg-white border border-gray-150 px-3 py-1.5 rounded-xl">
                <svg class="animate-spin w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Update tiap 5 detik</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- 1. Suhu --}}
            <div id="suhuCard" class="card-hover bg-white rounded-3xl p-6 border border-gray-100 shadow-sm transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div id="suhuIconBg" class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center transition-colors">
                        <svg id="suhuIcon" class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        </svg>
                    </div>
                    <span id="suhuBadge" class="px-3 py-1 bg-green-150 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider">
                        Normal
                    </span>
                </div>
                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Suhu Kandang</p>
                <div class="flex items-baseline mt-2">
                    <span id="suhuVal" class="text-5xl font-extrabold text-gray-800 transition-colors">--</span>
                    <span class="text-xl text-gray-400 font-bold ml-1">°C</span>
                </div>
                {{-- Progress bar --}}
                <div class="mt-4 w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                    <div id="suhuBar" class="bg-gradient-to-r from-orange-400 to-orange-500 h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
                <div class="flex justify-between items-center text-2xs text-gray-400 mt-2.5 font-bold uppercase">
                    <span>Min: 20°C</span>
                    <span>Max: 42°C</span>
                </div>
            </div>

            {{-- 2. Kelembapan --}}
            <div id="kelembapanCard" class="card-hover bg-white rounded-3xl p-6 border border-gray-100 shadow-sm transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div id="kelembapanIconBg" class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center transition-colors">
                        <svg id="kelembapanIcon" class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75c-4.97 4.97-7.5 8.47-7.5 11.25a7.5 7.5 0 0015 0c0-2.78-2.53-6.28-7.5-11.25z" />
                        </svg>
                    </div>
                    <span id="kelembapanBadge" class="px-3 py-1 bg-green-150 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider">
                        Normal
                    </span>
                </div>
                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Kelembapan Udara</p>
                <div class="flex items-baseline mt-2">
                    <span id="kelembapanVal" class="text-5xl font-extrabold text-gray-800 transition-colors">--</span>
                    <span class="text-xl text-gray-400 font-bold ml-1">%</span>
                </div>
                <div class="mt-4 w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                    <div id="kelembapanBar" class="bg-gradient-to-r from-blue-400 to-blue-500 h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
                <div class="flex justify-between items-center text-2xs text-gray-400 mt-2.5 font-bold uppercase">
                    <span>Min: 30%</span>
                    <span>Max: 100%</span>
                </div>
            </div>

            {{-- 3. Amonia --}}
            <div id="amoniaCard" class="card-hover bg-white rounded-3xl p-6 border border-gray-100 shadow-sm transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div id="amoniaIconBg" class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center transition-colors">
                        <svg id="amoniaIcon" class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <span id="amoniaBadge" class="px-3 py-1 bg-green-150 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider">
                        Normal
                    </span>
                </div>
                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Gas Amonia (NH₃)</p>
                <div class="flex items-baseline mt-2">
                    <span id="amoniaVal" class="text-5xl font-extrabold text-gray-800 transition-colors">--</span>
                    <span class="text-xl text-gray-400 font-bold ml-1"> ppm</span>
                </div>
                <div class="mt-4 w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                    <div id="amoniaBar" class="bg-gradient-to-r from-purple-400 to-purple-500 h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
                <div class="flex justify-between items-center text-2xs text-gray-400 mt-2.5 font-bold uppercase">
                    <span>Aman: &lt;2.5 ppm</span>
                    <span>Bahaya: &gt;15.0 ppm</span>
                </div>
            </div>


        </div>

        {{-- Status Aktuator Real-time dari ESP8266 --}}
        <div class="mt-6 mb-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5">
            <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-1.5 mb-4">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
                Status Aktuator Kandang (dari ESP8266)
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Kipas --}}
                <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50">
                    <div id="kipasStatusIcon" class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Kipas (IN1)</p>
                        <span id="kipasStatusText" class="text-sm font-bold text-gray-400">MATI</span>
                    </div>
                </div>
                {{-- Pompa/Sprayer --}}
                <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50">
                    <div id="pompaStatusIcon" class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75c-4.97 4.97-7.5 8.47-7.5 11.25a7.5 7.5 0 0015 0c0-2.78-2.53-6.28-7.5-11.25z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Pompa/Sprayer (IN2)</p>
                        <span id="pompaStatusText" class="text-sm font-bold text-gray-400">MATI</span>
                    </div>
                </div>
                {{-- Lampu --}}
                <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50">
                    <div id="lampuStatusIcon" class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Lampu Pemanas (IN3)</p>
                        <span id="lampuStatusText" class="text-sm font-bold text-gray-400">MATI</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Equipment Controls Panel --}}
<div class="mb-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-4 border-b border-gray-100">
        <div>
            <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Panel Kontrol Peralatan
            </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Kontrol langsung aktuator kandang secara manual</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400 font-medium">Kipas:</span>
                        <span id="kipasStatusBadge" class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">NONAKTIF</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400 font-medium">Sprayer:</span>
                        <span id="sprayerStatusBadge" class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">NONAKTIF</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400 font-medium">Lampu:</span>
                        <span id="lampuStatusBadge" class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">NONAKTIF</span>
                    </div>
                </div>
            </div>

            <!-- Kipas Control -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center mb-6 pb-6 border-b border-gray-100">
                <div class="md:col-span-2">
                    <h3 class="text-base font-bold text-gray-700">Kipas Pendingin / Sirkulasi Udara (Fan)</h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        Aktifkan kipas secara manual untuk memperlancar sirkulasi udara atau membuang bau amonia yang menyengat sebelum mencapai ambang batas berbahaya.
                    </p>
                </div>
                <div class="flex justify-center md:justify-end">
                    <button
                        type="button"
                        id="kipasBtn"
                        onclick="toggleKipas()"
                        class="w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-blue-600 hover:bg-blue-500 focus:outline-none"
                    >
                        💨 Aktifkan Kipas Manual
                    </button>
                </div>
            </div>

            <!-- Sprayer Control -->
                <div class="md:col-span-2">
                    <h3 class="text-base font-bold text-gray-700">Penyemprot Cairan Penetral Amonia (Sprayer)</h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        Zat amonia yang tinggi (>15.0 ppm) berbahaya bagi puyuh. Aktifkan penyemprot cairan penetral untuk menurunkan kadar gas amonia secara instan.
                    </p>
                    <div class="flex items-center gap-2.5 mt-3 text-xs font-semibold text-yellow-700 bg-yellow-50 px-3.5 py-2.5 rounded-xl border border-yellow-100 w-fit">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Ambang Batas Keamanan: Suhu &gt;35°C | Amonia &gt;15.0 ppm | Kelembapan &lt;40% atau &gt;80%
                    </div>
                </div>
                <div class="flex justify-center md:justify-end">
                    <button
                        type="button"
                        id="sprayerBtn"
                        onclick="toggleSprayer()"
                        class="w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-red-600 hover:bg-red-500 pulse-ring focus:outline-none"
                    >
                        🚨 Aktifkan Penyemprot Amonia
                    </button>
                </div>

            <!-- Lampu Pemanas Control -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center mt-6 pt-6 border-t border-gray-100">
                <div class="md:col-span-2">
                    <h3 class="text-base font-bold text-gray-700">Lampu Pemanas (Heater Lamp)</h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        Aktifkan lampu pemanas secara manual untuk menghangatkan kandang saat suhu terlalu dingin. Lampu juga akan menyala otomatis jika suhu di bawah 20°C.
                    </p>
                </div>
                <div class="flex justify-center md:justify-end">
                    <button
                        type="button"
                        id="lampuBtn"
                        onclick="toggleLampu()"
                        class="w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-amber-600 hover:bg-amber-500 focus:outline-none"
                    >
                        💡 Aktifkan Lampu Manual
                    </button>
                </div>
            </div>

            </div>
        </div>

    </main>

    {{-- Footer - White with black text --}}
    <footer class="w-full mt-auto">
        <div class="footer-gradient h-[2px]"></div>
        <div class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    {{-- Left: University Branding --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                            <img src="{{ asset('images/uhn_logo.png') }}" alt="Logo UHN" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="text-gray-900 font-bold text-xs sm:text-sm tracking-wide uppercase">Universitas Harkat Negeri</p>
                            <p class="text-gray-500 text-[10px] sm:text-xs font-medium tracking-wider uppercase">Prodi Teknik Komputer</p>
                        </div>
                    </div>
                    {{-- Right: Copyright --}}
                    <div class="text-center sm:text-right">
                        <p class="text-gray-800 text-xs sm:text-sm font-semibold">&copy; {{ date('Y') }} Tugas Akhir</p>
                        <p class="text-gray-400 text-[10px] sm:text-xs font-medium tracking-wider uppercase">All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Toast Notification Container --}}
    <div id="toastContainer" class="fixed top-20 right-5 z-50 flex flex-col gap-3 max-w-sm w-full px-4 sm:px-0"></div>

    {{-- JavaScript Logic --}}
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // UI Locks to prevent polling from overwriting manual button clicks
        let isSprayerLocked = false;
        let isKipasLocked = false;
        let isLampuLocked = false;

        // Dynamic Jam
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            document.getElementById('currentTime').textContent = now.toLocaleDateString('id-ID', options);
        }
        updateTime();
        setInterval(updateTime, 1000);

        // Toast Notification System
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            toast.className = `flex items-center gap-3 p-4 rounded-2xl shadow-xl border backdrop-blur-xl animate-slide-in transition-all duration-300`;
            
            let bgClass, borderClass, textClass, iconSvg;

            if (type === 'success') {
                bgClass = 'bg-white/95';
                borderClass = 'border-green-200';
                textClass = 'text-gray-800';
                iconSvg = `<div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                </div>`;
            } else if (type === 'info') {
                bgClass = 'bg-white/95';
                borderClass = 'border-blue-200';
                textClass = 'text-gray-800';
                iconSvg = `<div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>`;
            } else { // error
                bgClass = 'bg-red-50/95';
                borderClass = 'border-red-200';
                textClass = 'text-red-900';
                iconSvg = `<div class="w-8 h-8 rounded-xl bg-red-150 flex items-center justify-center text-red-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>`;
            }

            toast.classList.add(bgClass, borderClass, textClass);
            toast.innerHTML = `
                ${iconSvg}
                <div class="flex-grow">
                    <p class="text-sm font-semibold">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition-colors ml-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;

            container.appendChild(toast);

            // Auto remove after 3.5 seconds
            setTimeout(() => {
                toast.classList.replace('animate-slide-in', 'animate-slide-out');
                toast.addEventListener('animationend', () => toast.remove());
            }, 3500);
        }

        // Update Sprayer Button UI State
        function updateSprayerButton(isActive) {
            const btn = document.getElementById('sprayerBtn');
            const badge = document.getElementById('sprayerStatusBadge');
            
            if (isActive) {
                // Active State (Blinking Green)
                btn.className = "w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-green-600 hover:bg-green-500 pulse-ring-active animate-blink focus:outline-none";
                btn.textContent = "✅ Penyemprot Aktif - Klik untuk Matikan";
                
                badge.className = "px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 animate-pulse border border-green-200";
                badge.textContent = "AKTIF";
            } else {
                // Inactive State (Pulse Red)
                btn.className = "w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-red-600 hover:bg-red-500 pulse-ring focus:outline-none";
                btn.textContent = "🚨 Aktifkan Penyemprot Amonia";
                
                badge.className = "px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200";
                badge.textContent = "NONAKTIF";
            }
        }

        // Toggle Sprayer Action via AJAX
        async function toggleSprayer() {
            const btn = document.getElementById('sprayerBtn');
            btn.disabled = true;

            try {
                const response = await fetch("{{ route('api.sprayer.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) throw new Error("HTTP error " + response.status);
                const data = await response.json();

                if (data.success) {
                    updateSprayerButton(data.active);
                    showToast(data.message, data.active ? 'success' : 'info');
                }
            } catch (error) {
                console.error("Gagal mengganti status sprayer:", error);
                showToast("⚠️ Gagal berkomunikasi dengan server sprayer.", "error");
            } finally {
                btn.disabled = false;
                isSprayerLocked = true;
                setTimeout(() => { isSprayerLocked = false; }, 8000); // Kunci UI dari polling selama 8 detik
            }
        }

        // Update Kipas Button UI State
        function updateKipasButton(isActive) {
            const btn = document.getElementById('kipasBtn');
            const badge = document.getElementById('kipasStatusBadge');
            
            if (isActive) {
                btn.className = "w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-green-600 hover:bg-green-500 animate-blink focus:outline-none";
                btn.textContent = "✅ Kipas Aktif - Klik untuk Matikan";
                
                badge.className = "px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 animate-pulse border border-green-200";
                badge.textContent = "AKTIF";
            } else {
                btn.className = "w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-blue-600 hover:bg-blue-500 focus:outline-none";
                btn.textContent = "💨 Aktifkan Kipas Manual";
                
                badge.className = "px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200";
                badge.textContent = "NONAKTIF";
            }
        }

        // Toggle Kipas Action via AJAX
        async function toggleKipas() {
            const btn = document.getElementById('kipasBtn');
            btn.disabled = true;

            try {
                const response = await fetch("{{ route('api.kipas.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) throw new Error("HTTP error " + response.status);
                const data = await response.json();

                if (data.success) {
                    updateKipasButton(data.active);
                    showToast(data.message, data.active ? 'success' : 'info');
                }
            } catch (error) {
                console.error("Gagal mengganti status kipas:", error);
                showToast("⚠️ Gagal berkomunikasi dengan server kipas.", "error");
            } finally {
                btn.disabled = false;
                isKipasLocked = true;
                setTimeout(() => { isKipasLocked = false; }, 8000); // Kunci UI dari polling selama 8 detik
            }
        }

        // Update Lampu Button UI State
        function updateLampuButton(isActive) {
            const btn = document.getElementById('lampuBtn');
            const badge = document.getElementById('lampuStatusBadge');
            
            if (isActive) {
                btn.className = "w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-green-600 hover:bg-green-500 animate-blink focus:outline-none";
                btn.textContent = "✅ Lampu Aktif - Klik untuk Matikan";
                
                badge.className = "px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 animate-pulse border border-green-200";
                badge.textContent = "AKTIF";
            } else {
                btn.className = "w-full sm:w-auto px-8 py-5 text-white font-extrabold text-sm rounded-2xl tracking-wide transition-all shadow-md active:scale-95 duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-amber-600 hover:bg-amber-500 focus:outline-none";
                btn.textContent = "💡 Aktifkan Lampu Manual";
                
                badge.className = "px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200";
                badge.textContent = "NONAKTIF";
            }
        }

        // Toggle Lampu Action via AJAX
        async function toggleLampu() {
            const btn = document.getElementById('lampuBtn');
            btn.disabled = true;

            try {
                const response = await fetch("{{ route('api.lampu.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) throw new Error("HTTP error " + response.status);
                const data = await response.json();

                if (data.success) {
                    updateLampuButton(data.active);
                    showToast(data.message, data.active ? 'success' : 'info');
                }
            } catch (error) {
                console.error("Gagal mengganti status lampu:", error);
                showToast("⚠️ Gagal berkomunikasi dengan server lampu.", "error");
            } finally {
                btn.disabled = false;
                isLampuLocked = true;
                setTimeout(() => { isLampuLocked = false; }, 8000); // Kunci UI dari polling selama 8 detik
            }
        }

        // Update Dashboard Elements dynamically based on live AJAX data
        function updateDashboard(data) {

            // Suhu Update
            const suhuVal = document.getElementById('suhuVal');
            suhuVal.textContent = data.suhu;
            
            // Map progress bar percentage (20 to 42 as range)
            const suhuPercent = Math.max(0, Math.min(100, ((data.suhu - 20) / (42 - 20)) * 100));
            const suhuBar = document.getElementById('suhuBar');
            suhuBar.style.width = `${suhuPercent}%`;

            const suhuCard = document.getElementById('suhuCard');
            const suhuBadge = document.getElementById('suhuBadge');
            const suhuIconBg = document.getElementById('suhuIconBg');
            const suhuIcon = document.getElementById('suhuIcon');

            if (data.suhu > 35.0) { // Bahaya
                suhuBadge.className = "px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full uppercase tracking-wider animate-pulse";
                suhuBadge.textContent = "BAHAYA";
                suhuCard.className = "card-hover bg-red-50/20 rounded-3xl p-6 border border-red-300 shadow-md ring-2 ring-red-500/5 transition-all duration-300";
                suhuIconBg.className = "w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 flex-shrink-0";
                suhuBar.className = "bg-gradient-to-r from-red-500 to-rose-600 h-2.5 rounded-full transition-all duration-500";
            } else if (data.suhu > 33.0) { // Waspada
                suhuBadge.className = "px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full uppercase tracking-wider";
                suhuBadge.textContent = "WASPADA";
                suhuCard.className = "card-hover bg-yellow-50/10 rounded-3xl p-6 border border-yellow-300 shadow-sm transition-all duration-300";
                suhuIconBg.className = "w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 flex-shrink-0";
                suhuBar.className = "bg-gradient-to-r from-yellow-400 to-amber-500 h-2.5 rounded-full transition-all duration-500";
            } else { // Normal
                suhuBadge.className = "px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider";
                suhuBadge.textContent = "NORMAL";
                suhuCard.className = "card-hover bg-white rounded-3xl p-6 border border-gray-100 shadow-sm transition-all duration-300";
                suhuIconBg.className = "w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 flex-shrink-0";
                suhuBar.className = "bg-gradient-to-r from-orange-400 to-orange-500 h-2.5 rounded-full transition-all duration-500";
            }

            // Kelembapan Update
            const kelembapanVal = document.getElementById('kelembapanVal');
            kelembapanVal.textContent = data.kelembapan;

            const kelembapanPercent = Math.max(0, Math.min(100, ((data.kelembapan - 30) / (100 - 30)) * 100));
            const kelembapanBar = document.getElementById('kelembapanBar');
            kelembapanBar.style.width = `${kelembapanPercent}%`;

            const kelembapanCard = document.getElementById('kelembapanCard');
            const kelembapanBadge = document.getElementById('kelembapanBadge');
            const kelembapanIconBg = document.getElementById('kelembapanIconBg');

            if (data.kelembapan < 40.0 || data.kelembapan > 80.0) { // Bahaya
                kelembapanBadge.className = "px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full uppercase tracking-wider animate-pulse";
                kelembapanBadge.textContent = "BAHAYA";
                kelembapanCard.className = "card-hover bg-red-50/20 rounded-3xl p-6 border border-red-300 shadow-md ring-2 ring-red-500/5 transition-all duration-300";
                kelembapanIconBg.className = "w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 flex-shrink-0";
                kelembapanBar.className = "bg-gradient-to-r from-red-500 to-rose-600 h-2.5 rounded-full transition-all duration-500";
            } else if (data.kelembapan < 50.0 || data.kelembapan > 75.0) { // Waspada
                kelembapanBadge.className = "px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full uppercase tracking-wider";
                kelembapanBadge.textContent = "WASPADA";
                kelembapanCard.className = "card-hover bg-yellow-50/10 rounded-3xl p-6 border border-yellow-300 shadow-sm transition-all duration-300";
                kelembapanIconBg.className = "w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 flex-shrink-0";
                kelembapanBar.className = "bg-gradient-to-r from-yellow-400 to-amber-500 h-2.5 rounded-full transition-all duration-500";
            } else { // Normal
                kelembapanBadge.className = "px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider";
                kelembapanBadge.textContent = "NORMAL";
                kelembapanCard.className = "card-hover bg-white rounded-3xl p-6 border border-gray-100 shadow-sm transition-all duration-300";
                kelembapanIconBg.className = "w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 flex-shrink-0";
                kelembapanBar.className = "bg-gradient-to-r from-blue-400 to-blue-500 h-2.5 rounded-full transition-all duration-500";
            }

            // Amonia Update
            const amoniaVal = document.getElementById('amoniaVal');
            amoniaVal.textContent = data.amonia;

            const amoniaPercent = Math.max(0, Math.min(100, (data.amonia / 50) * 100));
            const amoniaBar = document.getElementById('amoniaBar');
            amoniaBar.style.width = `${amoniaPercent}%`;

            const amoniaCard = document.getElementById('amoniaCard');
            const amoniaBadge = document.getElementById('amoniaBadge');
            const amoniaIconBg = document.getElementById('amoniaIconBg');

            if (data.amonia > 25.0) { // Bahaya
                amoniaBadge.className = "px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full uppercase tracking-wider animate-pulse";
                amoniaBadge.textContent = "BAHAYA";
                amoniaCard.className = "card-hover bg-red-50/20 rounded-3xl p-6 border border-red-300 shadow-md ring-2 ring-red-500/5 transition-all duration-300";
                amoniaIconBg.className = "w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 flex-shrink-0";
                amoniaBar.className = "bg-gradient-to-r from-red-500 to-rose-600 h-2.5 rounded-full transition-all duration-500";
            } else if (data.amonia > 20.0) { // Waspada
                amoniaBadge.className = "px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full uppercase tracking-wider";
                amoniaBadge.textContent = "WASPADA";
                amoniaCard.className = "card-hover bg-yellow-50/10 rounded-3xl p-6 border border-yellow-300 shadow-sm transition-all duration-300";
                amoniaIconBg.className = "w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 flex-shrink-0";
                amoniaBar.className = "bg-gradient-to-r from-yellow-400 to-amber-500 h-2.5 rounded-full transition-all duration-500";
            } else { // Normal
                amoniaBadge.className = "px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider";
                amoniaBadge.textContent = "NORMAL";
                amoniaCard.className = "card-hover bg-white rounded-3xl p-6 border border-gray-100 shadow-sm transition-all duration-300";
                amoniaIconBg.className = "w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500 flex-shrink-0";
                amoniaBar.className = "bg-gradient-to-r from-purple-400 to-purple-500 h-2.5 rounded-full transition-all duration-500";
            }

            // Sync Sprayer, Kipas & Lampu button state from server telemetries (hanya jika tidak dikunci)
            if (!isSprayerLocked) updateSprayerButton(data.sprayer_active);
            if (!isKipasLocked) updateKipasButton(data.kipas_active);
            if (!isLampuLocked) updateLampuButton(data.lampu_active);

            // Update Actuator Status Indicators
            updateActuatorStatus('kipas', data.kipas_active);
            updateActuatorStatus('pompa', data.sprayer_active);
            updateActuatorStatus('lampu', data.lampu_active);
        }

        // Update individual actuator status indicator
        function updateActuatorStatus(name, isActive) {
            const icon = document.getElementById(name + 'StatusIcon');
            const text = document.getElementById(name + 'StatusText');
            if (!icon || !text) return;

            if (isActive) {
                icon.className = 'w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0';
                icon.querySelector('svg').className.baseVal = 'w-5 h-5 text-green-600';
                text.textContent = 'MENYALA';
                text.className = 'text-sm font-bold text-green-600';
            } else {
                icon.className = 'w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0';
                icon.querySelector('svg').className.baseVal = 'w-5 h-5 text-gray-400';
                text.textContent = 'MATI';
                text.className = 'text-sm font-bold text-gray-400';
            }
        }

        // Fetch sensor telemetries on load and every 5 seconds
        async function fetchSensorData() {
            try {
                const response = await fetch("{{ route('api.sensor.latest') }}");
                if (!response.ok) throw new Error("HTTP Status: " + response.status);
                const data = await response.json();
                updateDashboard(data);
            } catch (error) {
                console.error("Gagal sinkronisasi data sensor:", error);
                // Fail silently or log to console. To avoid spamming user with toasts, we don't trigger toast every time.
            }
        }

        // Initial Load and Interval binding
        fetchSensorData();
        setInterval(fetchSensorData, 5000);

        // Welcome Toast - show once on login then fade away
        function dismissWelcome() {
            const toast = document.getElementById('welcomeToast');
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => { toast.style.display = 'none'; }, 500);
            sessionStorage.setItem('welcomeShown', 'true');
        }

        (function showWelcomeToast() {
            if (sessionStorage.getItem('welcomeShown')) return;
            const toast = document.getElementById('welcomeToast');
            toast.style.display = 'flex';
            // Trigger animation in next frame
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    toast.classList.remove('opacity-0', 'translate-y-2');
                    toast.classList.add('opacity-100', 'translate-y-0');
                });
            });
            // Auto-dismiss after 3 seconds
            setTimeout(dismissWelcome, 3000);
        })();

        // Navbar scroll effect - add shadow and blur on scroll
        const navbar = document.getElementById('mainNavbar');
        let lastScrollY = 0;
        let ticking = false;

        function handleNavbarScroll() {
            if (window.scrollY > 10) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(handleNavbarScroll);
                ticking = true;
            }
        }, { passive: true });
    </script>
</body>
</html>
