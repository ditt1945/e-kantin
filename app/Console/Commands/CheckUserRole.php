<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {email : Email user yang akan dicek}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek role user berdasarkan email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user = User::with('tenant')->where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User dengan email '{$email}' tidak ditemukan!");
            return 1;
        }

        $this->info("👤 Informasi User:");
        $this->line("==================");
        $this->line("Nama      : {$user->name}");
        $this->line("Email     : {$user->email}");
        $this->line("ID        : {$user->id}");
        $this->line("Role      : {$user->role}");
        $this->line("Tenant ID : " . ($user->tenant_id ?: 'NULL'));

        if ($user->tenant) {
            $this->line("Nama Tenant: {$user->tenant->nama_tenant}");
            $this->line("Status Tenant: " . ($user->tenant->is_active ? 'Aktif' : 'Nonaktif'));
        } else {
            $this->line("Tenant    : Tidak ada");
        }

        $this->line("Bergabung : {$user->created_at->format('d M Y H:i:s')}");

        return 0;
    }
}