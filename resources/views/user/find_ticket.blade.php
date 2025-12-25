@extends('layouts.app')

@section('content')
@php
use App\Models\Port;
use App\Models\TicketStock;
use App\Models\TicketPrice;

    $originId = request()->query('origin_port_id');
    $destinationId = request()->query('destination_port_id');
    $departureDate = request()->query('departure_date');
    $departureTime = request()->query('departure_time'); // dapat dari request juga
    $dewasaCount = (int) request()->query('dewasa_count', 0);
    $bayiCount = (int) request()->query('bayi_count', 0);

    $vehicleTypes = (array) request()->query('vehicle_types', []);
    $vehicleCounts = (array) request()->query('vehicle_counts', []);
    $vehicleCounts = array_map(fn($v) => (int) $v, $vehicleCounts);

    $origin = $originId ? Port::find($originId) : null;
    $destination = $destinationId ? Port::find($destinationId) : null;

    // Ambil semua harga tiket, keyBy 'name' untuk akses gampang
    $prices = TicketPrice::all()->keyBy('name');
    $dewasaPrice = $prices['Dewasa']->price ?? 0;
    $bayiPrice = $prices['Bayi']->price ?? 0;

    $vehiclePrices = [];
    foreach ($vehicleTypes as $type) {
        $vehiclePrices[$type] = $prices[$type]->price ?? 0;
    }

    $results = TicketStock::searchByRoute($originId, $destinationId, $departureDate, $departureTime);

@endphp

<div class="container py-4">
    <!-- Search Summary -->
    <div class="bg-white shadow-sm p-4 rounded mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">{{ $origin->name ?? '-' }} → {{ $destination->name ?? '-' }}</h4>
            <p class="text-muted mb-0">{{ $departureDate ?? '-' }} | {{ $dewasaCount }} Dewasa • {{ $bayiCount }} Bayi</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Ubah Pencarian</a>
    </div>

    @if($results->isEmpty())
        <div class="alert alert-warning">
            Tidak ditemukan jadwal untuk rute dan tanggal yang dipilih.
        </div>
    @else
        <div class="row gy-3">
            @foreach($results as $stock)
                @php
                    // Stok penumpang dan kendaraan berdasarkan kolom di table ticket_stocks
                    $passengerStock = $stock->stock_passenger ?? 0;
                    $vehicleStockMap = [
                        'Mobil' => $stock->stock_roda_4 ?? 0,
                        'Motor' => $stock->stock_roda_2 ?? 0,
                    ];

                    // Batasi jumlah penumpang yang bisa dipesan sesuai stok
                    $totalPassengersRequested = $dewasaCount + $bayiCount;
                    if ($totalPassengersRequested > $passengerStock) {
                        $totalPassengersRequested = $passengerStock;
                        // Opsional: kamu bisa juga batasi dewasa & bayi secara proporsional jika ingin lebih akurat
                    }

                    // Hitung harga total penumpang dengan stok terbatas
                    $total = 0;
                    if ($totalPassengersRequested > 0) {
                        // Asumsi stok penumpang dibagi proporsional
                        $dewasaEffective = min($dewasaCount, $totalPassengersRequested);
                        $bayiEffective = min($bayiCount, $totalPassengersRequested - $dewasaEffective);
                        $total += ($dewasaEffective * $dewasaPrice) + ($bayiEffective * $bayiPrice);
                    }

                    // Hitung harga kendaraan dan batasi stok kendaraan
                    $vehicleTotal = 0;
                    foreach ($vehicleTypes as $i => $vt) {
                        $countRequested = $vehicleCounts[$i] ?? 0;
                        $stockAvailable = $vehicleStockMap[$vt] ?? 0;
                        $countUsed = min($countRequested, $stockAvailable);
                        $unitPrice = $vehiclePrices[$vt] ?? 0;
                        $vehicleTotal += $countUsed * $unitPrice;
                    }
                    $total += $vehicleTotal;

                @endphp

                <div class="col-12">
                    <div class="offer-card result-card">
                        <!-- Top Information -->
                        <div class="result-top d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">
                                    Berangkat {{ \Carbon\Carbon::parse($stock->departure_time)->format('H:i') }}
                                </h5>
                                <div class="result-meta">Stok penumpang tersisa: {{ $passengerStock }}</div>
                                <div class="result-meta">
                                    Stok kendaraan:
                                    @foreach($vehicleStockMap as $type => $stok)
                                        <div>{{ $type }}: {{ $stok }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="result-price">
                                    {{ $total > 0 ? 'Rp ' . number_format($total, 0, ',', '.') : 'Rp 0' }}
                                </div>
                                <div class="result-actions mt-2 d-flex justify-content-end">
                                    <form action="{{ route('book_ticket') }}" method="GET" class="d-flex gap-2 align-items-center">
                                        <input type="hidden" name="ticket_stock_id" value="{{ $stock->id }}">
                                        <input type="hidden" name="departure_date" value="{{ $departureDate }}">
                                        <input type="hidden" name="departure_time" value="{{ $stock->departure_time }}">
                                        <input type="hidden" name="dewasa_count" value="{{ $dewasaCount }}">
                                        <input type="hidden" name="bayi_count" value="{{ $bayiCount }}">
                                        @foreach($vehicleTypes as $i => $vt)
                                            <input type="hidden" name="vehicle_types[]" value="{{ $vt }}">
                                            <input type="hidden" name="vehicle_counts[]" value="{{ $vehicleCounts[$i] ?? 0 }}">
                                        @endforeach
                                        <!-- Legacy -->
                                        <input type="hidden" name="vehicle_type" value="{{ $vehicleTypes[0] ?? '' }}">
                                        <input type="hidden" name="vehicle_count" value="{{ $vehicleCounts[0] ?? 0 }}">
                                        <input type="hidden" name="total_price" value="{{ $total }}">
                                        <button class="btn-cta" type="submit">Lihat Detail</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Detail -->
                        <div class="pt-3 mt-2" style="border-top:1px solid rgba(3,37,76,0.04);">
                            <div class="d-flex gap-4 flex-wrap">
                                <div>
                                    Dewasa:
                                    {{ $dewasaPrice ? 'Rp ' . number_format($dewasaPrice, 0, ',', '.') : '-' }}
                                </div>
                                <div>
                                    Bayi:
                                    {{ $bayiPrice ? 'Rp ' . number_format($bayiPrice, 0, ',', '.') : '-' }}
                                </div>
                                <div style="min-width: 180px;">
                                    Kendaraan:
                                    @if(count($vehicleTypes))
                                        @foreach($vehicleTypes as $i => $vt)
                                            <div style="white-space:nowrap;">
                                                {{ $vt }} x {{ $vehicleCounts[$i] ?? 0 }} :
                                                {{ isset($vehiclePrices[$vt])
                                                    ? 'Rp ' . number_format($vehiclePrices[$vt], 0, ',', '.')
                                                    : '-' }}
                                            </div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
    