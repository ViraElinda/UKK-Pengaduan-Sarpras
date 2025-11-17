<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Daftar - Pengaduan Sarpras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .password-strength {
            height: 4px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 8px;
        }
        .password-strength-bar {
            height: 100%;
            transition: all 0.3s;
            width: 0%;
        }
    </style>
</head>
<body class="bg-emerald-600 min-h-screen flex items-center justify-center p-4">

    <!-- Back to Home -->
    <a href="<?= base_url('/') ?>" class="fixed top-6 left-6 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-xl font-semibold shadow-lg transition-all flex items-center gap-2 z-10">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
        <span class="hidden sm:inline">Kembali</span>
    </a>

    <div class="w-full max-w-md animate-fadeIn">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl shadow-2xl mb-4 border border-white/30">
                <i data-lucide="user-plus" class="w-12 h-12 text-white"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-white mb-2">Bergabung Sekarang</h1>
            <p class="text-white/80 font-medium">Buat akun baru untuk mulai melaporkan</p>
        </div>

        <div class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl p-8 border border-white/50">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Daftar Akun</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3 shadow border border-red-200" role="alert">
                    <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="font-semibold"><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/auth/register') ?>" method="post" class="space-y-5">
                <div>
                    <label for="nama_pengguna" class="block text-gray-700 font-bold mb-2 text-sm">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input type="text" name="nama_pengguna" id="nama_pengguna" placeholder="Masukkan nama lengkap Anda"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all font-medium" required>
                    </div>
                </div>

                <div>
                    <label for="username" class="block text-gray-700 font-bold mb-2 text-sm">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="at-sign" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input type="text" name="username" id="username" placeholder="Pilih username unik"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all font-medium" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-bold mb-2 text-sm">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" minlength="6"
                               class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all font-medium" required>
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div id="passwordStrengthBar" class="password-strength-bar"></div>
                    </div>
                    <p id="passwordStrengthText" class="text-xs text-gray-500 mt-1"></p>
                </div>

                <input type="hidden" name="role" value="user">

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                    <p class="text-sm text-blue-800 leading-relaxed">
                        <strong>Catatan:</strong> Akun Anda akan terdaftar sebagai <strong>Pengguna</strong> dan dapat langsung digunakan untuk melaporkan.
                    </p>
                </div>

                <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                    <span>Daftar Sekarang</span>
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500 font-medium">Atau</span>
                </div>
            </div>

                <p class="text-center text-gray-600 font-medium">
                Sudah punya akun?
                <a href="<?= base_url('auth/login') ?>" class="text-emerald-600 hover:text-emerald-700 font-bold hover:underline">Masuk Sekarang</a>
            </p>
        </div>

        <p class="text-center text-white/80 text-sm mt-6">
            Dengan mendaftar, Anda menyetujui <a href="#" class="underline font-semibold">Syarat & Ketentuan</a> kami
        </p>
    </div>

    <script>
        lucide.createIcons();

        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            
            const icon = togglePassword.querySelector('i');
            if (type === 'password') {
                icon.setAttribute('data-lucide', 'eye');
            } else {
                icon.setAttribute('data-lucide', 'eye-off');
            }
            lucide.createIcons();
        });

        const strengthBar = document.getElementById('passwordStrengthBar');
        const strengthText = document.getElementById('passwordStrengthText');
        
        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            let strength = 0;
            let color = '';
            let text = '';
            
            if (password.length >= 6) strength++;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            if (strength === 0) {
                strengthBar.style.width = '0%';
                text = '';
            } else if (strength <= 2) {
                strengthBar.style.width = '33%';
                color = '#ef4444';
                text = 'Lemah';
            } else if (strength <= 3) {
                strengthBar.style.width = '66%';
                color = '#f59e0b';
                text = 'Sedang';
            } else {
                strengthBar.style.width = '100%';
                color = '#10b981';
                text = 'Kuat';
            }
            
            strengthBar.style.backgroundColor = color;
            strengthText.textContent = text;
            strengthText.style.color = color;
        });

        (function() {
            if (window.history && window.history.pushState) {
                window.history.pushState('forward', null, window.location.href);
                window.addEventListener('popstate', function() {
                    window.history.pushState('forward', null, window.location.href);
                });
            }

            if (performance.navigation.type === 2) {
                window.location.reload(true);
            }

            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    window.location.reload(true);
                }
            });
        })();
    </script>

</body>
</html>
