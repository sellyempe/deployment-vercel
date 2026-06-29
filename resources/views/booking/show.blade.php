<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Booking - Pink Tour and Travel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-poppins bg-gray-50/50 text-gray-900">
    <div>
        <x-navbar :always-scrolled="true"></x-navbar>

        <section class="pt-32 pb-24 px-4 min-h-screen">
            <div class="max-w-5xl mx-auto">
                <a href="{{ route('booking.index') }}"
                    class="text-pink-600 hover:text-pink-700 font-semibold mb-6 inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Kembali ke Booking Saya
                </a>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div class="lg:col-span-2 space-y-8">
                        <div
                            class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-64 h-64 bg-pink-100/30 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none">
                            </div>
                            <div class="flex items-center justify-between mb-8 relative z-10">
                                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail <span
                                        class="text-pink-600">Booking</span></h1>

                                @if ($booking->status === 'pending')
                                <span
                                    class="px-4 py-2 bg-yellow-100 text-yellow-800 font-semibold rounded-full">Menunggu
                                    Konfirmasi Pembayaran</span>
                                @elseif ($booking->status === 'confirmed')
                                <span
                                    class="px-4 py-2 bg-green-100 text-green-800 font-semibold rounded-full">Dikonfirmasi</span>
                                @elseif ($booking->status === 'completed')
                                <span
                                    class="px-4 py-2 bg-blue-100 text-blue-800 font-semibold rounded-full">Selesai</span>
                                @elseif ($booking->status === 'cancelled')
                                <span
                                    class="px-4 py-2 bg-red-100 text-red-800 font-semibold rounded-full">Dibatalkan</span>
                                @endif
                            </div>

                            <div class="space-y-5 relative z-10">
                                <div class="flex justify-between border-b border-gray-50 pb-3">
                                    <span class="text-gray-500 font-medium">Nomor Pesanan</span>
                                    <span class="font-bold text-gray-900">{{ $booking->order_id }}</span>
                                </div>

                                <div class="flex justify-between border-b border-gray-50 pb-3">
                                    <span class="text-gray-500 font-medium">Tanggal Booking</span>
                                    <span
                                        class="font-bold text-gray-900">{{ $booking->created_at->format('d F Y H:i') }}</span>
                                </div>

                                @if ($booking->confirmed_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Tanggal Konfirmasi</span>
                                    <span
                                        class="font-bold text-gray-900">{{ $booking->confirmed_at->format('d F Y H:i') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-64 h-64 bg-gray-100/50 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none">
                            </div>
                            <h2 class="text-2xl font-extrabold text-gray-900 mb-6 relative z-10">
                                Paket Wisata
                            </h2>

                            <div class="mb-8 relative rounded-[1.5rem] overflow-hidden group">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent z-10">
                                </div>
                                <img src="{{ $booking->trip->image }}" alt="{{ $booking->trip->title }}"
                                    class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute bottom-4 left-4 z-20">
                                    <span
                                        class="px-3 py-1 bg-pink-600/90 backdrop-blur-md text-white text-xs font-bold rounded-full shadow-sm">{{ $booking->trip->duration_days }}
                                        Hari</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                                <div
                                    class="bg-gray-50 p-4 rounded-[1rem] border border-gray-100 col-span-1 md:col-span-2">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Nama Paket
                                    </p>
                                    <p class="text-lg font-bold text-gray-900">{{ $booking->trip->title }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-[1rem] border border-gray-100">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Durasi</p>
                                    <p class="font-bold text-gray-900">{{ $booking->trip->duration_days }} Hari</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-[1rem] border border-gray-100">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Destinasi
                                    </p>
                                    <p class="font-bold text-gray-900">{{ $booking->trip->destination }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-[1rem] border border-gray-100">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Kota
                                        Keberangkatan</p>
                                    <p class="font-bold text-gray-900">{{ $booking->trip->departure_city }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-[1rem] border border-gray-100">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Titik
                                        Kumpul</p>
                                    <p class="font-bold text-gray-900">{{ $booking->trip->meeting_point }}</p>
                                    <p class="text-gray-500 text-xs mt-1">{{ $booking->trip->meeting_address }}</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                            <h2 class="text-2xl font-extrabold text-gray-900 mb-6 relative z-10">
                                Detail Pesanan
                            </h2>

                            <div class="space-y-5 relative z-10">
                                <div class="flex justify-between border-b border-gray-50 pb-3">
                                    <span class="text-gray-500 font-medium">Jumlah Peserta</span>
                                    <span class="font-bold text-gray-900">{{ $booking->participants }} orang</span>
                                </div>

                                @if ($booking->preferred_date)
                                <div class="flex justify-between border-b border-gray-50 pb-3">
                                    <span class="text-gray-500 font-medium">Tanggal Perjalanan</span>
                                    <span
                                        class="font-bold text-gray-900">{{ $booking->preferred_date->format('d F Y') }}</span>
                                </div>
                                @endif

                                @if ($booking->phone)
                                <div class="flex justify-between border-b border-gray-50 pb-3">
                                    <span class="text-gray-500 font-medium">Nomor Telepon</span>
                                    <span class="font-bold text-gray-900">{{ $booking->phone }}</span>
                                </div>
                                @endif

                                @if ($booking->special_request)
                                <div class="border-b border-gray-50 pb-3">
                                    <span class="text-gray-500 font-medium">Catatan Khusus</span>
                                    <p class="font-bold text-gray-900 mt-1">{{ $booking->special_request }}</p>
                                </div>
                                @endif

                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Harga per Orang</span>
                                    <span class="font-bold text-gray-900">Rp
                                        {{ number_format($booking->trip->price, 0, ',', '.') }}</span>
                                </div>

                                <div class="border-t border-gray-200 pt-5 mt-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900">Total Pembayaran</span>
                                        <span class="text-3xl font-extrabold text-pink-600">Rp
                                            {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                            <h2 class="text-2xl font-extrabold text-gray-900 mb-6 relative z-10">
                                Data Pemesan
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                                <div class="bg-gray-50 p-4 rounded-[1rem] border border-gray-100">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Nama
                                        Lengkap</p>
                                    <p class="font-bold text-gray-900">{{ $booking->user->name }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-[1rem] border border-gray-100">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Alamat
                                        Email</p>
                                    <p class="font-bold text-gray-900">{{ $booking->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        @if (($booking->status === 'confirmed' || $booking->status === 'completed') && !$hasReviewed)
                        @include('components.review-form', ['reviewableType' => 'App\Models\Trip', 'reviewableId' =>
                        $booking->trip_id])
                        @endif
                    </div>

                    <div class="lg:col-span-1">
                        <div
                            class="bg-white rounded-[2rem] p-6 md:p-8 border border-gray-100 shadow-xl shadow-gray-100/50 sticky top-28 space-y-6">
                            <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-2">Status Pembayaran</h3>

                            @if ($booking->status === 'pending')
                            <div
                                class="bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-100 rounded-[1.5rem] p-6 relative overflow-hidden">
                                <p class="text-yellow-800 font-bold mb-3 relative z-10">
                                    Menunggu Konfirmasi Pembayaran
                                </p>
                                <p class="text-yellow-700 text-sm relative z-10 font-medium">Silakan selesaikan
                                    pembayaran untuk mengkonfirmasi booking Anda.</p>
                            </div>
                            @elseif ($booking->status === 'confirmed')
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 rounded-[1.5rem] p-6 relative overflow-hidden">
                                <p class="text-green-800 font-bold mb-3 relative z-10 flex items-center gap-2">
                                    <span
                                        class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm text-green-600 text-sm">✓</span>
                                    Pembayaran Berhasil
                                </p>
                                <p class="text-green-700 text-sm relative z-10 font-medium">Booking Anda telah
                                    dikonfirmasi. Cek email Anda untuk detail lebih lanjut.</p>

                                <a href="{{ route('booking.download_ticket', $booking->id) }}"
                                    class="mt-5 w-full flex items-center justify-center py-4 px-6 bg-pink-600 text-white rounded-2xl font-bold hover:bg-pink-700 transition-all shadow-lg shadow-pink-600/30 relative z-10 gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download E-Ticket
                                </a>
                            </div>
                            @elseif ($booking->status === 'completed')
                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-[1.5rem] p-6 relative overflow-hidden">
                                <p class="text-blue-800 font-bold mb-3 relative z-10 flex items-center gap-2">
                                    <span
                                        class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm text-blue-600 text-sm">✨</span>
                                    Perjalanan Selesai
                                </p>
                                <p class="text-blue-700 text-sm relative z-10 font-medium">Terima kasih telah memilih
                                    PinkTravel. Kami harap Anda menikmati perjalanan ini!</p>

                                @if (!$hasReviewed)
                                <button onclick="openReviewModal()"
                                    class="mt-5 w-full flex items-center justify-center py-3 px-6 bg-pink-600 text-white rounded-xl font-bold hover:bg-pink-700 transition-all shadow-lg shadow-pink-600/30 relative z-10 gap-2">
                                    <span>Berikan Ulasan</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                        </path>
                                    </svg>
                                </button>
                                @else
                                <div
                                    class="mt-5 bg-white/60 rounded-xl p-3 text-center border border-white relative z-10">
                                    <span
                                        class="text-sm font-bold text-blue-800 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Ulasan telah dikirim
                                    </span>
                                </div>
                                @endif
                            </div>
                            @elseif ($booking->status === 'cancelled')
                            <div
                                class="bg-gradient-to-br from-red-50 to-rose-50 border border-red-100 rounded-[1.5rem] p-6 relative overflow-hidden">
                                <p class="text-red-800 font-bold mb-3 relative z-10">
                                    Booking Dibatalkan
                                </p>
                                <p class="text-red-700 text-sm relative z-10 font-medium leading-relaxed">
                                    Booking ini telah dibatalkan. Bagi pesanan yang telah dibayar, proses pengembalian
                                    dana (refund) akan diproses secara manual. Silakan hubungi Customer Service kami
                                    untuk konfirmasi rekening transfer pengembalian dana.
                                </p>
                            </div>
                            @endif

                            @if ($booking->paymentTransaction)
                            <div class="border-t border-gray-100 pt-6 mt-6">
                                <p class="text-sm font-bold text-gray-900 mb-4">Riwayat Transaksi</p>
                                <div class="bg-gray-50 p-4 rounded-[1rem] border border-gray-100">
                                    <p class="text-xs text-gray-500 font-medium mb-1">Reference ID</p>
                                    <p class="text-sm font-bold text-gray-900 font-mono mb-3">
                                        {{ $booking->paymentTransaction->reference_id }}
                                    </p>

                                    <p class="text-xs text-gray-500 font-medium mb-1">Status Bank</p>
                                    <p class="text-sm font-bold text-gray-900 capitalize">
                                        {{ $booking->paymentTransaction->status }}
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if ($booking->status === 'pending' || $booking->status === 'confirmed')
                            <div class="pt-4">
                                <button onclick="cancelBooking()"
                                    class="w-full border-2 border-red-100 text-red-600 py-4 rounded-2xl font-bold hover:bg-red-50 hover:border-red-200 transition-all text-sm">
                                    Batalkan Booking
                                </button>
                                <form id="cancel-form" action="{{ route('booking.cancel', $booking->id) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>

                            <script>
                            function cancelBooking() {
                                Swal.fire({
                                    title: 'Batalkan Booking Anda?',
                                    html: `
                                        <p style="color: #4b5563; font-size: 15px; margin-top: 10px; margin-bottom: 0; line-height: 1.5;">
                                            Apakah Anda yakin ingin membatalkan pesanan ini?
                                        </p>
                                    `,
                                    icon: 'warning',
                                    iconColor: '#f43f5e',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ya, Batalkan',
                                    cancelButtonText: 'Kembali',
                                    buttonsStyling: false,
                                    didOpen: () => {
                                        const popup = Swal.getPopup();
                                        if (popup) {
                                            popup.style.borderRadius = '2rem';
                                            popup.style.padding = '30px';
                                            popup.style.fontFamily = 'Poppins, sans-serif';

                                            const title = popup.querySelector('.swal2-title');
                                            if (title) {
                                                title.style.fontSize = '22px';
                                                title.style.fontWeight = '800';
                                                title.style.color = '#111827';
                                                title.style.padding = '0';
                                            }

                                            const confirmBtn = popup.querySelector('.swal2-confirm');
                                            const cancelBtn = popup.querySelector('.swal2-cancel');
                                            if (confirmBtn) {
                                                confirmBtn.style.padding = '12px 24px';
                                                confirmBtn.style.borderRadius = '12px';
                                                confirmBtn.style.fontSize = '14px';
                                                confirmBtn.style.fontWeight = 'bold';
                                                confirmBtn.style.backgroundColor = '#f43f5e'; // rose-500
                                                confirmBtn.style.color = '#ffffff';
                                                confirmBtn.style.border = 'none';
                                                confirmBtn.style.boxShadow =
                                                    '0 4px 6px -1px rgba(244, 63, 94, 0.2)';
                                                confirmBtn.style.cursor = 'pointer';
                                                confirmBtn.style.margin = '0 8px';
                                                confirmBtn.style.transition = 'all 0.2s';
                                            }
                                            if (cancelBtn) {
                                                cancelBtn.style.padding = '12px 24px';
                                                cancelBtn.style.borderRadius = '12px';
                                                cancelBtn.style.fontSize = '14px';
                                                cancelBtn.style.fontWeight = 'bold';
                                                cancelBtn.style.backgroundColor = '#f3f4f6'; // gray-100
                                                cancelBtn.style.color = '#4b5563'; // gray-600
                                                cancelBtn.style.border = 'none';
                                                cancelBtn.style.cursor = 'pointer';
                                                cancelBtn.style.margin = '0 8px';
                                                cancelBtn.style.transition = 'all 0.2s';
                                            }
                                        }
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('cancel-form').submit();
                                    }
                                });
                            }
                            </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-footer></x-footer>
    </div>

    @if ($booking->status === 'completed' && !$hasReviewed)
    {{-- data-trip-id dipakai JS untuk menghindari Blade syntax di dalam string JS --}}
    <div id="reviewModal" class="fixed inset-0 z-[100] hidden" data-trip-id="{{ $booking->trip_id }}">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeReviewModal()"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div
                class="relative bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full border border-gray-100">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-pink-100/50 rounded-full blur-2xl -mt-10 -mr-10 pointer-events-none">
                </div>
                <div class="bg-white px-8 pt-10 pb-6 relative z-10">
                    <div class="mb-8 text-center">
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Bagaimana perjalanan Anda?</h3>
                        <p class="text-gray-500 text-sm">Bagikan pengalaman Anda selama mengikuti paket wisata <span
                                class="font-bold text-gray-700">{{ $booking->trip->title }}</span></p>
                    </div>

                    <form id="reviewForm" class="space-y-6">
                        <div class="flex flex-col items-center">
                            <div class="flex items-center gap-2 flex-row-reverse justify-center" id="star-rating">
                                <input type="radio" id="star5" name="rating" value="5" class="hidden peer" />
                                <label for="star5"
                                    class="cursor-pointer text-gray-200 text-5xl transition-colors">★</label>

                                <input type="radio" id="star4" name="rating" value="4" class="hidden peer" />
                                <label for="star4"
                                    class="cursor-pointer text-gray-200 text-5xl transition-colors">★</label>

                                <input type="radio" id="star3" name="rating" value="3" class="hidden peer" />
                                <label for="star3"
                                    class="cursor-pointer text-gray-200 text-5xl transition-colors">★</label>

                                <input type="radio" id="star2" name="rating" value="2" class="hidden peer" />
                                <label for="star2"
                                    class="cursor-pointer text-gray-200 text-5xl transition-colors">★</label>

                                <input type="radio" id="star1" name="rating" value="1" class="hidden peer" />
                                <label for="star1"
                                    class="cursor-pointer text-gray-200 text-5xl transition-colors">★</label>
                            </div>
                            <p id="rating-error"
                                class="text-red-500 text-sm font-medium mt-3 hidden bg-red-50 px-3 py-1 rounded-lg">
                                Pilih rating (bintang) terlebih dahulu</p>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Ceritakan Pengalaman Anda <span
                                    class="text-gray-400 font-normal">(Opsional)</span></label>
                            <textarea id="reviewComment" rows="4"
                                class="w-full bg-gray-50 border border-gray-200 rounded-[1rem] px-5 py-4 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors text-sm"
                                placeholder="Apa yang Anda sukai dari perjalanan ini?"></textarea>
                        </div>
                    </form>
                </div>
                <div
                    class="bg-gray-50 px-8 py-5 flex flex-col-reverse sm:flex-row gap-3 relative z-10 border-t border-gray-100">
                    <button type="button" onclick="closeReviewModal()"
                        class="w-full sm:w-auto inline-flex justify-center rounded-xl border-2 border-gray-200 px-6 py-3 bg-white text-sm font-bold text-gray-600 shadow-sm hover:bg-gray-50 hover:text-gray-900 transition-all">
                        Batal
                    </button>
                    <button type="button" onclick="submitReview()" id="btnSubmitReview"
                        class="w-full sm:w-auto flex-1 inline-flex justify-center items-center gap-2 rounded-xl border border-transparent px-6 py-3 bg-pink-600 text-sm font-bold text-white shadow-lg shadow-pink-600/30 hover:bg-pink-700 hover:-translate-y-0.5 transition-all">
                        <span>Kirim Ulasan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // ─── Star Rating ───────────────────────────────────────────────
    const stars = document.querySelectorAll('#star-rating label');
    const radios = document.querySelectorAll('#star-rating input');

    // Karena HTML flex-row-reverse, bintang ke-0 di DOM = bintang nilai 5
    // updateStars(activeIndex) → warnai bintang 0..activeIndex kuning
    function updateStars(activeIndex) {
        stars.forEach((s, i) => {
            if (i <= activeIndex) {
                s.classList.remove('text-gray-200');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-200');
            }
        });
    }

    function resetStars() {
        const checkedIdx = Array.from(radios).findIndex(r => r.checked);
        if (checkedIdx !== -1) {
            updateStars(checkedIdx);
        } else {
            stars.forEach(s => {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-200');
            });
        }
    }

    stars.forEach((star, index) => {
        star.addEventListener('mouseover', () => updateStars(index));
        star.addEventListener('mouseout', () => resetStars());
        star.addEventListener('click', () => updateStars(index));
    });

    // ─── Modal ─────────────────────────────────────────────────────
    function openReviewModal() {
        document.getElementById('reviewModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // ─── Submit ────────────────────────────────────────────────────
    async function submitReview() {
        const checkedRadio = document.querySelector('input[name="rating"]:checked');

        if (!checkedRadio) {
            document.getElementById('rating-error').classList.remove('hidden');
            return;
        }

        document.getElementById('rating-error').classList.add('hidden');

        const btn = document.getElementById('btnSubmitReview');
        btn.disabled = true;
        btn.innerHTML = 'Mengirim...';

        // Ambil trip_id dari data attribute — aman, tidak melibatkan Blade di dalam JS string
        const tripId = document.getElementById('reviewModal').dataset.tripId;

        try {
            const response = await fetch('/api/reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    reviewable_type: 'App\\Models\\Trip',
                    reviewable_id: parseInt(tripId),
                    rating: parseInt(checkedRadio.value),
                    comment: document.getElementById('reviewComment').value
                })
            });

            const data = await response.json();

            if (response.ok) {
                alert('Terima kasih! Ulasan berhasil dikirim.');
                window.location.reload();
            } else {
                alert(data.message || 'Gagal mengirim ulasan');
            }

        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan sistem.');

        } finally {
            btn.disabled = false;
            btn.innerHTML = `
                    <span>Kirim Ulasan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                `;
        }
    }
    </script>
    @endif
</body>

</html>