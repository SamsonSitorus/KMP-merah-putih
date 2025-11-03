@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @if(session('payment_path'))
                    <div class="mb-3">File tersimpan: <a target="_blank" href="{{ asset('storage/' . session('payment_path')) }}">Lihat bukti</a></div>
                @endif
            @endif

            @php
                $ticketStockId = request()->query('ticket_stock_id');
                $departureDate = request()->query('departure_date');
                $departureTime = request()->query('departure_time');
                $dewasaCount = (int) request()->query('dewasa_count', 0);
                $anakCount = (int) request()->query('anak_count', 0);
                $vehicleType = request()->query('vehicle_type');
                $vehicleCount = (int) request()->query('vehicle_count', 0);
                $totalPrice = request()->query('total_price');
            @endphp

            <!-- Detail Pemesanan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">Detail Pemesanan</div>
                <div class="card-body">
                    <p class="mb-1"><strong>Ticket Stock ID:</strong> {{ $ticketStockId ?? '-' }}</p>
                    <p class="mb-1"><strong>Tanggal:</strong> {{ $departureDate ?? '-' }}</p>
                    <p class="mb-1"><strong>Jam:</strong> {{ $departureTime ?? '-' }}</p>
                    <p class="mb-1"><strong>Penumpang:</strong> {{ $dewasaCount }} Dewasa, {{ $anakCount }} Anak-anak</p>
                    <p class="mb-1"><strong>Kendaraan:</strong> {{ $vehicleType ? $vehicleType . ' × ' . $vehicleCount : 'Tidak membawa kendaraan' }}</p>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total Harga</span>
                        <span class="text-danger">{{ $totalPrice ? 'Rp ' . number_format($totalPrice,0,',','.') : 'Rp 0' }}</span>
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Pembayaran -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">Upload Bukti Pembayaran</div>
                <div class="card-body">
                    <form action="{{ route('book_ticket.confirm') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ticket_stock_id" value="{{ $ticketStockId }}">
                        <input type="hidden" name="departure_date" value="{{ $departureDate }}">
                        <input type="hidden" name="departure_time" value="{{ $departureTime }}">
                        <input type="hidden" name="dewasa_count" value="{{ $dewasaCount }}">
                        <input type="hidden" name="anak_count" value="{{ $anakCount }}">
                        <input type="hidden" name="vehicle_type" value="{{ $vehicleType }}">
                        <input type="hidden" name="vehicle_count" value="{{ $vehicleCount }}">
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                        <div class="mb-3">
                            <label for="payment_proof" class="form-label fw-semibold">Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*,.pdf" required>
                            <div class="form-text text-muted">Format yang diperbolehkan: JPG, PNG, atau PDF. Maks 2MB.</div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 rounded-pill">Kirim Bukti & Konfirmasi</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
