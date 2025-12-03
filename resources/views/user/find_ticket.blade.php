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

    // Support multiple vehicle types: vehicle_types[] and vehicle_counts[]
    $vehicleTypes = (array) request()->query('vehicle_types', []);
    $vehicleCounts = (array) request()->query('vehicle_counts', []);
    // normalize counts to integers
    $vehicleCounts = array_map(fn($v) => (int) $v, $vehicleCounts);

    $origin = $originId ? Port::find($originId) : null;
    $destination = $destinationId ? Port::find($destinationId) : null;

    // Gunakan method model untuk mencari stok tiket agar logic tidak bercampur di view
    $results = TicketStock::searchByRoute($originId, $destinationId, $departureDate);
@endphp
<div class="container py-4">

    <!-- Search Summary -->
    <div class="bg-white shadow-sm p-4 rounded mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">{{ $origin->name ?? '-' }} → {{ $destination->name ?? '-' }}</h4>
            <p class="text-muted mb-0">{{ $departureDate ?? '-' }} | {{ $dewasaCount }} Dewasa • {{ $anakCount }} Anak-anak</p>
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
                    $prices = $stock->prices()->get();
                    $passengerPrices = $prices->whereNotNull('passenger_type')->groupBy('passenger_type')->map(fn($g) => $g->first()->price);
                    $vehiclePrices = $prices->whereNotNull('vehicle_type')->groupBy('vehicle_type')->map(fn($g) => $g->first()->price);

                    $total = 0;
                    $total += ($dewasaCount * ($passengerPrices['Dewasa'] ?? 0));
                    $total += ($anakCount * ($passengerPrices['Anak-anak'] ?? 0));

                    $vehicleTotal = 0;
                    foreach ($vehicleTypes as $i => $vt) {
                        $cnt = $vehicleCounts[$i] ?? 0;
                        $unit = $vehiclePrices[$vt] ?? 0;
                        $vehicleTotal += ($cnt * $unit);
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
                                <div class="result-meta">Stok tersisa: {{ $stock->remaining_stock }}</div>
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
                                        <input type="hidden" name="anak_count" value="{{ $anakCount }}">
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
                                    {{ isset($passengerPrices['Dewasa'])
                                        ? 'Rp ' . number_format($passengerPrices['Dewasa'], 0, ',', '.')
                                        : '-' }}
                                </div>
                                <div>
                                    Anak-anak:
                                    {{ isset($passengerPrices['Anak-anak'])
                                        ? 'Rp ' . number_format($passengerPrices['Anak-anak'], 0, ',', '.')
                                        : '-' }}
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
