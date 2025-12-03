@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-4">Riwayat Pemesanan Pengguna</h5>
            <div class="d-flex align-items-center gap-4">
                <img 
                    src="{{ optional($detail)->foto_profil 
                            ? asset('storage/' . optional($detail)->foto_profil) 
                            : asset('assets/img/avatars/1.png') }}"
                    alt="Foto Profil"
                    class="rounded-circle border border-2"
                    style="width: 110px; height: 110px; object-fit: cover; border-color: #0d6efd;"
                >
                <div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                </div>
            </div>
            <ul class="nav nav-tabs mt-4 mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'berhasil' ? 'active' : '' }}"
                       href="{{ route('history.status', 'berhasil') }}">
                        Berhasil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'menunggu' ? 'active' : '' }}"
                       href="{{ route('history.status', 'menunggu') }}">
                        Menunggu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'dibatalkan' ? 'active' : '' }}"
                       href="{{ route('history.status', 'dibatalkan') }}">
                        Gagal
                    </a>
                </li>
            </ul>
            @if($booking->isEmpty())
                <p class="text-center text-muted mt-4">
                    Tidak ada pesanan dengan status <strong>{{ ucfirst($status) }}</strong>.
                </p>
            @else
                @foreach($booking as $b)
                    <div class="card mb-3 p-3">
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Booking ID</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <!-- <th>Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $b->id }}</td>
                                    <td>{{ $b->created_at->format('d M Y') }}</td>
                                    <td>{{ ucfirst($b->status) }}</td>
                                    <td>
                                        @if($status === 'berhasil' && session('booking_id'))
                                            <div class="mb-3 text-center">
                                                <a href="{{ route('book_ticket.download', session('booking_id')) }}" target="_blank" class="btn bk-btn-primary w-50 rounded-pill">
                                                    Download E-Ticket
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
