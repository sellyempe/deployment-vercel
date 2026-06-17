<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Review;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $trips = Trip::all();
        $destinations = Destination::all();

        if ($users->isEmpty() || ($trips->isEmpty() && $destinations->isEmpty())) {
            return;
        }

        $comments = [
            'Pengalaman yang luar biasa! Pemandu wisata sangat profesional dan ramah.',
            'Destinasi yang indah, pelayanan terbaik. Highly recommended!',
            'Paket wisata yang sangat worth it. Akan booking lagi.',
            'Pemandangan spektakuler, organisasi yang rapi. Terima kasih!',
            'Liburan paling seru bersama keluarga. Terima kasih PinkTravel!',
            'Semua detail diperhatikan dengan baik. Sangat puas dengan layanannya.',
            'Destinasi eksotis dengan harga yang terjangkau. Sempurna!',
            'Pemandu lokal yang sangat berpengetahuan. Pengalaman tak terlupakan.',
            'Acara berjalan lancar sesuai jadwal. Sangat memuaskan!',
            'Paket wisata yang komprehensif dengan fasilitas lengkap.',
        ];

        // Reviews untuk Trips
        foreach ($trips as $trip) {
            for ($i = 0; $i < rand(2, 4); $i++) {
                Review::create([
                    'user_id' => $users->random()->id,
                    'reviewable_type' => Trip::class,
                    'reviewable_id' => $trip->id,
                    'rating' => rand(4, 5),
                    'comment' => $comments[array_rand($comments)],
                    'status' => 'approved',
                ]);
            }
        }

        // Reviews untuk Destinations
        foreach ($destinations as $destination) {
            for ($i = 0; $i < rand(2, 5); $i++) {
                Review::create([
                    'user_id' => $users->random()->id,
                    'reviewable_type' => Destination::class,
                    'reviewable_id' => $destination->id,
                    'rating' => rand(3, 5),
                    'comment' => $comments[array_rand($comments)],
                    'status' => 'approved',
                ]);
            }
        }
    }
}
