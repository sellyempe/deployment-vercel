<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking {{ $trip->title ?? 'Paket Wisata' }} - PinkTravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_pink.css">
    <style>
        /* Minimal custom styling for Flatpickr - targeting library classes that Tailwind can't reach via HTML */
        .flatpickr-day.enabled-date { font-weight: 700 !important; color: #db2777 !important; }
        .flatpickr-day.enabled-date::after { content: ""; position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%); width: 4px; height: 4px; background: #db2777; border-radius: 50%; }
        .flatpickr-calendar { border-radius: 1rem !important; box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1) !important; border: 1px solid #f3f4f6 !important; }
        .flatpickr-current-month { font-size: 1.1rem !important; font-weight: 600 !important; display: flex !important; align-items: center !important; gap: 4px !important; }
        .flatpickr-monthDropdown-months { font-weight: 700 !important; padding: 2px 8px !important; border-radius: 0.5rem !important; }
        .flatpickr-prev-month:hover, .flatpickr-next-month:hover { background: #fdf2f8 !important; border-radius: 50% !important; }
        .flatpickr-prev-month:hover svg, .flatpickr-next-month:hover svg { fill: #db2777 !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
</head>

<body class="font-poppins bg-slate-50 text-slate-900">
    <div>
        <x-navbar :always-scrolled="true"></x-navbar>

        <section class="pt-32 pb-24 px-4 min-h-screen">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-pink-100/30 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none"></div>
                            
                            <h1 class="text-4xl font-extrabold text-slate-900 mb-2 relative z-10 tracking-tight">
                                Pesan <span class="text-pink-600">Wisata</span>
                            </h1>
                            <p class="text-slate-500 mb-10 relative z-10 text-lg">Lengkapi detail perjalanan Anda</p>

                            @if ($errors->any())
                            <div class="bg-red-50 border border-red-100 rounded-2xl p-6 mb-8">
                                <p class="text-red-800 font-bold mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Cek kembali data Anda:
                                </p>
                                <ul class="list-disc list-inside text-red-700 space-y-1 text-sm">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('booking.store') }}" method="POST" class="space-y-8 relative z-10">
                                @csrf
                                <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 space-y-4">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-500 font-medium">Paket</span>
                                        <span class="font-bold text-slate-900">{{ $trip->title }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-500 font-medium">Harga / Orang</span>
                                        <span class="font-bold text-pink-600">Rp {{ number_format($trip->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="pt-3 border-t border-slate-200 flex justify-between items-center">
                                        <span class="text-slate-500 font-medium">Sisa Kuota (<span id="quota-date-label" class="text-slate-400">Pilih Tanggal</span>)</span>
                                        <span class="font-bold text-slate-900"><span id="available-seats-display">--</span> kursi</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <label class="block text-sm font-bold text-slate-700">Tanggal Perjalanan</label>
                                        <div class="relative">
                                            <input type="text" id="date-selector" 
                                                data-available="{{ json_encode($trip->tripDates->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))->toArray()) }}"
                                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 outline-none transition-all cursor-pointer @error('preferred_date') border-red-500 @enderror"
                                                placeholder="Pilih tanggal..." readonly>
                                            <svg class="absolute right-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <input type="hidden" id="preferred_date" name="preferred_date" value="{{ old('preferred_date') }}">
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-sm font-bold text-slate-700">Jumlah Peserta</label>
                                        <input type="number" id="participants" name="participants" min="1" value="{{ old('participants', 1) }}"
                                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 outline-none transition-all"
                                            required>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-sm font-bold text-slate-700">Nomor Telepon WhatsApp</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="0812..."
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 outline-none transition-all"
                                        required>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-sm font-bold text-slate-700">Catatan Khusus (Opsional)</label>
                                    <textarea name="special_request" rows="3"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 outline-none transition-all resize-none">{{ old('special_request') }}</textarea>
                                </div>

                                <div class="bg-pink-600 rounded-3xl p-8 text-white shadow-xl shadow-pink-600/20">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-pink-100 text-sm font-medium mb-1">Total Estimasi</p>
                                            <p id="subtotal" class="text-3xl font-black">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
                                        </div>
                                        <button type="submit" id="submit-btn" 
                                            class="bg-white text-pink-600 px-8 py-4 rounded-2xl font-bold hover:bg-pink-50 transition-all shadow-lg active:scale-95 disabled:opacity-50 disabled:scale-100 flex items-center gap-2">
                                            Booking
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                <p class="text-center text-xs text-slate-400">
                                    Dengan mengklik Booking, Anda setuju dengan <a href="{{ route('terms') }}" class="underline hover:text-pink-600">Syarat & Ketentuan</a> kami.
                                </p>
                            </form>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-xl shadow-slate-200/50 sticky top-28 space-y-6">
                            <div class="aspect-video rounded-3xl overflow-hidden shadow-inner">
                                <img src="{{ format_image_url($trip->image) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 leading-tight mb-2">{{ $trip->title }}</h3>
                                <div class="flex items-center gap-2 text-slate-500 text-sm">
                                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $trip->destination }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-footer></x-footer>
    </div>

    <script>
    const pricePerPerson = Number("{{ $trip->price }}");
    const checkAvailabilityUrl = "{{ url('/booking/check-availability') }}";
    const tripId = "{{ $trip->id }}";
    
    let currentMaxParticipants = 0;

    document.addEventListener('DOMContentLoaded', function() {
        const selector = document.getElementById('date-selector');
        const availableDates = JSON.parse(selector.dataset.available || '[]');
        const participantsInput = document.getElementById('participants');
        const subtotalDisplay = document.getElementById('subtotal');
        const dateHiddenInput = document.getElementById('preferred_date');
        const seatsDisplay = document.getElementById('available-seats-display');
        const quotaDateLabel = document.getElementById('quota-date-label');
        const submitBtn = document.getElementById('submit-btn');

        // Initialize Flatpickr
        let fp = flatpickr("#date-selector", {
            locale: "id",
            dateFormat: "D, d M Y",
            disableMobile: true,
            enable: [
                function(date) {
                    const dateStr = date.getFullYear() + "-" + 
                                  String(date.getMonth() + 1).padStart(2, '0') + "-" + 
                                  String(date.getDate()).padStart(2, '0');
                    return availableDates.includes(dateStr);
                }
            ],
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    const dateVal = instance.formatDate(selectedDates[0], "Y-m-d");
                    if (dateHiddenInput) dateHiddenInput.value = dateVal;
                    checkAvailability(dateVal);
                }
            },
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");
                if (availableDates.includes(dateStr)) {
                    dayElem.classList.add("enabled-date");
                }
            }
        });

        async function checkAvailability(selectedDate) {
            seatsDisplay.innerHTML = '<span class="animate-pulse text-slate-300">...</span>';
            quotaDateLabel.textContent = new Date(selectedDate).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            submitBtn.disabled = true;

            try {
                const response = await fetch(`${checkAvailabilityUrl}?trip_id=${tripId}&date=${selectedDate}`);
                const data = await response.json();

                currentMaxParticipants = Number(data.available_seats);
                seatsDisplay.textContent = currentMaxParticipants;
                
                if (currentMaxParticipants === 0) {
                    seatsDisplay.className = "text-red-500 font-bold";
                    submitBtn.innerHTML = 'Penuh';
                } else {
                    seatsDisplay.className = "text-slate-900 font-bold";
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Booking <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>';
                    calculateTotal();
                }
            } catch (error) {
                seatsDisplay.textContent = 'Error';
            }
        }

        function calculateTotal() {
            let p = parseInt(participantsInput.value) || 1;
            if (p > currentMaxParticipants && currentMaxParticipants > 0) {
                p = currentMaxParticipants;
                participantsInput.value = p;
            }
            const total = pricePerPerson * p;
            subtotalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        participantsInput.addEventListener('input', calculateTotal);
        
        if (dateHiddenInput.value) {
            fp.setDate(dateHiddenInput.value);
            checkAvailability(dateHiddenInput.value);
        }
    });
    </script>
</body>
</html>