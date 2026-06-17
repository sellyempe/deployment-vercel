<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    @include('components.navbar', ['alwaysScrolled' => true])

    <div class="h-screen pt-20 px-4 overflow-hidden">
        <div class="max-w-4xl mx-auto">

            @if(session('success'))
            <div class="mb-6 flex items-center gap-3 px-5 py-4 bg-emerald-50 border border-emerald-100 rounded-[20px] text-emerald-600 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Berhasil!</p>
                    <p class="text-xs opacity-90">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif

            <div class="flex items-center gap-4 mb-5">
                <a href="/" class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center text-gray-600 hover:text-pink-500 shadow-sm transition-all hover:-translate-x-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-[#132440]">
                        Profile Saya
                    </h1>
                </div>
            </div>

            <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-6">
                <div class="grid lg:grid-cols-[280px_1fr] gap-6 items-stretch">
                    <div>
                        @if(!empty($user->photo))
                        <div class="rounded-[20px] overflow-hidden h-[420px] bg-gray-100">
                            <img src="{{ asset('storage/' . $user->photo) }}?t={{ time() }}" alt="Profile"
                                class="w-full h-full object-cover object-center">
                        </div>
                        @else
                        <div class="h-[420px] rounded-[20px] bg-[#FFF7FB] flex flex-col items-center justify-center text-center px-8">
                            <div class="w-28 h-28 rounded-full bg-pink-500 text-white flex items-center justify-center text-5xl font-bold shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h3 class="mt-6 text-2xl font-bold text-[#132440]">
                                {{ $user->name }}
                            </h3>
                            <p class="text-gray-400 text-sm mt-2">
                                Tambahkan foto melalui halaman edit profil
                            </p>
                        </div>
                        @endif
                    </div>

                    <div>
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-bold text-[#132440]">
                                    Informasi Akun
                                </h2>
                                <p class="text-gray-500 mt-1 text-xs">
                                    Kelola informasi akun Anda
                                </p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="border border-pink-500 text-pink-500 hover:bg-pink-500 hover:text-white transition-all duration-200 px-5 py-2 rounded-full font-medium text-sm">
                                Edit Profile
                            </a>
                        </div>

                        <div class="space-y-3">
                            <div class="border-b border-gray-200 pb-3">
                                <p class="text-sm text-gray-400 mb-2">Nama Lengkap</p>
                                <h3 class="text-sm text-[#132440]">{{ $user->name }}</h3>
                            </div>

                            <div class="border-b border-gray-200 pb-3">
                                <p class="text-sm text-gray-400 mb-2">Email</p>
                                <h3 class="text-sm text-[#132440]">{{ $user->email }}</h3>
                            </div>

                            <div class="border-b border-gray-200 pb-3">
                                <p class="text-sm text-gray-400 mb-2">Nomor Telepon</p>
                                <h3 class="text-sm text-[#132440]">{{ $user->phone ?? '-' }}</h3>
                            </div>

                            <div class="border-b border-gray-200 pb-3">
                                <p class="text-sm text-gray-400 mb-2">Jenis Kelamin</p>
                                <h3 class="text-sm text-[#132440]">
                                    @switch($user->gender)
                                    @case('male')
                                    Laki-laki
                                    @break
                                    @case('female')
                                    Perempuan
                                    @break
                                    @default
                                    -
                                    @endswitch
                                </h3>
                            </div>

                            <div>
                                <p class="text-sm text-gray-400 mb-2">Tanggal Lahir</p>
                                <h3 class="text-sm text-[#132440]">
                                    {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d F Y') : '-' }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm mt-3 p-4 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#132440]">Ubah Password</h3>
                    <p class="text-gray-500 text-sm mt-1">Perbarui password akun</p>
                </div>
                <button onclick="togglePasswordModal()" class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">
                    Ubah
                </button>
            </div>
        </div>
    </div>

    <div id="passwordModal" class="hidden fixed inset-0 flex items-center justify-center p-4 z-50 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-[24px] w-full max-w-sm shadow-xl border border-gray-100">
            <h1 class="text-xl font-bold text-[#132440] mb-5">Ubah Password</h1>
            <form action="{{ route('profile.update-password') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-[#132440] mb-1">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full h-[45px] border border-gray-200 rounded-xl px-4 outline-none focus:border-pink-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#132440] mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full h-[45px] border border-gray-200 rounded-xl px-4 outline-none focus:border-pink-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#132440] mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full h-[45px] border border-gray-200 rounded-xl px-4 outline-none focus:border-pink-500 text-sm">
                    </div>
                    <div class="pt-2 flex gap-3">
                        <button type="button" onclick="togglePasswordModal()" class="flex-1 py-2.5 border border-pink-500 text-pink-500 rounded-xl font-semibold text-sm">Batal</button>
                        <button type="submit" class="flex-1 py-2.5 bg-pink-500 text-white rounded-xl font-semibold text-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    function togglePasswordModal() {
        const modal = document.getElementById('passwordModal');
        modal.classList.toggle('hidden');
    }
    </script>
</body>

</html>