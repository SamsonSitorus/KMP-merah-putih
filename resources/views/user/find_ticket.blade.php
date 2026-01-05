@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-blue: #03254c;
        --accent-orange: #ff5e1f;
        --soft-gray: #f8f9fa;
        --border-color: #e9ecef;
    }

    body { background-color: #f4f7fa; }

    /* Header Pencarian yang lebih Clean */
    .search-summary-card {
        background: var(--primary-blue);
        color: white;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(3, 37, 76, 0.15);
    }

    /* Card Hasil Pencarian */
    .result-card {
        border: 1px solid var(--border-color);
        border-radius: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #fff;
        overflow: hidden;
    }
    .result-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
        border-color: #d1d9e6;
    }

    /* Styling Waktu Keberangkatan */
    .time-display {
        background-color: var(--soft-gray);
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        min-width: 120px;
    }
    .time-text {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--primary-blue);
        line-height: 1;
    }

    /* Status Stok */
    .badge-stock {
        background-color: #fff;
        border: 1px solid var(--border-color);
        color: #6c757d;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
    }

    /* Harga */
    .price-label { font-size: 0.8rem; color: #6c757d; font-weight: 500; }
    .price-amount {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--accent-orange);
    }

    /* Tombol */
    .btn-book {
        background: var(--accent-orange);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: 0.3s;
    }
    .btn-book:hover {
        background: #e64a19;
        color: white;
        box-shadow: 0 4px 15px rgba(255, 94, 31, 0.3);
    }

    /* Garis Pemisah Vertikal */
    .v-divider {
        width: 1px;
        background-color: var(--border-color);
        align-self: stretch;
    }
</style>

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