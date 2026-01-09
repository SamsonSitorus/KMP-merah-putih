@extends('layouts.app')

@section('content')\ <link rel="stylesheet" href="{{ asset('assets/ss/find_ticket.css') }}">

<div class="container py-5">
    <div class="search-summary-card p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="fs-4 fw-bold">{{ $origin->name ?? 'Asal' }}</span>
                <i class="bi bi-arrow-right-circle-fill fs-5 opacity-75"></i>
                <span class="fs-4 fw-bold">{{ $destination->name ?? 'Tujuan' }}</span>
            </div>
            <div class="d-flex flex-wrap gap-3 opacity-75 small">
                <span><i class="bi bi-calendar3 me-1"></i> {{ $departureDate ?? '-' }}</span>
                <span><i class="bi bi-people-fill me-1"></i> {{ $totalPassengers }} Orang</span>
                <span><i class="bi bi-truck-flatbed me-1"></i> {{ $totalVehicles }} Kendaraan</span>
            </div>
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-light btn-sm rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Ubah Pencarian
            </a>
        </div>
    </div>

    <h5 class="mb-4 fw-bold text-dark"><i class="bi bi- ship me-2 text-primary"></i>Jadwal Keberangkatan Tersedia</h5>

    @if($results->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 shadow-sm">
            <img src="https://illustrations.popsy.co/gray/falling.svg" alt="empty" style="width: 180px" class="mb-3 opacity-50">
            <h5 class="text-muted">Waduh, jadwal tidak ditemukan!</h5>
            <p class="text-muted small">Coba pilih tanggal atau rute lainnya.</p>
        </div>
    @else
        <div class="row gy-3">
            @foreach($results as $stock)
            <div class="col-12">
                <div class="result-card p-3 p-md-4 shadow-sm">
                    <div class="row align-items-center g-3">
                        
                        <div class="col-md-3">
                            <div class="time-display shadow-sm">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.65rem;">Berangkat</small>
                                <div class="time-text">{{ \Carbon\Carbon::parse($stock->departure_time)->format('H:i') }}</div>
                                <div class="mt-2 d-flex justify-content-center gap-1">
                                    <span class="badge-stock"><i class="bi bi-bicycle me-1"></i>{{ $stock->stock_roda_2 ?? 0 }}</span>
                                    <span class="badge-stock"><i class="bi bi-car-front me-1"></i>{{ $stock->stock_roda_4 ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 px-md-4">
                            <div class="row border-start-md ps-md-3">
                                <div class="col-6">
                                    <label class="d-block fw-bold text-primary small mb-2"><i class="bi bi-people me-1"></i> Penumpang</label>
                                   <ul class="list-unstyled mb-0 small text-muted">
                                        @foreach($passengers as $p)
                                            <li>
                                                {{ $p['name'] ?? '-' }} x {{ $p['count'] ?? 0 }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <label class="d-block fw-bold text-primary small mb-2"><i class="bi bi-car-front me-1"></i> Kendaraan</label>
                                    <ul class="list-unstyled mb-0 small text-muted">
                                        @forelse($vehicles as $v)
                                        <li>{{ $v['name'] ?? '-' }} x {{ $v['count'] ?? 0 }}</li>
                                    @empty
                                        <li class="fst-italic">Tanpa Kendaraan</li>
                                    @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 text-md-end text-center mt-3 mt-md-0 border-start-md">
                            <div class="mb-3">
                                <span class="price-label d-block">Harga Total</span>
                                <span class="price-amount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            
                            
                            <form action="{{ route('book_ticket') }}" method="GET">
                                <input type="hidden" name="ticket_stock_id" value="{{ $stock->id }}">
                                <input type="hidden" name="departure_date" value="{{ $departureDate }}">
                                <input type="hidden" name="departure_time" value="{{ $stock->departure_time }}">
                                <input type="hidden" name="booking_items" value='@json(["passengers"=>$passengers,"vehicles"=>$vehicles])'>
                                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                                @foreach($ticketTypeIds as $id)
                                <input type="hidden" name="ticket_type_ids[]" value="{{ $id }}">
                                @endforeach
                                <button class="btn btn-book w-100 shadow-sm" type="submit">
                                    Pilih Jadwal <i class="bi bi-chevron-right ms-1"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection