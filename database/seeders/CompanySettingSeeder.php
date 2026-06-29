<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Pink Tour and Travel',
                'type' => 'string',
                'label' => 'Nama Website',
                'description' => 'Nama utama dari website pariwisata ini.',
                'category' => 'general',
            ],
            [
                'key' => 'site_logo',
                'value' => 'images/logo-pinktravel.png',
                'type' => 'image',
                'label' => 'Logo Website',
                'description' => 'Logo resmi website pariwisata.',
                'category' => 'general',
            ],
            [
                'key' => 'contact_email',
                'value' => 'pinktourandtravel@gmail.com',
                'type' => 'string',
                'label' => 'Email Kontak',
                'description' => 'Alamat email utama perusahaan untuk korespondensi pelanggan.',
                'category' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 852 9821 0193',
                'type' => 'string',
                'label' => 'Telepon Kontak',
                'description' => 'Nomor telepon utama perusahaan yang dapat dihubungi.',
                'category' => 'contact',
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '6282115249423',
                'type' => 'string',
                'label' => 'Nomor WhatsApp',
                'description' => 'Nomor WhatsApp untuk percakapan langsung dengan admin (format: 628...).',
                'category' => 'contact',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Makassar, Indonesia',
                'type' => 'text',
                'label' => 'Alamat Kantor',
                'description' => 'Alamat fisik kantor atau kantor pusat perusahaan.',
                'category' => 'contact',
            ],
            [
                'key' => 'site_description',
                'value' => 'Jelajahi destinasi impian Anda bersama kami dengan paket wisata terpercaya dan berpengalaman.',
                'type' => 'text',
                'label' => 'Deskripsi Website',
                'description' => 'Penjelasan singkat tentang website untuk bagian kaki (footer) dan optimasi mesin pencari (SEO).',
                'category' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            CompanySetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}