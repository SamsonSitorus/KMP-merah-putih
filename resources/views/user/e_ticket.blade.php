@extends('layouts.app')

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .eticket-container, .eticket-container * {
            visibility: visible;
        }
        .eticket-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
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
    ul.passenger-list { padding-left: 1rem; margin: 0; }
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
        <div class="eticket-title">E-Ticket</div>
        <!-- <div class="eticket-subtitle">Booking ID: {{ $booking->id }}</div> -->
        <div class="eticket-subtitle">Tanggal pemesanan: {{ now()->format('d-m-Y') }}</div>
    </div>
    <div class="eticket-section">
        <h3>Informasi Penumpang</h3>
        <div class="eticket-detail-row">
            <div>Dipesan Oleh Akun: </div>
            <div>{{ $booking->booker_name ?? $booking->user->name ?? 'N/A' }}</div>
        </div>

        @php
            $dewasaPassengers = $booking->passenger->where('category','dewasa');
            $anakPassengers = $booking->passenger->where('category','anak');
        @endphp

        @if($dewasaPassengers->count())
            <div class="eticket-detail-row">
                <div>Penumpang Dewasa</div>
                <div>
                    <ul class="passenger-list">
                        @foreach($dewasaPassengers as $p)
                            <li>{{ $p->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if($anakPassengers->count())
            <div class="eticket-detail-row">
                <div>Penumpang Anak-anak</div>
                <div>
                    <ul class="passenger-list">
                        @foreach($anakPassengers as $p)
                            <li>{{ $p->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
    <div class="eticket-section">
        <h3>Detail Pemesanan</h3>
        <!-- <div class="eticket-detail-row">
            <div>Ticket Stock ID</div>
            <div>{{ $booking->ticket_stock_id }}</div>
        </div> -->
        <div class="eticket-detail-row">
            <div>Tanggal Berangkat</div>
            <div>{{ $booking->departure_date }}</div>
        </div>
        <div class="eticket-detail-row">
            <div>Jam Berangkat</div>
            <div>{{ $booking->departure_time }}</div>
        </div>
    </div>
    <div class="eticket-section">
        <h3>Detail Kendaraan</h3>
        @if($booking->vehicles->count())
            @foreach($booking->vehicles as $vehicle)
                <div class="eticket-detail-row">
                    <div>{{ $vehicle->vehicle_type }}</div>
                    <div>{{ $vehicle->vehicle_count }} × Rp {{ number_format($vehicle->unit_price ?? 0,0,',','.') }}</div>
                </div>
            @endforeach
        @else
            <div>Tidak ada kendaraan</div>
        @endif
    </div>

    <div class="eticket-section">
        <h3>Total Price</h3>
        <div class="eticket-detail-row">
            <div></div>
            <div><strong>Rp {{ number_format($booking->total_price,0,',','.') }}</strong></div>
        </div>
    </div>

    <div class="eticket-footer no-print">
        <button class="btn-print" onclick="window.print()">Print / Save PDF</button>
    </div>
</div>

@endsection
