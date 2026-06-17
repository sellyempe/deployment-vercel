<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $destination->name }} - PinkTravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body class="font-poppins bg-white text-gray-900">
    <div>
        <x-navbar></x-navbar>

        <section class="relative h-[65vh] min-h-[550px] bg-gray-900 overflow-hidden">
            <!-- Swiper Hero -->
            <div class="swiper heroSwiper h-full w-full">
                <div class="swiper-wrapper">
                    @forelse($destination->images as $img)
                    <div class="swiper-slide relative">
                        <img src="{{ format_image_url($img->path) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/80"></div>
                    </div>
                    @empty
                    <div class="swiper-slide relative">
                        <img src="{{ format_image_url($destination->image) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/80"></div>
                    </div>
                    @endforelse
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>

            <div class="absolute bottom-16 left-0 right-0 z-20 pointer-events-none">
                <div class="max-w-7xl mx-auto px-4 w-full">
                    <a href="/"
                        class="text-white/80 mb-6 inline-flex items-center hover:text-white transition group bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 text-sm font-medium w-fit pointer-events-auto">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                    <div class="flex flex-wrap gap-3 mb-4 pointer-events-auto">
                        <span
                            class="px-4 py-1.5 bg-pink-600/90 backdrop-blur-md text-white rounded-full text-sm font-bold shadow-lg shadow-pink-600/30 uppercase tracking-wide">
                            {{ $destination->category }}
                        </span>
                        <span
                            class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full text-sm font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $destination->location }}
                        </span>
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight drop-shadow-2xl">
                        {{ $destination->name }}
                    </h1>
                </div>
            </div>
        </section>

        <section class="py-24 px-4 bg-gray-50/50">
            <div class="max-w-4xl mx-auto">

                <div class="bg-white rounded-[2rem] p-8 md:p-10 mb-8 border border-gray-100 shadow-sm">
                    <h2 class="text-3xl font-extrabold text-[#020617] mb-6 tracking-tight">Tentang <span
                            class="text-pink-600">Destinasi Ini</span></h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        {{ $destination->description }}
                    </p>
                </div>

                <div
                    class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-[2rem] p-8 md:p-10 mb-8 border border-pink-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-pink-200/50 rounded-full blur-2xl">
                    </div>
                    <h2 class="text-2xl font-extrabold text-[#020617] mb-6 relative z-10 flex items-center gap-3">
                        <span
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-pink-500">✨</span>
                        Fakta Menarik
                    </h2>
                    <p class="text-lg text-pink-900/80 font-medium leading-relaxed relative z-10">
                        "{{ $destination->interesting_fact }}"
                    </p>
                </div>

                <div
                    class="bg-[#020617] rounded-[2rem] p-10 mb-16 shadow-xl shadow-slate-950/20 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-900/20 to-transparent"></div>
                    <h2 class="text-3xl font-extrabold text-white mb-4 relative z-10 tracking-tight">Ingin Mengunjungi
                        Destinasi Ini?</h2>
                    <p class="text-gray-300 mb-8 text-lg relative z-10">Pesan paket wisata Anda sekarang dan dapatkan
                        pengalaman tak terlupakan</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-pink-600 hover:bg-pink-500 text-white rounded-2xl font-bold transition-all hover:-translate-y-1 shadow-lg shadow-pink-600/30 gap-2">
                            Booking Sekarang
                        </a>
                    </div>
                </div>

                <div id="reviews-section" class="mt-12">
                    @auth
                    @include('components.review-form', ['reviewableType' => 'App\\Models\\Destination', 'reviewableId' => $destination->id])
                    @endauth

                    <div id="reviews-list" class="space-y-6 mt-12">
                        <h2 class="text-2xl font-extrabold text-[#020617] mb-8">Apa Kata Traveler?</h2>
                        <p class="text-gray-500 text-center py-8">Memuat ulasan...</p>
                    </div>
                </div>
            </div>
        </section>

        <x-footer></x-footer>
    </div>

    <script>
    const destinationId = Number("{{ $destination->id }}");

    document.addEventListener('DOMContentLoaded', function() {
        loadReviews();

        // Initialize Hero Swiper
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });
    });

    // ===== Load Reviews =====
    async function loadReviews() {
        try {
            const response = await fetch(`/api/reviews/destination/${destinationId}`);
            if (!response.ok) throw new Error('Network response was not ok');

            const reviews = await response.json();
            const reviewsList = document.getElementById('reviews-list');
            if (!reviewsList) return;

            if (reviews.length === 0) {
                reviewsList.innerHTML = `<p class="text-gray-500 text-center py-8">Belum ada ulasan untuk destinasi ini</p>`;
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

    // ===== GALLERY MODAL =====
    function openGallery(imgSrc) {
        const modal = document.getElementById('gallery-modal');
        const modalImg = document.getElementById('modal-img');
        if (modal && modalImg) {
            modalImg.src = imgSrc;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeGallery() {
        const modal = document.getElementById('gallery-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeGallery();
    });
    </script>
</body>

</html>                           ${'⭐'.repeat(review.rating)}
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

    // ===== GALLERY MODAL =====
    function openGallery(imgSrc) {
        const modal = document.getElementById('gallery-modal');
        const modalImg = document.getElementById('modal-img');
        if (modal && modalImg) {
            modalImg.src = imgSrc;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeGallery() {
        const modal = document.getElementById('gallery-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeGallery();
    });
    </script>
</body>

</html>