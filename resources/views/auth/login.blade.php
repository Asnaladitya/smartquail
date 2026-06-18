<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Sistem Monitoring Kandang Puyuh IoT">
    <title>Login — Monitoring Kandang Puyuh IoT</title>
    <link rel="icon" href="{{ asset('images/smartquail_logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: {
                'kandang': { 700:'#15803d', 800:'#166534', 900:'#14532d', 950:'#052e16' }
            }, fontFamily: { 'sans': ['Plus Jakarta Sans','Inter','system-ui','sans-serif'] } } }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .bg-custom {
            background-image: url('{{ asset('images/background1.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .bg-animated { background: linear-gradient(135deg, #14532d 0%, #166534 25%, #14532d 50%, #052e16 75%, #14532d 100%); background-size: 400% 400%; animation: g 15s ease infinite; }
        @keyframes g { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        .particle { position:absolute; border-radius:50%; background:rgba(255,255,255,0.04); animation:f 20s infinite ease-in-out; }
        .particle:nth-child(1){width:300px;height:300px;top:-50px;left:-80px;animation-duration:25s}
        .particle:nth-child(2){width:200px;height:200px;top:60%;right:-40px;animation-delay:-5s;animation-duration:20s}
        .particle:nth-child(3){width:150px;height:150px;bottom:-30px;left:30%;animation-delay:-10s;animation-duration:22s}
        @keyframes f { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-30px) scale(1.05)} }
        .card-enter { animation: cu 0.8s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes cu { from{opacity:0;transform:translateY(40px) scale(0.96)} to{opacity:1;transform:translateY(0) scale(1)} }
        .input-animated { transition: all 0.3s ease; }
        .input-animated:focus { transform: translateY(-1px); }
        .btn-glow { position:relative; overflow:hidden; transition:all 0.3s ease; }
        .btn-glow::before { content:''; position:absolute; top:0; left:-100%; width:100%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.15),transparent); transition:left 0.5s ease; }
        .btn-glow:hover::before { left:100%; }
        .btn-glow:hover { transform:translateY(-2px); box-shadow:0 12px 40px -8px rgba(20,83,45,0.5); }
        .shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
        @keyframes shake { 10%,90%{transform:translateX(-2px)} 20%,80%{transform:translateX(4px)} 30%,50%,70%{transform:translateX(-6px)} 40%,60%{transform:translateX(6px)} }
        .pulse-ring { animation: pr 3s ease-out infinite; }
        @keyframes pr { 0%{box-shadow:0 0 0 0 rgba(34,197,94,0.4)} 70%{box-shadow:0 0 0 15px rgba(34,197,94,0)} 100%{box-shadow:0 0 0 0 rgba(34,197,94,0)} }
    </style>
</head>
<body class="bg-custom min-h-screen flex items-start justify-center p-4 pt-8 sm:pt-16 relative overflow-y-auto">
    <div class="absolute inset-0 bg-black/40 z-0"></div> <!-- Optional overlay for better readability -->
    <div class="particle z-0"></div><div class="particle z-0"></div><div class="particle z-0"></div>

    <div class="card-enter w-full max-w-lg relative z-10 my-6">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-50 h-40 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/20 mb-5 pulse-ring overflow-hidden">
                <img src="{{ asset('images/pyh.png') }}" alt="Logo Monitoring" class="w-full h-full object-contain drop-shadow-lg scale-110">
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Monitoring Kandang Puyuh IoT</h1>
            <p class="text-green-300/70 text-sm mt-2 font-medium">Sistem pemantauan kandang puyuh secara real-time</p>
        </div>

        <div class="bg-white/80 backdrop-blur-md border border-white/40 rounded-3xl shadow-2xl shadow-black/30 p-8 sm:p-12">
            <div class="mb-7">
                <h2 class="text-xl font-bold text-gray-800">Selamat Datang 👋</h2>
                <p class="text-gray-500 text-sm mt-1">Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login.submit') }}" id="loginForm" novalidate>
                @csrf
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukan Email Anda" required autocomplete="email"
                            class="input-animated w-full pl-12 pr-4 py-4 bg-white/60 border border-gray-300/50 rounded-xl text-gray-800 placeholder-gray-500 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/40 focus:border-green-700 focus:bg-white/90 @error('email') border-red-400 bg-red-50/80 @enderror">
                    </div>
                    @error('email')<p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Masukan Password Anda" required autocomplete="current-password"
                            class="input-animated w-full pl-12 pr-12 py-4 bg-white/60 border border-gray-300/50 rounded-xl text-gray-800 placeholder-gray-500 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/40 focus:border-green-700 focus:bg-white/90 @error('password') border-red-400 bg-red-50/80 @enderror">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-800 transition-colors">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    @error('password')<p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center mb-7">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-green-700 focus:ring-green-500/30 cursor-pointer">
                        <span class="text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" id="loginBtn" class="btn-glow w-full py-3.5 px-6 bg-gradient-to-r from-kandang-800 to-kandang-900 hover:from-kandang-700 hover:to-kandang-800 text-white font-semibold rounded-xl text-sm tracking-wide focus:outline-none focus:ring-2 focus:ring-green-500/40 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="btnText" class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                        Masuk
                    </span>
                    <span id="btnLoading" class="hidden flex items-center justify-center gap-2">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Memproses...
                    </span>
                </button>
            </form>

            @if ($errors->has('login'))
            <div class="mt-5 p-4 bg-red-50 border border-red-200 rounded-xl shake">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-red-700">Login Gagal</p>
                        <p class="text-sm text-red-600 mt-0.5">{{ $errors->first('login') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

    </div>

    {{-- Footer --}}
    <footer class="fixed bottom-0 left-0 right-0 z-20">
        <div style="height:2px; background: linear-gradient(90deg, #e5e7eb, #9ca3af, #e5e7eb);"></div>
        <div class="bg-white/95 backdrop-blur-md border-t border-gray-200 shadow-[0_-2px_10px_rgba(0,0,0,0.05)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                            <img src="{{ asset('images/uhn_logo.png') }}" alt="Logo UHN" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="text-gray-900 font-bold text-[10px] sm:text-xs tracking-wide uppercase">Universitas Harkat Negeri</p>
                            <p class="text-gray-500 text-[9px] sm:text-[10px] font-medium tracking-wider uppercase">Prodi Teknik Komputer</p>
                        </div>
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-gray-800 text-[10px] sm:text-xs font-semibold">&copy; {{ date('Y') }} Tugas Akhir</p>
                        <p class="text-gray-400 text-[9px] sm:text-[10px] font-medium tracking-wider uppercase">All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function togglePassword() {
            const p = document.getElementById('password');
            const e1 = document.getElementById('eyeIcon');
            const e2 = document.getElementById('eyeOffIcon');
            if (p.type === 'password') { p.type = 'text'; e1.classList.add('hidden'); e2.classList.remove('hidden'); }
            else { p.type = 'password'; e1.classList.remove('hidden'); e2.classList.add('hidden'); }
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
