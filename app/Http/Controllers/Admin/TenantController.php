<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::withCount(['menus', 'orders'])
            ->with(['menus' => function($query) {
                $query->where('is_available', true);
            }])
            ->paginate(10);

        // Calculate additional statistics for each tenant
        $tenants->getCollection()->transform(function ($tenant) {
            $tenant->menus_active_count = $tenant->menus->where('is_available', true)->count();
            $tenant->total_sales = $tenant->orders()->sum('total_harga');
            return $tenant;
        });

        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $owners = User::where('role', 'tenant_owner')->orderBy('name')->get();

        return view('admin.tenants.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_tenant' => 'required|string|max:255',
            'pemilik' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'is_active' => 'sometimes|boolean',
            'owner_user_id' => 'nullable|exists:users,id'
        ]);

        $tenant = Tenant::create([
            'nama_tenant' => $data['nama_tenant'],
            'pemilik' => $data['pemilik'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'no_telepon' => $data['no_telepon'] ?? null,
            'is_active' => $request->boolean('is_active')
        ]);

        $this->assignOwner($tenant, $data['owner_user_id'] ?? null);

        return redirect()->route('tenants.index')->with('success', 'Tenant baru berhasil dibuat.');
    }

    public function edit(Tenant $tenant)
    {
        $owners = User::where('role', 'tenant_owner')->orderBy('name')->get();
        $currentOwnerId = User::where('tenant_id', $tenant->id)
            ->where('role', 'tenant_owner')
            ->value('id');

        return view('admin.tenants.edit', compact('tenant', 'owners', 'currentOwnerId'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $data = $request->validate([
            'nama_tenant' => 'required|string|max:255',
            'pemilik' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'is_active' => 'sometimes|boolean',
            'owner_user_id' => 'nullable|exists:users,id'
        ]);

        $tenant->update([
            'nama_tenant' => $data['nama_tenant'],
            'pemilik' => $data['pemilik'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'no_telepon' => $data['no_telepon'] ?? null,
            'is_active' => $request->boolean('is_active')
        ]);

        $this->assignOwner($tenant, $data['owner_user_id'] ?? null);

        return redirect()->route('tenants.index')->with('success', 'Tenant berhasil diperbarui.');
    }

    public function destroy(Tenant $tenant)
    {
        User::where('tenant_id', $tenant->id)->update(['tenant_id' => null]);
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'Tenant berhasil dihapus.');
    }

    public function export()
    {
        $tenants = Tenant::withCount(['menus', 'orders'])->get();

        $filename = 'tenants_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($tenants) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Nama Tenant', 'Pemilik', 'No Telepon', 'Status', 'Jumlah Menu', 'Jumlah Pesanan']);

            foreach ($tenants as $tenant) {
                fputcsv($file, [
                    $tenant->nama_tenant,
                    $tenant->pemilik ?? '-',
                    $tenant->no_telepon ?? '-',
                    $tenant->is_active ? 'Aktif' : 'Nonaktif',
                    $tenant->menus_count,
                    $tenant->orders_count
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function assignOwner(Tenant $tenant, ?int $userId): void
    {
        User::where('tenant_id', $tenant->id)
            ->where('role', 'tenant_owner')
            ->update(['tenant_id' => null]);

        if (!$userId) {
            return;
        }

        $owner = User::where('id', $userId)->where('role', 'tenant_owner')->first();
        if (!$owner) {
            return;
        }

        $owner->tenant_id = $tenant->id;
        $owner->save();
    }
}
