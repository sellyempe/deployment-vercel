<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Saya - Pink Tour and Travel</title>
    <meta name="description" content="Dasbor pengguna PinkTravel - lihat riwayat dan status booking perjalanan Anda.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins bg-gray-50/50 text-gray-900">
    <div>
        <x-navbar :always-scrolled="true"></x-navbar>

        <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">Dasbor Saya</h1>
                        <p class="text-gray-600 mt-2">Selamat datang kembali, {{ $user->name }}!</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Member sejak</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif

                <div class="bg-white border-b border-gray-200 rounded-t-lg">
                    <div class="flex space-x-8 px-6 overflow-x-auto">
                        <button onclick="switchTab('dashboard', this)"
                            class="tab-link active-tab px-4 py-4 text-gray-900 font-medium border-b-2 border-pink-600 whitespace-nowrap">
                            📊 Ringkasan
                        </button>
                        <button onclick="switchTab('bookings', this)"
                            class="tab-link px-4 py-4 text-gray-700 font-medium border-b-2 border-transparent hover:text-gray-900 whitespace-nowrap">
                            📋 Pesanan Saya
                        </button>
                        <button onclick="switchTab('wishlist', this)"
                            class="tab-link px-4 py-4 text-gray-700 font-medium border-b-2 border-transparent hover:text-gray-900 whitespace-nowrap">
                            ❤️ Wishlist
                        </button>
                        <button onclick="switchTab('profile', this)"
                            class="tab-link px-4 py-4 text-gray-700 font-medium border-b-2 border-transparent hover:text-gray-900 whitespace-nowrap">
                            👤 Profil
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-b-lg shadow">
                    <div id="dashboard-tab" class="tab-content p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg p-5 text-center">
                                <p class="text-3xl font-bold text-pink-600">{{ $stats['total'] }}</p>
                                <p class="text-pink-700 text-sm font-medium mt-1">Total Pesanan</p>
                            </div>
                            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-5 text-center">
                                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                                <p class="text-yellow-700 text-sm font-medium mt-1">Menunggu Bayar</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-5 text-center">
                                <p class="text-3xl font-bold text-green-600">{{ $stats['confirmed'] }}</p>
                                <p class="text-green-700 text-sm font-medium mt-1">Dikonfirmasi</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-5 text-center">
                                <p class="text-3xl font-bold text-blue-600">{{ $stats['completed'] }}</p>
                                <p class="text-blue-700 text-sm font-medium mt-1">Selesai</p>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-4">Aktivitas Terbaru</h3>
                        <div class="space-y-4">
                            @forelse ($recentBookings as $booking)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4 flex-1">
                                    @php
                                    $badgeClass = match($booking->status) {
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-red-100 text-red-800',
                                    };
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }} flex-shrink-0">
                                        {{ strtoupper($booking->status) }}
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $booking->trip->title ?? 'Trip tidak tersedia' }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->participants }} peserta ·
                                            {{ $booking->trip->duration_days ?? '-' }} hari</p>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    <a href="{{ route('booking.show', $booking->id) }}"
                                        class="text-pink-600 hover:text-pink-900 text-xs font-medium">Detail →</a>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12 bg-gray-50 rounded-lg">
                                <p class="text-gray-500 mb-2">Belum ada pemesanan</p>
                                <a href="/" class="text-pink-600 hover:text-pink-900 font-medium">Jelajahi trip →</a>
                            </div>
                            @endforelse
                        </div>

                        @if ($stats['total'] > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('booking.index') }}"
                                class="text-pink-600 hover:text-pink-700 font-medium text-sm">
                                Lihat semua {{ $stats['total'] }} pesanan →
                            </a>
                        </div>
                        @endif
                    </div>

                    <div id="bookings-tab" class="tab-content hidden p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Pesanan Saya</h3>
                            <a href="{{ route('booking.index') }}"
                                class="text-sm text-pink-600 hover:text-pink-700 font-medium">
                                Lihat semua →
                            </a>
                        </div>
                        <div class="space-y-4">
                            @forelse ($recentBookings as $booking)
                            <div
                                class="flex items-start justify-between p-5 border border-gray-200 rounded-lg hover:shadow-md transition">
                                <div class="flex items-center space-x-4 flex-1">
                                    @if ($booking->trip && $booking->trip->image)
                                    <img src="{{ $booking->trip->image }}" alt="{{ $booking->trip->title }}"
                                        class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                    @else
                                    <div
                                        class="w-20 h-20 bg-pink-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-3xl">✈️</span>
                                    </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900">
                                            {{ $booking->trip->title ?? 'Trip tidak tersedia' }}</h4>
                                        <p class="text-sm text-gray-600">{{ $booking->trip->duration_days ?? '-' }} Hari
                                            · {{ $booking->participants }} Peserta</p>
                                        <p class="text-xs text-gray-500 mt-1">Order: {{ $booking->order_id }}</p>
                                    </div>
                                </div>
                                <div class="text-right ml-4 flex-shrink-0">
                                    @php
                                    $badgeClass = match($booking->status) {
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-red-100 text-red-800',
                                    };
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }} block mb-2">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <p class="font-bold text-gray-900">Rp
                                        {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    <a href="{{ route('booking.show', $booking->id) }}"
                                        class="text-pink-600 hover:text-pink-900 text-sm font-medium">Detail →</a>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12 bg-gray-50 rounded-lg">
                                <p class="text-gray-500 mb-2">Belum ada pemesanan</p>
                                <a href="/" class="text-pink-600 hover:text-pink-900 font-medium">Cari paket wisata
                                    →</a>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <div id="wishlist-tab" class="tab-content hidden p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Wishlist Saya</h3>
                        <div id="wishlist-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <p class="col-span-full text-gray-500 text-center py-8">Memuat wishlist...</p>
                        </div>
                    </div>

                    <div id="profile-tab" class="tab-content hidden p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Profil & Pengaturan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-semibold text-lg text-gray-900 mb-4">Informasi Akun</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" value="{{ $user->name }}" disabled
                                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-900">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" value="{{ $user->email }}" disabled
                                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-900">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Member Sejak</label>
                                        <input type="text" value="{{ $user->created_at->format('d M Y') }}" disabled
                                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-900">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg text-gray-900 mb-4">Aksi</h4>
                                <div class="space-y-3">
                                    <a href="{{ route('booking.index') }}"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 font-medium transition">
                                        📋 Lihat Semua Pesanan
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                                            🚪 Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer></x-footer>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');

        if (successAlert) {
            const key = 'msg_' + btoa('{{ session("success") }}').substring(0, 16);
            if (!sessionStorage.getItem(key)) {
                successAlert.classList.remove('hidden');
                sessionStorage.setItem(key, 'shown');
            }
        }

        if (errorAlert) {
            const key = 'msg_' + btoa('{{ session("error") }}').substring(0, 16);
            if (!sessionStorage.getItem(key)) {
                errorAlert.classList.remove('hidden');
                sessionStorage.setItem(key, 'shown');
            }
        }
    });

    function switchTab(tabName, btn) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        document.querySelectorAll('.tab-link').forEach(link => {
            link.classList.remove('border-pink-600', 'text-gray-900', 'active-tab');
            link.classList.add('border-transparent', 'text-gray-700');
        });

        document.getElementById(tabName + '-tab').classList.remove('hidden');
        btn.classList.add('border-pink-600', 'text-gray-900');
        btn.classList.remove('border-transparent', 'text-gray-700');

        if (tabName === 'wishlist') {
            loadWishlists();
        }
    }

    async function loadWishlists() {
        const container = document.getElementById('wishlist-container');
        try {
            const response = await fetch('/api/wishlists');
            if (!response.ok) throw new Error('Not authenticated');
            const wishlists = await response.json();

            if (wishlists.length === 0) {
                container.innerHTML =
                    '<p class="col-span-full text-gray-500 text-center py-8">Belum ada item di wishlist</p>';
                return;
            }

            container.innerHTML = wishlists.map(item => {
                const w = item.wishlistable;
                if (!w) return '';
                const isTrip = item.wishlistable_type === 'App\Models\Trip';
                const link = isTrip ? `/trip/${w.id}` : `/destination/${w.id}`;
                const image = w.image || '';
                const title = isTrip ? w.title : w.name;
                const subtitle = isTrip ?
                    `${w.destination} · Rp ${parseInt(w.price).toLocaleString('id-ID')}` :
                    w.location;

                return `
                        <div class="bg-white rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition">
                            <img src="${image}" alt="${title}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 mb-1">${title}</h4>
                                <p class="text-sm text-gray-600 mb-4">${subtitle}</p>
                                <div class="flex gap-2">
                                    <a href="${link}" class="flex-1 px-3 py-2 bg-pink-600 text-white rounded text-sm font-semibold text-center hover:bg-pink-700 transition">
                                        Lihat Detail
                                    </a>
                                    <button onclick="removeFromWishlist(${item.id})" class="px-3 py-2 bg-red-100 text-red-600 rounded text-sm font-semibold hover:bg-red-200 transition">
                                        ❌
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
            }).join('');
        } catch (error) {
            container.innerHTML =
                '<p class="col-span-full text-red-500 text-center py-8">Gagal memuat wishlist. Pastikan Anda sudah login.</p>';
        }
    }

    async function removeFromWishlist(id) {
        if (!confirm('Hapus dari wishlist?')) return;
        try {
            const response = await fetch(`/api/wishlists/${id}`, {
                method: 'DELETE'
            });
            if (response.ok) {
                loadWishlists();
            } else {
                alert('Gagal menghapus dari wishlist');
            }
        } catch (error) {
            alert('Gagal menghapus dari wishlist');
        }
    }
    </script>
</body>

</html>