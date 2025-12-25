@extends('layouts.app')
@section('content')
<style>
    @media print {
        .no-print {
            display: none;
        }
    }
    .eticket-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 1rem 2rem;
        border: 2px dashed #0077d6;
        border-radius: 12px;    
        font-family: Arial, sans-serif;
        color: #0f1724;
    }
    .eticket-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .eticket-title {
        font-weight: 700;
        font-size: 1.4rem;
        color: #0077d6;
        margin-bottom: 0.2rem;
    }
    .eticket-subtitle {
        font-size: 0.9rem;
        color: #525252;
    }
    .eticket-section {
        margin-bottom: 1rem;
    }
    .eticket-section h3 {
        font-size: 1.1rem;
        font-weight: 700;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.3rem;
        margin-bottom: 0.5rem;
    }
    .eticket-detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.25rem 0;
        border-bottom: 1px dashed #cbd5e1;
    }
    .eticket-footer {
        text-align: center;
        margin-top: 2rem;
    }
    .btn-print {
        background-color: #0077d6;
        border: none;
        color: white;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 6px;
        cursor: pointer;
    }
</style>

<div class="eticket-container">
    <div class="eticket-header">
        <div class="eticket-title">Konfirmasi E-Tiket Pemesanan</div>
        <div class="eticket-subtitle">ID Pemesanan: {{ $booking->id }}</div>
        <div class="eticket-subtitle">Tanggal Penerbitan: {{ now()->format('d-m-Y') }}</div>
    </div>

    <div class="eticket-section">
        <h3>Informasi Penumpang</h3>
        <div class="eticket-detail-row">
            <div>Nama</div>
            <div>{{ $booking->user->name ?? 'N/A' }}</div>
        </div>
        <div class="eticket-detail-row">
            <div>Email</div>
            <div>{{ $booking->user->email ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="eticket-section">
        <h3>Detail Pemesanan</h3>
        <div class="eticket-detail-row">
            <div>ID Tiket Stock</div>
            <div>{{ $booking->ticket_stock_id }}</div>
        </div>
        <div class="eticket-detail-row">
            <div>Tanggal Keberangkatan</div>
            <div>{{ $booking->departure_date }}</div>
        </div>
        <div class="eticket-detail-row">
            <div>Waktu Keberangkatan</div>
            <div>{{ $booking->departure_time }}</div>
        </div>
        <div class="eticket-detail-row">
            <div>Penumpang Dewasa</div>
            <div>{{ $booking->dewasa_count }}</div>
        </div>
        <div class="eticket-detail-row">
            <div>Penumpang Anak-anak</div>
            <div>{{ $booking->anak_count }}</div>
        </div>
    </div>

    <div class="eticket-section">
        <h3>Detail Kendaraan</h3>
        @if($booking->vehicles->count())
            @foreach($booking->vehicles as $vehicle)
                <div class="eticket-detail-row">
                    <div>{{ $vehicle->vehicle_type }}</div>
                    <div>{{ $vehicle->count }} × Rp {{ number_format($vehicle->unit_price, 0, ',', '.') }}</div>
                </div>
            @endforeach
        @else
            <div>Tidak ada kendaraan yang dipesan</div>
        @endif
    </div>

    <div class="eticket-section">
        <h3>Total Harga</h3>
        <div class="eticket-detail-row">
            <div></div>
            <div><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></div>
        </div>
    </div>

    <div class="eticket-footer no-print">
        <button class="btn-print" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>
</div>

@endsection
