@component('mail::message')
# Status Pesanan Berubah

Halo {{ $order->user->name }},

Status pesanan Anda telah berubah!

## Detail Pesanan

**Kode Pesanan:** {{ $order->kode_pesanan }}  
**Kantin:** {{ $order->tenant->nama_tenant }}  

@php
    $statusLabel = match($newStatus) {
        'diproses' => '🔄 Sedang Diproses',
        'selesai' => '✅ Siap Diambil',
        'dibatalkan' => '❌ Dibatalkan',
        'pending' => '⏳ Menunggu',
        'pending_cash' => '💰 Menunggu Pembayaran Tunai',
        default => ucfirst($newStatus),
    };
@endphp

**Status Baru:** {{ $statusLabel }}  
**Waktu Update:** {{ now()->format('d M Y H:i') }}

@if($newStatus === 'selesai')
Pesanan Anda sudah siap untuk diambil! Segera ke {{ $order->tenant->nama_tenant }} untuk mengambil pesanan.
@elseif($newStatus === 'dibatalkan')
Mohon maaf, pesanan Anda dibatalkan. Silakan hubungi {{ $order->tenant->nama_tenant }} untuk informasi lebih lanjut.
@endif

@component('mail::button', ['url' => route('customer.orders')])
Lihat Detail Pesanan
@endcomponent

Terima kasih menggunakan e-Kantin! 🎉

Salam,  
Tim e-Kantin - Kantin SMKN 2 Surabaya
@endcomponent
