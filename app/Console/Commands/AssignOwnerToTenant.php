<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Tenant;

class AssignOwnerToTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:assign-owner
                            {--email= : Email dari owner yang akan ditugaskan}
                            {--tenant-id= : ID tenant yang akan dipilih}
                            {--create-owner : Buat owner baru jika belum ada}
                            {--list : Tampilkan daftar owner dan tenant tersedia}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign tenant owner to a tenant or create new owner';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('list')) {
            $this->showList();
            return 0;
        }

        $email = $this->option('email');
        $tenantId = $this->option('tenant-id');
        $createNew = $this->option('create-owner');

        // Show available options if no parameters
        if (!$email && !$tenantId && !$createNew) {
            $this->showInstructions();
            return 0;
        }

        // If creating new owner
        if ($createNew) {
            return $this->createNewOwner();
        }

        // Validate inputs
        if (!$email) {
            $email = $this->ask('Masukkan email owner:');
        }

        if (!$tenantId) {
            $tenantId = $this->ask('Masukkan ID tenant:');
        }

        return $this->assignOwner($email, $tenantId);
    }

    private function showList()
    {
        $this->info('📋 Daftar Owner dan Tenant yang Tersedia');
        $this->line('======================================');

        // Show available owners
        $this->newLine();
        $this->info('👤 Tenant Owners Tersedia:');

        $owners = User::where('role', 'tenant_owner')->get();

        if ($owners->isEmpty()) {
            $this->warn('  ❌ Belum ada tenant owner yang terdaftar');
            $this->line('  💡 Gunakan --create-owner untuk membuat owner baru');
        } else {
            $this->table(
                ['ID', 'Nama', 'Email', 'Tenant ID', 'Tenant'],
                $owners->map(function($owner) {
                    return [
                        $owner->id,
                        $owner->name,
                        $owner->email,
                        $owner->tenant_id ?? 'NULL',
                        $owner->tenant ? $owner->tenant->nama_tenant : 'Tidak ada'
                    ];
                })
            );
        }

        // Show available tenants
        $this->newLine();
        $this->info('🏢 Tenant yang Tersedia (tanpa owner):');

        $tenantIdsWithOwners = User::whereNotNull('tenant_id')->pluck('tenant_id');
        $availableTenants = Tenant::whereNotIn('id', $tenantIdsWithOwners)
            ->where('is_active', true)
            ->orderBy('nama_tenant')
            ->get();

        if ($availableTenants->isEmpty()) {
            $this->warn('  ❌ Semua tenant sudah memiliki owner');
        } else {
            $this->table(
                ['ID', 'Nama Tenant', 'Pemilik (Field)', 'No Telepon'],
                $availableTenants->map(function($tenant) {
                    return [
                        $tenant->id,
                        $tenant->nama_tenant,
                        $tenant->pemilik ?? '-',
                        $tenant->no_telepon ?? '-'
                    ];
                })
            );
        }
    }

    private function showInstructions()
    {
        $this->info('📖 Cara Penggunaan:');
        $this->line('');
        $this->line('1. Lihat daftar owner dan tenant:');
        $this->line('   php artisan tenant:assign-owner --list');
        $this->line('');
        $this->line('2. Buat owner baru untuk tenant:');
        $this->line('   php artisan tenant:assign-owner --create-owner');
        $this->line('');
        $this->line('3. Tugaskan owner ke tenant:');
        $this->line('   php artisan tenant:assign-owner --email=owner@email.com --tenant-id=1');
        $this->line('');
        $this->line('4. Tugaskan dengan interaktif:');
        $this->line('   php artisan tenant:assign-owner');
    }

    private function createNewOwner()
    {
        $this->info('👤 Buat Owner Baru');
        $this->line('==================');

        // Show available tenants first
        $tenantIdsWithOwners = User::whereNotNull('tenant_id')->pluck('tenant_id');
        $availableTenants = Tenant::whereNotIn('id', $tenantIdsWithOwners)
            ->where('is_active', true)
            ->orderBy('nama_tenant')
            ->get();

        if ($availableTenants->isEmpty()) {
            $this->error('❌ Tidak ada tenant tersedia tanpa owner');
            return 1;
        }

        $this->newLine();
        $this->info('Tenant tersedia:');
        foreach ($availableTenants as $tenant) {
            $this->line("  [{$tenant->id}] {$tenant->nama_tenant} (Pemilik: " . ($tenant->pemilik ?: '-') . ")");
        }

        // Get owner data
        $this->newLine();
        $name = $this->ask('Nama owner');
        $email = $this->ask('Email owner');
        $password = $this->secret('Password untuk owner');

        // Validate unique email
        if (User::where('email', $email)->exists()) {
            $this->error('❌ Email sudah digunakan!');
            return 1;
        }

        // Select tenant
        $tenantId = $this->anticipate(function() {
            return $this->ask('Pilih ID tenant (lihat daftar di atas)');
        }, function($answer) use ($availableTenants) {
            return $availableTenants->pluck('id')->contains($answer);
        });

        // Get selected tenant
        $selectedTenant = $availableTenants->firstWhere('id', $tenantId);
        if (!$selectedTenant) {
            $this->error('❌ Tenant ID tidak valid!');
            return 1;
        }

        // Create owner
        $owner = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'tenant_owner',
            'tenant_id' => $selectedTenant->id
        ]);

        $this->newLine();
        $this->info('✅ Owner berhasil dibuat!');
        $this->line("   Nama: {$owner->name}");
        $this->line("   Email: {$owner->email}");
        $this->line("   Tenant: {$selectedTenant->nama_tenant}");
        $this->line("   Password: [disembunyikan]");

        return 0;
    }

    private function assignOwner($email, $tenantId)
    {
        // Find owner
        $owner = User::where('email', $email)->where('role', 'tenant_owner')->first();

        if (!$owner) {
            $this->error("❌ Owner dengan email '{$email}' tidak ditemukan!");
            return 1;
        }

        // Find tenant
        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            $this->error("❌ Tenant dengan ID '{$tenantId}' tidak ditemukan!");
            return 1;
        }

        // Check if tenant already has owner
        $existingOwner = User::where('tenant_id', $tenant->id)
                            ->where('role', 'tenant_owner')
                            ->first();

        if ($existingOwner && $existingOwner->id !== $owner->id) {
            if (!$this->confirm("Tenant '{$tenant->nama_tenant}' sudah dimiliki oleh '{$existingOwner->name}'. Ganti owner?")) {
                $this->info('❌ Operasi dibatalkan');
                return 0;
            }

            // Clear previous owner
            $existingOwner->update(['tenant_id' => null]);
        }

        // Assign owner to tenant
        $owner->update(['tenant_id' => $tenant->id]);

        $this->newLine();
        $this->info('✅ Owner berhasil ditugaskan ke tenant!');
        $this->line("   Owner: {$owner->name} ({$owner->email})");
        $this->line("   Tenant: {$tenant->nama_tenant}");
        $this->line("   Pemilik (Field): " . ($tenant->pemilik ?: 'Tidak diisi'));
        $this->line("   Status: " . ($tenant->is_active ? 'Aktif' : 'Nonaktif'));

        return 0;
    }
}