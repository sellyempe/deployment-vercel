<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - {{ get_setting('site_name', 'Pink Tour and Travel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white">

    <div class="min-h-screen flex w-full">

        <!-- LEFT SIDE IMAGE (Same as Register) -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-950">
            <img src="/images/banda-neira.jpeg" alt="Banda Neira"
                class="absolute inset-0 w-full h-full object-cover opacity-90" style="object-position: 75% center;">
            <div class="absolute inset-0 bg-slate-950/20 backdrop-blur-[0.5px]"></div>
        </div>

        <!-- RIGHT SIDE CONTENT -->
        <div class="w-full lg:w-1/2 bg-white flex items-center justify-center p-8">

            <div class="w-full max-w-md">

                <!-- Heading -->
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-[#020617] mb-2">
                        Verifikasi Email Anda
                    </h2>
                    <p class="text-slate-500">
                        Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan
                        mengeklik tautan yang baru saja kami kirimkan ke email Anda.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 text-sm text-center">
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
                @endif

                <div class="space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 rounded-xl transition duration-200">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 font-medium underline">
                            Keluar
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>