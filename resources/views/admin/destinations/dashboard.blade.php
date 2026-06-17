<x-admin-layout title="Kelola Destinasi" active="destinations">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-white">Destinasi Wisata</h2>
            <p class="text-sm text-gray-500">{{ $destinations->count() }} destinasi terdaftar</p>
        </div>
        <a href="{{ route('admin.destinations.create') }}"
            class="flex items-center gap-2 px-5 py-2.5 bg-[#132440] hover:bg-[#1B365D] text-white text-sm font-semibold rounded-xl transition shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Destinasi
        </a>
    </div>

    @if($destinations->isEmpty())
    <div class="bg-gray-900 border border-white/5 rounded-2xl py-20 text-center">
        <div class="text-5xl mb-4">📍</div>
        <p class="text-gray-500 font-medium">Belum ada destinasi</p>
        <a href="{{ route('admin.destinations.create') }}"
            class="inline-block mt-3 text-pink-400 hover:text-pink-300 text-sm font-medium">
            + Tambah destinasi pertama
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($destinations as $destination)
        <div
            class="bg-[#16476A] rounded-[28px] overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 group">

            <div class="relative h-64 overflow-hidden">
                @if($destination->image)
                <img src="{{ $destination->image }}" alt="{{ $destination->name }}"
                    class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full bg-[#16476A] flex items-center justify-center">
                    <span class="text-5xl text-white/30">📍</span>
                </div>
                @endif

                <div class="absolute top-4 right-4 z-10">
                    @if($destination->status === 'active')
                    <span
                        class="px-4 py-1.5 rounded-full bg-emerald-400/20 border border-emerald-300/30 text-emerald-300 text-sm font-semibold backdrop-blur-sm">
                        Aktif
                    </span>
                    @else
                    <span
                        class="px-4 py-1.5 rounded-full bg-gray-400/20 border border-white/20 text-white text-sm font-semibold backdrop-blur-sm">
                        Nonaktif
                    </span>
                    @endif
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-3 font-bold text-white mb-2">
                    {{ $destination->name }}
                </h3>

                <p class="text-pink-400 text-sm flex items-center gap-1 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $destination->location }}
                </p>

                <p class="text-white/90 text-sm leading-relaxed mb-5 line-clamp-2">
                    {{ $destination->description }}
                </p>

                <div class="flex gap-3">
                    <a href="{{ route('admin.destinations.edit', $destination->id) }}"
                        class="flex-1 flex items-center justify-center gap-2 py-3 rounded-2xl bg-[#255B8A] hover:bg-[#2F6EA4] text-blue-300 font-semibold transition">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('admin.destinations.destroy', $destination->id) }}"
                        onsubmit="return confirm('Hapus destinasi {{ addslashes($destination->name) }}?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="px-6 py-3 rounded-2xl bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</x-admin-layout>