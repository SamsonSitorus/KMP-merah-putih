@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ asset('assets/ss/e_ticket.css') }}">


<div class="ticket-wrapper">
    <div class="eticket-card">
        {{-- HEADER --}}
        <div class="ticket-header">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h5 class="text-white fw-bold mb-0">E-TICKET</h5>
                    <small class="opacity-75">Booking ID #{{ $booking->id }}</small>
                </div>
                <div class="qr-placeholder text-center">
                   {{-- logo --}}
                    <img src="{{ asset('assets/img/logo.webp') }}" class="img-fluid" alt="QR Code" style="max-width: 100%; max-height: 100%;">
                </div>  
            </div>

            <div class="route-display">
                <div class="route-point">
                    <span>Asal</span>
                    <h2>{{ $booking->ticketStock->originPort->name ?? 'N/A' }}</h2>
                </div>
                <div class="ship-icon-wrapper">
                    <div class="line"></div>
                    <i class="bx bxs-ship fs-3" style="z-index: 1;"></i>
                </div>
                <div class="route-point text-end">
                    <span>Tujuan</span>
                    <h2>{{ $booking->ticketStock->destinationPort->name ?? 'N/A' }}</h2>
                </div>
            </div>
        </div>

        {{-- CUTOUT --}}
        <div class="ticket-cutout">
            <div class="dashed-line"></div>
        </div>

        <div class="ticket-body">
            {{-- DETAIL JADWAL --}}
            <div class="row g-4 mb-5">
                <div class="col-6">
                    <span class="label-muted">Tanggal Keberangkatan</span>
                    <div class="d-flex align-items-center">
                        <i class="bx bx-calendar me-2 text-primary"></i>
                        <span class="value-text">{{ \Carbon\Carbon::parse($booking->departure_date)->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <span class="label-muted">Jam Keberangkatan</span>
                    <div class="d-flex align-items-center">
                        <i class="bx bx-time-five me-2 text-primary"></i>
                        <span class="value-text">{{ $booking->departure_time }} WIB</span>
                    </div>
                </div>
                <div class="col-6">
                    <span class="label-muted">Nama Pemesan</span>
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user me-2 text-primary"></i>
                        <span class="value-text">{{ $booking->booker_name }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <span class="label-muted">Status</span>
                    <div>
                        <span class="badge bg-label-success text-uppercase">{{ $booking->status }}</span>
                    </div>
                </div>
            </div>

            {{-- PENUMPANG --}}
            <div class="mb-4">
                <h6 class="fw-bold mb-3"><i class="bx bx-group me-2"></i>Daftar Penumpang</h6>
                @forelse($booking->Pessanger as $p)
                <div class="data-item d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-dark">{{ $p->name }}</div>
                        <small class="text-muted">{{ $p->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $p->age }} Tahun</small>
                    </div>
                </div>
                @empty
                <div class="text-center p-3 text-muted">Tidak ada data penumpang</div>
                @endforelse
            </div>

            {{-- KENDARAAN --}}
            @if($booking->vehicles->count() > 0)
            <div class="mb-4">
                <h6 class="fw-bold mb-3"><i class="bx bx-car me-2"></i>Detail Kendaraan</h6>
                @foreach($booking->vehicles as $v)
                <div class="data-item d-flex align-items-center">
                    <div class="bg-label-primary p-2 rounded me-3">
                        <i class="bx bx-taxi fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ $v->no_plat }}</div>
                        <small class="text-muted">{{ $v->vehicle_name }} ({{ $v->vehicle_year }}) • {{ $v->vehicle_type }}</small>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="dashed-line my-4"></div>

            {{-- FOOTER --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="label-muted">Total Pembayaran</span>
                    <h4 class="text-primary fw-bolder mb-0">Rp {{ number_format($booking->total_price,0,',','.') }}</h4>
                </div>
                <div class="no-print">
                    <button class="btn btn-primary btn-lg px-4" onclick="window.print()">
                        <i class="bx bx-printer me-2"></i> Cetak
                    </button>
                </div>
            </div>

            <div class="mt-4 p-3 rounded-3 bg-light border">
                <small class="text-muted d-block">
                    <i class="bx bx-info-circle me-1"></i> <strong>Catatan:</strong> 
                    Mohon datang 30 menit sebelum keberangkatan untuk proses verifikasi tiket di pelabuhan.
                </small>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <a href="{{ route('history.status', 'berhasil') }}" class="btn btn-link text-secondary text-decoration-none">
            <i class="bx bx-left-arrow-alt me-1"></i> Kembali ke Riwayat
        </a>
    </div>
</div>
@endsection