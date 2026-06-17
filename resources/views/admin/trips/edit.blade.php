<x-admin-layout title="Edit Trip" active="trips">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">Dashboard</a>
        <span>/</span>
        <span class="text-gray-300">Edit: {{ Str::limit($trip->title, 40) }}</span>
    </nav>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />


    <form method="POST" action="{{ route('admin.trips.update', $trip->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <div class="xl:col-span-2 space-y-5">

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-5">Informasi Trip</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Judul Trip <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $trip->title) }}"
                                class="w-full px-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                required>
                            @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Kota Keberangkatan <span
                                        class="text-pink-500">*</span></label>
                                <input type="text" name="departure_city"
                                    value="{{ old('departure_city', $trip->departure_city) }}"
                                    class="w-full px-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Destinasi <span
                                        class="text-pink-500">*</span></label>
                                <input type="text" name="destination"
                                    value="{{ old('destination', $trip->destination) }}"
                                    class="w-full px-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi <span
                                    class="text-pink-500">*</span></label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition resize-none"
                                required>{{ old('description', $trip->description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Overview <span
                                    class="text-pink-500">*</span></label>
                            <textarea name="overview" rows="4"
                                class="w-full px-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition resize-none"
                                required>{{ old('overview', $trip->overview) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Titik Kumpul</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Titik Kumpul</label>
                            <input type="text" name="meeting_point"
                                value="{{ old('meeting_point', $trip->meeting_point) }}"
                                class="w-full px-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Alamat Lengkap</label>
                            <input type="text" name="meeting_address"
                                value="{{ old('meeting_address', $trip->meeting_address) }}"
                                class="w-full px-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Pin Lokasi Peta <span
                                class="text-xs text-gray-500 font-normal">(Cari nama tempat atau geser pin
                                merah)</span></label>

                        <div class="flex gap-2 mb-3">
                            <input type="text" id="map-search-input"
                                placeholder="Ketik nama tempat/kota untuk mencari..."
                                class="flex-1 px-4 py-2.5 bg-[#1E5B86] border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                                autocomplete="off">
                            <button type="button" id="map-search-btn"
                                class="px-5 py-2.5 bg-[#1E5B86] hover:bg-[#1A4A6B] border border-white/10 text-white text-sm font-medium rounded-xl transition flex items-center gap-2 whitespace-nowrap">
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
                                <input type="text" id="latitude" name="latitude"
                                    value="{{ old('latitude', $trip->latitude) }}" readonly
                                    class="w-full px-3 py-2 bg-[#1E5B86] border border-white/10 rounded-lg text-white text-sm focus:outline-none cursor-not-allowed font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Longitude</label>
                                <input type="text" id="longitude" name="longitude"
                                    value="{{ old('longitude', $trip->longitude) }}" readonly
                                    class="w-full px-3 py-2 bg-[#1E5B86] border border-white/10 rounded-lg text-white text-sm focus:outline-none cursor-not-allowed font-mono">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-5">

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Galeri Trip</h3>
                    
                    @if($trip->images->count() > 0)
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-3 mb-6">
                        @foreach($trip->images as $img)
                        <div class="relative aspect-square rounded-xl overflow-hidden bg-gray-800 group shadow-lg">
                            <img src="{{ format_image_url($img->path) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition gap-2">
                                @if($img->path === $trip->image)
                                <span class="bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">SAMPUL</span>
                                @endif
                                <button type="button" 
                                    onclick="if(confirm('Hapus foto ini dari galeri?')) { document.getElementById('delete-img-{{ $img->id }}').submit(); }"
                                    class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-lg transition shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @foreach($trip->images as $img)
                    <form id="delete-img-{{ $img->id }}" action="{{ route('admin.images.destroy', $img->id) }}" method="POST" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                    @endforeach

                    <div id="imagesDropArea"
                        class="border-2 border-dashed border-white/10 rounded-xl p-6 text-center cursor-pointer hover:border-pink-500/50 transition-colors bg-gray-800/30"
                        onclick="document.getElementById('imagesInput').click()">
                        <div id="imagesPreviewWrap" class="hidden grid grid-cols-3 md:grid-cols-4 gap-2 mb-3">
                            <!-- Previews will be injected here -->
                        </div>
                        <div id="imagesPlaceholder">
                            <div class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center mx-auto mb-3 text-pink-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-400 font-medium">Tambah Foto Baru</p>
                            <p class="text-xs text-gray-600 mt-1">Bisa pilih banyak foto sekaligus</p>
                        </div>
                    </div>
                    <input type="file" id="imagesInput" name="images[]" accept="image/*" class="hidden" multiple
                        onchange="previewMultipleImages(this)">
                    @error('images')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
                    @error('images.*')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
                </div>

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Harga & Kapasitas</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Harga per Orang (Rp) <span
                                    class="text-pink-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                <input type="text" inputmode="numeric" name="price"
                                    value="{{ old('price', $trip->price) }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="w-full pl-10 pr-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Durasi (Hari) <span
                                    class="text-pink-500">*</span></label>
                            <input type="text" inputmode="numeric" name="duration_days"
                                value="{{ old('duration_days', $trip->duration_days) }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full px-4 py-3 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
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
                        @forelse($trip->tripDates as $tripDate)
                        <div class="flex items-center gap-2 date-item">
                            <input type="date" name="trip_dates[]" value="{{ $tripDate->date->format('Y-m-d') }}"
                                class="flex-1 px-4 py-2 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            <input type="text" inputmode="numeric" name="trip_kuotas[]" value="{{ $tripDate->kuota }}"
                                placeholder="Kuota" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-24 px-4 py-2 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            <button type="button" onclick="removeItem(this, '.date-item')"
                                class="p-2 text-gray-500 hover:text-red-400 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        @empty
                        <div class="flex items-center gap-2 date-item">
                            <input type="date" name="trip_dates[]"
                                class="flex-1 px-4 py-2 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            <input type="text" inputmode="numeric" name="trip_kuotas[]" placeholder="Kuota"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-24 px-4 py-2 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition"
                                required>
                            <button type="button" onclick="removeItem(this, '.date-item')"
                                class="p-2 text-gray-500 hover:text-red-400 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        @endforelse
                    </div>
                    @error('trip_dates')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
                </div>

                <div class="bg-[#16476A] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Publikasi</h3>
                    <div class="space-y-2">
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/5 transition">
                            <input type="radio" name="status" value="active"
                                {{ old('status', $trip->status) === 'active' ? 'checked' : '' }}
                                class="accent-emerald-500">
                            <div>
                                <p class="text-sm font-medium text-white">Aktif</p>
                                <p class="text-xs text-gray-500">Tampil di website</p>
                            </div>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-gray-500/50 has-[:checked]:bg-gray-500/5 transition">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status', $trip->status) === 'inactive' ? 'checked' : '' }}
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
                <a href="{{ route('admin.dashboard') }}"
                    class="block w-full text-center px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white font-medium rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>

    <script>
    function removeItem(el, selector) {
        const item = el.closest(selector);
        if (item) item.remove();
    }

    document.getElementById('addDateBtn').addEventListener('click', function() {
        const container = document.getElementById('trip-dates-container');
        container.insertAdjacentHTML('beforeend', `
            <div class="flex items-center gap-2 date-item mt-2">
                <input type="date" name="trip_dates[]" 
                       class="flex-1 px-4 py-2 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                <input type="text" inputmode="numeric" name="trip_kuotas[]" placeholder="Kuota" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       class="w-24 px-4 py-2 bg-[#1E5B86] border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                <button type="button" onclick="removeItem(this, '.date-item')" class="p-2 text-gray-500 hover:text-red-400 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        `);
    });

    function previewImage(input) {

        if (!input.files[0]) return;

        const reader = new FileReader();

        reader.onload = function(e) {

            const preview =
                document.getElementById('imagePreview');

            const emptyState =
                document.getElementById('emptyImageState');

            preview.src = e.target.result;

            preview.classList.remove('hidden');

            emptyState.classList.add('hidden');
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

        // Fix leaflet map rendering bug in hidden/flex layouts
        setTimeout(() => map.invalidateSize(), 500);
    });
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</x-admin-layout>