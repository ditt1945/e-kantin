<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Tenant;

class AddMasRezaMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Mas Reza's tenant
        $tenant = Tenant::where('nama_tenant', 'Kantin Mas Reza')->first();
        
        if (!$tenant) {
            $this->command->info('Kantin Mas Reza not found!');
            return;
        }

        // Get or create categories
        $categorySnack = Category::firstOrCreate(
            ['nama_kategori' => 'Snack/Cemilan'],
            ['deskripsi' => 'Makanan ringan dan camilan']
        );

        $categoryIce = Category::firstOrCreate(
            ['nama_kategori' => 'Es & Minuman Dingin'],
            ['deskripsi' => 'Minuman dingin dan es krim']
        );

        $categoryNoodle = Category::firstOrCreate(
            ['nama_kategori' => 'Mie Instan'],
            ['deskripsi' => 'Berbagai pilihan mie instan']
        );

        // Menu items for Mas Reza
        $menus = [
            // Snacks
            [
                'nama_menu' => 'Chiki Goreng Pedas',
                'deskripsi' => 'Chiki crispy dengan rasa pedas yang nikmat',
                'harga' => 8000,
                'category_id' => $categorySnack->id,
                'stok' => 50,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Chiki Rasa Jagung',
                'deskripsi' => 'Chiki dengan rasa jagung manis dan gurih',
                'harga' => 7000,
                'category_id' => $categorySnack->id,
                'stok' => 50,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Chiki Keju',
                'deskripsi' => 'Chiki lezat dengan rasa keju yang kuat',
                'harga' => 8000,
                'category_id' => $categorySnack->id,
                'stok' => 50,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Kacang Goreng Rasa Bawang',
                'deskripsi' => 'Kacang goreng crispy dengan rasa bawang',
                'harga' => 10000,
                'category_id' => $categorySnack->id,
                'stok' => 40,
                'is_available' => true,
            ],
            // Es & Minuman
            [
                'nama_menu' => 'Es Cendol',
                'deskripsi' => 'Es cendol tradisional dengan santan dan gula merah',
                'harga' => 12000,
                'category_id' => $categoryIce->id,
                'stok' => 100,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Es Teh',
                'deskripsi' => 'Es teh manis segar',
                'harga' => 5000,
                'category_id' => $categoryIce->id,
                'stok' => 100,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Es Jeruk',
                'deskripsi' => 'Es jeruk segar dengan rasa asam manis',
                'harga' => 6000,
                'category_id' => $categoryIce->id,
                'stok' => 80,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Es Krim Wall\'s',
                'deskripsi' => 'Es krim premium merk Wall\'s berbagai rasa',
                'harga' => 15000,
                'category_id' => $categoryIce->id,
                'stok' => 50,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Es Krim Magnum',
                'deskripsi' => 'Es krim premium merk Magnum dengan cokelat',
                'harga' => 18000,
                'category_id' => $categoryIce->id,
                'stok' => 40,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Es Krim Cornetto',
                'deskripsi' => 'Es krim lezat dalam cone, merk Cornetto',
                'harga' => 12000,
                'category_id' => $categoryIce->id,
                'stok' => 60,
                'is_available' => true,
            ],
            // Mie Instan
            [
                'nama_menu' => 'Mie Goreng Indomie Pedas',
                'deskripsi' => 'Mie goreng Indomie dengan rasa pedas',
                'harga' => 10000,
                'category_id' => $categoryNoodle->id,
                'stok' => 100,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Mie Rebus Indomie',
                'deskripsi' => 'Mie rebus Indomie dengan kuah gurih',
                'harga' => 9000,
                'category_id' => $categoryNoodle->id,
                'stok' => 80,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Mie Goreng Sedap Pedas',
                'deskripsi' => 'Mie goreng Mie Sedap dengan rasa pedas istimewa',
                'harga' => 10000,
                'category_id' => $categoryNoodle->id,
                'stok' => 80,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Mie Rebus Sedap Ayam',
                'deskripsi' => 'Mie rebus Mie Sedap dengan rasa ayam',
                'harga' => 9000,
                'category_id' => $categoryNoodle->id,
                'stok' => 70,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Mie Goreng Pop Mie',
                'deskripsi' => 'Pop Mie goreng instant dengan kemasan cup',
                'harga' => 8000,
                'category_id' => $categoryNoodle->id,
                'stok' => 100,
                'is_available' => true,
            ],
            [
                'nama_menu' => 'Mie Ayam Bakso Instan',
                'deskripsi' => 'Mie rebus dengan bakso dan rasa ayam',
                'harga' => 11000,
                'category_id' => $categoryNoodle->id,
                'stok' => 60,
                'is_available' => true,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'nama_menu' => $menu['nama_menu'],
                ],
                $menu + ['tenant_id' => $tenant->id]
            );
        }

        $this->command->info('Menu for Kantin Mas Reza added successfully!');
    }
}
