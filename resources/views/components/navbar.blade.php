@props(['alwaysScrolled' => false])
<nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 {{ $alwaysScrolled ? 'scrolled' : '' }}"
    style="background: transparent;">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <a href="/" class="flex items-center gap-3 group flex-shrink-0">

                <img src="{{ asset(get_setting('site_logo', 'images/logo-pinktravel.png')) }}"
                    alt="{{ get_setting('site_name', 'Pink Tour and Travel') }}" class="w-12 h-12 object-cover rounded-xl bg-white p-1 shadow-md
                group-hover:scale-105 transition-transform duration-200">

                <div class="flex flex-col leading-tight">
                    <span id="logoText" class="text-2xl font-bold text-pink-600">
                        {{ get_setting('site_name', 'Pink Tour and Travel') }}
                    </span>
                </div>

            </a>

            <div class="hidden md:flex items-center gap-1">
                <a href="/" onclick="handleNavClick(event,'beranda')"
                    class="nav-link relative px-4 py-2 font-medium text-sm cursor-pointer">
                    Beranda<span class="nav-link-underline"></span>
                </a>
                <a href="/" onclick="handleNavClick(event,'trips')"
                    class="nav-link relative px-4 py-2 font-medium text-sm cursor-pointer">
                    Trip<span class="nav-link-underline"></span>
                </a>
                <a href="/" onclick="handleNavClick(event,'destinasi')"
                    class="nav-link relative px-4 py-2 font-medium text-sm cursor-pointer">
                    Destinasi<span class="nav-link-underline"></span>
                </a>
                <a href="https://wa.me/{{ get_setting('contact_whatsapp', '6282115249423') }}?text=Halo%20{{ urlencode(get_setting('site_name', 'Pink Tour and Travel')) }},%20saya%20ingin%20bertanya"
                    onclick="contactWhatsApp(event, this.href)"
                    class="nav-link relative px-4 py-2 font-medium text-sm cursor-pointer">
                    Kontak<span class="nav-link-underline"></span>
                </a>

                <div class="nav-divider w-px h-5 mx-2"></div>

                @auth
                <div class="relative">
                    <button onclick="toggleProfileDropdown()"
                        class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-white/10 transition">

                        @if(auth()->user()->photo)
                        <img src="{{ format_image_url(auth()->user()->photo) }}" alt="Profile"
                            class="w-9 h-9 rounded-full object-cover">
                        @else
                        <div
                            class="w-9 h-9 rounded-full bg-pink-500 flex items-center justify-center text-sm font-bold text-white flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        @endif

                        <span id="userName" class="text-white font-medium text-sm transition duration-300">
                            {{ Str::limit(auth()->user()->name, 12) }}
                        </span>
                    </button>

                    <div id="profileDropdown"
                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-2">

                        <a href="{{ route('profile') }}"
                            class="block px-4 py-3 text-gray-700 hover:bg-pink-50 transition font-medium whitespace-nowrap">
                            Profil
                        </a>

                        <a href="{{ route('booking.index') }}"
                            class="block px-4 py-3 text-gray-700 hover:bg-pink-50 transition font-medium whitespace-nowrap">
                            Riwayat Pesanan
                        </a>

                        <div class="border-t border-gray-100 my-2"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-3 text-red-600 hover:bg-red-50 transition font-medium text-left">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                @else
                <a href="{{ route('login') }}" class="nav-auth-link px-4 py-2 font-medium text-sm">
                    Masuk
                </a>

                <a href="{{ route('register') }}" class="px-5 py-2 bg-pink-600 hover:bg-pink-500 text-white rounded-xl font-semibold text-sm
    transition-all shadow-lg shadow-pink-600/25 hover:-translate-y-0.5">
                    Daftar
                </a>
                @endauth
            </div>

            <button id="mobileMenuBtn" onclick="toggleMobileMenu()"
                class="md:hidden p-2 rounded-xl hover:bg-white/10 transition">
                <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div id="mobileMenu"
        class="hidden md:hidden bg-slate-950/95 backdrop-blur-xl border-t border-white/10 px-4 py-4 space-y-1">
        <a href="/" onclick="handleNavClick(event,'beranda')"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">🏠
            Beranda</a>
        <a href="/" onclick="handleNavClick(event,'trips')"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">✈️
            Trip</a>
        <a href="/" onclick="handleNavClick(event,'destinasi')"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">📍
            Destinasi</a>
        <a href="https://wa.me/{{ get_setting('contact_whatsapp', '6282115249423') }}?text=Halo%20{{ urlencode(get_setting('site_name', 'Pink Tour and Travel')) }},%20saya%20ingin%20bertanya"
            onclick="contactWhatsApp(event, this.href)"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">📞
            Kontak</a>
        <div class="pt-2 border-t border-white/10 space-y-2">
            @auth
            <a href="{{ route('profile') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">👤
                Profil</a>
            <a href="{{ route('booking.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">📋
                Riwayat Pesanan</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 font-medium transition">🚪
                    Keluar</button>
            </form>
            @else
            <a href="{{ route('login') }}"
                class="block px-4 py-3 rounded-xl text-center text-gray-300 hover:bg-white/10 font-medium transition">Masuk</a>
            <a href="{{ route('register') }}"
                class="block px-4 py-3 rounded-xl text-center bg-pink-600 hover:bg-pink-500 text-white font-semibold transition">Daftar
                Gratis</a>
            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const mainNav = document.getElementById('mainNav');
    const isAlwaysScrolled =
        "{{ $alwaysScrolled ? 'true' : 'false' }}" === "true";

    function handleScroll() {

        if (!mainNav) return;

        const userName =
            document.getElementById('userName');

        if (isAlwaysScrolled || window.scrollY > 60) {

            mainNav.classList.add('scrolled');

            // navbar putih
            if (userName) {
                userName.classList.remove('text-white');
                userName.classList.add('text-[#020617]');
            }

        } else {

            mainNav.classList.remove('scrolled');

            // navbar transparan
            if (userName) {
                userName.classList.remove('text-[#020617]');
                userName.classList.add('text-white');
            }
        }
    }

    window.addEventListener('scroll', handleScroll, {
        passive: true
    });

    handleScroll();

    window.toggleMobileMenu = function() {
        const menu = document.getElementById('mobileMenu');
        const h = document.getElementById('hamburgerIcon');
        const c = document.getElementById('closeIcon');

        if (!menu || !h || !c) return;

        const open = menu.classList.contains('hidden');

        menu.classList.toggle('hidden', !open);
        h.classList.toggle('hidden', open);
        c.classList.toggle('hidden', !open);
    };

    window.handleNavClick = function(event, sectionId) {
        event.preventDefault();

        const mobileMenu = document.getElementById('mobileMenu');
        const hamburgerIcon =
            document.getElementById('hamburgerIcon');
        const closeIcon =
            document.getElementById('closeIcon');

        if (mobileMenu) {
            mobileMenu.classList.add('hidden');
        }

        if (hamburgerIcon) {
            hamburgerIcon.classList.remove('hidden');
        }

        if (closeIcon) {
            closeIcon.classList.add('hidden');
        }

        if (
            window.location.pathname === '/' ||
            window.location.pathname === ''
        ) {
            const el =
                document.getElementById(sectionId);

            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        } else {
            window.location.href =
                '/#' + sectionId;
        }
    };

    window.toggleProfileDropdown = function() {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    };

    window.contactWhatsApp = function(event, url) {
        event.preventDefault();
        Swal.fire({
            title: 'Hubungi WhatsApp',
            text: 'Anda akan dialihkan ke WhatsApp Customer Service kami. Apakah Anda ingin melanjutkan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#db2777', // pink-600
            cancelButtonColor: '#6b7280', // gray-500
            customClass: {
                popup: 'rounded-[1.5rem]'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.open(url, '_blank');
            }
        });
    };

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        const profileBtn = event.target.closest('button[onclick="toggleProfileDropdown()"]');

        if (dropdown && !profileBtn && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>