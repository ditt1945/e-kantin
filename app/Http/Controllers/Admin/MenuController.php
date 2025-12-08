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
}
