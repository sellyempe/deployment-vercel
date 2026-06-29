<x-admin-layout title="Edit Destinasi" active="destinations">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.destinations.dashboard') }}" class="hover:text-white transition">Destinasi</a>
        <span>/</span>
        <span class="text-gray-300">Edit: {{ Str::limit($destination->name, 40) }}</span>
    </nav>

    <form method="POST" action="{{ route('admin.destinations.update', $destination->id) }}"
        enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <div class="xl:col-span-2 space-y-5">
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-5">Informasi Destinasi
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Destinasi <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $destination->name) }}"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Lokasi <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="location" value="{{ old('location', $destination->location) }}"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            @error('location')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Kategori <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="category" value="{{ old('category', $destination->category) }}"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            @error('category')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Fakta Menarik <span
                                    class="text-pink-500">*</span></label>
                            <textarea name="interesting_fact" rows="3"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition resize-none"
                                required>{{ old('interesting_fact', $destination->interesting_fact) }}</textarea>
                            @error('interesting_fact')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi <span
                                    class="text-pink-500">*</span></label>
                            <textarea name="description" rows="6"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition resize-none"
                                required>{{ old('description', $destination->description) }}</textarea>
                            @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-5">

                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Galeri Destinasi</h3>

                    @if($destination->images->count() > 0)
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-3 mb-6">
                        @foreach($destination->images as $img)
                        <div class="relative aspect-square rounded-xl overflow-hidden bg-gray-800 group shadow-lg">
                            <img src="{{ format_image_url($img->path) }}" class="w-full h-full object-cover">
                            <div
                                class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition gap-2">
                                @if($img->path === $destination->image)
                                <span
                                    class="bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">SAMPUL</span>
                                @endif
                                <button type="button"
                                    onclick="if(confirm('Hapus foto ini dari galeri?')) { document.getElementById('delete-img-{{ $img->id }}').submit(); }"
                                    class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-lg transition shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div id="imagesDropArea"
                        class="border-2 border-dashed border-white/10 rounded-xl p-6 text-center cursor-pointer hover:border-pink-500/50 transition-colors bg-gray-800/30"
                        onclick="document.getElementById('imagesInput').click()">
                        <div id="imagesPreviewWrap" class="hidden grid grid-cols-3 md:grid-cols-4 gap-2 mb-3">
                        </div>
                        <div id="imagesPlaceholder">
                            <div
                                class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center mx-auto mb-3 text-pink-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-400 font-medium">Tambah Foto Baru</p>
                        </div>
                    </div>
                    <input type="file" id="imagesInput" name="images[]" accept="image/*" class="hidden" multiple
                        onchange="previewMultipleImages(this)">
                    @error('images')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
                    @error('images.*')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
                </div>

                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Publikasi</h3>
                    <div class="space-y-2">
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/5 transition">
                            <input type="radio" name="status" value="active"
                                {{ old('status', $destination->status) === 'active' ? 'checked' : '' }}
                                class="accent-emerald-500">
                            <div>
                                <p class="text-sm font-medium text-white">Aktif</p>
                                <p class="text-xs text-gray-500">Tampil di website</p>
                            </div>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-gray-500/50 has-[:checked]:bg-gray-500/5 transition">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status', $destination->status) === 'inactive' ? 'checked' : '' }}
                                class="accent-gray-500">
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
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.destinations.dashboard') }}"
                    class="block w-full text-center px-6 py-3 bg-gray-100 hover:bg-gray-255 text-gray-600 hover:text-gray-800 border border-gray-200/50 font-medium rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>

    @foreach($destination->images as $img)
    <form id="delete-img-{{ $img->id }}" action="{{ route('admin.images.destroy', $img->id) }}"
        method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>
    @endforeach

    <script>
    function previewImage(input) {
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById('imagePreview');
            if (el.tagName === 'IMG') {
                el.src = e.target.result;
            } else {
                el.outerHTML =
                    `<img id="imagePreview" src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
            }
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
    </script>

</x-admin-layout>