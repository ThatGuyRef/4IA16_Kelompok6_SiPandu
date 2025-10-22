<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Kelurahan Jati</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .glow {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.6);
        }
        .bg-gradient-custom {
            /* Warna yang lebih vibrant */
            background: linear-gradient(135deg, #4f46e5 0%, #a78bfa 100%);
        }
        /* Memastikan input di dalam div flex terlihat rapi */
        .input-wrapper input {
            padding: 0.75rem 0.5rem;
            border: none;
            outline: none;
        }
        /* CSS tambahan untuk memastikan background image terlihat baik */
        .bg-cover-fixed {
            background-size: cover;
            background-position: center;
        }
    </style>
    <!-- Konfigurasi Font Inter (opsional, tapi disarankan untuk Tailwind) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-custom flex items-center justify-center relative overflow-hidden font-sans">
    <!-- Dekorasi Latar Belakang -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-blue-300 rounded-full opacity-20 floating"></div>
        <div class="absolute bottom-20 right-20 w-32 h-32 bg-purple-300 rounded-full opacity-20 floating" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-indigo-300 rounded-full opacity-30 floating" style="animation-delay: 2s;"></div>
    </div>

    <!-- Container Utama Login Card -->
    <div class="flex bg-white shadow-2xl rounded-3xl overflow-hidden w-full max-w-6xl 
                transform transition-transform duration-500 glow mx-4 my-8 md:my-0">
        
        <!-- Kiri: Formulir Login -->
        <div class="w-full md:w-1/2 p-6 sm:p-10 flex flex-col justify-center relative">
            <div class="text-center mb-8">
                <i class="fas fa-user-lock text-6xl text-indigo-600 mb-4 floating"></i>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-2">Selamat Datang!</h1>
                <p class="text-gray-500 text-sm sm:text-base">Masuk ke sistem administrasi SI-PANDU Kelurahan Jati.</p>
            </div>

            <!-- Pesan Error (Laravel Syntax Placeholder) -->
            {{-- Mengganti komentar HTML dengan komentar Blade untuk memastikan sintaks Blade tetap valid --}}
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg mb-4 animate-pulse">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                {{-- Mengaktifkan CSRF --}}
                @csrf

                <div class="relative">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="flex items-center border border-gray-300 rounded-xl focus-within:ring-2 
                                focus-within:ring-indigo-300 focus-within:border-indigo-500 transition input-wrapper">
                        <i class="fas fa-envelope text-gray-400 ml-4"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full p-3 pl-2 focus:outline-none"
                            placeholder="contoh@domain.com" required autocomplete="email">
                    </div>
                    @error('email')
                        <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="flex items-center border border-gray-300 rounded-xl focus-within:ring-2 
                                focus-within:ring-indigo-300 focus-within:border-indigo-500 transition input-wrapper">
                        <i class="fas fa-lock text-gray-400 ml-4"></i>
                        <input type="password" id="password" name="password"
                            class="w-full p-3 pl-2 focus:outline-none"
                            placeholder="••••••••" required autocomplete="current-password">
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 
                           text-white py-3 rounded-xl font-semibold transition transform hover:scale-[1.02] shadow-xl 
                           flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Sistem
                </button>
            </form>

            <p class="text-center text-gray-400 text-xs sm:text-sm mt-8">
                © {{ date('Y') }} Kelurahan Jati — Semua Hak Dilindungi
            </p>
        </div>

        <!-- Kanan: Gambar Kota dengan Overlay, menggunakan background-image -->
        <div class="hidden md:block w-1/2 bg-gradient-to-br from-indigo-600 to-purple-700 relative opacity-90 bg-cover-fixed" 
             style="background-image: url('{{ asset('image/Q4N4Yo6uW2o4CK75NwmlR5tfJcUqxCdTqJHqKJad.jpg') }}');">
            
            <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white p-8">
                <h2 class="text-5xl font-extrabold mb-4 floating" style="animation-duration: 4s;">SI-PANDU</h2>
                <p class="text-lg text-center leading-relaxed font-light">
                    Sistem Pelayanan Administrasi Penduduk Terpadu Kelurahan Jati. <br>
                    <span class="text-indigo-200 italic font-medium">Melayani dengan cepat dan transparan.</span>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
