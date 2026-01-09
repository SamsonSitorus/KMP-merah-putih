@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ asset('assets/ss/book_ticket.css') }}">

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
            {{-- Form Section --}}
            <div class="col-lg-8">
                <div class="step-header p-4 mb-4 shadow-sm">
                    <h4 class="mb-1 fw-bold text-dark">Lengkapi Data Pemesanan</h4>
                    <p class="text-muted small mb-0">Pastikan semua data sesuai dengan kartu identitas (KTP/Paspor/SIM).</p>
                </div>

                {{-- Penumpang Section --}}
                <div class="form-section-card p-4 shadow-sm mb-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-primary text-white">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Data Penumpang</h5>
                    </div>

                    @foreach($passengers as $pIndex => $p)
                        @for($i = 1; $i <= $p['count']; $i++)
                            <div class="sub-card-item">
                                <span class="item-label">
                                    <span class="badge bg-light text-primary me-2 border">{{ $i }}</span>
                                    {{ $p['name'] }}
                                </span>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" name="passengers[{{ $pIndex }}][names][]" class="form-control" placeholder="Contoh: Budi Santoso" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-semibold">Jenis Kelamin</label>
                                        <select name="passengers[{{ $pIndex }}][genders][]" class="form-select" required>
                                            <option value="" disabled selected>Pilih...</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-semibold">Usia</label>
                                        <input type="number" name="passengers[{{ $pIndex }}][ages][]" class="form-control" placeholder="Contoh: 22" min="0" required>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endforeach
                </div>

                {{-- Kendaraan Section --}}
                @if(count($vehicles))
                <div class="form-section-card p-4 shadow-sm mb-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-success text-white">
                            <i class="bi bi-truck-flatbed"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Data Kendaraan</h5>
                    </div>

                    @foreach($vehicles as $vIndex => $v)
                        @for($i = 1; $i <= $v['count']; $i++)
                            <div class="sub-card-item">
                                <span class="item-label text-success">
                                    <span class="badge bg-light text-success me-2 border">{{ $i }}</span>
                                    {{ $v['name'] }}
                                </span>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Merek/Tipe</label>
                                        <input type="text" name="vehicles[{{ $vIndex }}][vehicle_names][]" class="form-control" placeholder="Avanza, Xpander, dsb" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-semibold">Tahun</label>
                                        <input type="number" name="vehicles[{{ $vIndex }}][vehicle_years][]" class="form-control" placeholder="2022" min="1900" max="{{ date('Y') }}" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label small fw-semibold">Nomor Plat</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                            <input type="text" name="vehicles[{{ $vIndex }}][plates][]" class="form-control" placeholder="B 1234 ABC" style="text-transform: uppercase" required>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="vehicles[{{ $vIndex }}][vehicle_type]" value="{{ $v['name'] }}">
                            </div>
                        @endfor
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Sidebar Section --}}
            <div class="col-lg-4">
                <div class="summary-sidebar">
                    <div class="card summary-card p-2">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-receipt-cutoff me-2"></i> Ringkasan Pesanan
                            </h5>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="opacity-75 small">Tanggal</span>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($departureDate)->format('d M Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="opacity-75 small">Waktu</span>
                                    <span class="fw-bold">{{ $departureTime }} WIB</span>
                                </div>
                            </div>

                            <div class="price-badge mb-4 text-center">
                                <small class="opacity-75 d-block mb-1">Total Pembayaran</small>
                                <h2 class="mb-0 fw-bold text-warning">Rp {{ number_format($totalPrice, 0, ',', '.') }}</h2>
                            </div>

                            <button type="submit" class="btn btn-confirm w-100 mb-3 shadow">
                                Konfirmasi Booking <i class="bi bi-arrow-right-short ms-2"></i>
                            </button>
                            
                            <a href="{{ url()->previous() }}" class="btn btn-link text-white text-decoration-none w-100 text-center small opacity-75">
                                <i class="bi bi-chevron-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 p-4 border-0 rounded-4 bg-white shadow-sm small">
                        <div class="d-flex">
                            <div class="text-success fs-3 me-3">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Pembayaran Aman</h6>
                                <p class="text-muted mb-0">Enkripsi SSL 256-bit menjamin data Anda aman bersama kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection