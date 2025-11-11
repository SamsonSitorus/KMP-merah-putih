@extends('layouts.app')

@section('content')
@php
    use App\Models\Port;
    use App\Models\TicketStock;

    $originId = request()->query('origin_port_id');
    $destinationId = request()->query('destination_port_id');
    $departureDate = request()->query('departure_date');
    $dewasaCount = (int) request()->query('dewasa_count', 0);
    $anakCount = (int) request()->query('anak_count', 0);
    $vehicleType = request()->query('vehicle_type');
    $vehicleCount = (int) request()->query('vehicle_count', 0);

    $origin = $originId ? Port::find($originId) : null;
    $destination = $destinationId ? Port::find($destinationId) : null;

    // Gunakan method model untuk mencari stok tiket agar logic tidak bercampur di view
    $results = TicketStock::searchByRoute($originId, $destinationId, $departureDate);
@endphp

<div class="container py-4">

    <!-- Search summary -->
    <div class="bg-white shadow-sm p-4 rounded mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">{{ $origin->name ?? '-' }} → {{ $destination->name ?? '-' }}</h4>
            <p class="text-muted mb-0">{{ $departureDate ?? '-' }} | {{ $dewasaCount }} Dewasa • {{ $anakCount }} Anak-anak</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Ubah Pencarian</a>
    </div>

    @if($results->isEmpty())
        <div class="alert alert-warning">Tidak ditemukan jadwal untuk rute dan tanggal yang dipilih.</div>
    @else
        <div class="row gy-3">
            @foreach($results as $stock)
                @php
                    $prices = $stock->prices()->get();
                    $passengerPrices = $prices->whereNotNull('passenger_type')->groupBy('passenger_type')->map(fn($g) => $g->first()->price);
                    $vehiclePrices = $prices->whereNotNull('vehicle_type')->groupBy('vehicle_type')->map(fn($g) => $g->first()->price);

                    $total = 0;
                    $total += ($dewasaCount * ($passengerPrices['Dewasa'] ?? 0));
                    $total += ($anakCount * ($passengerPrices['Anak-anak'] ?? 0));
                    $total += ($vehicleCount * ($vehiclePrices[$vehicleType] ?? 0));
                @endphp

                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Berangkat {{ \Carbon\Carbon::parse($stock->departure_time)->format('H:i') }}</h5>
                                <small class="text-muted">Stok tersisa: {{ $stock->remaining_stock }}</small>
                            </div>

                            <div class="text-end">
                                <div class="mb-2 fw-bold text-danger">{{ $total > 0 ? 'Rp ' . number_format($total,0,',','.') : 'Rp 0' }}</div>
                                <form action="{{ route('book_ticket') }}" method="GET">
                                    <input type="hidden" name="ticket_stock_id" value="{{ $stock->id }}">
                                    <input type="hidden" name="departure_date" value="{{ $departureDate }}">
                                    <input type="hidden" name="departure_time" value="{{ $stock->departure_time }}">
                                    <input type="hidden" name="dewasa_count" value="{{ $dewasaCount }}">
                                    <input type="hidden" name="anak_count" value="{{ $anakCount }}">
                                    <input type="hidden" name="vehicle_type" value="{{ $vehicleType }}">
                                    <input type="hidden" name="vehicle_count" value="{{ $vehicleCount }}">
                                    <input type="hidden" name="total_price" value="{{ $total }}">
                                    <button class="btn btn-primary">Pesan Sekarang</button>
                                </form>
                            </div>
                        </div>

                        <div class="card-footer bg-white">
                            <div class="d-flex gap-3 flex-wrap">
                                <div>Dewasa: {{ isset($passengerPrices['Dewasa']) ? 'Rp ' . number_format($passengerPrices['Dewasa'],0,',','.') : '-' }}</div>
                                <div>Anak-anak: {{ isset($passengerPrices['Anak-anak']) ? 'Rp ' . number_format($passengerPrices['Anak-anak'],0,',','.') : '-' }}</div>
                                <div>Kendaraan ({{ $vehicleType ?? '-' }}): {{ isset($vehiclePrices[$vehicleType]) ? 'Rp ' . number_format($vehiclePrices[$vehicleType],0,',','.') : '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
