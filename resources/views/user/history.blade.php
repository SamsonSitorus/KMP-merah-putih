@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                <div class="position-relative">
                    <img 
                        src="{{ optional($detail)->foto_profil 
                                ? asset('storage/' . optional($detail)->foto_profil) 
                                : asset('assets/img/avatars/1.png') }}"
                        alt="Foto Profil"
                        class="rounded-circle border border-4 border-white shadow-sm"
                        style="width: 100px; height: 100px; object-fit: cover;"
                    >
                </div>
                <div class="text-center text-md-start">
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                    <div class="mt-2">
                        <span class="badge {{ $latest && $latest->status == 'berhasil' ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                            Status Terakhir: {{ $latest ? ucfirst($latest->status) : 'Tidak ada pesanan' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @if($status === 'menunggu_persetujuan')
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center" role="alert">
        <i class="fas fa-info-circle me-3 fa-lg"></i>
        {{-- <div>
            Pesanan Anda sedang dalam proses verifikasi. Mohon tunggu beberapa saat.
        </div> 
    </div>
    @endif --}}

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-2">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'berhasil' ? 'active shadow-sm' : 'text-secondary' }}"
                       href="{{ route('history.status', 'berhasil') }}">
                        <i class="fas fa-check-circle me-1"></i> Berhasil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'menunggu_persetujuan' ? 'active shadow-sm' : 'text-secondary' }}"
                       href="{{ route('history.status', 'menunggu_persetujuan') }}">
                        <i class="fas fa-clock me-1"></i> Menunggu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'dibatalkan' ? 'active shadow-sm' : 'text-secondary' }}"
                       href="{{ route('history.status', 'dibatalkan') }}">
                        <i class="fas fa-times-circle me-1"></i> Gagal
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        @if($booking->isEmpty())
            <div class="col-12 text-center py-5">
                <img src="{{ asset('assets/img/illustrations/empty-cart.png') }}" alt="Empty" style="width: 150px;" class="opacity-50">
                <p class="text-muted mt-3">Tidak ada riwayat pesanan dengan status <strong>{{ ucfirst($status) }}</strong>.</p>
            </div>
        @else
            @foreach($booking as $b)
                <div class="col-12 mb-3">
                    <div class="card border-0 shadow-sm hover-shadow transition">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <div class="text-center">
                                            <h6 class="fw-bold mb-0 text-primary">{{ $b->ticketStock->originPort->name ?? '-' }}</h6>
                                            <small class="text-muted">Asal</small>
                                        </div>
                                        <div class="px-4">
                                            <i class="fas fa-long-arrow-alt-right text-muted"></i>
                                        </div>
                                        <div class="text-center">
                                            <h6 class="fw-bold mb-0 text-primary">{{ $b->ticketStock->destinationPort->name ?? '-' }}</h6>
                                            <small class="text-muted">Tujuan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0 text-md-center">
                                    <p class="mb-0 fw-medium"><i class="far fa-calendar-alt me-2 text-muted"></i>{{ $b->created_at->format('d M Y') }}</p>
                                    <small class="text-muted">Tanggal Pemesanan</small>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0 text-md-center">
                                    @php
                                        $badgeClass = 'bg-light text-dark';
                                        if($b->status == 'berhasil') $badgeClass = 'bg-success-subtle text-success';
                                        if($b->status == 'dibatalkan') $badgeClass = 'bg-danger-subtle text-danger';
                                        if($b->status == 'menunggu_persetujuan') $badgeClass = 'bg-warning-subtle text-warning';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} border px-3 py-2 w-100">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    @if($b->status === 'berhasil')
                                        <a href="{{ route('book_ticket.download', $b->id) }}" target="_blank" class="btn btn-primary rounded-pill px-4 shadow-sm w-100 w-md-auto">
                                            <i class="fas fa-download me-2"></i>E-Ticket
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary rounded-pill px-4 disabled w-100 w-md-auto">
                                            Detail
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition {
        transition: all 0.3s ease;
    }
    .nav-pills .nav-link.active {
        background-color: #0d6efd;
    }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .bg-warning-subtle { background-color: #fff3cd; }
</style>
@endsection
