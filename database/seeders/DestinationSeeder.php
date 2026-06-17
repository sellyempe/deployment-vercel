<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Benteng Belgica',
                'description' => 'Benteng bersejarah yang dibangun oleh Belanda pada tahun 1611 di Banda Neira',
                'interesting_fact' => 'Benteng Belgica merupakan benteng tertua di Kepulauan Banda dan masih berdiri kokoh hingga saat ini. Benteng ini pernah menjadi markas perangkat militer Belanda dan kini menjadi salah satu destinasi wisata bersejarah paling penting di Indonesia. Dari atas benteng, pengunjung dapat melihat pemandangan laut yang spektakuler.',
                'category' => 'Bersejarah',
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Benteng Nassau',
                'description' => 'Benteng pertahanan bersejarah yang berlokasi strategis di Kepulauan Banda',
                'interesting_fact' => 'Benteng Nassau dibangun untuk mengamankan jalur perdagangan rempah-rempah yang sangat berharga pada abad ke-17. Sisa-sisa benteng ini masih dapat dilihat dan menjadi saksi bisu dari kehidupan masa lalu yang penuh dengan intrik perdagangan dan perang untuk menguasai sumber daya rempah.',
                'category' => 'Bersejarah',
                'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Istana Mini Banda',
                'description' => 'Istana kecil dengan arsitektur kolonial yang masih terjaga dengan baik',
                'interesting_fact' => 'Istana Mini Banda adalah contoh sempurna dari arsitektur kolonial Belanda yang dipadukan dengan gaya lokal. Bangunan ini pernah menjadi tempat tinggal para pejabat tinggi Belanda dan kini menjadi museum yang menampilkan koleksi benda-benda bersejarah dari era kolonial.',
                'category' => 'Budaya',
                'image' => 'https://images.unsplash.com/photo-1518156677180-95a2893f3e9f?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Rumah Pengasingan Hatta',
                'description' => 'Rumah bersejarah tempat Bung Hatta diasingkan selama penjajahan Belanda',
                'interesting_fact' => 'Mohammad Hatta, salah satu proklamator kemerdekaan Indonesia, diasingkan di Banda Neira selama bertahun-tahun oleh pemerintah Belanda. Rumah ini kini menjadi monumen penting yang menceritakan kisah perjuangan para pahlawan nasional melawan penjajahan.',
                'category' => 'Bersejarah',
                'image' => 'https://images.unsplash.com/photo-1534632066927-ab7c9ab60908?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Pulau Hatta',
                'description' => 'Pulau kecil yang indah dengan pantai pasir putih dan terumbu karang',
                'interesting_fact' => 'Pulau Hatta dinamakan untuk menghormati Mohammad Hatta dan merupakan bagian dari Taman Nasional Banda. Pulau ini terkenal dengan keindahan bawah lautnya yang spektakuler, menjadikannya destinasi diving dan snorkeling terbaik di kawasan Kepulauan Banda. Terumbu karang yang masih perawan menjadi daya tarik utama.',
                'category' => 'Diving & Snorkeling',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Pulau Sjahrir',
                'description' => 'Pulau bersejarah yang dinamakan dari nama Perdana Menteri Indonesia pertama',
                'interesting_fact' => 'Sutan Sjahrir adalah Perdana Menteri pertama Indonesia dan pernah diasingkan di Banda Neira. Pulau ini dinamakan untuk mengenangnya dan kini menjadi spot snorkeling yang populer dengan kehidupan laut yang sangat kaya dan beragam.',
                'category' => 'Diving & Snorkeling',
                'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Lava Flow',
                'description' => 'Formasi lava batuan unik yang terbentuk dari aktivitas vulkanik masa lalu',
                'interesting_fact' => 'Lava Flow adalah bukti nyata dari aktivitas vulkanik yang pernah terjadi di Kepulauan Banda jutaan tahun yang lalu. Batuan lava ini membentuk pemandangan yang sangat dramatis dan unik, sehingga menjadi spot fotografi favorit para wisatawan dan pengunjung yang tertarik dengan geologi.',
                'category' => 'Alam',
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Pulau Karaka',
                'description' => 'Pulau kecil dengan kehidupan laut yang kaya dan coral garden yang menakjubkan',
                'interesting_fact' => 'Pulau Karaka terkenal sebagai salah satu spot diving terbaik di Kepulauan Banda dengan kondisi terumbu karang yang masih asri dan ikan-ikan besar yang sering ditemui. Kedalaman diving yang variatif membuat spot ini cocok untuk diver pemula hingga profesional.',
                'category' => 'Diving & Snorkeling',
                'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Gunung Api Banda',
                'description' => 'Gunung berapi aktif yang dapat dilihat dari sebagian besar pulau di Kepulauan Banda',
                'interesting_fact' => 'Gunung Api Banda adalah gunung berapi aktif yang menjadi landmark geografis Kepulauan Banda. Meskipun masih aktif, gunung ini dapat didaki dan menawarkan pemandangan yang spektakuler dari puncaknya. Pada malam hari, kilau lava dari kawah dapat terlihat dengan jelas, menciptakan pemandangan yang sangat menakjubkan.',
                'category' => 'Alam',
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
            [
                'name' => 'Pohon Sejuta Umat',
                'description' => 'Pohon tua yang memiliki makna religius dan historis bagi masyarakat lokal',
                'interesting_fact' => 'Pohon Sejuta Umat adalah pohon purba yang telah berdiri selama ratusan tahun dan memiliki makna spiritual yang mendalam bagi penduduk Banda Neira. Pohon ini dipercaya membawa berkah dan menjadi tempat ziarah spiritual. Bagian bawah pohon menampilkan cukilan dan inskripsi dari berbagai periode sejarah.',
                'category' => 'Budaya',
                'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400&h=300&fit=crop',
                'location' => 'Banda Neira',
            ],
        ];

        foreach ($destinations as $destination) {
            $categoryName = $destination['category'];
            unset($destination['category']);

            $category = Category::where('category_name', $categoryName)
                ->where('category_type', 1)
                ->first();

            Destination::create(array_merge($destination, [
                'category_id' => $category ? $category->id : null,
                'category' => $categoryName,
                'status' => 'active',
            ]));
        }
    }
}
