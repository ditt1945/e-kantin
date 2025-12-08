@component('mail::message')
# Pesanan Dikonfirmasi

Halo {{ $order->user->name }},

Pesanan Anda telah dikonfirmasi dan sedang dipersiapkan!

## Detail Pesanan

**Kode Pesanan:** {{ $order->kode_pesanan }}  
**Kantin:** {{ $order->tenant->nama_tenant }}  
**Total Harga:** Rp {{ number_format($order->total_harga, 0, ',', '.') }}  
**Waktu Pesan:** {{ $order->created_at->format('d M Y H:i') }}

### Item Pesanan

@foreach($order->orderItems as $item)
- {{ $item->quantity }}x {{ $item->menu->nama_menu }} - Rp {{ number_format($item->subtotal, 0, ',', '.') }}
@endforeach

@if($order->payment)
**Status Pembayaran:** {{ ucfirst($order->payment->status) }}  
**Invoice:** {{ $order->payment->invoice_number }}
@endif

@component('mail::button', ['url' => route('customer.orders')])
Lihat Pesanan
@endcomponent

Terima kasih telah memesan di e-Kantin! 🎉

Salam,  
Tim e-Kantin - Kantin SMKN 2 Surabaya
@endcomponent
