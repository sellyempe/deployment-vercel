<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F7F8FC] min-h-screen">

    @include('components.navbar', ['alwaysScrolled' => true])

    <div class="h-screen pt-20 px-4 overflow-hidden">
        <div class="max-w-4xl mx-auto">

            <div class="flex items-center gap-4 mb-5">
                <a href="{{ route('profile') }}" class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center text-gray-600 hover:text-pink-500 shadow-sm transition-all hover:-translate-x-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-[#132440]">
                        Edit Profil
                    </h1>
                </div>
            </div>

            <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-6">
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

                <div class="grid lg:grid-cols-[280px_1fr] gap-6">
                    <div>
                        <div class="relative overflow-hidden rounded-[20px] h-[420px]">
                            @if($user->photo)
                            <img id="previewImage" src="{{ asset('storage/' . $user->photo) }}?t={{ time() }}" alt="Profile"
                                class="w-full h-full object-cover">
                            @else
                            <img id="previewImage" src="{{ asset('images/default-profile.png') }}" alt="Profile"
                                class="w-full h-full object-cover hidden">
                            <div id="emptyProfile" class="w-full h-full bg-gradient-to-b from-pink-50 to-pink-100 flex flex-col items-center justify-center text-center px-6">
                                <div class="w-28 h-28 rounded-full bg-pink-500 text-white flex items-center justify-center text-5xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <h3 class="mt-5 text-xl font-bold text-[#132440]">
                                    Belum ada foto profil
                                </h3>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="min-w-0">
                        @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                            <ul class="list-disc list-inside text-[11px] text-red-600">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-3">
                                <div class="grid md:grid-cols-[150px_1fr] items-center gap-3 border-b border-gray-100 pb-2">
                                    <label class="font-semibold text-[#132440] text-xs">Nama Lengkap</label>
                                    <input name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full h-[38px] rounded-lg border border-gray-200 px-3 outline-none focus:border-pink-500 text-sm">
                                </div>

                                <div class="grid md:grid-cols-[150px_1fr] items-center gap-3 border-b border-gray-100 pb-2">
                                    <label class="font-semibold text-[#132440] text-xs">Email</label>
                                    <input name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full h-[38px] rounded-lg border border-gray-200 px-3 outline-none focus:border-pink-500 text-sm">
                                </div>

                                <div class="grid md:grid-cols-[150px_1fr] items-center gap-3 border-b border-gray-100 pb-2">
                                    <label class="font-semibold text-[#132440] text-xs">Nomor Telepon</label>
                                    <input name="phone" type="text" value="{{ old('phone', $user->phone ?? '') }}" class="w-full h-[38px] rounded-lg border border-gray-200 px-3 outline-none focus:border-pink-500 text-sm">
                                </div>

                                <div class="grid md:grid-cols-[150px_1fr] items-center gap-3 border-b border-gray-100 pb-2">
                                    <label class="font-semibold text-[#132440] text-xs">Jenis Kelamin</label>
                                    <select name="gender" class="w-full h-[38px] rounded-lg border border-gray-200 px-3 outline-none focus:border-pink-500 text-sm">
                                        <option value="">Pilih Gender</option>
                                        <option value="female" {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                        <option value="male" {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    </select>
                                </div>

                                <div class="grid md:grid-cols-[150px_1fr] items-center gap-3 border-b border-gray-100 pb-2">
                                    <label class="font-semibold text-[#132440] text-xs">Tanggal Lahir</label>
                                    <input name="birth_date" type="date" max="{{ date('Y-m-d') }}" value="{{ old('birth_date', $user->birth_date ?? '') }}" class="w-full h-[38px] rounded-lg border border-gray-200 px-3 outline-none focus:border-pink-500 text-sm">
                                </div>

                                <div class="grid md:grid-cols-[150px_1fr] items-center gap-3">
                                    <label class="font-semibold text-[#132440] text-xs">Foto Profil</label>
                                    <div class="flex items-center gap-3">
                                        <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden">
                                        <label for="photoInput" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-1.5 rounded-lg font-semibold text-xs cursor-pointer transition">Pilih Foto</label>
                                        <span class="text-gray-400 text-[10px]">JPG/PNG/WEBP | Max 2MB</span>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-3 pt-3 mt-2">
                                    <a href="{{ route('profile') }}" class="px-7 py-3 rounded-xl border border-pink-400 text-pink-500 font-semibold hover:bg-pink-50 transition text-sm">Batal</a>
                                    <button type="submit" class="px-7 py-3 rounded-xl bg-pink-500 hover:bg-pink-600 text-white font-semibold shadow-md transition text-sm">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2MB');
            this.value = '';
            return;
        }

        const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Format foto harus JPG, PNG, atau WEBP');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.getElementById('previewImage');
            const emptyProfile = document.getElementById('emptyProfile');
            preview.src = event.target.result;
            preview.classList.remove('hidden');
            if (emptyProfile) {
                emptyProfile.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    });
    </script>
</body>

</html>