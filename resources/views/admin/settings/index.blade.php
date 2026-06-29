@php
$categoryTranslations = [
'general' => 'Pengaturan Umum',
'contact' => 'Pengaturan Kontak',
];

$labelTranslations = [
'Site Name' => 'Nama Website',
'Site Logo' => 'Logo Website',
'Site Description' => 'Deskripsi Website',
'Contact Email' => 'Email Kontak',
'Contact Phone' => 'Telepon Kontak',
'WhatsApp Number' => 'Nomor WhatsApp',
'Contact Address' => 'Alamat Kantor',
];

$descriptionTranslations = [
'The name of the website.' => 'Nama utama dari website pariwisata ini.',
'The logo of the website.' => 'Logo resmi website pariwisata.',
'A brief description of the website for the footer and SEO.' => 'Penjelasan singkat tentang website untuk bagian kaki
(footer) dan optimasi mesin pencari (SEO).',
'Primary contact email address.' => 'Alamat email utama perusahaan untuk korespondensi pelanggan.',
'Primary contact phone number.' => 'Nomor telepon utama perusahaan yang dapat dihubungi.',
'WhatsApp number for direct contact (format: 628...).' => 'Nomor WhatsApp untuk percakapan langsung dengan admin
(format: 628...).',
'Physical address of the company.' => 'Alamat fisik kantor atau kantor pusat perusahaan.',
];
@endphp

<x-admin-layout title="Pengaturan Website" active="settings">
    <div class="max-w-4xl">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @foreach($settings as $category => $items)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="font-bold text-[#132440] uppercase tracking-wider text-xs">
                        {{ $categoryTranslations[strtolower($category)] ?? ucfirst($category) }}
                    </h3>
                </div>

                <div class="p-6 space-y-6">
                    @foreach($items as $setting)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <div>
                            <label class="block text-sm font-semibold text-[#132440]">
                                {{ $labelTranslations[$setting->label] ?? $setting->label }}
                            </label>
                            @if($setting->description)
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $descriptionTranslations[$setting->description] ?? $setting->description }}
                            </p>
                            @endif
                        </div>

                        <div class="md:col-span-2">
                            @if($setting->type === 'string')
                            <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-500/20 transition-all text-sm">
                            @elseif($setting->type === 'text')
                            <textarea name="{{ $setting->key }}" rows="3"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-500/20 transition-all text-sm">{{ $setting->value }}</textarea>
                            @elseif($setting->type === 'image')
                            <div class="flex items-center gap-4">
                                @if($setting->value)
                                <div class="w-16 h-16 rounded-lg overflow-hidden border border-gray-100 bg-gray-50">
                                    <img src="{{ asset($setting->value) }}" alt="{{ $setting->label }}"
                                        class="w-full h-full object-contain">
                                </div>
                                @endif
                                <input type="file" name="{{ $setting->key }}"
                                    class="flex-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="flex justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-[#EC008C] hover:bg-pink-600 text-white rounded-xl font-bold shadow-lg shadow-pink-600/20 transition-all hover:-translate-y-0.5">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>