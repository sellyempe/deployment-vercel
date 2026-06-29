<x-admin-layout title="Tambah Trip Baru" active="trips">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">Dashboard</a>
        <span>/</span>
        <span class="text-gray-300">Tambah Trip</span>
    </nav>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />


    <form method="POST" action="{{ route('admin.trips.store') }}" enctype="multipart/form-data" id="tripForm">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <div class="xl:col-span-2 space-y-5">

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-5">Informasi Trip</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Judul Trip <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                placeholder="e.g. Open Trip Banda Neira dari Jakarta"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                required>
                            @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Kota Keberangkatan <span
                                        class="text-pink-500">*</span></label>
                                <input type="text" name="departure_city" value="{{ old('departure_city') }}"
                                    placeholder="e.g. Jakarta"
                                    class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                    required>
                                @error('departure_city')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Destinasi <span
                                        class="text-pink-500">*</span></label>
                                <input type="text" name="destination" value="{{ old('destination') }}"
                                    placeholder="e.g. Banda Neira"
                                    class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                    required>
                                @error('destination')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi Singkat <span
                                    class="text-pink-500">*</span></label>
                            <textarea name="description" rows="3"
                                placeholder="Deskripsi singkat yang menarik tentang trip ini..."
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition resize-none"
                                required>{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Overview Lengkap <span
                                    class="text-pink-500">*</span></label>
                            <textarea name="overview" rows="4"
                                placeholder="Penjelasan lengkap tentang perjalanan, highlight, dan pengalaman yang akan didapat..."
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition resize-none"
                                required>{{ old('overview') }}</textarea>
                            @error('overview')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-5">Titik Kumpul</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Titik Kumpul <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="meeting_point" value="{{ old('meeting_point') }}"
                                placeholder="e.g. Terminal 2 Bandara Soekarno-Hatta"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                required>
                            @error('meeting_point')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Alamat Lengkap <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="meeting_address" value="{{ old('meeting_address') }}"
                                placeholder="e.g. Jl. Raya Soetta, Tangerang"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                required>
                            @error('meeting_address')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Pin Lokasi Peta <span
                                class="text-xs text-gray-500 font-normal">(Cari nama tempat atau geser pin
                                merah)</span></label>

                        <div class="flex gap-2 mb-3">
                            <input type="text" id="map-search-input"
                                placeholder="Ketik nama tempat/kota untuk mencari..."
                                class="flex-1 px-4 py-2.5 bg-gray-800 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                autocomplete="off">
                            <button type="button" id="map-search-btn"
                                class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 border border-white/10 text-white text-sm font-medium rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Lokasi
                            </button>
                        </div>

                        <div id="map"
                            class="w-full h-72 rounded-xl border border-white/10 mb-3 relative z-0 shadow-inner"></div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Latitude</label>
                                <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly
                                    class="w-full px-3 py-2 bg-gray-800/50 border border-white/5 rounded-lg text-gray-400 text-sm focus:outline-none cursor-not-allowed font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Longitude</label>
                                <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}"
                                    readonly
                                    class="w-full px-3 py-2 bg-gray-800/50 border border-white/5 rounded-lg text-gray-400 text-sm focus:outline-none cursor-not-allowed font-mono">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Itinerary Perjalanan
                        </h3>
                        <button type="button" onclick="addItinerary()"
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-pink-600/20 hover:bg-pink-600/30 text-pink-400 text-xs font-semibold rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Hari
                        </button>
                    </div>
                    <div id="itineraries" class="space-y-3">
                        <div class="itinerary-item bg-gray-800 border border-white/5 rounded-xl p-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-pink-600/20 rounded-lg flex items-center justify-center">
                                    <span class="text-pink-400 font-bold text-sm day-label">1</span>
                                </div>
                                <div class="flex-1 grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Judul Hari</label>
                                        <input type="text" name="itineraries[0][title]"
                                            placeholder="e.g. Keberangkatan & Tiba"
                                            class="w-full px-3 py-2 bg-gray-700 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:border-pink-500 transition"
                                            required>
                                        <input type="hidden" name="itineraries[0][day_number]" value="1">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
                                        <textarea name="itineraries[0][description]" rows="2"
                                            placeholder="Aktivitas hari ini..."
                                            class="w-full px-3 py-2 bg-gray-700 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:border-pink-500 transition resize-y"
                                            required></textarea>
                                    </div>
                                </div>
                                <button type="button" onclick="removeItem(this, '.itinerary-item')"
                                    class="text-gray-600 hover:text-red-400 mt-2 transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-emerald-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Sudah Termasuk
                            </h3>
                            <button type="button" onclick="addInclude()"
                                class="text-emerald-400 hover:text-emerald-300 text-xs font-semibold transition">+
                                Tambah</button>
                        </div>
                        <div id="includes" class="space-y-2">
                            <div class="include-item flex items-center gap-2">
                                <input type="text" name="includes[0][item_name]" placeholder="e.g. Tiket Pesawat"
                                    class="flex-1 px-3 py-2 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:border-emerald-500 transition"
                                    required>
                                <input type="hidden" name="includes[0][category]" value="general">
                                <button type="button" onclick="removeItem(this, '.include-item')"
                                    class="text-gray-600 hover:text-red-400 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-red-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tidak Termasuk
                            </h3>
                            <button type="button" onclick="addExclude()"
                                class="text-red-400 hover:text-red-300 text-xs font-semibold transition">+
                                Tambah</button>
                        </div>
                        <div id="excludes" class="space-y-2">
                            <div class="exclude-item flex items-center gap-2">
                                <input type="text" name="excludes[0][item_name]" placeholder="e.g. Tips Guide"
                                    class="flex-1 px-3 py-2 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:border-red-500 transition"
                                    required>
                                <input type="hidden" name="excludes[0][category]" value="general">
                                <button type="button" onclick="removeItem(this, '.exclude-item')"
                                    class="text-gray-600 hover:text-red-400 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-5">

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Galeri Trip <span
                            class="text-pink-500">*</span></h3>
                    <div id="imagesDropArea"
                        class="border-2 border-dashed border-white/10 rounded-xl p-8 text-center cursor-pointer hover:border-pink-500/50 transition-colors"
                        onclick="document.getElementById('imagesInput').click()">

                        <div id="imagesPreviewWrap" class="hidden grid grid-cols-3 md:grid-cols-4 gap-2 mb-4">
                            <!-- Previews injected here -->
                        </div>

                        <div id="imagesPlaceholder">
                            <div
                                class="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-white font-bold mb-1">Klik atau seret banyak foto ke sini</p>
                            <p class="text-gray-400 text-xs">Foto pertama akan otomatis menjadi sampul utama</p>
                            <p class="text-gray-500 text-[10px] mt-2 uppercase tracking-widest">JPG, PNG, WebP · MAKS
                                5MB / FOTO</p>
                        </div>
                    </div>
                    <input type="file" id="imagesInput" name="images[]" accept="image/*" class="hidden" multiple
                        onchange="previewMultipleImages(this)">
                    @error('images')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
                    @error('images.*')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Harga & Kapasitas</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Harga per Orang (Rp) <span
                                    class="text-pink-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                                <input type="text" inputmode="numeric" name="price" value="{{ old('price') }}"
                                    placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="w-full pl-10 pr-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                    required>
                            </div>
                            @error('price')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Durasi (Hari) <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" inputmode="numeric" name="duration_days"
                                value="{{ old('duration_days') }}" placeholder="3"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                required>
                            @error('duration_days')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Jadwal Keberangkatan
                            <span class="text-pink-500">*</span>
                        </h3>
                        <button type="button" id="addDateBtn"
                            class="text-xs flex items-center gap-1 text-pink-500 hover:text-pink-400 font-medium transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Tanggal
                        </button>
                    </div>
                    <div id="trip-dates-container" class="space-y-2">
                        <div class="flex items-center gap-2 date-item">
                            <input type="date" name="trip_dates[]"
                                class="flex-1 px-4 py-2 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            <input type="text" inputmode="numeric" name="trip_kuotas[]" placeholder="Kuota"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-24 px-4 py-2 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            <button type="button" onclick="removeItem(this, '.date-item')"
                                class="p-2 text-gray-500 hover:text-red-400 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('trip_dates')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
                </div>

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
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
                                <p class="text-xs text-gray-500">Disembunyikan dari publik</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-pink-600 hover:bg-pink-500 text-white font-semibold rounded-xl transition shadow-lg shadow-pink-600/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Trip
                </button>
                <a href="{{ route('admin.dashboard') }}"
                    class="block w-full text-center px-6 py-3 bg-gray-100 hover:bg-gray-250 text-gray-600 hover:text-gray-800 border border-gray-200/50 font-medium rounded-xl transition">
                    Batal
                </a>

            </div>
        </div>
    </form>

    <script>
    let itineraryCount = 1,
        includeCount = 1,
        excludeCount = 1;

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

    function addItinerary() {
        const container = document.getElementById('itineraries');
        const idx = itineraryCount;
        container.insertAdjacentHTML('beforeend', `
            <div class="itinerary-item bg-gray-800 border border-white/5 rounded-xl p-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-pink-600/20 rounded-lg flex items-center justify-center">
                        <span class="text-pink-400 font-bold text-sm">${idx + 1}</span>
                    </div>
                    <div class="flex-1 grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Judul Hari</label>
                            <input type="text" name="itineraries[${idx}][title]" placeholder="e.g. Snorkeling & Pantai"
                                   class="w-full px-3 py-2 bg-gray-700 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:border-pink-500 transition" required>
                            <input type="hidden" name="itineraries[${idx}][day_number]" value="${idx + 1}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
                            <textarea name="itineraries[${idx}][description]" placeholder="Aktivitas hari ini..." rows="2"
                                      class="w-full px-3 py-2 bg-gray-750 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:border-pink-500 transition resize-y" required></textarea>
                        </div>
                    </div>
                    <button type="button" onclick="removeItem(this, '.itinerary-item')" class="text-gray-600 hover:text-red-400 mt-2 transition flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>`);
        itineraryCount++;
    }

    function addInclude() {
        const container = document.getElementById('includes');
        container.insertAdjacentHTML('beforeend', `
            <div class="include-item flex items-center gap-2">
                <input type="text" name="includes[${includeCount}][item_name]" placeholder="e.g. Akomodasi"
                       class="flex-1 px-3 py-2 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:border-emerald-500 transition" required>
                <input type="hidden" name="includes[${includeCount}][category]" value="general">
                <button type="button" onclick="removeItem(this, '.include-item')" class="text-gray-600 hover:text-red-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>`);
        includeCount++;
    }

    function addExclude() {
        const container = document.getElementById('excludes');
        container.insertAdjacentHTML('beforeend', `
            <div class="exclude-item flex items-center gap-2">
                <input type="text" name="excludes[${excludeCount}][item_name]" placeholder="e.g. Tips Guide"
                       class="flex-1 px-3 py-2 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:border-red-500 transition" required>
                <input type="hidden" name="excludes[${excludeCount}][category]" value="general">
                <button type="button" onclick="removeItem(this, '.exclude-item')" class="text-gray-600 hover:text-red-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>`);
        excludeCount++;
    }

    function removeItem(btn, selector) {
        const item = btn.closest(selector);
        if (item) item.remove();
    }

    // --- Trip Dates Dinamis ---
    document.getElementById('addDateBtn').addEventListener('click', function() {
        const container = document.getElementById('trip-dates-container');
        container.insertAdjacentHTML('beforeend', `
            <div class="flex items-center gap-2 date-item mt-2">
                <input type="date" name="trip_dates[]" 
                       class="flex-1 px-4 py-2 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                <input type="text" inputmode="numeric" name="trip_kuotas[]" placeholder="Kuota" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       class="w-24 px-4 py-2 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                <button type="button" onclick="removeItem(this, '.date-item')" class="p-2 text-gray-500 hover:text-red-400 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        `);
    });

    // --- Peta Interaktif Leaflet ---
    document.addEventListener('DOMContentLoaded', function() {
        // Default center point: Jakarta (Monas)
        const defaultLat = -6.1753924;
        const defaultLng = 106.8271528;

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        // Initialize map
        const map = L.map('map').setView([
            latInput.value ? latInput.value : defaultLat,
            lngInput.value ? lngInput.value : defaultLng
        ], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Create draggable marker
        const marker = L.marker([
            latInput.value ? latInput.value : defaultLat,
            lngInput.value ? lngInput.value : defaultLng
        ], {
            draggable: true
        }).addTo(map);

        // If inputs are empty initially, set them to default
        if (!latInput.value || !lngInput.value) {
            latInput.value = defaultLat;
            lngInput.value = defaultLng;
        }

        // Update inputs when marker is dragged
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            latInput.value = position.lat.toFixed(8);
            lngInput.value = position.lng.toFixed(8);
        });

        // Update marker when map is clicked
        map.on('click', function(event) {
            marker.setLatLng(event.latlng);
            latInput.value = event.latlng.lat.toFixed(8);
            lngInput.value = event.latlng.lng.toFixed(8);
        });

        // Search Location Logic
        const searchBtn = document.getElementById('map-search-btn');
        const searchInput = document.getElementById('map-search-input');

        async function searchLocation() {
            const query = searchInput.value.trim();
            if (!query) return;

            const btnOriginalHTML = searchBtn.innerHTML;
            searchBtn.innerHTML = '<span class="animate-pulse">Mencari...</span>';
            searchBtn.disabled = true;

            try {
                // Gunakan Nominatim API dari OpenStreetMap
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`
                );
                const data = await response.json();

                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);

                    // Fly to location with animation
                    map.flyTo([lat, lon], 16, {
                        duration: 1.5
                    });
                    marker.setLatLng([lat, lon]);

                    latInput.value = lat.toFixed(8);
                    lngInput.value = lon.toFixed(8);
                } else {
                    alert('Lokasi tidak ditemukan. Coba gunakan nama kota atau jalan yang lebih spesifik.');
                }
            } catch (error) {
                console.error('Error searching location:', error);
                alert('Terjadi kesalahan saat mencari lokasi.');
            } finally {
                searchBtn.innerHTML = btnOriginalHTML;
                searchBtn.disabled = false;
            }
        }

        searchBtn.addEventListener('click', searchLocation);

        // Prevent form submission when pressing enter on search input
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchLocation();
            }
        });

        // Form submission image validation
        const tripForm = document.getElementById('tripForm');
        if (tripForm) {
            tripForm.addEventListener('submit', function(e) {
                const imagesInput = document.getElementById('imagesInput');
                if (!imagesInput.files || imagesInput.files.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Foto Belum Diisi',
                        text: 'Harap isi foto trip terlebih dahulu sebelum disimpan.',
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

        // Fix leaflet map rendering bug in hidden/flex layouts
        setTimeout(() => map.invalidateSize(), 500);
    });
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</x-admin-layout>