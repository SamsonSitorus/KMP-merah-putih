@extends('layouts.app')

@section('content')
<style>
    /* Menggunakan variabel warna standar Sneat */
    :root {
        --sn-primary: #696cff;
        --sn-secondary: #8592a3;
        --sn-success: #71dd37;
        --sn-card-bg: #ffffff;
        --sn-body-bg: #f5f5f9;
    }

    .ticket-wrapper {
        background-color: var(--sn-body-bg);
        padding: 3rem 1rem;
        min-height: 100vh;
    }

    .eticket-card {
        max-width: 750px;
        margin: 0 auto;
        background: var(--sn-card-bg);
        border-radius: 0.5rem; /* Standar Sneat card */
        box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
        position: relative;
        border: none;
    }

    /* Notch Tiket */
    .eticket-card::before, .eticket-card::after {
        content: "";
        position: absolute;
        width: 30px;
        height: 30px;
        background-color: var(--sn-body-bg);
        border-radius: 50%;
        top: 45%;
        z-index: 2;
    }
    .eticket-card::before { left: -15px; }
    .eticket-card::after { right: -15px; }

    .ticket-header {
        background: linear-gradient(72.47deg, #696cff 22.16%, rgba(105, 108, 255, 0.7) 76.47%);
        color: #fff;
        padding: 2rem;
        border-radius: 0.5rem 0.5rem 0 0;
        text-align: center;
    }

    .ticket-body {
        padding: 2.5rem;
    }

    .divider-dashed {
        border-top: 2px dashed #d9dee3;
        margin: 2rem 0;
        position: relative;
    }

    /* Route Display Sneat Style */
    .route-section {
        background: #fcfcfd;
        border: 1px solid #d9dee3;
        border-radius: 0.5rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .port-info h3 {
        color: var(--sn-primary);
        font-weight: 700;
        margin-bottom: 0;
        font-size: 1.5rem;
    }

    .port-info span {
        color: var(--sn-secondary);
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 600;
    }

    /* Info Grid */
    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--sn-secondary);
        font-weight: 600;
        margin-bottom: 0.25rem;
        display: block;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #566a7f;
        display: flex;
        align-items: center;
    }

    .bx-icon-bg {
        width: 32px;
        height: 32px;
        background: rgba(105, 108, 255, 0.1);
        color: var(--sn-primary);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    /* Passenger Table */
    .table-custom {
        width: 100%;
        border-spacing: 0 8px;
        border-collapse: separate;
    }
    .table-custom td {
        background: #f8f9fa;
        padding: 0.8rem 1rem;
        color: #566a7f;
    }
    .table-custom tr td:first-child { border-radius: 8px 0 0 8px; font-weight: 600; }
    .table-custom tr td:last-child { border-radius: 0 8px 8px 0; }

    @media print {
        .no-print { display: none !important; }
        .ticket-wrapper { background: white; padding: 0; }
        .eticket-card { box-shadow: none; border: 1px solid #d9dee3; }
        .ticket-header { background: #696cff !important; -webkit-print-color-adjust: exact; }
    }
</style>

<div class="ticket-wrapper">
    <div class="eticket-card">
        {{-- HEADER --}}
        <div class="ticket-header">
            <h4 class="text-white fw-bold mb-1">E-TICKET PENYEBERANGAN</h4>
            <p class="mb-0 opacity-75">Booking ID: <span class="fw-bold">#{{ $booking->id }}</span></p>
        </div>

        <div class="ticket-body">
            {{-- RUTE PERJALANAN --}}
            <div class="route-section shadow-sm">
                <div class="port-info">
                    <span>Asal</span>
                    <h3>{{ $booking->ticketStock->originPort->name ?? 'N/A' }}</h3>
                </div>
                <div class="text-center px-3">
                    <i class="bx bx-ship text-primary fs-2"></i>
                    <div class="d-flex align-items-center mt-1">
                        <div style="height: 2px; width: 30px; background: #d9dee3;"></div>
                        <i class="bx bx-chevron-right text-secondary"></i>
                        <div style="height: 2px; width: 30px; background: #d9dee3;"></div>
                    </div>
                </div>
                <div class="port-info text-end">
                    <span>Tujuan</span>
                    <h3>{{ $booking->ticketStock->destinationPort->name ?? 'N/A' }}</h3>
                </div>
            </div>

            {{-- INFORMASI UTAMA --}}
            <div class="row g-4">
                <div class="col-sm-6">
                    <label class="info-label">Jadwal Keberangkatan</label>
                    <div class="info-value">
                        <div class="bx-icon-bg"><i class="bx bx-calendar"></i></div>
                        {{ $booking->departure_date }}
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="info-label">Jam Keberangkatan</label>
                    <div class="info-value">
                        <div class="bx-icon-bg"><i class="bx bx-time-five"></i></div>
                        {{ $booking->departure_time }} WIB
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="info-label">Pemesan</label>
                    <div class="info-value">
                        <div class="bx-icon-bg"><i class="bx bx-user"></i></div>
                        {{ $booking->booker_name }}
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="info-label">Status</label>
                    <div class="mt-1">
                        <span class="badge bg-label-success fs-tiny text-uppercase fw-bold">
                            {{ $booking->status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="divider-dashed"></div>

            {{-- DAFTAR PENUMPANG --}}
            <div class="mb-4">
                <h6 class="fw-bold mb-3 d-flex align-items-center">
                    <i class="bx bx-group me-2 text-primary"></i> Daftar Penumpang
                </h6>
                <table class="table-custom">
                    <tbody>
                        @forelse($booking->Pessanger as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td class="text-end text-muted">Penumpang Dewasa</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center">Data tidak ditemukan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- KENDARAAN --}}
            @if($booking->vehicles->count() > 0)
            <div class="mb-2">
                <h6 class="fw-bold mb-3 d-flex align-items-center">
                    <i class="bx bx-car me-2 text-primary"></i> Detail Kendaraan
                </h6>
                @foreach($booking->vehicles as $v)
                <div class="d-flex align-items-center p-3 mb-2 border rounded-3 bg-light">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-taxi"></i>
                        </span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0 fw-bold">{{ $v->no_plat }}</h6>
                            <small class="text-muted">{{ $v->vehicle_type }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="divider-dashed"></div>

            {{-- FOOTER TIKET --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <label class="info-label mb-0">Total Pembayaran</label>
                    <h3 class="text-primary fw-bolder mb-0">Rp {{ number_format($booking->total_price,0,',','.') }}</h3>
                </div>
                <div class="no-print">
                    <button class="btn btn-primary d-flex align-items-center" onclick="window.print()">
                        <i class="bx bx-printer me-2"></i> Cetak Tiket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <a href="{{ route('history.status', 'berhasil') }}" class="btn btn-link text-muted">
            <i class="bx bx-left-arrow-alt me-1"></i> Kembali ke Riwayat
        </a>
    </div>
</div>
@endsection