@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Notifikasi</h2>
        <p class="text-muted mb-0">Riwayat pemberitahuan terbaru untuk akun Anda.</p>
    </div>
    <form method="POST" action="{{ route('notifications.mark_all_read') }}">
        @csrf
        <button class="btn btn-outline-primary"><i class="fas fa-check me-1"></i>Tandai semua dibaca</button>
    </form>
</div>

<div class="card shadow-sm">
    <div class="list-group list-group-flush">
        @forelse($notifications as $notification)
            <div class="list-group-item d-flex justify-content-between align-items-start {{ is_null($notification->read_at) ? 'bg-light' : '' }}">
                <div>
                    <div class="fw-semibold">{{ $notification->data['message'] ?? 'Notifikasi' }}</div>
                    <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
                @if(is_null($notification->read_at))
                    <span class="badge bg-primary">Baru</span>
                @endif
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="fas fa-bell-slash fa-3x mb-3"></i>
                <p>Tidak ada notifikasi.</p>
            </div>
        @endforelse
    </div>
    <div class="p-3">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
