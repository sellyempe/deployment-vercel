@props(['title' => 'Admin', 'active' => ''])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Pink Tour and Travel Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins bg-white text-gray-900 flex min-h-screen">

    <aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 flex flex-col z-50 shadow-sm">

        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/5">
            <div class="w-12 h-12 rounded-xl overflow-hidden shadow-lg bg-white flex items-center justify-center">
                <img src="{{ asset(get_setting('site_logo', 'images/logo-pinktravel.png')) }}"
                    alt="{{ get_setting('site_name', 'Pink Tour and Travel') }}" class="w-full h-full object-cover">
            </div>
            <div>
                <p class="font-bold text-[#132440] text-sm leading-none">
                    {{ get_setting('site_name', 'Pink Tour and Travel') }}
                </p>

                <p class="text-xs text-[#132440] mt-0.5">
                    Admin Panel
                </p>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <p class="px-4 pt-2 pb-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ $active === 'trips'
                            ? 'bg-[#EC008C] text-white shadow-lg shadow-pink-600/20'
                            : 'text-[#132440] hover:text-white hover:bg-[#EC008C]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                </svg>
                <span>Kelola Trip</span>
            </a>

            <a href="{{ route('admin.bookings.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ $active === 'bookings'
                            ? 'bg-[#EC008C] text-white shadow-lg shadow-pink-600/20'
                            : 'text-[#132440] hover:text-white hover:bg-[#EC008C]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Manajemen Booking</span>
            </a>

            <a href="{{ route('admin.destinations.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ $active === 'destinations'
                            ? 'bg-[#EC008C] text-white shadow-lg shadow-pink-600/20'
                            : 'text-[#132440] hover:text-white hover:bg-[#EC008C]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Kelola Destinasi</span>
            </a>

            <a href="{{ route('admin.reviews.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ $active === 'reviews'
                            ? 'bg-[#EC008C] text-white shadow-lg shadow-pink-600/20'
                            : 'text-[#132440] hover:text-white hover:bg-[#EC008C]'   }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                <span>Review &amp; Testimoni</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ $active === 'settings'
                            ? 'bg-[#EC008C] text-white shadow-lg shadow-pink-600/20'
                            : 'text-[#132440] hover:text-white hover:bg-[#EC008C]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pengaturan Website</span>
            </a>

        </nav>

        <div class="px-3 py-4 border-t border-white/5">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-pink-50 border border-pink-100 mb-2">
                <div
                    class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-[#132440] truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <input type="hidden" name="logout_source" value="admin_dashboard">
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col min-h-screen">

        <header class="sticky top-0 z-40 bg-white border-b border-gray-200 px-8 py-4 flex items-center">

            <div>
                <h1 class="text-xl font-bold text-[#132440]">
                    {{ $title }}
                </h1>

                <p class="text-xs text-gray-500 mt-0.5">
                    Panel Admin Pink Tour and Travel
                </p>
            </div>

        </header>

        @if(session('success'))
        <div
            class="mx-8 mt-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div
            class="mx-8 mt-5 flex items-center gap-3 px-5 py-3.5 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('error') }}
        </div>
        @endif

        <main class="flex-1 px-8 py-6">
            {{ $slot }}
        </main>
    </div>

    <!-- SweetAlert2 library and interceptor script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Shared SweetAlert2 config with inline styles
        function showDeleteConfirm(message) {
            return Swal.fire({
                title: 'Konfirmasi Tindakan',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                didOpen: (popup) => {
                    // Style the popup
                    popup.style.backgroundColor = '#16476A';
                    popup.style.border = '1px solid rgba(255,255,255,0.1)';
                    popup.style.borderRadius = '28px';
                    popup.style.color = '#fff';
                    popup.style.padding = '1.5rem';
                    popup.style.boxShadow = '0 25px 50px -12px rgba(0,0,0,0.5)';

                    // Style the title
                    const title = popup.querySelector('.swal2-title');
                    if (title) {
                        title.style.color = '#fff';
                        title.style.fontSize = '1.25rem';
                        title.style.fontWeight = '700';
                    }

                    // Style the message text
                    const html = popup.querySelector('.swal2-html-container');
                    if (html) {
                        html.style.color = '#d1d5db';
                        html.style.fontSize = '0.875rem';
                        html.style.marginTop = '0.5rem';
                    }

                    // Style the icon
                    const icon = popup.querySelector('.swal2-icon');
                    if (icon) {
                        icon.style.borderColor = '#f59e0b';
                        icon.style.color = '#f59e0b';
                    }

                    // Style the confirm button
                    const confirmBtn = popup.querySelector('.swal2-confirm');
                    if (confirmBtn) {
                        confirmBtn.style.backgroundColor = '#EF4444';
                        confirmBtn.style.color = '#fff';
                        confirmBtn.style.fontWeight = '600';
                        confirmBtn.style.padding = '0.625rem 1.25rem';
                        confirmBtn.style.borderRadius = '0.75rem';
                        confirmBtn.style.border = 'none';
                        confirmBtn.style.cursor = 'pointer';
                        confirmBtn.style.transition = 'background-color 0.2s';
                        confirmBtn.addEventListener('mouseenter', () => confirmBtn.style
                            .backgroundColor = '#DC2626');
                        confirmBtn.addEventListener('mouseleave', () => confirmBtn.style
                            .backgroundColor = '#EF4444');
                    }

                    // Style the cancel button
                    const cancelBtn = popup.querySelector('.swal2-cancel');
                    if (cancelBtn) {
                        cancelBtn.style.backgroundColor = 'rgba(255,255,255,0.1)';
                        cancelBtn.style.color = '#fff';
                        cancelBtn.style.fontWeight = '600';
                        cancelBtn.style.padding = '0.625rem 1.25rem';
                        cancelBtn.style.borderRadius = '0.75rem';
                        cancelBtn.style.border = 'none';
                        cancelBtn.style.cursor = 'pointer';
                        cancelBtn.style.transition = 'background-color 0.2s';
                        cancelBtn.addEventListener('mouseenter', () => cancelBtn.style
                            .backgroundColor = 'rgba(255,255,255,0.2)');
                        cancelBtn.addEventListener('mouseleave', () => cancelBtn.style
                            .backgroundColor = 'rgba(255,255,255,0.1)');
                    }
                }
            });
        }

        // 1. Intercept all forms that use inline native confirm() in onsubmit
        document.querySelectorAll('form[onsubmit*="confirm("]').forEach(form => {
            const onsubmitAttr = form.getAttribute('onsubmit');
            form.removeAttribute('onsubmit'); // Prevent native popup

            // Extract and clean confirmation message
            const match = onsubmitAttr.match(/confirm\(['"](.*)['"]\)/);
            let message = match ? match[1] : 'Apakah Anda yakin ingin menghapus data ini?';
            message = message.replace(/\\'/g, "'").replace(/\\"/g, '"'); // Unescape quotes

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                showDeleteConfirm(message).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // 2. Intercept elements (like buttons) that use inline confirm() in onclick
        document.querySelectorAll('[onclick*="confirm("]').forEach(element => {
            const onclickAttr = element.getAttribute('onclick');
            element.removeAttribute('onclick'); // Prevent native popup

            // Extract and clean confirmation message
            const confirmMatch = onclickAttr.match(/confirm\(['"](.*)['"]\)/);
            let message = confirmMatch ? confirmMatch[1] : 'Apakah Anda yakin?';
            message = message.replace(/\\'/g, "'").replace(/\\"/g, '"'); // Unescape quotes

            // Parse action code
            let actionCode = '';
            const firstBrace = onclickAttr.indexOf('{');
            const lastBrace = onclickAttr.lastIndexOf('}');
            if (firstBrace !== -1 && lastBrace !== -1) {
                actionCode = onclickAttr.substring(firstBrace + 1, lastBrace).trim();
            } else {
                const ifConfirmRegex = /if\s*\(\s*confirm\s*\(.*?\)\s*\)\s*/;
                actionCode = onclickAttr.replace(ifConfirmRegex, '').trim();
            }

            element.addEventListener('click', function(e) {
                e.preventDefault();
                showDeleteConfirm(message).then((result) => {
                    if (result.isConfirmed) {
                        new Function(actionCode)();
                    }
                });
            });
        });
    });
    </script>
</body>

</html>