<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syarat dan Ketentuan - Pink Tour and Travel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins bg-gray-50/50 text-gray-900">
    <div>
        <x-navbar :always-scrolled="true"></x-navbar>

        <section class="pt-32 pb-24 px-4 min-h-screen">
            <div class="max-w-4xl mx-auto">
                <div
                    class="bg-white rounded-[2rem] p-8 md:p-12 border border-gray-100 shadow-sm relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-pink-100/30 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none">
                    </div>

                    <h1 class="text-4xl font-extrabold text-gray-900 mb-8 relative z-10 tracking-tight">Syarat & <span
                            class="text-pink-600">Ketentuan</span></h1>

                    <div class="prose prose-pink max-w-none relative z-10 space-y-8 text-gray-600">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Pendaftaran dan Pemesanan</h2>
                            <p class="leading-relaxed">Dengan melakukan pemesanan di Pink Tour and Travel, Anda
                                menyatakan bahwa Anda telah berusia minimal 18 tahun atau memesan di bawah pengawasan
                                orang dewasa. Anda bertanggung jawab untuk memberikan data yang akurat dan lengkap.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Pembayaran</h2>
                            <p class="leading-relaxed">Seluruh pembayaran dilakukan melalui sistem pembayaran resmi kami
                                (Midtrans). Pemesanan baru akan diproses setelah pembayaran berhasil dikonfirmasi. Kami
                                tidak bertanggung jawab atas kegagalan transaksi yang disebabkan oleh pihak bank atau
                                penyedia layanan pembayaran.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Kebijakan Pembatalan</h2>
                            <p class="leading-relaxed mb-4">Di Pink Tour and Travel, kami berkomitmen memberikan
                                pelayanan yang transparan dan mengutamakan kenyamanan pelanggan. Oleh karena itu,
                                kebijakan pembatalan perjalanan berlaku sebagai berikut:</p>

                            <p class="font-bold text-gray-900 mb-2">Pembatalan oleh Peserta</p>
                            <ul class="list-disc list-inside space-y-2 ml-4 mb-6 leading-relaxed">
                                <li>Pembatalan yang dilakukan lebih dari 21 hari sebelum tanggal keberangkatan akan
                                    dikenakan potongan biaya administrasi dan reservasi, sehingga pelanggan akan
                                    menerima pengembalian dana sebesar 90% dari total pembayaran.</li>
                                <li>Pembatalan yang dilakukan 7–21 hari sebelum tanggal keberangkatan akan dikenakan
                                    potongan biaya operasional, sehingga pelanggan akan menerima pengembalian dana
                                    sebesar 75% dari total pembayaran.</li>
                                <li>Pembatalan yang dilakukan kurang dari 7 hari sebelum tanggal keberangkatan akan
                                    dikenakan potongan biaya operasional dan reservasi yang telah diproses, sehingga
                                    pelanggan akan menerima pengembalian dana sebesar 50% dari total pembayaran.</li>
                            </ul>

                            <p class="font-bold text-gray-900 mb-2">Pembatalan oleh Pink Tour and Travel</p>
                            <p class="leading-relaxed">Apabila pembatalan perjalanan dilakukan oleh pihak Pink Tour and
                                Travel karena kendala operasional atau kondisi tertentu, maka pelanggan akan menerima
                                pengembalian dana 100% tanpa potongan apa pun.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Tanggung Jawab</h2>
                            <p class="leading-relaxed">Selama perjalanan berlangsung, kami akan berupaya memastikan
                                setiap layanan berjalan sesuai rencana. Namun, Pink Tour and Travel tidak bertanggung
                                jawab atas kerugian atau kendala yang terjadi akibat faktor di luar kendali perusahaan,
                                seperti kehilangan barang pribadi, kecelakaan, kondisi cuaca ekstrem, bencana alam,
                                gangguan transportasi, maupun kebijakan pemerintah (Force Majeure). Dalam situasi
                                tersebut, kami akan tetap berusaha memberikan bantuan dan solusi terbaik demi kenyamanan
                                peserta.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Perubahan Jadwal</h2>
                            <p class="leading-relaxed">Pink Tour and Travel selalu berkomitmen untuk memberikan
                                pengalaman perjalanan yang aman dan nyaman bagi setiap peserta. Oleh karena itu, kami
                                berhak melakukan penyesuaian terhadap jadwal maupun rencana perjalanan apabila
                                diperlukan, terutama apabila terjadi kondisi di lapangan yang berada di luar kendali
                                kami, seperti faktor cuaca, kondisi transportasi, atau situasi lainnya. Setiap perubahan
                                akan dikomunikasikan secara jelas kepada peserta demi menjaga kenyamanan dan kelancaran
                                perjalanan.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Ketepatan Waktu Keberangkatan</h2>
                            <p class="leading-relaxed">Peserta diharapkan hadir tepat waktu sesuai jadwal yang telah
                                ditentukan. Keterlambatan yang menyebabkan peserta tertinggal transportasi atau kegiatan
                                perjalanan menjadi tanggung jawab masing-masing peserta.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Kondisi Kesehatan Peserta</h2>
                            <p class="leading-relaxed">Peserta diharapkan memastikan kondisi kesehatan dalam keadaan
                                baik sebelum mengikuti perjalanan. Apabila memiliki kondisi kesehatan tertentu, peserta
                                wajib menginformasikannya kepada pihak Pink Tour and Travel sebelum keberangkatan.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Penggunaan Data Pribadi</h2>
                            <p class="leading-relaxed">Data pribadi pelanggan yang diberikan saat melakukan pemesanan
                                akan dijaga kerahasiaannya dan hanya digunakan untuk kebutuhan administrasi, reservasi
                                perjalanan, serta komunikasi terkait layanan Pink Tour and Travel.</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Konfirmasi Pembayaran dan Grup
                                Perjalanan</h2>
                            <p class="leading-relaxed">Peserta yang telah berhasil melakukan pembayaran dan
                                terverifikasi akan dihubungi oleh tim Pink Tour and Travel, kemudian dimasukkan ke dalam
                                grup perjalanan sesuai dengan jadwal keberangkatan yang dipilih untuk memudahkan
                                koordinasi dan penyampaian informasi perjalanan.</p>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-100 text-center">
                        <a href="{{ url()->previous() }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-[#020617] text-white rounded-2xl font-bold hover:bg-slate-900 transition-all shadow-lg shadow-slate-900/20">
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