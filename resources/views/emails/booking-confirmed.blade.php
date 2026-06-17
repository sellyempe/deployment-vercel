<x-mail::message>
# Pembayaran Berhasil & Booking Dikonfirmasi! 🎉

Halo {{ $booking->user->name }},

Terima kasih! Pembayaran Anda telah kami terima dan pesanan Anda telah resmi dikonfirmasi. Persiapkan diri Anda untuk petualangan seru bersama kami.

Kami telah melampirkan **E-Ticket (PDF)** pada email ini sebagai bukti reservasi resmi Anda.

**Detail Perjalanan:**
- **Trip:** {{ $booking->trip->title }}
- **Tanggal:** {{ $booking->preferred_date->format('d M Y') }}
- **Titik Temu:** {{ $booking->trip->meeting_point }}

**Ringkasan Pesanan:**
- **Order ID:** #{{ $booking->order_id }}
- **Jumlah Peserta:** {{ $booking->participants }} Orang
- **Total Pembayaran:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}
- **Status:** Lunas & Dikonfirmasi ✓

<x-mail::button :url="route('booking.show', $booking->id)" color="pink">
Lihat Detail Pesanan
</x-mail::button>

**Informasi Penting:**
- Harap simpan E-Ticket yang terlampir (bisa dicetak atau ditunjukkan lewat HP).
- Sampai di titik temu paling lambat 30 menit sebelum keberangkatan.
- Jika ada pertanyaan, hubungi tim kami via WhatsApp atau balas email ini.

Terima kasih telah memilih Pink Tour and Travel. Kami tidak sabar untuk menemani perjalanan Anda!

Salam Hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>
