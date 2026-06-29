<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atur Ulang Kata Sandi - {{ get_setting('site_name', 'Pink Tour and Travel') }}</title>
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
                    Pemesanan lengkap untuk pengalaman open trip Banda Neira Anda yang tak unutuk dilupakan.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 bg-white flex items-center justify-center p-8">
            <div class="w-full max-w-md">

                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-[#020617] mb-2">
                        Atur Ulang Kata Sandi
                    </h2>
                    <p class="text-slate-500 text-sm">
                        Masukkan kata sandi baru Anda di bawah ini.
                    </p>
                </div>

                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Alamat Email
                        </label>
                        <input type="email" name="email" value="{{ old('email', $email) }}" required readonly
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Kata Sandi Baru
                        </label>
                        <input type="password" name="password" required
                            oninvalid="this.setCustomValidity('Harap isi bagian ini.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none"
                            placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Konfirmasi Kata Sandi Baru
                        </label>
                        <input type="password" name="password_confirmation" required
                            oninvalid="this.setCustomValidity('Harap isi bagian ini.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none"
                            placeholder="••••••••">
                    </div>

                    <button type="submit"
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 rounded-xl transition duration-200">
                        Perbarui Kata Sandi
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>