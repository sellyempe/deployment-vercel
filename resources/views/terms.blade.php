<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syarat dan Ketentuan - PinkTravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins bg-gray-50/50 text-gray-900">
    <div>
        <x-navbar :always-scrolled="true"></x-navbar>

        <section class="pt-32 pb-24 px-4 min-h-screen">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-[2rem] p-8 md:p-12 border border-gray-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-pink-100/30 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none"></div>
                    
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-8 relative z-10 tracking-tight">Syarat & <span class="text-pink-600">Ketentuan</span></h1>
                    
                    <div class="prose prose-pink max-w-none relative z-10 space-y-8 text-gray-600">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Pendaftaran dan Pemesanan</h2>
                            <p class="leading-relaxed">Dengan melakukan pemesanan di PinkTravel, Anda menyatakan bahwa Anda telah berusia minimal 18 tahun atau memesan di bawah pengawasan orang dewasa. Anda bertanggung jawab untuk memberikan data yang akurat dan lengkap.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Pembayaran</h2>
                            <p class="leading-relaxed">Seluruh pembayaran dilakukan melalui sistem pembayaran resmi kami (Midtrans). Pemesanan baru akan diproses setelah pembayaran berhasil dikonfirmasi. Kami tidak bertanggung jawab atas kegagalan transaksi yang disebabkan oleh pihak bank atau penyedia layanan pembayaran.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Kebijakan Pembatalan</h2>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li>Pembatalan lebih dari 7 hari sebelum keberangkatan: Pengembalian dana 75%.</li>
                                <li>Pembatalan 3-7 hari sebelum keberangkatan: Pengembalian dana 50%.</li>
                                <li>Pembatalan kurang dari 3 hari sebelum keberangkatan: Tidak ada pengembalian dana.</li>
                            </ul>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Tanggung Jawab</h2>
                            <p class="leading-relaxed">PinkTravel bertindak sebagai penyelenggara perjalanan dan tidak bertanggung jawab atas kehilangan barang pribadi, kecelakaan, atau gangguan perjalanan yang disebabkan oleh keadaan darurat (Force Majeure) seperti cuaca buruk, bencana alam, atau kebijakan pemerintah.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Perubahan Jadwal</h2>
                            <p class="leading-relaxed">Kami berhak untuk mengubah rencana perjalanan atau jadwal demi keamanan dan kenyamanan peserta, terutama jika terjadi kondisi di luar kendali kami di lapangan.</p>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-100 text-center">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-8 py-4 bg-[#020617] text-white rounded-2xl font-bold hover:bg-slate-900 transition-all shadow-lg shadow-slate-900/20 gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <x-footer></x-footer>
    </div>
</body>

</html>