<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Saya - Pink Tour and Travel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins bg-gray-50/50 text-gray-900">
    <div>
        <x-navbar :always-scrolled="true"></x-navbar>

        <section class="py-20 px-4 bg-gray-50 min-h-screen">
            <div class="max-w-6xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Booking Saya</h1>
                    <p class="text-gray-600">Lihat dan kelola semua booking wisata Anda</p>
                </div>

                @if ($bookings->isEmpty())
                <div class="bg-white rounded-lg p-12 border border-gray-200 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Booking</h3>
                    <p class="text-gray-600 mb-6">Anda belum memiliki booking wisata. Mulai jelajahi paket wisata kami
                        sekarang.</p>
                    <a href="/"
                        class="inline-block bg-pink-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-pink-700 transition">
                        Jelajahi Paket Wisata
                    </a>
                </div>
                @else
                <div class="space-y-4">
                    @foreach ($bookings as $booking)
                    <div class="bg-white rounded-lg border border-gray-200 hover:shadow-lg transition overflow-hidden">
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex-1">
                                <div class="mb-3">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $booking->trip->title }}</h3>

                                        @if ($booking->status === 'pending')
                                        <span
                                            class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Menunggu
                                            Konfirmasi Pembayaran</span>
                                        @elseif ($booking->status === 'confirmed')
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Dikonfirmasi</span>
                                        @elseif ($booking->status === 'completed')
                                        <span
                                            class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Selesai</span>
                                        @elseif ($booking->status === 'cancelled')
                                        <span
                                            class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Dibatalkan</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600">Order ID: {{ $booking->order_id }}</p>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600 text-xs">Durasi</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->trip->duration_days }} Hari
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 text-xs">Peserta</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->participants }} orang</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 text-xs">Total Harga</p>
                                        <p class="font-semibold text-gray-900">Rp
                                            {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 text-xs">Tanggal Booking</p>
                                        <p class="font-semibold text-gray-900">
                                            {{ $booking->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="ml-6 flex gap-2">
                                <a href="{{ route('booking.show', $booking->id) }}"
                                    class="px-4 py-2 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition text-sm whitespace-nowrap">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>

        <x-footer></x-footer>
    </div>
</body>

</html>