<?php

namespace Database\Seeders;

use App\Models\Costume;
use Illuminate\Database\Seeder;

class CostumeSeeder extends Seeder
{
    /**
     * Data awal koleksi kostum Sebajar.id.
     *
     * Stok standar setiap koleksi:
     * - Baju   : All Size 16, XL 2, XXL 2
     * - Celana : All Size 18, XXL 2
     *
     * Total maksimal = 20 set per koleksi.
     *
     * Catatan:
     * Stok celana XXXL tambahan yang pernah dicatat Sebajar adalah
     * stok global 5 pcs, bukan 5 pcs untuk setiap koleksi. Struktur
     * database saat ini belum memiliki tabel stok global sehingga
     * stok tersebut tidak dimasukkan sebagai stok per kostum.
     *
     * Semua path gambar dibuat relatif terhadap public/images.
     * Contoh: costumes/sbj-001.jpg -> public/images/costumes/sbj-001.jpg.
     */
    public function run(): void
    {
        $standardSizes = [
            ['category' => 'baju', 'size' => 'All Size', 'quantity' => 16],
            ['category' => 'baju', 'size' => 'XL', 'quantity' => 2],
            ['category' => 'baju', 'size' => 'XXL', 'quantity' => 2],
            ['category' => 'celana', 'size' => 'All Size', 'quantity' => 18],
            ['category' => 'celana', 'size' => 'XXL', 'quantity' => 2],
        ];

        $costumes = [
            [
                'code' => 'SBJ-001',
                'name' => 'Ungu - Peach',
                'image' => 'costumes/sbj-001.jpg',
                'description' => 'Kostum Tari Saman dengan kombinasi warna Ungu dan Peach.',
                'status' => 'active',
            ],
            [
                'code' => 'SBJ-002',
                'name' => 'Merah Manggis - Biru Langit',
                'image' => 'costumes/sbj-002.jpg',
                'description' => 'Kostum Tari Saman dengan kombinasi warna Merah Manggis dan Biru Langit.',
                'status' => 'active',
            ],
            [
                'code' => 'SBJ-005',
                'name' => 'Merah Cabai - Hijau Botol',
                'image' => 'costumes/sbj-005.jpg',
                'description' => 'Kostum Tari Saman dengan kombinasi warna Merah Cabai dan Hijau Botol.',
                'status' => 'active',
            ],
            [
                'code' => 'SBJ-006',
                'name' => 'Maroon - Gold',
                'image' => 'costumes/sbj-006.jpg',
                'description' => 'Kostum Tari Saman dengan kombinasi warna Maroon dan Gold.',
                'status' => 'active',
            ],
            [
                'code' => 'SBJ-007',
                'name' => 'Pink - Ungu Lilac',
                'image' => null,
                'description' => 'Kostum Tari Saman dengan kombinasi warna Pink dan Ungu Lilac.',
                'status' => 'active',
            ],
            [
                'code' => 'SBJ-008',
                'name' => 'Pink Fanta - Biru Telor Asin',
                'image' => null,
                'description' => 'Kostum Tari Saman dengan kombinasi warna Pink Fanta dan Biru Telor Asin.',
                'status' => 'active',
            ],
            [
                'code' => 'SBJ-009',
                'name' => 'Navy - Oren',
                'image' => null,
                'description' => 'Kostum Tari Saman dengan kombinasi warna Navy dan Oren.',
                'status' => 'active',
            ],
            [
                'code' => 'SBJ-010',
                'name' => 'Coklat - Cream',
                'image' => null,
                'description' => 'Kostum Tari Saman dengan kombinasi warna Coklat dan Cream.',
                'status' => 'active',
            ],
            [
                'code' => 'SBJ-011',
                'name' => 'Navy - Lemon',
                'image' => null,
                'description' => 'Kostum Tari Saman dengan kombinasi warna Navy dan Lemon.',
                'status' => 'active',
            ],
        ];

        foreach ($costumes as $data) {
            $costume = Costume::updateOrCreate(
                ['code' => $data['code']],
                $data
            );

            foreach ($standardSizes as $size) {
                $costume->sizes()->updateOrCreate(
                    [
                        'category' => $size['category'],
                        'size' => $size['size'],
                    ],
                    [
                        'quantity' => $size['quantity'],
                    ]
                );
            }
        }
    }
}
