<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $trip->title }} - PinkTravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if($trip->latitude && $trip->longitude)
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="">
    </script>
    @endif

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body class="font-poppins bg-white text-gray-900">
    <div>
        <x-navbar></x-navbar>

        <!-- Hero Section with Carousel -->
        <section class="relative h-[65vh] min-h-[550px] bg-gray-900 overflow-hidden">
            <div class="swiper heroSwiper w-full h-full">
                <div class="swiper-wrapper">
                    @forelse($trip->images as $img)
                    <div class="swiper-slide relative">
                        <img src="{{ format_image_url($img->path) }}" alt="{{ $trip->title }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/80"></div>
                    </div>
                    @empty
                    <div class="swiper-slide relative">
                        <img src="{{ format_image_url($trip->image) }}" alt="{{ $trip->title }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/80"></div>
                    </div>
                    @endforelse
                </div>

                <!-- Navigation Arrows (Tailwind Styled) -->
                <div
                    class="swiper-button-next !w-12 !h-12 !bg-black/20 !backdrop-blur-sm !rounded-full !after:text-lg !after:font-bold !text-white hover:!bg-pink-600/50 transition-colors">
                </div>
                <div
                    class="swiper-button-prev !w-12 !h-12 !bg-black/20 !backdrop-blur-sm !rounded-full !after:text-lg !after:font-bold !text-white hover:!bg-pink-600/50 transition-colors">
                </div>

                <!-- Pagination -->
                <div
                    class="swiper-pagination ![--swiper-pagination-color:#db2777] ![--swiper-pagination-bullet-inactive-color:#fff]">
                </div>
            </div>

            <div class="absolute bottom-16 left-0 right-0 z-20 pointer-events-none">
                <div class="max-w-7xl mx-auto px-4 w-full text-left">
                    <h1
                        class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 tracking-tight drop-shadow-2xl">
                        {{ $trip->title }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-4 pointer-events-auto">
                        <span
                            class="px-5 py-2.5 bg-pink-600 text-white rounded-full font-bold shadow-lg shadow-pink-600/30 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $trip->duration_days }} Hari
                        </span>
                        <span
                            class="px-5 py-2.5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-full font-bold flex items-center gap-2">
                            <span class="text-pink-400">Rp</span> {{ number_format($trip->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-4 bg-gray-50/50">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-[2rem] p-8 md:p-10 mb-8 border border-gray-100 shadow-sm">
                            <h2 class="text-3xl font-extrabold text-[#020617] mb-6 tracking-tight">Tentang <span
                                    class="text-pink-600">Paket Ini</span></h2>
                            <p class="text-gray-600 leading-relaxed mb-6 text-lg">{{ $trip->description }}</p>
                            <p class="text-gray-600 leading-relaxed text-lg">{{ $trip->overview }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-[2rem] p-8 md:p-10 mb-8 border border-pink-100 shadow-sm relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-pink-200/50 rounded-full blur-2xl pointer-events-none">
                            </div>
                            <h2
                                class="text-2xl font-extrabold text-pink-600 mb-6 relative z-10 flex items-center gap-3">
                                Titik Keberangkatan
                            </h2>
                            <div class="flex flex-col gap-6 relative z-10">
                                <div>
                                    <p class="text-xl font-bold text-pink-900 mb-2">{{ $trip->meeting_point }}</p>
                                    <p class="text-pink-700/80 leading-relaxed">{{ $trip->meeting_address }}</p>
                                </div>
                                <div
                                    class="w-full h-64 md:h-80 rounded-2xl overflow-hidden shadow-inner border border-pink-200/50 bg-white relative z-0">
                                    @if($trip->latitude && $trip->longitude)
                                    <div id="map" class="w-full h-full"></div>
                                    @else
                                    <iframe width="100%" height="100%" style="border:0;" loading="lazy" allowfullscreen
                                        referrerpolicy="no-referrer-when-downgrade"
                                        src="https://www.google.com/maps?q={{ urlencode($trip->meeting_address ?? $trip->meeting_point) }}&output=embed">
                                    </iframe>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] p-8 md:p-10 mb-8 border border-gray-100 shadow-sm">
                            <h2
                                class="text-3xl font-extrabold text-[#020617] mb-8 tracking-tight flex items-center gap-3">
                                Jadwal Perjalanan
                            </h2>
                            <div class="space-y-8">
                                @forelse($trip->itineraries as $itinerary)
                                <div class="border-l-4 border-pink-600 pl-6 pb-8">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span
                                            class="bg-pink-600 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold">{{ $itinerary->day_number }}</span>
                                        <h3 class="text-2xl font-bold text-[#020617]">{{ $itinerary->title }}</h3>
                                    </div>
                                    <p class="text-gray-600 mb-4 whitespace-pre-line">{{ $itinerary->description }}</p>

                                    @if($itinerary->activities && is_array($itinerary->activities))
                                    <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                        @foreach($itinerary->activities as $activity)
                                        <div class="flex gap-4">
                                            <span
                                                class="text-pink-600 font-bold whitespace-nowrap">{{ $activity['time'] ?? '' }}</span>
                                            <div>
                                                <p class="font-semibold text-[#020617]">
                                                    {{ $activity['activity'] ?? '' }}</p>
                                                <p class="text-gray-600 text-sm">{{ $activity['description'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @empty
                                <p class="text-gray-500">Belum ada jadwal perjalanan untuk paket ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div
                            class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl shadow-pink-50 sticky top-24">
                            <h3 class="text-2xl font-extrabold text-[#020617] mb-8 tracking-tight">Ringkasan Paket</h3>

                            <div class="mb-6 bg-gray-50 rounded-2xl p-4 flex items-center justify-between">
                                <p class="text-gray-500 font-medium">Durasi</p>
                                <p class="text-xl font-bold text-[#020617]">{{ $trip->duration_days }} Hari</p>
                            </div>

                            <div class="mb-8 p-4">
                                <p class="text-gray-500 font-medium mb-1">Mulai dari</p>
                                <p class="text-4xl font-extrabold text-pink-600">Rp
                                    {{ number_format($trip->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex flex-col gap-3 mb-8">
                                @auth
                                @if(auth()->user()->role === 'admin')
                                <button disabled
                                    class="w-full bg-gray-200 text-gray-500 font-bold py-4 rounded-2xl cursor-not-allowed text-center flex items-center justify-center">
                                    Admin Tidak Bisa Memesan
                                </button>
                                @else
                                <a href="{{ route('booking.create', $trip->id) }}"
                                    class="w-full bg-[#020617] text-white font-bold py-4 rounded-2xl hover:bg-slate-900 transition-all hover:-translate-y-1 shadow-lg shadow-slate-900/20 text-center flex items-center justify-center">
                                    Pesan Sekarang
                                </a>
                                @endif
                                @else
                                <a href="{{ route('login') }}"
                                    class="w-full bg-pink-600 text-white font-bold py-4 rounded-2xl hover:bg-pink-700 transition-all hover:-translate-y-1 shadow-lg shadow-pink-600/30 text-center flex items-center justify-center">
                                    Login untuk Pesan
                                </a>
                                @endauth
                            </div>

                            <div class="mb-6 border-t border-gray-100 pt-6">
                                <h4 class="font-bold text-[#020617] mb-4">Termasuk</h4>
                                <ul class="space-y-3">
                                    @forelse($trip->includes as $include)
                                    <li class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-600 font-medium">{{ $include->item_name }}</span>
                                    </li>
                                    @empty
                                    <li class="text-gray-400 text-sm">Tidak ada informasi.</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="border-t border-gray-100 pt-6">
                                <h4 class="font-bold text-[#020617] mb-4">Tidak Termasuk</h4>
                                <ul class="space-y-3">
                                    @forelse($trip->excludes as $exclude)
                                    <li class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-gray-500">{{ $exclude->item_name }}</span>
                                    </li>
                                    @empty
                                    <li class="text-gray-400 text-sm">Tidak ada informasi.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-4 bg-white border-t border-gray-100">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-12 tracking-tight text-center">Apa Kata
                    <span class="text-pink-600">Traveler?</span>
                </h2>

                <div class="grid grid-cols-1 gap-12">
                    <div id="reviews-section">
                        <div id="reviews-list" class="space-y-6">
                            <p class="text-gray-500 text-center py-8">Memuat ulasan...</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-footer></x-footer>
    </div>

    <script>
    const tripId = Number("{{ $trip->id }}");

    document.addEventListener('DOMContentLoaded', function() {
        loadReviews();

        // Initialize Hero Swiper
        new Swiper('.heroSwiper', {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Navbar scroll logic
        const navbar = document.querySelector('nav');
        if (navbar) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 80) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }

        // ===== MAP =====
        const hasMap = "{{ $trip->latitude && $trip->longitude ? 'true' : 'false' }}" === "true";
        if (hasMap) {
            const lat = Number("{{ $trip->latitude ?? 0 }}");
            const lng = Number("{{ $trip->longitude ?? 0 }}");
            const map = L.map('map').setView([lat, lng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const marker = L.marker([lat, lng])
                .addTo(map)
                .bindPopup(`<b>{{ $trip->meeting_point }}</b><br>{{ $trip->meeting_address }}`);

            marker.on('click', () => window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank'));
            setTimeout(() => map.invalidateSize(), 500);
        }
    });

    // ===== LOAD REVIEWS =====
    async function loadReviews() {
        try {
            const response = await fetch(`/api/reviews/trip/${tripId}`);
            if (!response.ok) throw new Error('Network response was not ok');

            const reviews = await response.json();
            const reviewsList = document.getElementById('reviews-list');
            if (!reviewsList) return;

            if (reviews.length === 0) {
                reviewsList.innerHTML =
                    `<p class="text-gray-500 text-center py-8">Belum ada ulasan untuk trip ini</p>`;
                return;
            }

            reviewsList.innerHTML = reviews.map(review => {
                const userPhoto = review.user.photo ? `/storage/${review.user.photo}` : null;
                const userInitial = review.user.name.charAt(0).toUpperCase();

                return `
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-6 border-b border-gray-50 pb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-pink-50 text-pink-600 font-bold text-lg rounded-2xl flex items-center justify-center overflow-hidden">
                                ${userPhoto 
                                    ? `<img src="${userPhoto}" alt="${review.user.name}" class="w-full h-full object-cover">`
                                    : userInitial
                                }
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">${review.user.name}</p>
                                <p class="text-xs text-gray-400 font-medium">
                                    ${new Date(review.created_at).toLocaleDateString('id-ID', {
                                        year: 'numeric', month: 'long', day: 'numeric'
                                    })}
                                </p>
                            </div>
                        </div>
                        <div class="text-yellow-400 text-sm flex gap-0.5">
                            ${'⭐'.repeat(review.rating)}
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        ${review.comment || 'Tidak ada komentar'}
                    </p>
                </div>`;
            }).join('');
        } catch (error) {
            console.error('Error loading reviews:', error);
        }
    }
    </script>
</body>

</html>