<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('tenant')->latest();

        // Search by name or email
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        // Filter by tenant
        if ($tenantId = $request->get('tenant')) {
            $query->where('tenant_id', $tenantId);
        }

        $users = $query->paginate(20)->withQueryString();

        // Get counts for filters
        $roleCounts = User::select('role', \DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');

        $tenants = \App\Models\Tenant::where('is_active', true)
            ->orderBy('nama_tenant')
            ->get();

        return view('admin.users.index', compact('users', 'roleCounts', 'tenants'));
    }

    public function create()
    {
        $tenants = \App\Models\Tenant::where('is_active', true)
            ->orderBy('nama_tenant')
            ->get();

        return view('admin.users.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,tenant_owner,admin',
            'tenant_id' => 'nullable|exists:tenants,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'tenant_id' => $request->role === 'tenant_owner' ? $request->tenant_id : null,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:customer,tenant_owner,admin',
        ]);

        // Log role change
        $oldRole = $user->role;
        $newRole = $request->role;

        $user->update($request->only(['name', 'email', 'role']));

        // Special handling for tenant_owner role
        if ($newRole === 'tenant_owner' && $oldRole !== 'tenant_owner') {
            // If changing to tenant_owner, clear tenant_id if no tenant assigned
            if (!$user->tenant_id) {
                // You can add logic here to assign a tenant or require admin to assign one
                return back()->with('warning', 'Role berhasil diubah ke Tenant, namun tenant belum ditugaskan. Silakan atur tenant melalui halaman kelola tenant.');
            }
        } elseif ($newRole !== 'tenant_owner' && $oldRole === 'tenant_owner') {
            // If changing away from tenant_owner, clear tenant_id
            $user->update(['tenant_id' => null]);
        }

        return back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus admin.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function checkRole(Request $request)
    {
        $email = $request->get('email');

        if (!$email) {
            return response()->json(['error' => 'Email diperlukan'], 400);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'tenant' => $user->tenant ? [
                'id' => $user->tenant->id,
                'nama_tenant' => $user->tenant->nama_tenant
            ] : null,
            'tenant_id' => $user->tenant_id,
            'created_at' => $user->created_at->format('Y-m-d H:i:s')
        ]);
    }
}