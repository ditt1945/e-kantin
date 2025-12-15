<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Tenant;

class CheckTenantData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tenant and owner data integrity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Pengecekan Data Tenant & Owner');
        $this->line('====================================');

        // 1. Check all users by role
        $this->newLine();
        $this->info('👥 Data Users berdasarkan Role:');

        $usersByRole = User::select('role', User::raw('count(*) as count'))
            ->groupBy('role')
            ->get()
            ->keyBy('role');

        $this->table(
            ['Role', 'Jumlah'],
            [
                ['customer', $usersByRole->get('customer')->count ?? 0],
                ['tenant_owner', $usersByRole->get('tenant_owner')->count ?? 0],
                ['admin', $usersByRole->get('admin')->count ?? 0],
                ['null/undefined', User::whereNull('role')->count()],
            ]
        );

        // 2. Check tenant data
        $this->newLine();
        $this->info('🏢 Data Tenant:');
        $tenants = Tenant::all();

        $this->table(
            ['ID', 'Nama Tenant', 'Pemilik (Field)', 'No Telepon', 'Status', 'Created At'],
            $tenants->map(function($tenant) {
                return [
                    $tenant->id,
                    $tenant->nama_tenant,
                    $tenant->pemilik ?? '-',
                    $tenant->no_telepon ?? '-',
                    $tenant->is_active ? '✅ Aktif' : '❌ Nonaktif',
                    $tenant->created_at->format('Y-m-d H:i')
                ];
            })
        );

        // 3. Check tenant owners with their tenant_id
        $this->newLine();
        $this->info('👤 Detail Tenant Owners:');

        $tenantOwners = User::where('role', 'tenant_owner')->get();

        $this->table(
            ['ID User', 'Nama', 'Email', 'Tenant ID', 'Nama Tenant (Relasi)'],
            $tenantOwners->map(function($owner) {
                return [
                    $owner->id,
                    $owner->name,
                    $owner->email ?? 'NULL',
                    $owner->tenant_id ?? 'NULL',
                    $owner->tenant ? $owner->tenant->nama_tenant : 'Tidak ada'
                ];
            })
        );

        // 4. Check integrity issues
        $this->newLine();
        $this->warn('⚠️  Masalah yang ditemukan:');

        $issues = 0;

        // Check tenant owners without tenant_id
        $ownersWithoutTenantId = User::where('role', 'tenant_owner')->whereNull('tenant_id')->count();
        if ($ownersWithoutTenantId > 0) {
            $this->line("  • {$ownersWithoutTenantId} tenant_owner tidak memiliki tenant_id");
            $issues++;
        }

        // Check tenant_id yang tidak ada di tenants table
        $invalidTenantIds = User::where('role', 'tenant_owner')
            ->whereNotNull('tenant_id')
            ->whereNotIn('tenant_id', Tenant::pluck('id'))
            ->pluck('tenant_id', 'name');

        if ($invalidTenantIds->count() > 0) {
            foreach ($invalidTenantIds as $name => $tenantId) {
                $this->line("  • {$name} memiliki tenant_id={$tenantId} yang tidak ada di tabel tenants");
            }
            $issues++;
        }

        // Check tenants without owners
        $tenantIdsWithOwners = User::whereNotNull('tenant_id')->pluck('tenant_id');
        $tenantsWithoutOwners = Tenant::whereNotIn('id', $tenantIdsWithOwners)->get();

        if ($tenantsWithoutOwners->count() > 0) {
            foreach ($tenantsWithoutOwners as $tenant) {
                $this->line("  • Tenant '{$tenant->nama_tenant}' (ID: {$tenant->id}) tidak memiliki owner");
            }
            $issues++;
        }

        // Check tenants with field 'pemilik' null
        $tenantsWithoutPemilik = Tenant::whereNull('pemilik')->count();
        if ($tenantsWithoutPemilik > 0) {
            $this->line("  • {$tenantsWithoutPemilik} tenant tidak memiliki nama pemilik di field 'pemilik'");
            $issues++;
        }

        if ($issues === 0) {
            $this->info('  ✅ Tidak ada masalah ditemukan!');
        }

        return 0;
    }
}