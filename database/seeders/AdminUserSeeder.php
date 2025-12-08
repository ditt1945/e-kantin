<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Category;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create tenant owner user
        $tenantOwner = User::firstOrCreate(
            ['email' => 'tenant@demo.com'],
            [
                'name' => 'Tenant Owner Demo',
                'password' => Hash::make('tenant123'),
                'role' => 'tenant_owner',
                'email_verified_at' => now(),
            ]
        );

        // Create tenant for tenant owner
        $tenant = Tenant::firstOrCreate(
            ['nama_tenant' => 'Kantin Demo'],
            [
                'deskripsi' => 'Kantin demo untuk testing - menyediakan berbagai makanan dan minuman',
                'pemilik' => $tenantOwner->name,
                'no_telepon' => '081234567890',
                'is_active' => true,
            ]
        );

        // Link tenant to user
        $tenantOwner->update(['tenant_id' => $tenant->id]);

        // Create categories if not exist
        $categories = [
            ['nama_kategori' => 'Makanan Berat', 'deskripsi' => 'Nasi, mie, dan makanan berat lainnya'],
            ['nama_kategori' => 'Snack', 'deskripsi' => 'Camilan ringan'],
            ['nama_kategori' => 'Minuman', 'deskripsi' => 'Minuman segar'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['nama_kategori' => $cat['nama_kategori']],
                ['deskripsi' => $cat['deskripsi']]
            );
        }

        // Create customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@demo.com'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✓ Demo users created successfully!');
        $this->command->info('Admin: admin@demo.com / admin123');
        $this->command->info('Tenant: tenant@demo.com / tenant123 (Kantin: ' . $tenant->nama_tenant . ')');
        $this->command->info('Customer: customer@demo.com / customer123');
    }
}
