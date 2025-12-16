<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Tenant;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::with(['tenant', 'category'])->orderBy('nama_menu');

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $menus = $query->paginate(15)->withQueryString();
        $tenants = Tenant::orderBy('nama_tenant')->get();
        $categories = Category::orderBy('nama_kategori')->get();

        return view('admin.menus.index', compact('menus', 'tenants', 'categories'));
    }

    public function create()
    {
        $tenants = Tenant::where('is_active', true)->orderBy('nama_tenant')->get();
        $categories = Category::where('is_active', true)->orderBy('nama_kategori')->get();

        return view('admin.menus.create', compact('tenants', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'tenant_id' => 'required|exists:tenants,id',
            'category_id' => 'required|exists:categories,id',
            'is_available' => 'boolean',
        ]);

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'tenant_id' => $request->tenant_id,
            'category_id' => $request->category_id,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $tenants = Tenant::where('is_active', true)->orderBy('nama_tenant')->get();
        $categories = Category::where('is_active', true)->orderBy('nama_kategori')->get();

        return view('admin.menus.edit', compact('menu', 'tenants', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'tenant_id' => 'required|exists:tenants,id',
            'category_id' => 'required|exists:categories,id',
            'is_available' => 'boolean',
        ]);

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'tenant_id' => $request->tenant_id,
            'category_id' => $request->category_id,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }

    public function export()
    {
        $menus = Menu::with(['tenant', 'category'])->get();

        $filename = 'menus_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($menus) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Nama Menu', 'Deskripsi', 'Harga', 'Tenant', 'Kategori', 'Status']);

            foreach ($menus as $menu) {
                fputcsv($file, [
                    $menu->nama_menu,
                    $menu->deskripsi ?: '-',
                    $menu->harga,
                    $menu->tenant->nama_tenant,
                    $menu->category->nama_kategori,
                    $menu->is_available ? 'Tersedia' : 'Tidak Tersedia'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
