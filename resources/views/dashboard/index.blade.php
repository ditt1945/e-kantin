@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="mb-5 d-flex justify-content-between align-items-center">
        <div>
            <h2 style="font-weight: 800; font-size: 2rem; margin-bottom: 0.3rem;">
                <i class="fas fa-shield-alt me-2" style="color: var(--primary);"></i>Admin Dashboard
            </h2>
            <p style="color: var(--text-secondary); font-size: 0.95rem;">{{ date('d F Y') }} - Kelola Kantin SMKN 2 Surabaya</p>
        </div>
        <div>
            <a href="{{ route('tenants.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border: none; padding: 0.7rem 1.2rem; border-radius: 8px; font-weight: 600; margin-right: 0.5rem;">
                <i class="fas fa-plus me-1"></i>Tambah Kantin
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-sm" style="background: var(--light-gray); color: var(--text-primary); border: none; padding: 0.7rem 1.2rem; border-radius: 8px; font-weight: 600;">
                <i class="fas fa-tags me-1"></i>Kategori
            </a>
        </div>
    </div>

    {{-- Stat Cards Grid --}}
    <div class="row g-3 mb-4">
        {{-- Total Kantin --}}
        <div class="col-md-3 col-sm-6">
            <div class="card" style="border: none; border-radius: 12px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; overflow: hidden;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <small style="opacity: 0.9; font-size: 0.85rem;">Total Kantin</small>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800;">{{ $totalTenants }}</h3>
                        </div>
                        <i class="fas fa-store" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Menu --}}
        <div class="col-md-3 col-sm-6">
            <div class="card" style="border: none; border-radius: 12px; background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%); color: #362c28; overflow: hidden;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <small style="opacity: 0.9; font-size: 0.85rem;">Total Menu</small>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800;">{{ $totalMenus }}</h3>
                        </div>
                        <i class="fas fa-utensils" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pengguna --}}
        <div class="col-md-3 col-sm-6">
            <div class="card" style="border: none; border-radius: 12px; background: linear-gradient(135deg, var(--primary-light) 0%, var(--light-gray) 100%); color: #362c28; overflow: hidden;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <small style="opacity: 0.9; font-size: 0.85rem;">Total Pengguna</small>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800;">{{ $totalUsers ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-users" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pesanan --}}
        <div class="col-md-3 col-sm-6">
            <div class="card" style="border: none; border-radius: 12px; background: linear-gradient(135deg, var(--warning) 0%, var(--primary) 100%); color: #362c28; overflow: hidden;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <small style="opacity: 0.9; font-size: 0.85rem;">Total Pesanan</small>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800;">{{ $totalOrders ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-shopping-cart" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Management Links --}}
    <div class="row g-3 mb-4">
        {{-- Manage Kantin --}}
        <div class="col-md-6 col-lg-3">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); height: 100%;">
                <div class="card-body p-4 d-flex flex-column">
                    <i class="fas fa-store" style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem;"></i>
                    <h6 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Kelola Kantin</h6>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; flex-grow: 1;">Tambah, edit, dan kelola kantin di SMKN 2 Surabaya</p>
                    <a href="{{ route('tenants.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border: none; border-radius: 8px; align-self: flex-start; font-weight: 600;">
                        <i class="fas fa-arrow-right me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>
        </div>

        {{-- Manage Pengguna --}}
        <div class="col-md-6 col-lg-3">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); height: 100%;">
                <div class="card-body p-4 d-flex flex-column">
                    <i class="fas fa-user-cog" style="font-size: 2rem; color: var(--success); margin-bottom: 1rem;"></i>
                    <h6 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Kelola Pengguna</h6>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; flex-grow: 1;">Kelola role dan akses semua pengguna sistem</p>
                    <a href="{{ route('users.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%); color: #362c28; border: none; border-radius: 8px; align-self: flex-start; font-weight: 600;">
                        <i class="fas fa-arrow-right me-1"></i>Kelola
                    </a>
                </div>
            </div>
        </div>

        {{-- Manage Kategori --}}
        <div class="col-md-6 col-lg-3">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); height: 100%;">
                <div class="card-body p-4 d-flex flex-column">
                    <i class="fas fa-tags" style="font-size: 2rem; color: var(--warning); margin-bottom: 1rem;"></i>
                    <h6 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Kategori Menu</h6>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; flex-grow: 1;">Atur kategori makanan dan minuman (Ciki, Es-es, dll)</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--warning) 0%, var(--primary) 100%); color: #362c28; border: none; border-radius: 8px; align-self: flex-start; font-weight: 600;">
                        <i class="fas fa-arrow-right me-1"></i>Kelola
                    </a>
                </div>
            </div>
        </div>

        {{-- Manage Menu --}}
        <div class="col-md-6 col-lg-3">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); height: 100%;">
                <div class="card-body p-4 d-flex flex-column">
                    <i class="fas fa-utensils" style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem;"></i>
                    <h6 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Semua Menu</h6>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; flex-grow: 1;">Lihat dan monitor semua menu dari semua kantin</p>
                    <a href="{{ route('menus.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border: none; border-radius: 8px; align-self: flex-start; font-weight: 600;">
                        <i class="fas fa-arrow-right me-1"></i>Lihat
                    </a>
                </div>
            </div>
        </div>

        {{-- Manage Pesanan --}}
        <div class="col-md-6 col-lg-3">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); height: 100%;">
                <div class="card-body p-4 d-flex flex-column">
                    <i class="fas fa-shopping-cart" style="font-size: 2rem; color: var(--success); margin-bottom: 1rem;"></i>
                    <h6 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Semua Pesanan</h6>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; flex-grow: 1;">Monitor semua pesanan dari semua kantin</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%); color: #362c28; border: none; border-radius: 8px; align-self: flex-start; font-weight: 600;">
                        <i class="fas fa-arrow-right me-1"></i>Lihat
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders Section --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 1.5rem;">
                        <i class="fas fa-clock me-2" style="color: var(--primary);"></i>Pesanan Terbaru
                    </h5>
                    @if($pesananTerbaru->count() > 0)
                        <div class="table-responsive">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid var(--primary);">
                                        <th style="text-align: left; padding: 1rem; color: var(--text-primary); font-weight: 700;">ID Pesanan</th>
                                        <th style="text-align: left; padding: 1rem; color: var(--text-primary); font-weight: 700;">Kantin</th>
                                        <th style="text-align: right; padding: 1rem; color: var(--text-primary); font-weight: 700;">Total</th>
                                        <th style="text-align: center; padding: 1rem; color: var(--text-primary); font-weight: 700;">Status</th>
                                        <th style="text-align: center; padding: 1rem; color: var(--text-primary); font-weight: 700;">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesananTerbaru as $pesanan)
                                    <tr style="border-bottom: 1px solid var(--border-gray); transition: all 0.3s ease;" onmouseover="this.style.background='var(--light-gray)'" onmouseout="this.style.background='transparent'">
                                        <td style="padding: 1rem; color: var(--text-primary); font-weight: 600;">#{{ $pesanan->id }}</td>
                                        <td style="padding: 1rem; color: var(--text-secondary);">{{ $pesanan->tenant->nama_tenant ?? 'N/A' }}</td>
                                        <td style="padding: 1rem; text-align: right; color: var(--text-primary); font-weight: 600;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                        <td style="padding: 1rem; text-align: center;">
                                            @if($pesanan->status == 'selesai')
                                                <span class="badge bg-success text-white">Selesai</span>
                                            @elseif($pesanan->status == 'diproses')
                                                <span class="badge bg-warning text-dark">Diproses</span>
                                            @elseif($pesanan->status == 'pending')
                                                <span class="badge bg-primary text-white">Pending</span>
                                            @else
                                                <span class="badge bg-danger text-white">{{ ucfirst($pesanan->status) }}</span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem; text-align: center; color: var(--text-secondary); font-size: 0.9rem;">{{ $pesanan->created_at->format('d M H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div style="background: var(--light-gray); padding: 2rem; border-radius: 8px; text-align: center;">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--border-gray); margin-bottom: 0.5rem; display: block;"></i>
                            <p style="color: var(--text-secondary); margin: 0;">Belum ada pesanan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection