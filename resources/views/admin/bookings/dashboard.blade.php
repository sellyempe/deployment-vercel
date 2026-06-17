<x-admin-layout title="Manajemen Pemesanan" active="bookings">
    @php
    $statusCfg = [
    'all' => ['label' => 'Total', 'color' => 'gray'],
    'pending' => ['label' => 'Menunggu', 'color' => 'yellow'],
    'confirmed' => ['label' => 'Dikonfirmasi', 'color' => 'green'],
    'completed' => ['label' => 'Selesai', 'color' => 'blue'],
    'cancelled' => ['label' => 'Dibatalkan', 'color' => 'red'],
    ];

    $totalAll = $counts->sum();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
        @foreach($statusCfg as $key => $cfg)
        <a href="{{ route('admin.bookings.dashboard', ['status' => $key]) }}" class="bg-[#16476A] border rounded-2xl p-4 text-center transition
                {{ $status === $key ? 'border-pink-500/50' : 'border-transparent hover:border-white/10' }}">
            <p class="text-2xl font-bold text-white">{{ $key === 'all' ? $totalAll : ($counts[$key] ?? 0) }}</p>
            <p class="text-xs text-white/80 mt-0.5">
                {{ $cfg['label'] }}
            </p>
        </a>
        @endforeach
    </div>

    <div class="flex flex-wrap gap-2 mb-5">
        @foreach($statusCfg as $key => $cfg)
        <a href="{{ route('admin.bookings.dashboard', ['status' => $key]) }}" class="px-4 py-1.5 rounded-full text-xs font-semibold transition
                {{ $status === $key ? 'bg-pink-600 text-white' : 'bg-[#16476A] text-white hover:bg-[#1B547D]' }}">
            {{ $cfg['label'] }}
        </a>
        @endforeach
    </div>

    @if(in_array($status, ['completed', 'confirmed', 'cancelled']))
    <div class="mb-5">
        <a href="{{ route('admin.bookings.export', ['status' => $status]) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span>Export Excel</span>
        </a>
    </div>
    @endif

    <div class="bg-[#16476A] border border-white/5 rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/10 text-left bg-[#0D2340]">
                    <th class="px-5 py-4 text-xs font-semibold text-white uppercase tracking-wider">ID Pemesanan</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white uppercase tracking-wider">Pelanggan</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white uppercase tracking-wider">Trip</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white uppercase tracking-wider">Peserta</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white uppercase tracking-wider">Total</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                    <th class="px-5 py-4 text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.03]">
                @forelse($bookings as $booking)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-5 py-4 font-mono text-xs text-gray-500">{{ Str::limit($booking->order_id, 16) }}</td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-white text-sm">{{ $booking->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->user->email ?? '' }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-medium text-gray-200 text-sm">{{ Str::limit($booking->trip->title ?? '-', 30) }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $booking->trip->departure_city ?? '' }} →
                            {{ $booking->trip->destination ?? '' }}
                        </p>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="font-bold text-white">{{ $booking->participants }}</span>
                        <span class="text-gray-600 text-xs">org</span>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </p>
                    </td>
                    <td class="px-5 py-4 text-gray-500 text-xs">
                        {{ $booking->created_at->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4">
                        @php
                        $badge = match($booking->status) {
                        'confirmed' => 'bg-emerald-500/10 text-emerald-400',
                        'pending' => 'bg-yellow-500/10 text-yellow-400',
                        'completed' => 'bg-blue-500/10 text-blue-400',
                        'cancelled' => 'bg-red-500/10 text-red-400',
                        default => 'bg-gray-500/10 text-gray-400',
                        };
                        $statusLabel = match($booking->status) {
                        'confirmed' => 'Dikonfirmasi',
                        'pending' => 'Menunggu',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($booking->status),
                        };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        @if($booking->status === 'confirmed')
                        <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}"
                            onsubmit="return confirm('Tandai pemesanan ini sebagai selesai?')">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 text-xs font-semibold rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Selesai
                            </button>
                        </form>
                        @else
                        <span class="text-gray-700 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center bg-[#16476A]">
                        <div class="text-gray-500 mb-3 flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-white font-medium">
                            Tidak ada pemesanan dengan filter ini
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $bookings->links() }}
    </div>
    @endif
</x-admin-layout>