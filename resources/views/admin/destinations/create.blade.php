<x-admin-layout title="Tambah Destinasi" active="destinations">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.destinations.dashboard') }}" class="hover:text-white transition">Destinasi</a>
        <span>/</span>
        <span class="text-gray-300">Tambah Baru</span>
    </nav>

    <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data"
        id="destinationForm">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <div class="xl:col-span-2 space-y-5">
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-5">Informasi Destinasi
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Destinasi <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="e.g. Kepulauan Banda Neira"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                required>
                            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Lokasi <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="location" value="{{ old('location') }}"
                                placeholder="e.g. Maluku Tengah, Maluku"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                required>
                            @error('location')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Kategori <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="category" value="{{ old('category') }}"
                                placeholder="e.g. Alam, Pantai, Sejarah"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                required>
                            @error('category')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Fakta Menarik <span
                                    class="text-pink-500">*</span></label>
                            <textarea name="interesting_fact" rows="3" placeholder="Fakta unik tentang destinasi ini..."
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition resize-none"
                                required>{{ old('interesting_fact') }}</textarea>
                            @error('interesting_fact')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi <span
                                    class="text-pink-500">*</span></label>
                            <textarea name="description" rows="5"
                                placeholder="Ceritakan tentang destinasi ini: keindahan alam, budaya, aktivitas yang bisa dilakukan..."
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition resize-none"
                                required>{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-5">

                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Galeri Destinasi <span
                            class="text-pink-500">*</span></h3>
                    <div id="imagesDropArea"
                        class="border-2 border-dashed border-white/10 rounded-xl p-8 text-center cursor-pointer hover:border-pink-500/50 transition-colors"
                        onclick="document.getElementById('imagesInput').click()">
                        <div id="imagesPreviewWrap" class="hidden grid grid-cols-3 md:grid-cols-4 gap-2 mb-4">
                        </div>
                        <div id="imagesPlaceholder">
                            <div
                                class="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl">
                                🖼</div>
                            <p class="text-white font-bold mb-1">Klik untuk upload foto</p>
                            <p class="text-gray-400 text-xs">Foto pertama akan otomatis menjadi sampul utama</p>
                        </div>
                    </div>
                    <input type="file" id="imagesInput" name="images[]" accept="image/*" class="hidden" multiple
                        onchange="previewMultipleImages(this)">
                    @error('images')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
                    @error('images.*')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Publikasi</h3>
                    <div class="space-y-2">
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/5 transition">
                            <input type="radio" name="status" value="active"
                                {{ old('status', 'active') === 'active' ? 'checked' : '' }} class="accent-emerald-500">
                            <div>
                                <p class="text-sm font-medium text-white">Aktif</p>
                                <p class="text-xs text-gray-500">Tampil di website</p>
                            </div>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-gray-500/50 has-[:checked]:bg-gray-500/5 transition">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status') === 'inactive' ? 'checked' : '' }} class="accent-gray-500">
                            <div>
                                <p class="text-sm font-medium text-white">Nonaktif</p>
                                <p class="text-xs text-gray-500">Disembunyikan</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-pink-600 hover:bg-pink-500 text-white font-semibold rounded-xl transition shadow-lg shadow-pink-600/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Destinasi
                </button>
                <a href="{{ route('admin.destinations.dashboard') }}"
                    class="block w-full text-center px-6 py-3 bg-gray-100 hover:bg-gray-255 text-gray-600 hover:text-gray-800 border border-gray-200/50 font-medium rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>

    <script>
    function previewImage(input) {
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreviewWrap').classList.remove('hidden');
            document.getElementById('imagePlaceholder').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }

    function previewMultipleImages(input) {
        const wrap = document.getElementById('imagesPreviewWrap');
        const placeholder = document.getElementById('imagesPlaceholder');
        wrap.innerHTML = '';

        if (input.files && input.files.length > 0) {
            wrap.classList.remove('hidden');
            placeholder.classList.add('hidden');

            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'aspect-square rounded-lg overflow-hidden bg-gray-800';
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    wrap.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            wrap.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const destForm = document.getElementById('destinationForm');
        if (destForm) {
            destForm.addEventListener('submit', function(e) {
                const imagesInput = document.getElementById('imagesInput');
                if (!imagesInput.files || imagesInput.files.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Foto Belum Diisi',
                        text: 'Harap isi foto destinasi terlebih dahulu sebelum disimpan.',
                        icon: 'warning',
                        confirmButtonColor: '#db2777', // pink-600
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'rounded-[1.5rem]'
                        }
                    });
                }
            });
        }
    });
    </script>

</x-admin-layout>