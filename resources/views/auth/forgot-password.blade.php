<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Kata Sandi - {{ get_setting('site_name', 'Pink Tour and Travel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white overflow-hidden">

    <div class="min-h-screen flex w-full">

        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-950">
            <img src="/images/banda-neira.jpeg" alt="Banda Neira"
                class="absolute inset-0 w-full h-full object-cover opacity-90" style="object-position: 75% center;">
            <div class="absolute inset-0 bg-slate-950/20 z-10 backdrop-blur-[0.5px]"></div>
            <div class="absolute z-20 flex flex-col text-white text-left w-full max-w-2xl px-8"
                style="bottom: 7%; left: 3%;">
                <h1 class="text-5xl font-bold mb-4 leading-tight uppercase">
                    Jelajahi Banda Neira Bersama Kami
                </h1>
                <p class="text-lg text-white/90 leading-relaxed">
                    Pemesanan lengkap untuk pengalaman open trip Banda Neira Anda yang tak terlupakan.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 bg-white flex items-center justify-center p-8">
            <div class="w-full max-w-md">

                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-[#020617] mb-2">
                        Lupa Kata Sandi?
                    </h2>
                    <p class="text-slate-500 text-sm">
                        Masukkan alamat email Anda untuk menerima tautan pemulihan kata sandi.
                    </p>
                </div>

                @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 text-sm text-center">
                    {{ session('status') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Alamat Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            oninvalid="this.setCustomValidity('Harap isi bagian ini.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none"
                            placeholder="nama@contoh.com">
                    </div>

                    <button type="submit"
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 rounded-xl transition duration-200">
                        Kirim Tautan Reset
                    </button>
                </form>

                <p class="text-center mt-8 text-gray-600">
                    Kembali ke
                    <a href="{{ route('login') }}" class="text-pink-600 font-semibold">
                        Masuk
                    </a>
                </p>

            </div>
        </div>
    </div>

</body>

</html>