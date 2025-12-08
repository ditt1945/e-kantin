<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantMenuController extends Controller
{
    public function index()
    {
        $tenant = Auth::user()->tenant;
        $menus = $tenant->menus()->with('category')->get();
        
        return view('tenant.menus.index', compact('menus', 'tenant'));
    }

    public function create()
    {
        $tenant = Auth::user()->tenant;
        $categories = Category::all(); // ✅ Ambil semua kategori yang ada
        
        return view('tenant.menus.create', compact('tenant', 'categories'));
    }

    public function store(Request $request)
    {
        $tenant = Auth::user()->tenant;
        
        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id', // ✅ Validasi kategori ada
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['tenant_id'] = $tenant->id; // Auto set tenant_id
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('tenant.menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        // Authorization - hanya bisa edit menu milik sendiri
        if ($menu->tenant_id !== Auth::user()->tenant->id) {
            abort(403, 'Unauthorized');
        }

        $categories = Category::all(); // ✅ Ambil semua kategori untuk dropdown
        return view('tenant.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        // Authorization - hanya bisa edit menu milik sendiri
        if ($menu->tenant_id !== Auth::user()->tenant->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id', // ✅ Validasi kategori
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($menu->gambar) {
                \Storage::disk('public')->delete($menu->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('tenant.menus.index')
            ->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        // Authorization - hanya bisa hapus menu milik sendiri
        if ($menu->tenant_id !== Auth::user()->tenant->id) {
            abort(403, 'Unauthorized');
        }

        // Delete image if exists
        if ($menu->gambar) {
            \Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()->route('tenant.menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}