<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pemesanan - PinkTravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins bg-gray-50/50 text-gray-900">
    <div>
        <x-navbar :always-scrolled="true"></x-navbar>

        <section class="pt-32 pb-24 px-4 min-h-screen">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div class="lg:col-span-2">
                        <div
                            class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm mb-8 relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-64 h-64 bg-green-100/30 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none">
                            </div>
                            <div class="flex items-center gap-4 mb-8 relative z-10">
                                <div
                                    class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center shadow-sm">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pemesanan <span
                                            class="text-green-600">Berhasil</span></h1>
                                    <p class="text-gray-500 font-medium">Selesaikan pembayaran untuk mengkonfirmasi</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-[1.5rem] p-6 mb-8 border border-gray-100 relative z-10">
                                <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                                    Detail Pesanan
                                </h3>

                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nomor Pesanan</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->order_id }}</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nama Paket</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->trip->title }}</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Durasi</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->trip->duration_days }}
                                            Hari</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jumlah Peserta</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->participants }}
                                            orang</span>
                                    </div>

                                    @if ($booking->preferred_date)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Perjalanan</span>
                                        <span
                                            class="font-semibold text-gray-900">{{ $booking->preferred_date->format('d F Y') }}</span>
                                    </div>
                                    @endif

                                    @if ($booking->phone)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nomor Telepon</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->phone }}</span>
                                    </div>
                                    @endif

                                    @if ($booking->special_request)
                                    <div>
                                        <span class="text-gray-600">Catatan Khusus</span>
                                        <p class="font-semibold text-gray-900 mt-1">{{ $booking->special_request }}</p>
                                    </div>
                                    @endif

                                    <div class="border-t border-gray-200 pt-5 mt-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-gray-900">Total Pembayaran</span>
                                            <span class="text-3xl font-extrabold text-pink-600">Rp
                                                {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50/50 border border-blue-100 rounded-[1.5rem] p-6 relative z-10">
                                <h4 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                                    <span
                                        class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm text-blue-500 text-sm">ℹ️</span>
                                    Informasi Penting
                                </h4>
                                <ul class="space-y-3 text-sm text-blue-800 font-medium">
                                    <li class="flex gap-2">
                                        <span class="text-blue-500 mt-0.5">•</span>
                                        <span>Pembayaran harus diselesaikan dalam waktu 24 jam</span>
                                    </li>
                                    <li class="flex gap-2">
                                        <span class="text-blue-500 mt-0.5">•</span>
                                        <span>Booking akan otomatis dibatalkan jika tidak ada pembayaran</span>
                                    </li>
                                    <li class="flex gap-2">
                                        <span class="text-blue-500 mt-0.5">•</span>
                                        <span>Konfirmasi booking akan dikirim ke email Anda setelah pembayaran
                                            berhasil</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-64 h-64 bg-gray-100/50 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none">
                            </div>
                            <h3
                                class="text-2xl font-extrabold text-gray-900 mb-6 relative z-10">
                                Data Pemesan
                            </h3>

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
                    </div>

                    <div class="lg:col-span-1">
                        <div
                            class="bg-white rounded-[2rem] p-6 md:p-8 border border-gray-100 shadow-xl shadow-gray-100/50 sticky top-28">
                            <h3 class="text-2xl font-extrabold text-gray-900 mb-6 tracking-tight">Pembayaran</h3>

                            <div
                                class="bg-gradient-to-br from-pink-50 to-rose-50 border border-pink-100 rounded-[1.5rem] p-6 mb-8 relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-pink-200/50 rounded-full blur-xl pointer-events-none">
                                </div>
                                <p class="text-gray-600 text-sm font-bold mb-2 relative z-10">Total Tagihan</p>
                                <p class="text-3xl font-extrabold text-pink-600 relative z-10 drop-shadow-sm">Rp
                                    {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>

                            <button id="pay-button"
                                class="w-full flex items-center justify-center py-4 px-6 bg-pink-600 text-white rounded-2xl font-bold hover:bg-pink-500 transition-all shadow-lg shadow-pink-600/30 hover:-translate-y-1 mb-4">
                                Bayar Sekarang
                            </button>

                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </section>

    <x-footer></x-footer>
    </div>

    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
    <script>
    document.getElementById('pay-button').addEventListener('click', function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                // Pembayaran berhasil - redirect ke halaman sukses atau booking details
                window.location.href = "{{ route('booking.show', $booking->id) }}";
            },
            onPending: function(result) {
                // Menunggu pembayaran
                console.log('Pending', result);
            },
            onError: function(result) {
                // Pembayaran gagal
                alert('Pembayaran gagal. Silakan coba lagi.');
                console.log('Error', result);
            },
            onClose: function() {
                console.log('Customer menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
    </script>
</body>

</html>