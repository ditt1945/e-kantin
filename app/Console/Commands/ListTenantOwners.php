<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Tenant;

class ListTenantOwners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:owners {--all : Show all owners including inactive tenants}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all tenant owners with their email and tenant information';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📋 Daftar Pemilik Kantin (Tenant Owners)');
        $this->line('==========================================');

        // Get all tenant owners with their tenants
        $query = User::where('role', 'tenant_owner')
                    ->with('tenant')
                    ->orderBy('name');

        if (!$this->option('all')) {
            $query->whereHas('tenant', function($q) {
                $q->where('is_active', true);
            });
        }

        $owners = $query->get();

        if ($owners->isEmpty()) {
            $this->warn('⚠️  Belum ada pemilik kantin yang terdaftar.');
            return 0;
        }

        $this->table(
            ['No', 'Nama Owner', 'Email', 'Tenant', 'Pemilik (Field)', 'Status'],
            $owners->map(function($owner, $index) {
                return [
                    $index + 1,
                    $owner->name ?? 'N/A',
                    $owner->email ?? 'N/A',
                    $owner->tenant?->nama_tenant ?? 'N/A',
                    $owner->tenant?->pemilik ?? 'N/A',
                    $owner->tenant?->is_active ? '✅ Aktif' : '❌ Nonaktif'
                ];
            })
        );

        // Summary
        $totalOwners = $owners->count();
        $activeTenants = $owners->filter(fn($owner) => $owner->tenant?->is_active)->count();
        $ownersWithoutTenant = $owners->filter(fn($owner) => !$owner->tenant)->count();

        $this->line("\n📊 Ringkasan:");
        $this->line("• Total Tenant Owners: {$totalOwners}");
        $this->line("• Tenant Aktif: {$activeTenants}");
        $this->line("• Owner tanpa Tenant: {$ownersWithoutTenant}");

        // Check for potential issues
        $issues = [];

        if ($ownersWithoutTenant > 0) {
            $issues[] = "{$ownersWithoutTenant} owner tidak memiliki tenant";
        }

        // Check owners with null email
        $ownersWithoutEmail = $owners->filter(fn($owner) => !$owner->email)->count();
        if ($ownersWithoutEmail > 0) {
            $issues[] = "{$ownersWithoutEmail} owner tidak memiliki email";
        }

        // Check tenants without owners
        $tenantsWithoutOwners = Tenant::whereNotIn('id',
                                    User::whereNotNull('tenant_id')
                                        ->pluck('tenant_id')
                                )
                                ->where('is_active', true)
                                ->count();
        if ($tenantsWithoutOwners > 0) {
            $issues[] = "{$tenantsWithoutOwners} tenant tidak memiliki owner";
        }

        if (!empty($issues)) {
            $this->newLine();
            $this->warn('⚠️  Masalah yang ditemukan:');
            foreach ($issues as $issue) {
                $this->line("  • {$issue}");
            }
        }

        // Export option
        if ($this->confirm('Apakah Anda ingin mengekspor data ke CSV?')) {
            $this->exportToCSV($owners);
        }

        return 0;
    }

    /**
     * Export owner data to CSV
     */
    private function exportToCSV($owners)
    {
        $filename = 'tenant_owners_' . date('Y-m-d_H-i-s') . '.csv';
        $filepath = storage_path('app/' . $filename);

        $file = fopen($filepath, 'w');

        // Header
        fputcsv($file, ['Nama Owner', 'Email', 'Tenant', 'Pemilik (Field)', 'No Telepon', 'Status Tenant', 'Created At']);

        // Data
        foreach ($owners as $owner) {
            fputcsv($file, [
                $owner->name ?? 'N/A',
                $owner->email ?? 'N/A',
                $owner->tenant?->nama_tenant ?? 'N/A',
                $owner->tenant?->pemilik ?? 'N/A',
                $owner->tenant?->no_telepon ?? 'N/A',
                $owner->tenant?->is_active ? 'Aktif' : 'Nonaktif',
                $owner->created_at ? $owner->created_at->format('Y-m-d H:i:s') : 'N/A'
            ]);
        }

        fclose($file);

        $this->info("✅ Data berhasil diekspor ke: {$filepath}");
    }
}