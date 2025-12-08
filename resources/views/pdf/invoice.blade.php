<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $payment->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #374151; font-size: 12px; line-height: 1.5; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; }
        .title { font-size: 28px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #ffffff; margin-bottom: 5px; }
        .header .subtitle { font-size: 14px; color: #e0e7ff; margin-bottom: 2px; }
        .header .contact { font-size: 12px; color: #c7d2fe; }
        .meta { background: #f9fafb; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
        .meta div { margin-bottom: 6px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 6px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f3f4f6; font-weight: bold; color: #374151; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em; }
        .summary { margin-top: 20px; width: 40%; margin-left: auto; background: #f9fafb; padding: 15px; border-radius: 6px; }
        .summary td { border: 0; padding: 8px 0; }
        .summary tr.total td { border-top: 2px solid #3b82f6; font-size: 16px; font-weight: bold; color: #1e40af; }
        .badge { display: inline-block; padding: 6px 12px; font-size: 11px; border-radius: 20px; text-transform: uppercase; font-weight: bold; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-primary { background: #dbeafe; color: #1e3a8a; }
        p { margin-top: 30px; font-size: 11px; color: #6b7280; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="title">e-Kantin</div>
            <div class="subtitle">SMKN 2 Surabaya</div>
            <div class="contact">support@e-kantin.local</div>
        </div>
        <div class="meta">
            <div><strong>Invoice:</strong> {{ $payment->invoice_number }}</div>
            <div><strong>Tanggal:</strong> {{ optional($payment->created_at)->format('d M Y H:i') }}</div>
            <div><strong>Status Pembayaran:</strong>
                @php
                    $statusClass = match(true) {
                        $payment->isPaid() => 'badge-success',
                        $payment->status === 'failed' => 'badge-danger',
                        default => 'badge-warning'
                    };
                @endphp
                <span class="badge {{ $statusClass }}">{{ strtoupper($payment->status) }}</span>
            </div>
        </div>
    </div>

    <div class="meta" style="margin-bottom: 20px;">
        <div><strong>Customer:</strong> {{ $payment->order->user->name ?? '-' }}</div>
        <div><strong>Email:</strong> {{ $payment->order->user->email ?? '-' }}</div>
        <div><strong>Kantin:</strong> {{ $payment->order->tenant->nama_tenant ?? '-' }}</div>
        <div><strong>Kode Pesanan:</strong> {{ $payment->order->kode_pesanan }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Kuantitas</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment->order->orderItems as $item)
                <tr>
                    <td>{{ $item->menu->nama_menu ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $subtotal = $payment->order->orderItems->sum('subtotal');
    @endphp

    <table class="summary">
        <tr>
            <td style="text-align: right;">Subtotal</td>
            <td style="text-align: right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr class="total">
            <td style="text-align: right;">Total</td>
            <td style="text-align: right;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p style="margin-top: 40px; font-size: 11px; color: #6b7280;">
        Invoice ini dibuat otomatis oleh sistem e-Kantin. Simpan dokumen ini sebagai bukti pembayaran.
    </p>
</body>
</html>
