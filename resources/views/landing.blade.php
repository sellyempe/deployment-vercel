<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="scroll-behavior: smooth;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ get_setting('site_name', 'Pink Tour and Travel') }} - Jelajahi Destinasi Impian Anda</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    @keyframes heroZoom {
        from { transform: scale(1.08); }
        to { transform: scale(1); }
    }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-zoom { animation: heroZoom 8s ease-out forwards; }
    .hero-fade-1 { animation: fadeSlideUp 0.8s ease-out 0.2s both; }
    .hero-fade-2 { animation: fadeSlideUp 0.8s ease-out 0.4s both; }
    .hero-fade-3 { animation: fadeSlideUp 0.8s ease-out 0.6s both; }
    .hero-fade-4 { animation: fadeSlideUp 0.8s ease-out 0.8s both; }
    .hero-fade-5 { animation: fadeSlideUp 0.8s ease-out 1.0s both; }

    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .trip-card:hover,
    .dest-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.15);
    }

    .trip-card,
    .dest-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-icon:hover {
        animation: none;
        transform: scale(1.1);
    }
    </style>
</head>

<body class="font-poppins bg-white text-[#1e293b]">
    @if(session('success'))
    <div id="successPopup" class="fixed top-6 right-6 z-[9999] bg-white border border-pink-100 rounded-[28px] shadow-[0_12px_40px_rgba(2,6,23,0.10)] p-5 w-[360px] transition-all duration-300 hidden opacity-0 translate-y-[-10px]">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-pink-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-[#020617] font-bold text-xl">
                    {{ session('success_title', 'Pemberitahuan') }}
                </h3>
                <p class="text-gray-500 text-sm mt-1 leading-relaxed">
                    {{ session('success') }}
                </p>
            </div>
            <button onclick="closePopup()" class="text-gray-300 hover:text-pink-500 transition">
                ✕
            </button>
        </div>
    </div>
    @php
        session()->forget(['success', 'success_title', 'success_type']);
    @endphp
    @endif

    <script>
    function closePopup() {
        const popup = document.getElementById('successPopup');
        if (!popup) return;
        popup.style.opacity = '0';
        popup.style.transform = 'translateY(-10px)';
        setTimeout(() => { popup.remove(); }, 300);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const popup = document.getElementById('successPopup');
        if (popup) {
            const msgKey = 'msg_' + btoa('{{ session("success") }}').substring(0, 16);
            
            if (!sessionStorage.getItem(msgKey)) {
                popup.classList.remove('hidden');
                setTimeout(() => {
                    popup.style.opacity = '1';
                    popup.style.transform = 'translateY(0)';
                }, 100);
                
                sessionStorage.setItem(msgKey, 'shown');
                setTimeout(closePopup, 3500);
            } else {
                popup.remove();
            }
        }
    });

    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            const popup = document.getElementById('successPopup');
            if (popup) popup.remove();
        }
    });
    </script>
    
    <div>
        <x-navbar></x-navbar>

        <section id="beranda" class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img src="{{ asset('images/banda-neira.jpeg') }}" alt="Banda Neira"
                    class="w-full h-full object-cover scale-105 hero-zoom">

                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>
                <div class="absolute inset-0 bg-black/35"></div>
            </div>

            <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
                <div class="hero-fade-1 inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white text-sm font-medium mb-8">
                    Open Trip Banda Neira
                </div>

                <h1 class="hero-fade-2 text-5xl md:text-7xl font-bold text-white mb-6 leading-tight tracking-tight">
                    Temukan Surga Tersembunyi<br>
                    <span class="text-pink-400">
                        Di Banda Neira
                    </span>
                </h1>

                <p class="hero-fade-3 text-xl text-white/80 mb-10 leading-relaxed max-w-2xl mx-auto">
                    {{ get_setting('site_description', 'Nikmati pengalaman perjalanan yang nyaman dan berkesan bersama Pink Tour and Travel melalui paket open trip terpercaya dengan itinerary terencana dan pelayanan profesional.') }}
                </p>

                <div class="hero-fade-4 flex flex-col sm:flex-row gap-4 justify-center mb-16">
                    <a href="#trips"
                        class="group px-8 py-4 bg-pink-600 hover:bg-pink-500 text-white rounded-2xl font-semibold transition-all shadow-lg shadow-pink-600/30 hover:shadow-pink-500/40 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span>Pesan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="#destinasi"
                        class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white rounded-2xl font-semibold transition-all hover:-translate-y-0.5">
                        Jelajahi Destinasi
                    </a>
                </div>

                <div class="hero-fade-5 grid grid-cols-3 gap-4 max-w-lg mx-auto">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-4 py-3 text-center">
                        <p class="text-2xl font-bold text-white">{{ $totalTravelers }}</p>
                        <p class="text-xs text-white/60 mt-0.5">Traveler</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-4 py-3 text-center">
                        <p class="text-2xl font-bold text-white">{{ $totalDestinations }}</p>
                        <p class="text-xs text-white/60 mt-0.5">Destinasi</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-4 py-3 text-center">
                        <p class="text-2xl font-bold text-white">{{ $averageRating }}★</p>
                        <p class="text-xs text-white/60 mt-0.5">Rating</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative py-24 px-4 bg-white overflow-hidden">
            <div class="relative max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="reveal">
                        <h2 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight tracking-tight text-pink-600">
                            Jelajahi Banda Neira<br>
                            Bersama Kami
                        </h2>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                            Pink Tour and Travel menghadirkan layanan open trip terpercaya ke Banda Neira dengan
                            informasi perjalanan lengkap, itinerary terstruktur, serta pengalaman wisata yang nyaman
                            dan berkesan.
                        </p>
                        <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                            Perjalanan ini dirancang untuk memberikan pengalaman wisata yang aman, nyaman, dan
                            berkesan bagi setiap peserta.
                        </p>
                        <a href="#trips"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-[#132440] hover:bg-[#1B3354] text-white rounded-2xl font-semibold transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-[#132440]/20">
                            <span>Booking Sekarang</span>
                        </a>
                    </div>

                    <div class="reveal relative">
                        <div class="reveal relative">
                            <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border border-gray-200">
                                <img src="{{ asset('images/thehidden-paradise.jpeg') }}" alt="The Hidden Paradise"
                                    class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trips" class="py-24 px-4 bg-gray-50/50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#132440] mb-4 tracking-tight">Opsi Keberangkatan
                        <span class="text-pink-600">Banda Neira</span>
                    </h2>
                    <p class="text-lg text-gray-500">Pilih kota keberangkatan Anda untuk memulai perjalanan</p>
                </div>

                <div class="relative flex items-center gap-4">
                    <button onclick="previousTripSlide()"
                        class="flex-shrink-0 p-3 rounded-full bg-white border border-gray-200 shadow-lg text-gray-700 hover:bg-pink-600 hover:text-white hover:border-pink-600 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>

                    <div class="trips-carousel-container overflow-hidden flex-1">
                        <div class="trips-carousel-track flex transition-transform duration-500 ease-in-out"
                            id="tripsCarouselTrack">
                        </div>
                    </div>

                    <button onclick="nextTripSlide()"
                        class="flex-shrink-0 p-3 rounded-full bg-white border border-gray-200 shadow-lg text-gray-700 hover:bg-pink-600 hover:text-white hover:border-pink-600 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center justify-center gap-2 mt-8" id="tripCarouselDots">
                </div>
            </div>
        </section>

        <section id="destinasi" class="py-24 px-4 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#132440] mb-4 tracking-tight">Destinasi <span
                            class="text-pink-600">Banda Neira</span></h2>
                    <p class="text-lg text-gray-500">Jelajahi berbagai destinasi menarik selain Banda Neira</p>
                </div>

                <div class="relative flex items-center gap-4">
                    <button onclick="previousSlide()"
                        class="flex-shrink-0 p-3 rounded-full bg-white border border-gray-200 shadow-lg text-gray-700 hover:bg-pink-600 hover:text-white hover:border-pink-600 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>

                    <div class="carousel-container overflow-hidden flex-1">
                        <div class="carousel-track flex transition-transform duration-500 ease-in-out"
                            id="carouselTrack">
                        </div>
                    </div>

                    <button onclick="nextSlide()"
                        class="flex-shrink-0 p-3 rounded-full bg-white border border-gray-200 shadow-lg text-gray-700 hover:bg-pink-600 hover:text-white hover:border-pink-600 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center justify-center gap-2 mt-8" id="carouselDots">
                </div>
            </div>
        </section>

        <section class="relative py-24 bg-white overflow-hidden">
            <div class="max-w-5xl mx-auto px-4">
                <div class="relative rounded-[3rem] p-12 md:p-20 overflow-hidden shadow-xl shadow-pink-100/50" style="background-color: #FBDADC !important;">
                    
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-white/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-white/20 rounded-full blur-3xl"></div>

                    <div class="relative z-10 text-center">
                        <span class="text-6xl font-serif opacity-90 leading-none" style="color: #132440 !important;">
                            “
                        </span>

                        <h2 class="mt-6 text-3xl sm:text-4xl md:text-5xl font-bold leading-tight tracking-tight" style="color: #132440 !important;">
                            Jangan Mati Sebelum Ke<br>
                            <span class="inline-block mt-2">Banda Neira</span>
                        </h2>

                        <div class="flex items-center justify-center gap-4 mt-10">
                            <div class="w-12 h-[2px]" style="background-color: #132440 !important; opacity: 0.2;"></div>
                            <p class="text-lg font-medium italic" style="color: #132440 !important; opacity: 0.8;">
                                Sutan Sjahrir
                            </p>
                            <div class="w-12 h-[2px]" style="background-color: #132440 !important; opacity: 0.2;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-4 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#020617] mb-4 tracking-tight">
                        Mengapa Memilih
                        <span class="text-pink-600">Pink Tour and Travel?</span>
                    </h2>
                    <p class="text-lg text-gray-500">
                        Kami memberikan layanan terbaik untuk memastikan perjalanan Anda tak terlupakan
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 reveal">
                    <div class="text-center group">
                        <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 overflow-hidden group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                            <img src="{{ asset('images/pemandu-berpengalaman.png') }}" alt="Pemandu Berpengalaman" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-[#020617] mb-2">Pemandu Berpengalaman</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Pemandu wisata berpengalaman dan bersertifikat</p>
                    </div>

                    <div class="text-center group">
                        <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 overflow-hidden group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                            <img src="{{ asset('images/harga.png') }}" alt="Harga Terjangkau" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-[#020617] mb-2">Harga Terjangkau</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Paket wisata dengan harga terjangkau berkualitas</p>
                    </div>

                    <div class="text-center group">
                        <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 overflow-hidden group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                            <img src="{{ asset('images/jaminan-keamanan.png') }}" alt="Keamanan Terjamin" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-[#020617] mb-2">Keamanan Terjamin</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Asuransi perjalanan dan perlindungan lengkap</p>
                    </div>

                    <div class="text-center group">
                        <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 overflow-hidden group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                            <img src="{{ asset('images/terpercaya.png') }}" alt="Terpercaya oleh Wisatawan" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-[#020617] mb-2">Terpercaya oleh Wisatawan</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Rating tinggi dari ribuan pelanggan yang puas</p>
                    </div>

                    <div class="text-center group">
                        <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 overflow-hidden group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                            <img src="{{ asset('images/fleksibel.png') }}" alt="Jadwal Fleksibel" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-[#020617] mb-2">Jadwal Fleksibel</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Jadwal yang dapat disesuaikan dengan kebutuhan Anda</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-4 bg-gray-50/50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#020617] mb-4 tracking-tight">Apa Kata <span class="text-pink-600">Traveler?</span></h2>
                    <p class="text-lg text-gray-500">Dengarkan pengalaman mereka yang telah menjelajahi keindahan Indonesia bersama kami</p>
                </div>

                <div id="testimonials-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <p class="col-span-full text-center text-gray-500">Memuat testimoni...</p>
                </div>
            </div>
        </section>
    </div>

    <div id="kontak">
        <x-footer></x-footer>
    </div>

    <script>
    let currentSlide = 0;
    let currentTripSlide = 0;
    let destinationsData = [];
    let tripsData = [];

    async function loadTrips() {
        try {
            const response = await fetch('/api/trips');
            const data = await response.json();
            
            tripsData = Array.isArray(data) ? data : Object.values(data);

            if (tripsData.length === 0) {
                document.getElementById('tripsCarouselTrack').innerHTML = '<p class="col-span-full text-center text-gray-500 py-8">Belum ada paket trip tersedia</p>';
                return;
            }

            const slides = [];
            for (let i = 0; i < tripsData.length; i += 4) {
                slides.push(tripsData.slice(i, i + 4));
            }

            const track = document.getElementById('tripsCarouselTrack');
            track.innerHTML = slides.map((slide, slideIndex) => `
                        <div class="trips-carousel-slide min-w-full">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
                                ${slide.map(trip => {
                                    const departure = trip.departure_city ? trip.departure_city.split(' - ')[0] : 'Banda Neira';
                                    const price = trip.price ? Number(trip.price).toLocaleString('id-ID') : '0';
                                    const image = trip.image || 'https://images.unsplash.com/photo-1528127269915-426fcf759973?w=800';
                                    
                                    return `
                                    <a href="/trip/${trip.id}" class="bg-white border border-gray-100 rounded-[2rem] overflow-hidden hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100 transition-all duration-300 cursor-pointer group flex flex-col hover:-translate-y-1">
                                        <div class="aspect-[4/3] bg-gray-100 overflow-hidden relative">
                                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/50 to-transparent z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            <img src="${image}" alt="${departure}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            <div class="absolute top-4 right-4 z-20 px-3 py-1 bg-white/95 backdrop-blur-md rounded-full text-xs font-bold text-pink-600 shadow-sm border border-white/50">
                                                ${trip.duration_days || 0} Hari
                                            </div>
                                        </div>
                                        <div class="p-6 flex-1 flex flex-col">
                                            <p class="text-pink-500 text-xs font-bold tracking-wider uppercase mb-1">Berangkat dari</p>
                                            <h3 class="text-xl font-bold text-[#020617] mb-6 flex-1">${departure}</h3>
                                            <div class="flex items-center justify-between pt-4 border-t border-gray-50 mt-auto">
                                                <span class="text-gray-500 text-xs">Mulai dari</span>
                                                <span class="text-lg font-extrabold text-pink-600">Rp ${price}</span>
                                            </div>
                                        </div>
                                    </a>
                                `;}).join('')}
                            </div>
                        </div>
                    `).join('');

            const dotsContainer = document.getElementById('tripCarouselDots');
            dotsContainer.innerHTML = slides.map((_, index) => `
                        <button onclick="goToTripSlide(${index})" class="w-3 h-3 rounded-full trip-carousel-dot ${index === 0 ? 'bg-pink-600' : 'bg-gray-300'}" data-slide="${index}"></button>
                    `).join('');

        } catch (error) {
            console.error('Error loading trips:', error);
            document.getElementById('tripsCarouselTrack').innerHTML = '<p class="col-span-full text-center text-red-500 py-8">Gagal memuat paket trip</p>';
        }
    }

    function updateTripCarousel() {
        const track = document.getElementById('tripsCarouselTrack');
        if (!track) return;
        track.style.transform = `translateX(-${currentTripSlide * 100}%)`;

        document.querySelectorAll('.trip-carousel-dot').forEach((dot, index) => {
            if (index === currentTripSlide) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-pink-600');
            } else {
                dot.classList.remove('bg-pink-600');
                dot.classList.add('bg-gray-300');
            }
        });
    }

    function nextTripSlide() {
        const totalSlides = Math.ceil(tripsData.length / 4);
        if (totalSlides === 0) return;
        currentTripSlide = (currentTripSlide + 1) % totalSlides;
        updateTripCarousel();
    }

    function previousTripSlide() {
        const totalSlides = Math.ceil(tripsData.length / 4);
        if (totalSlides === 0) return;
        currentTripSlide = (currentTripSlide - 1 + totalSlides) % totalSlides;
        updateTripCarousel();
    }

    function goToTripSlide(slideNumber) {
        currentTripSlide = slideNumber;
        updateTripCarousel();
    }

    function updateCarousel() {
        const track = document.getElementById('carouselTrack');
        if (!track) return;
        track.style.transform = `translateX(-${currentSlide * 100}%)`;

        document.querySelectorAll('.carousel-dot').forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-pink-600');
            } else {
                dot.classList.remove('bg-pink-600');
                dot.classList.add('bg-gray-300');
            }
        });
    }

    function nextSlide() {
        const totalSlides = Math.ceil(destinationsData.length / 4);
        if (totalSlides === 0) return;
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    }

    function previousSlide() {
        const totalSlides = Math.ceil(destinationsData.length / 4);
        if (totalSlides === 0) return;
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }

    function goToSlide(slideNumber) {
        currentSlide = slideNumber;
        updateCarousel();
    }

    async function loadDestinations() {
        try {
            const response = await fetch('/api/destinations');
            const data = await response.json();
            
            destinationsData = Array.isArray(data) ? data : Object.values(data);

            if (destinationsData.length === 0) {
                document.getElementById('carouselTrack').innerHTML = '<p class="col-span-full text-center text-gray-500 py-8">Belum ada destinasi tersedia</p>';
                return;
            }

            const slides = [];
            for (let i = 0; i < destinationsData.length; i += 4) {
                slides.push(destinationsData.slice(i, i + 4));
            }

            const track = document.getElementById('carouselTrack');
            track.innerHTML = slides.map((slide, slideIndex) => `
                        <div class="carousel-slide min-w-full">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
                                ${slide.map(destination => {
                                    const image = destination.image || 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=400';
                                    const desc = destination.description || '';
                                    
                                    return `
                                    <a href="/destination/${destination.id}" class="bg-gray-50 border border-gray-100 rounded-[2rem] overflow-hidden hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100 transition-all duration-300 cursor-pointer group flex flex-col hover:-translate-y-1">
                                        <div class="aspect-[4/3] bg-gray-100 overflow-hidden relative">
                                            <img src="${image}" alt="${destination.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            <div class="absolute top-4 left-4 z-20 px-3 py-1 bg-gray-900/60 backdrop-blur-md rounded-full text-xs font-medium text-white border border-white/20 shadow-sm">
                                                ${destination.category || 'Destinasi'}
                                            </div>
                                        </div>
                                        <div class="p-6 flex-1 flex flex-col">
                                            <h3 class="text-xl font-bold text-[#020617] mb-2 group-hover:text-pink-600 transition-colors">${destination.name}</h3>
                                            <p class="text-gray-500 text-sm mb-6 flex-1 leading-relaxed">${desc.length > 80 ? desc.substring(0, 80) + '...' : desc}</p>
                                            <div class="flex items-center gap-2 pt-4 border-t border-gray-200/60 mt-auto text-sm text-gray-600 font-medium">
                                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                ${destination.location || 'Banda Neira'}
                                            </div>
                                        </div>
                                    </a>
                                `;}).join('')}
                            </div>
                        </div>
                    `).join('');

            const dotsContainer = document.getElementById('carouselDots');
            dotsContainer.innerHTML = slides.map((_, index) => `
                        <button onclick="goToSlide(${index})" class="w-3 h-3 rounded-full carousel-dot ${index === 0 ? 'bg-pink-600' : 'bg-gray-300'}" data-slide="${index}"></button>
                    `).join('');

        } catch (error) {
            console.error('Error loading destinations:', error);
            document.getElementById('carouselTrack').innerHTML = '<p class="col-span-full text-center text-red-500 py-8">Gagal memuat destinasi</p>';
        }
    }

    async function loadTestimonials() {
        try {
            const response = await fetch('/api/reviews');
            const reviews = await response.json();

            const container = document.getElementById('testimonials-container');

            if (reviews.length === 0) {
                container.innerHTML =
                    '<p class="col-span-full text-center text-gray-500 py-8">Belum ada testimoni</p>';
                return;
            }

            const displayReviews = reviews.slice(0, 6);
            container.innerHTML = displayReviews.map(review => {
                const userPhoto = review.user.photo ? `/storage/${review.user.photo}` : null;
                const userInitial = review.user.name.charAt(0).toUpperCase();

                return `
                        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 hover:border-pink-100 hover:shadow-xl hover:shadow-pink-50 transition-all duration-300 relative group">
                            <div class="absolute top-8 right-8 text-6xl text-gray-50 font-serif leading-none group-hover:text-pink-50 transition-colors duration-300">"</div>
                            <div class="flex items-center gap-4 mb-6 relative z-10">
                                <div class="w-14 h-14 bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl flex items-center justify-center text-xl font-bold text-pink-600 border border-white shadow-sm transform -rotate-3 overflow-hidden">
                                    ${userPhoto 
                                        ? `<img src="${userPhoto}" alt="${review.user.name}" class="w-full h-full object-cover">`
                                        : userInitial
                                    }
                                </div>
                                <div>
                                    <p class="font-bold text-[#020617]">${review.user.name}</p>
                                    <div class="text-yellow-400 text-sm flex gap-0.5 mt-1">${'★'.repeat(review.rating)}</div>
                                </div>
                            </div>
                            <p class="text-gray-600 leading-relaxed relative z-10">"${review.comment || 'Pengalaman wisata yang sangat berkesan dan terorganisir dengan sangat baik!'}"</p>
                        </div>
                    `;}).join('');
        } catch (error) {
            console.error('Error loading testimonials:', error);
            container.innerHTML =
                '<p class="col-span-full text-center text-red-500 py-8">Error memuat testimoni</p>';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadTrips();
        loadDestinations();
        loadTestimonials();

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.12
        });

        document.querySelectorAll(
            '.reveal, #trips h2, #destinasi h2, #destinasi p, section h2, section > div > div:first-child, .text-center.mb-16'
        ).forEach(el => {
            if (!el.classList.contains('reveal')) {
                el.classList.add('reveal');
            }
            revealObserver.observe(el);
        });

        const navbar = document.querySelector('x-navbar') || document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 80 && navbar) {
                navbar.classList.add('scrolled');
            } else if (navbar) {
                navbar.classList.remove('scrolled');
            }
        });
    });
    </script>
</body>

</html>',file_path: