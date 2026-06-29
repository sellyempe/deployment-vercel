<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - {{ get_setting('site_name', 'Pink Tour and Travel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white overflow-hidden">

    <div class="min-h-screen flex w-full">

        <!-- LEFT SIDE IMAGE -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-950">

            <img src="/images/banda-neira.jpeg" alt="Banda Neira"
                class="absolute inset-0 w-full h-full object-cover opacity-90" style="object-position: 75% center;">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-slate-950/20 backdrop-blur-[0.5px]"></div>

            <!-- Left Content -->
            <div class="absolute z-10 flex flex-col text-white text-left w-full max-w-2xl px-8"
                style="bottom: 7%; left: 3%;">

                <h1 class="text-5xl font-bold leading-tight mb-4 uppercase">
                    Mulai Perjalanan Anda Bersama Kami
                </h1>

                <p class="text-lg text-white/90 leading-relaxed">
                    Buat akun Anda dan temukan pengalaman perjalanan tak terlupakan di Banda Neira bersama
                    {{ get_setting('site_name', 'Pink Tour and Travel') }}.
                </p>
            </div>
        </div>

        <!-- RIGHT SIDE FORM -->
        <div class="w-full lg:w-1/2 bg-white flex items-center justify-center p-8">

            <div class="w-full max-w-md">

                <!-- Heading -->
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-[#020617] mb-2">
                        Daftar Akun
                    </h2>

                    <p class="text-slate-500">
                        Bergabunglah dengan kami dan mulai petualangan perjalanan Anda
                    </p>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6">
                    <p class="font-semibold mb-2">
                        Mohon periksa kembali kesalahan berikut:
                    </p>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Register Form -->
                <form action="{{ route('register') }}" method="POST" class="space-y-5">

                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-800 mb-2">
                            Nama Lengkap
                        </label>

                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap Anda" required
                            oninvalid="this.setCustomValidity('Harap isi bagian ini.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-800 mb-2">
                            Alamat Email
                        </label>

                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="nama@contoh.com" required
                            oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Harap isi bagian ini.' : 'Masukkan alamat email yang valid.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-800 mb-2">
                            Kata Sandi
                        </label>

                        <input type="password" id="password" name="password" placeholder="••••••••" required
                            oninvalid="this.setCustomValidity('Harap isi bagian ini.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">

                        <p class="text-xs text-gray-500 mt-1">
                            Minimal 6 karakter
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-800 mb-2">
                            Konfirmasi Kata Sandi
                        </label>

                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="••••••••" required oninvalid="this.setCustomValidity('Harap isi bagian ini.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 rounded-xl transition duration-200 hover:scale-[1.02]">
                        Daftar Akun
                    </button>
                </form>

                <!-- Login Link -->
                <p class="text-center mt-6 text-gray-600">
                    Sudah punya akun?

                    <a href="{{ route('login') }}" class="text-pink-600 font-semibold hover:text-pink-700">
                        Masuk
                    </a>
                </p>

            </div>
        </div>
    </div>

</body>

</html>