<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('menus')->orderBy('nama_kategori')->paginate(12);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function destroy(Category $category)
    {
        if ($category->menus()->exists()) {
            return redirect()->route('categories.index')->with('error', 'Kategori tidak bisa dihapus karena masih digunakan menu.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function export()
    {
        $categories = Category::withCount('menus')->get();

        $filename = 'categories_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Nama Kategori', 'Deskripsi', 'Status', 'Jumlah Menu']);

            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->nama_kategori,
                    $category->deskripsi ?: '-',
                    $category->is_active ? 'Aktif' : 'Nonaktif',
                    $category->menus_count
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
