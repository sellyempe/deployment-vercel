<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Trip;
use App\Models\TripDate;
use App\Models\TripExclude;
use App\Models\TripInclude;
use App\Models\TripItinerary;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $trips = [
            [
                'departure' => 'Jakarta',
                'meeting_point' => 'Terminal 3 Bandara Soekarno Hatta',
                'meeting_address' => 'Tangerang, Banten',
                'price' => 4500000,
                'image' => 'https://images.unsplash.com/photo-1528127269915-426fcf759973?w=800',
            ],
            [
                'departure' => 'Surabaya',
                'meeting_point' => 'Terminal 2 Bandara Juanda',
                'meeting_address' => 'Surabaya, Jawa Timur',
                'price' => 3800000,
                'image' => 'https://images.unsplash.com/photo-1537225228614-56cc30d1eb5b?w=800',
            ],
            [
                'departure' => 'Ambon',
                'meeting_point' => 'Terminal Bandara Pattimura',
                'meeting_address' => 'Ambon, Maluku',
                'price' => 2500000,
                'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
            ],
            [
                'departure' => 'Makassar',
                'meeting_point' => 'Terminal Bandara Hasanuddin',
                'meeting_address' => 'Makassar, Sulawesi Selatan',
                'price' => 3200000,
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800',
            ],
        ];

        foreach ($trips as $tripData) {
            $trip = Trip::create([
                'title' => $tripData['departure'].' - Banda Neira 3D2N',
                'description' => 'Paket wisata lengkap dari '.$tripData['departure'].' menuju Banda Neira. Nikmati keindahan laut, sejarah peradaban, dan kuliner lokal yang autentik.',
                'overview' => 'Paket wisata eksklusif dengan akomodasi bintang 3, transportasi penuh, pemandu wisata berpengalaman, dan semua meals included.',
                'departure_city' => $tripData['departure'],
                'destination' => 'Banda Neira',
                'meeting_point' => $tripData['meeting_point'],
                'meeting_address' => $tripData['meeting_address'],
                'price' => $tripData['price'],
                'duration_days' => 3,
                'image' => $tripData['image'],
                'status' => 'active',
            ]);

            $dates = [
                ['date' => now()->addDays(14)->format('Y-m-d'), 'kuota' => 10],
                ['date' => now()->addDays(21)->format('Y-m-d'), 'kuota' => 15],
                ['date' => now()->addDays(28)->format('Y-m-d'), 'kuota' => 12],
            ];

            foreach ($dates as $date) {
                TripDate::create([
                    'trip_id' => $trip->id,
                    'date' => $date['date'],
                    'kuota' => $date['kuota'],
                ]);
            }

            TripItinerary::create([
                'trip_id' => $trip->id,
                'day_number' => 1,
                'title' => 'Pemberangkatan & Tiba di Banda Neira',
                'description' => 'Pemberangkatan dari '.$tripData['departure'].', perjalanan menuju Banda Neira, dan check-in penginapan.',
                'activities' => [
                    ['time' => '06:00', 'activity' => 'Gathering di Meeting Point', 'description' => 'Kumpul dan persiapan dokumen'],
                    ['time' => '07:00', 'activity' => 'Check-in Penerbangan', 'description' => 'Proses check-in dan boarding'],
                    ['time' => '09:00', 'activity' => 'Terbang ke Banda Neira', 'description' => 'Penerbangan dengan Garuda atau Lion Air'],
                    ['time' => '12:00', 'activity' => 'Tiba di Banda Neira', 'description' => 'Penjemputan dan transfer ke penginapan'],
                    ['time' => '13:30', 'activity' => 'Check-in Penginapan & Istirahat', 'description' => 'Refreshing setelah perjalanan'],
                    ['time' => '15:00', 'activity' => 'Jalan-Jalan Santai di Desa', 'description' => 'Melihat suasana lokal dan kehidupan sehari-hari'],
                    ['time' => '18:00', 'activity' => 'Makan Malam Lokal', 'description' => 'Cicipi hidangan tradisional Banda Neira'],
                ],
            ]);

            // Itinerary Day 2: Eksplorasi Banda Neira
            TripItinerary::create([
                'trip_id' => $trip->id,
                'day_number' => 2,
                'title' => 'Eksplorasi Sejarah & Keindahan Laut',
                'description' => 'Kunjungi benteng bersejarah, snorkeling, dan menikmati sunset di Banda Neira.',
                'activities' => [
                    ['time' => '07:00', 'activity' => 'Sarapan di Penginapan', 'description' => 'Buffet sarapan tradisional'],
                    ['time' => '08:00', 'activity' => 'Kunjungi Benteng Belgica', 'description' => 'Melihat peninggalan VOC yang masih kokoh berdiri'],
                    ['time' => '10:00', 'activity' => 'Kunjungi Benteng Nassau', 'description' => 'Benteng bersejarah di pulau Ay'],
                    ['time' => '12:00', 'activity' => 'Makan Siang di Pinggir Pantai', 'description' => 'Menu seafood segar hasil tangkapan lokal'],
                    ['time' => '13:30', 'activity' => 'Snorkeling di Pulau Hatta', 'description' => 'Menjelajahi keindahan bawah laut dengan terumbu karang yang masih alami'],
                    ['time' => '16:00', 'activity' => 'Lihat Sunset di Pantai', 'description' => 'Berfoto dengan latar belakang matahari terbenam yang menakjubkan'],
                    ['time' => '18:30', 'activity' => 'Makan Malam & Istirahat', 'description' => 'Rest & relax setelah aktivitas seharian'],
                ],
            ]);

            // Itinerary Day 3: Penutup & Kepulangan
            TripItinerary::create([
                'trip_id' => $trip->id,
                'day_number' => 3,
                'title' => 'Aktivitas Pagi & Kepulangan',
                'description' => 'Aktivitas pagi hari sebelum berangkat pulang ke '.$tripData['departure'].'.',
                'activities' => [
                    ['time' => '07:00', 'activity' => 'Sarapan Terakhir', 'description' => 'Sarapan di penginapan dengan pemandangan pantai'],
                    ['time' => '08:30', 'activity' => 'Kunjungi Rumah Pengasingan Hatta', 'description' => 'Belajar sejarah perjuangan di rumah bersejarah ini'],
                    ['time' => '10:00', 'activity' => 'Belanja Souvenir Lokal', 'description' => 'Membeli oleh-oleh khas Banda Neira (cengkeh, pala, dll)'],
                    ['time' => '11:30', 'activity' => 'Check-out Penginapan', 'description' => 'Persiapan kepulangan dan packing'],
                    ['time' => '12:30', 'activity' => 'Makan Siang Terakhir', 'description' => 'Lunch sebelum terbang pulang'],
                    ['time' => '14:00', 'activity' => 'Transfer ke Bandara & Penerbangan', 'description' => 'Berangkat kembali ke '.$tripData['departure'].''],
                    ['time' => '17:00', 'activity' => 'Tiba di '.$tripData['departure'], 'description' => 'Perjalanan berakhir, terima kasih telah mempercayai kami'],
                ],
            ]);

            // Includes
            $includes = [
                ['item_name' => 'Tiket Penerbangan Round Trip', 'category' => 'Flights'],
                ['item_name' => 'Penginapan 2 Malam (Hotel Bintang 3)', 'category' => 'Accommodation'],
                ['item_name' => 'Transportasi Lokal (Mobil & Kapal)', 'category' => 'Transport'],
                ['item_name' => 'Pemandu Wisata Profesional Berbahasa Indonesia', 'category' => 'Guide'],
                ['item_name' => 'Semua Tiket Masuk Benteng & Museum', 'category' => 'Tickets'],
                ['item_name' => 'Paket Snorkeling (Equipment & Instruktur)', 'category' => 'Activities'],
                ['item_name' => 'Sarapan 2x', 'category' => 'Meals'],
                ['item_name' => 'Makan Siang 3x', 'category' => 'Meals'],
                ['item_name' => 'Makan Malam 2x', 'category' => 'Meals'],
                ['item_name' => 'Asuransi Perjalanan & Asuransi Snorkeling', 'category' => 'Insurance'],
                ['item_name' => 'Welcome Drink & Closing Ceremony', 'category' => 'Others'],
            ];

            foreach ($includes as $include) {
                $category = Category::where('category_name', $include['category'])
                    ->where('category_type', 2)
                    ->first();

                TripInclude::create([
                    'trip_id' => $trip->id,
                    'item_name' => $include['item_name'],
                    'category' => $include['category'],
                    'category_id' => $category ? $category->id : null,
                ]);
            }

            // Excludes
            $excludes = [
                ['item_name' => 'Minuman & Makanan Tambahan', 'category' => 'Beverages'],
                ['item_name' => 'Tips untuk Guide & Crew', 'category' => 'Gratuity'],
                ['item_name' => 'Biaya Pribadi (Spa, Massage, dll)', 'category' => 'Personal'],
                ['item_name' => 'Barang Pribadi & Perlengkapan', 'category' => 'Personal'],
                ['item_name' => 'Aktivitas Tambahan di Luar Paket', 'category' => 'Extra'],
                ['item_name' => 'Biaya Dokumentasi Profesional', 'category' => 'Media'],
            ];

            foreach ($excludes as $exclude) {
                $category = Category::where('category_name', $exclude['category'])
                    ->where('category_type', 3)
                    ->first();

                TripExclude::create([
                    'trip_id' => $trip->id,
                    'item_name' => $exclude['item_name'],
                    'category' => $exclude['category'],
                    'category_id' => $category ? $category->id : null,
                ]);
            }
        }
    }
}
