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
                'label' => 'Site Name',
                'description' => 'The name of the website.',
                'category' => 'general',
            ],
            [
                'key' => 'site_logo',
                'value' => 'images/logo-pinktravel.png',
                'type' => 'image',
                'label' => 'Site Logo',
                'description' => 'The logo of the website.',
                'category' => 'general',
            ],
            [
                'key' => 'contact_email',
                'value' => 'pinktourandtravel@gmail.com',
                'type' => 'string',
                'label' => 'Contact Email',
                'description' => 'Primary contact email address.',
                'category' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 852 9821 0193',
                'type' => 'string',
                'label' => 'Contact Phone',
                'description' => 'Primary contact phone number.',
                'category' => 'contact',
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '6282115249423',
                'type' => 'string',
                'label' => 'WhatsApp Number',
                'description' => 'WhatsApp number for direct contact (format: 628...).',
                'category' => 'contact',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Makassar, Indonesia',
                'type' => 'text',
                'label' => 'Contact Address',
                'description' => 'Physical address of the company.',
                'category' => 'contact',
            ],
            [
                'key' => 'site_description',
                'value' => 'Jelajahi destinasi impian Anda bersama kami dengan paket wisata terpercaya dan berpengalaman.',
                'type' => 'text',
                'label' => 'Site Description',
                'description' => 'A brief description of the website for the footer and SEO.',
                'category' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            CompanySetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
