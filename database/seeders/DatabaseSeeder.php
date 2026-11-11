<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Akun Admin ----------
        User::updateOrCreate(
            ['email' => 'admin@warungfajar.test'],
            [
                'name'     => 'Admin Warung Fajar',
                'password' => Hash::make('password123'),
            ]
        );

        // ---------- Kategori ----------
        $categoryData = [
            'sembako-pokok'         => ['Sembako Pokok', '🌾'],
            'bumbu-dapur'           => ['Bumbu Dapur', '🧂'],
            'minuman-snack'         => ['Minuman & Snack', '🥤'],
            'kebutuhan-rumah-tangga' => ['Kebutuhan Rumah Tangga', '🧼'],
            'mie-makanan-instan'    => ['Mie & Makanan Instan', '🍜'],
        ];

        $categoryIds = [];
        foreach ($categoryData as $slug => [$name, $icon]) {
            $categoryIds[$slug] = Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'icon' => $icon]
            )->id;
        }

        // ---------- Produk (harga dummy, silakan sesuaikan) ----------
        $products = [
            // Sembako Pokok
            ['sembako-pokok', 'Beras Premium', 15000, 'kg', 'Beras pulen wangi kualitas premium, cocok untuk konsumsi harian keluarga.'],
            ['sembako-pokok', 'Minyak Goreng', 17000, 'liter', 'Minyak goreng jernih, tidak mudah berbusa, hemat untuk menggoreng.'],
            ['sembako-pokok', 'Gula Pasir', 17000, 'kg', 'Gula pasir putih bersih dengan rasa manis murni.'],
            ['sembako-pokok', 'Telur Ayam', 28000, 'kg', 'Telur ayam negeri segar, dipilih setiap hari.'],
            ['sembako-pokok', 'Tepung Terigu', 12000, 'kg', 'Tepung terigu serbaguna untuk kue, gorengan, dan roti.'],
            ['sembako-pokok', 'Garam Beryodium', 4000, 'pcs', 'Garam halus beryodium kemasan 250 gram.'],

            // Bumbu Dapur
            ['bumbu-dapur', 'Bawang Merah', 40000, 'kg', 'Bawang merah segar ukuran sedang, aroma kuat.'],
            ['bumbu-dapur', 'Bawang Putih', 38000, 'kg', 'Bawang putih kating, siung besar dan padat.'],
            ['bumbu-dapur', 'Cabai Rawit', 60000, 'kg', 'Cabai rawit merah segar dengan rasa pedas mantap.'],
            ['bumbu-dapur', 'Kecap Manis', 14000, 'botol', 'Kecap manis kental kemasan botol 520 ml.'],
            ['bumbu-dapur', 'Saus Sambal', 12000, 'botol', 'Saus sambal pedas manis kemasan botol 340 ml.'],
            ['bumbu-dapur', 'Merica Bubuk', 3000, 'pcs', 'Merica bubuk sachet untuk penyedap alami masakan.'],

            // Minuman & Snack
            ['minuman-snack', 'Air Mineral 600 ml', 3500, 'botol', 'Air mineral segar kemasan botol 600 ml.'],
            ['minuman-snack', 'Teh Celup', 8000, 'pcs', 'Teh celup isi 25 kantong, harum dan segar.'],
            ['minuman-snack', 'Kopi Sachet', 2000, 'pcs', 'Kopi instan sachet praktis, siap seduh kapan saja.'],
            ['minuman-snack', 'Biskuit Kelapa', 9000, 'pcs', 'Biskuit renyah rasa kelapa, cocok untuk camilan keluarga.'],
            ['minuman-snack', 'Keripik Singkong', 10000, 'pcs', 'Keripik singkong gurih dan renyah kemasan 150 gram.'],
            ['minuman-snack', 'Susu UHT Cokelat', 6500, 'pcs', 'Susu UHT rasa cokelat kemasan kotak 200 ml.'],

            // Kebutuhan Rumah Tangga
            ['kebutuhan-rumah-tangga', 'Deterjen Bubuk', 22000, 'pcs', 'Deterjen bubuk kemasan 800 gram, bersih dan wangi.'],
            ['kebutuhan-rumah-tangga', 'Sabun Cuci Piring', 13000, 'botol', 'Sabun cuci piring cair anti lemak kemasan 750 ml.'],
            ['kebutuhan-rumah-tangga', 'Sabun Mandi Batang', 4500, 'pcs', 'Sabun mandi batang dengan wangi segar tahan lama.'],
            ['kebutuhan-rumah-tangga', 'Tisu Gulung', 12000, 'pcs', 'Tisu gulung lembut isi 4 roll.'],
            ['kebutuhan-rumah-tangga', 'Pasta Gigi', 12500, 'pcs', 'Pasta gigi kemasan 190 gram untuk gigi bersih dan nafas segar.'],

            // Mie & Makanan Instan
            ['mie-makanan-instan', 'Mie Instan Goreng', 3500, 'pcs', 'Mie instan goreng dengan bumbu lengkap.'],
            ['mie-makanan-instan', 'Mie Instan Kuah', 3200, 'pcs', 'Mie instan kuah rasa ayam bawang yang hangat dan gurih.'],
            ['mie-makanan-instan', 'Bubur Instan', 5000, 'pcs', 'Bubur instan siap saji, praktis untuk sarapan.'],
        ];

        foreach ($products as [$categorySlug, $name, $price, $unit, $description]) {
            Product::updateOrCreate(
                ['name' => $name],
                [
                    'category_id' => $categoryIds[$categorySlug],
                    'price'       => $price,
                    'unit'        => $unit,
                    'description' => $description,
                ]
            );
        }
    }
}