<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Sistem Monitoring Kandang Puyuh IoT">
    <title>Login — Monitoring Kandang Puyuh IoT</title>
    <link class="w-full h-full object-contain" rel="icon" href="{{ asset('images/smartquail_logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif']
                    },
                    animation: {
                        'pulse-glow': 'pulseGlow 2.5s infinite',
                        'card-enter': 'cardEnter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        pulseGlow: {
                            '0%, 100%': { opacity: '1', transform: 'scale(1)', filter: 'brightness(1)' },
                            '50%': { opacity: '0.85', transform: 'scale(0.97)', filter: 'brightness(1.1)' }
                        },
                        cardEnter: {
                            '0%': { transform: 'translateY(40px) scale(0.95)', opacity: '0' },
                            '100%': { transform: 'translateY(0) scale(1)', opacity: '1' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' }
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
        body { 
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }
        .bg-custom {
            background-image: url('{{ asset('images/background1.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .particle { 
            position: absolute; 
            border-radius: 50%; 
            background: rgba(255, 255, 255, 0.02); 
            animation: float 20s infinite ease-in-out; 
        }
        .particle:nth-child(1){width:300px;height:300px;top:-50px;left:-80px;animation-duration:25s}
        .particle:nth-child(2){width:200px;height:200px;top:60%;right:-40px;animation-delay:-5s;animation-duration:20s}
        .particle:nth-child(3){width:150px;height:150px;bottom:-30px;left:30%;animation-delay:-10s;animation-duration:22s}
        
        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1.5px solid rgba(209, 213, 219, 0.6);
            background: rgba(255, 255, 255, 0.75);
        }
        
        .input-field:focus {
            border-color: rgb(34, 197, 94);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
            transform: translateY(-1px);
        }
        
        .input-field::placeholder {
            color: rgb(156, 163, 175);
        }
        
        .btn-submit {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.25);
        }
        
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-submit:hover::before {
            left: 100%;
        }
        
        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.35);
        }
        
        .btn-submit:active:not(:disabled) {
            transform: translateY(0px);
        }
        
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .shake {
            animation: shake 0.4s cubic-bezier(.36, .07, .19, .97) both;
        }
        
        @keyframes shake {
            10%, 90% { transform: translateX(-2px); }
            20%, 80% { transform: translateX(2px); }
            30%, 50%, 70% { transform: translateX(-4px); }
            40%, 60% { transform: translateX(4px); }
        }
        
        .error-message {
            animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-custom min-h-screen flex flex-col items-center p-4 relative overflow-y-auto overflow-x-hidden selection:bg-green-500/30 selection:text-green-800" style="padding-top: 2rem; padding-bottom: 2rem;">
    <!-- Backdrop overlay dengan gradient -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/35 via-black/40 to-black/50 z-0"></div> 
    
    <!-- Animated background floating particles -->
    <div class="particle z-0"></div>
    <div class="particle z-0"></div>
    <div class="particle z-0"></div>

    <!-- Login Card Container -->
    <div class="animate-card-enter w-full max-w-md relative z-10">
        
        <!-- Branding Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 mb-6 shadow-2xl shadow-black/20 overflow-hidden animate-pulse-glow">
                <img src="{{ asset('images/pyh.png') }}" alt="SmartQuail Logo" class="w-14 h-14 object-contain">
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight drop-shadow-lg mb-2">Monitoring Kandang Puyuh IoT</h1>
            <p class="text-green-100/90 text-sm font-medium drop-shadow-md">Sistem pemantauan lingkungan kandang secara real-time</p>
        </div>

        <!-- Form Panel -->
        <div class="bg-white/90 backdrop-blur-lg border border-white/60 rounded-3xl shadow-2xl shadow-black/40 p-8">
            
            <!-- Form Header -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-1">Selamat Datang 👋</h2>
                <p class="text-gray-500 text-sm">Masukkan kredensial Anda untuk masuk ke dashboard</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.submit') }}" id="loginForm" novalidate>
                @csrf
                
                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-xs font-semibold text-gray-800 mb-3 uppercase tracking-wide">Email Anda</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@example.com" required autocomplete="email"
                            class="input-field w-full pl-12 pr-4 py-3.5 rounded-xl text-gray-900 text-sm font-medium focus:outline-none @error('email') border-red-400 bg-red-50/80 @enderror">
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs text-red-600 font-semibold error-message flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586 7.313 11.899a1 1 0 00-1.414 1.414l3.535 3.536a1 1 0 001.414 0l8.181-8.182z" clip-rule="evenodd"/></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-xs font-semibold text-gray-800 mb-3 uppercase tracking-wide">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password"
                            class="input-field w-full pl-12 pr-12 py-3.5 rounded-xl text-gray-900 text-sm font-medium focus:outline-none @error('password') border-red-400 bg-red-50/80 @enderror">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-700 transition-colors duration-200">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-4.753 4.753m4.753-4.753L3.596 3.596m16.807 16.807L9.172 9.172m0 0a3 3 0 10-4.243-4.243m4.243 4.243L3.596 3.596" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs text-red-600 font-semibold error-message flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586 7.313 11.899a1 1 0 00-1.414 1.414l3.535 3.536a1 1 0 001.414 0l8.181-8.182z" clip-rule="evenodd"/></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center mb-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded border-gray-300 text-green-700 focus:ring-2 focus:ring-green-500/40 cursor-pointer accent-green-700">
                        <span class="text-sm text-gray-700 group-hover:text-gray-900 font-medium transition-colors">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="loginBtn" class="btn-submit w-full py-2.5 px-6 bg-gradient-to-r from-green-700 via-green-600 to-green-700 hover:from-green-600 hover:via-green-500 hover:to-green-600 text-white font-semibold rounded-xl text-sm tracking-wide focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-300">
                    <span id="btnText" class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Masuk</span>
                    </span>
                    <span id="btnLoading" class="hidden flex items-center justify-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memproses...</span>
                    </span>
                </button>
            </form>

            <!-- Failed Login Notice -->
            @if ($errors->has('login'))
            <div class="mt-6 p-4 bg-red-50 border border-red-300 rounded-xl shake error-message">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center text-red-600 mt-0.5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-red-700">Login Gagal</p>
                        <p class="text-sm text-red-600 mt-1">{{ $errors->first('login') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Divider -->
        <div class="mt-8 px-6">
            <div style="height:1.5px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full relative z-10 mt-12">
        <div class="bg-white/80 backdrop-blur-lg border-t border-white/40 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 bg-white border border-gray-200 p-2 overflow-hidden shadow-md">
                            <img src="{{ asset('images/uhn_logo.png') }}" alt="Logo UHN" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="text-gray-900 font-bold text-xs tracking-wide uppercase">Universitas Harkat Negeri</p>
                            <p class="text-gray-600 text-[11px] font-semibold tracking-wider uppercase">Prodi Teknik Komputer</p>
                        </div>
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-gray-800 text-xs font-semibold">&copy; {{ date('Y') }} Tugas Akhir</p>
                        <p class="text-gray-500 text-[11px] font-medium tracking-wider uppercase">All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            
            if (passwordInput.type === 'password') { 
                passwordInput.type = 'text'; 
                eyeIcon.classList.add('hidden'); 
                eyeOffIcon.classList.remove('hidden'); 
            } else { 
                passwordInput.type = 'password'; 
                eyeIcon.classList.remove('hidden'); 
                eyeOffIcon.classList.add('hidden'); 
            }
        }
        
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.disabled = true;
            document.getElementById('btnText').classList.add('hidden');
            document.getElementById('btnLoading').classList.remove('hidden');
        });
    </script>
</body>
</html>