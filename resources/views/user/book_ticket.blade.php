@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-blue: #03254c;
        --accent-orange: #ff5e1f;
        --bg-light: #f4f7fa;
    }

    body { background-color: var(--bg-light); }

    .step-header {
        background: white;
        border-radius: 12px;
        border-left: 5px solid var(--accent-orange);
    }

    .form-section-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e9ecef;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
        color: #6c757d;
    }

    .form-control {
        border-left: none;
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none;
        background-color: #fff;
    }

    .summary-sidebar {
        position: sticky;
        top: 20px;
    }

    .summary-card {
        border-radius: 16px;
        border: none;
        background: var(--primary-blue);
        color: white;
    }

    .price-badge {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 15px;
    }

    .btn-confirm {
        background: var(--accent-orange);
        color: white;
        border: none;
        padding: 15px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: 0.3s;
    }

    .btn-confirm:hover {
        background: #e64a19;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 94, 31, 0.3);
    }

    .passenger-number {
        width: 30px;
        height: 30px;
        background: var(--primary-blue);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.8rem;
        margin-right: 10px;
    }
</style>

@php
    $ticketStockId = request('ticket_stock_id');
    $departureDate = request('departure_date');
    $departureTime = request('departure_time');
    $totalPrice = request('total_price');
    $bookingItems = json_decode(request('booking_items'), true) ?? [];
    $passengers = $bookingItems['passengers'] ?? [];
    $vehicles   = $bookingItems['vehicles'] ?? [];
@endphp

<div class="container py-5">
    <form id="bookingForm" action="{{ route('book_ticket.detail') }}" method="POST">
        @csrf
        
        <input type="hidden" name="ticket_stock_id" value="{{ $ticketStockId }}">
        <input type="hidden" name="departure_date" value="{{ $departureDate }}">
        <input type="hidden" name="departure_time" value="{{ $departureTime }}">
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
        <input type="hidden" name="booking_items" value='@json($bookingItems)'>
       @foreach(request('ticket_type_ids', []) as $id)
            <input type="hidden" name="vehicle_categories[]" value="{{ $id }}">
        @endforeach


        <div class="row g-4">
            <div class="col-lg-8">
                <div class="step-header p-3 mb-4 shadow-sm">
                    <h4 class="mb-0 fw-bold text-dark">Lengkapi Data Pemesanan</h4>
                    <p class="text-muted small mb-0">Pastikan semua data sesuai dengan kartu identitas (KTP/Paspor/SIM).</p>
                </div>

                <div class="form-section-card p-4 shadow-sm mb-4">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-people-fill fs-4 text-primary me-2"></i>
                        <h5 class="mb-0 fw-bold">Data Penumpang</h5>
                    </div>

                    @foreach($passengers as $pIndex => $p)
                        @for($i = 1; $i <= $p['count']; $i++)
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">
                                    <span class="passenger-number">{{ $i }}</span> {{ $p['name'] }}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" 
                                           name="passengers[{{ $pIndex }}][names][]" 
                                           class="form-control" 
                                           placeholder="Nama Lengkap Sesuai Identitas" 
                                           required>
                                    <input type="hidden" name="passenger_types[]" value="{{ $p['name'] }}">
                                </div>
                            </div>
                        @endfor
                    @endforeach
                </div>

                @if(count($vehicles))
                    <div class="form-section-card p-4 shadow-sm mb-4">
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-truck-flatbed fs-4 text-primary me-2"></i>
                            <h5 class="mb-0 fw-bold">Data Kendaraan</h5>
                        </div>

                        @foreach($vehicles as $vIndex => $v)
                            @for($i = 1; $i <= $v['count']; $i++)
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase text-muted">
                                        No. Polisi {{ $v['name'] }} {{ $i }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                        <input type="text" 
                                               name="vehicles[{{ $vIndex }}][plates][]" 
                                               class="form-control" 
                                               placeholder="Contoh: BK 1234 ABC" 
                                               style="text-transform: uppercase"
                                               required>
                                        <input type="hidden" name="vehicle_types[]" value="{{ $v['name'] }}">
                                    </div>
                                    <div class="form-text mt-1 small">Masukkan plat nomor tanpa spasi jika perlu.</div>
                                </div>
                            @endfor
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="summary-sidebar">
                    <div class="card summary-card shadow-lg">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                            
                            <div class="mb-4">
                                <small class="opacity-75 d-block mb-1">Jadwal Keberangkatan</small>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-check me-2 fs-5"></i>
                                    <span class="fw-bold">{{ $departureDate }}</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <i class="bi bi-clock me-2 fs-5"></i>
                                    <span class="fw-bold">{{ $departureTime }} WIB</span>
                                </div>
                            </div>

                            <hr class="border-light opacity-25">

                            <div class="price-badge mb-4">
                                <small class="opacity-75 d-block mb-1">Total Pembayaran</small>
                                <h3 class="mb-0 fw-bold text-warning">Rp {{ number_format($totalPrice, 0, ',', '.') }}</h3>
                            </div>

                            <button type="submit" class="btn btn-confirm w-100 mb-3">
                                Konfirmasi Booking <i class="bi bi-arrow-right-short ms-2"></i>
                            </button>
                            
                            <a href="{{ url()->previous() }}" class="btn btn-link text-white text-decoration-none w-100 text-center small opacity-75">
                                <i class="bi bi-chevron-left me-1"></i> Kembali ke Pemilihan
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 p-3 border rounded-4 bg-white shadow-sm small">
                        <div class="d-flex">
                            <i class="bi bi-shield-check text-success fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Pembayaran Aman</h6>
                                <p class="text-muted mb-0">Data Anda dilindungi dengan enkripsi SSL standar internasional.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection