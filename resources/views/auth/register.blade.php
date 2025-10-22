<x-guest-layout>
    <div class="w-full max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
        <div class="w-full md:w-1/2 p-8 sm:p-10">
            <div class="text-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold heading-gradient">Buat Akun SI-PANDU</h1>
                <p class="text-gray-500 mt-2">Daftar untuk mulai menggunakan layanan kelurahan.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end">
                    <a class="text-sm text-gray-500 mr-4" href="{{ route('login') }}">Sudah punya akun?</a>
                    <button type="submit" class="btn-primary">Daftar</button>
                </div>
            </form>
        </div>

        <div class="hidden md:block md:w-1/2 bg-gradient-to-br from-primary-600 to-accent-500 text-white p-8 relative">
            <div class="absolute inset-0 bg-black bg-opacity-40 rounded-r-3xl"></div>
            <div class="relative z-10 h-full flex flex-col items-center justify-center text-center p-8">
                <h2 class="text-4xl font-extrabold mb-2">SI-PANDU</h2>
                <p class="text-indigo-100 max-w-xs">Sistem Pelayanan Administrasi Penduduk Terpadu Kelurahan Jati — cepat, mudah, dan transparan.</p>
            </div>
        </div>
    </div>
</x-guest-layout>
