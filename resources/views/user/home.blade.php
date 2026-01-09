@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/ss/home.css') }}">

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- floating shapes (HTML nodes) for parallax/animations -->
        <div class="hero-shape shape-1"></div>
        <div class="hero-shape shape-2"></div>
        <div class="hero-shape shape-3"></div>
        <div class="hero-shape shape-4"></div>

        <div class="hero-content">
            <h1>Temukan Perjalananmu</h1>
            <p>Atur jadwal kedatangan dan keberangkatan Anda di pelabuhan</p>

            <!-- Booking Form -->
            <div class="booking-card">
                <form id="ticketForm" action="{{ route('find_ticket') }}" method="GET">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label class="form-label">Pelabuhan Asal</label>
                            <select id="asalSelect" name="origin_port_id" class="form-select" required>
                                <option selected disabled>Pilih Pelabuhan Asal</option>
                                @foreach ($ports as $port)
                                    <option value="{{ $port->id }}" data-name="{{ strtolower($port->name) }}">
                                        {{ $port->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Pelabuhan Tujuan</label>
                            <input type="text" id="tujuanInput" class="form-control" placeholder="Pelabuhan Tujuan"
                                readonly>
                            <input type="hidden" id="tujuanId" name="destination_port_id">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label class="form-label">Pilih Tanggal</label>
                            <input type="date" name="departure_date" class="form-control" id="departureDateInput"
                                min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                            <label class="form-label">Jam Keberangkatan</label>
                            <select id="jamselect" name="departure_time" class="form-select">
                                <option selected disabled>Pilih Jam Keberangkatan</option>
                            </select>
                        </div>
                    </div>

                    <div class="section">
   
                    <input type="hidden" name="booking_items" id="bookingItems">
                    <!-- Passenger selector button now displays selected passengers live -->
                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">Penumpang</label>
                        <button type="button" class="btn-passenger-select" id="passengerSelectBtn">
                            <span>👥</span> Pilih Penumpang dan Kendaraan
                        </button>
                        <!-- Penumpang -->
                        <input type="hidden" name="passenger_type" id="passengerTypeInput" value="">
                        <input type="hidden" name="passenger_count" id="passengerCountInput" value="0">
                        <input type="hidden" name="passenger_price" id="passengerPriceInput" value="0">

                        <!-- Kendaraan -->
                        <input type="hidden" name="vehicle_type" id="vehicleTypeInput" value="">
                        <input type="hidden" name="vehicle_count" id="vehicleCountInput" value="0">
                        <input type="hidden" name="vehicle_price" id="vehiclePriceInput" value="0">

                    </div>
                    

                    <!-- Total Price -->
                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">Total Harga Tiket</label>
                        <input type="text" id="ticketPrice" name="price" class="form-control" readonly
                            style="background: var(--light); font-weight: 600; color: var(--accent); font-size: 1.1rem;">
                    </div>

                    <button type="submit" class="btn-search">
                        🎫 Temukan Perjalananmu
                    </button>
                </form>
            </div>
        </div>
        <!-- decorative wave -->
    </section>

    <!-- Hero wave SVG -->
    <div style="margin-top:-6px;">
        <svg class="hero-wave" viewBox="0 0 1440 120" preserveAspectRatio="none"
            style="width:100%; height:80px; display:block;">
            <defs>
                <linearGradient id="g1" x1="0%" x2="100%">
                    <stop offset="0%" stop-color="#0077d6" stop-opacity="0.18" />
                    <stop offset="100%" stop-color="#0052a3" stop-opacity="0.06" />
                </linearGradient>
            </defs>
            <path d="M0,32 C220,120 440,0 720,32 C1000,64 1220,8 1440,48 L1440 120 L0 120 Z" fill="url(#g1)"></path>
        </svg>
    </div>

    <!-- Modal for passenger selection -->
<div class="modal-overlay" id="passengerModal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">Pilih Penumpang</div>

        <div class="passenger-card">
            {{-- Loop untuk penumpang --}}
            @foreach ($passengerTypes as $ptype)
                @php
                    $slug = Str::slug($ptype->name, '_');
                    // Format harga display
                    $priceDisplay = $ptype->price ? 'Rp ' . number_format($ptype->price, 0, ',', '.') : '-';
                @endphp
                <div class="passenger-row" data-slug="{{ $slug }}">
                    <div class="passenger-info">
                        <h6>{{ $ptype->name }}</h6>
                        {{-- <small>{{ $ptype->description ?? '' }}</small> --}}
                        <div class="price-display" id="{{ $slug }}PriceDisplay">Harga: {{ $priceDisplay }}</div>
                    </div>
                    <div class="counter-group">
                        <button type="button" class="counter-btn" id="minus{{ $slug }}">−</button>
                        <span id="count{{ $slug }}" class="counter-display">0</span>
                        <button type="button" class="counter-btn" id="plus{{ $slug }}">+</button>
                    </div>
                </div>
            @endforeach

            {{-- Kendaraan --}}
            <div class="passenger-row" style="align-items: flex-start; gap: .5rem;">
                <div class="passenger-info" style="flex: 1 1 320px;">
                    <h6>Kendaraan</h6>
                    <small>(sudah termasuk hanya supir)</small>
                    <div class="price-display" id="vehiclePriceDisplay">Harga: -</div>
                </div>
                <div style="flex: 1 1 320px;">
                    <div class="vehicle-list" style="display:flex; flex-direction:column; gap:.5rem;">
                        @foreach ($vehicleTypes as $vtype)
                            @php
                                $slug = Str::slug($vtype->name, '_');
                                $priceDisplay = $vtype->price ? 'Rp ' . number_format($vtype->price, 0, ',', '.') : '-';
                            @endphp
                            <label style="display:flex; align-items:center; gap:.5rem; justify-content:space-between;">
                                <div style="display:flex; align-items:center; gap:.5rem;">
                                    <input type="checkbox" class="vehicle-checkbox" data-type="{{ $vtype->name }}"data-ticket-type-id="{{ $vtype->ticket_type_id }}"
                                        id="vehicle_chk_{{ $slug }}">
                                    <span>{{ $vtype->name }}</span>
                                </div>
                                <div style="display:flex; align-items:center; gap:.35rem;">
                                    <button type="button" class="counter-btn vehicle-minus"
                                        data-type="{{ $vtype->name }}">−</button>
                                    <span class="counter-display vehicle-count" data-type="{{ $vtype->name }}"
                                        id="count_{{ $slug }}">0</span>
                                    <button type="button" class="counter-btn vehicle-plus"
                                        data-type="{{ $vtype->name }}">+</button>
                                    <small class="vehicle-item-price" data-type="{{ $vtype->name }}"
                                        id="price_{{ $slug }}">{{ $priceDisplay }}</small>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="button" class="btn-done" id="donePassenger">SELESAI</button>
        </div>
    </div>
</div>


   <section id="offers" class="offers-section reveal py-5 bg-white">
    <div class="container">
        <div class="offers-header text-center mb-5">
            <h2 class="fw-bold text-dark">Daftar Tarif Penyeberangan</h2>
            <p class="text-muted">Informasi harga tiket berdasarkan kategori penumpang dan kendaraan</p>
        </div>

        <div class="row g-4 justify-content-center">

            <div class="col-lg-4 col-md-6 d-flex">
                <div class="offer-card border rounded-3 shadow-none w-100 h-100 d-flex flex-column bg-white">
                    <div class="p-3 border-bottom bg-white d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bx bx-group me-1"></i> Penumpang
                        </h6>
                        <small class="text-muted fw-semibold">ID #01</small>
                    </div>

                    <div class="card-body p-0 flex-grow-1">
                        <ul class="list-group list-group-flush">
                            @foreach($ticketprices as $price)
                                @if($price->ticket_type_id == 1)
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-light">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3">
                                                <i class="bx bx-user text-secondary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block fw-semibold text-dark">{{ $price->name }}</span>
                                                <small class="text-muted" style="font-size: 0.7rem;">Tiket Penumpang</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="d-block fw-bold text-dark">
                                                Rp {{ number_format($price->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="p-3 border-top mt-auto">
                        <div class="d-flex align-items-center text-muted">
                            <i class="bx bx-shield-quarter me-1"></i>
                            <span style="font-size: 0.75rem;">Termasuk asuransi perjalanan</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex">
                <div class="offer-card border rounded-3 shadow-none w-100 h-100 d-flex flex-column bg-white">
                    <div class="p-3 border-bottom bg-white d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bx bx-cycling me-1"></i> Kendaraan Roda 2
                        </h6>
                        <small class="text-muted fw-semibold">ID #02</small>
                    </div>

                    <div class="card-body p-0 flex-grow-1">
                        <ul class="list-group list-group-flush">
                            @foreach($ticketprices as $price)
                                @if($price->ticket_type_id == 2)
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-light">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3">
                                                <i class="bx bx-package text-secondary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block fw-semibold text-dark">{{ $price->name }}</span>
                                                <small class="text-muted" style="font-size: 0.7rem;">Tiket Kendaraan</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="d-block fw-bold text-dark">
                                                Rp {{ number_format($price->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="p-3 border-top mt-auto">
                        <div class="d-flex align-items-center text-muted">
                            <i class="bx bx-shield-quarter me-1"></i>
                            <span style="font-size: 0.75rem;">Termasuk asuransi perjalanan</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex">
                <div class="offer-card border rounded-3 shadow-none w-100 h-100 d-flex flex-column bg-white">
                    <div class="p-3 border-bottom bg-white d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bx bx-car me-1"></i> Kendaraan Roda 4
                        </h6>
                        <small class="text-muted fw-semibold">ID #03</small>
                    </div>

                    <div class="card-body p-0 flex-grow-1">
                        <ul class="list-group list-group-flush">
                            @foreach($ticketprices as $price)
                                @if($price->ticket_type_id == 3)
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-light">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3">
                                                <i class="bx bx-bus text-secondary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block fw-semibold text-dark">{{ $price->name }}</span>
                                                <small class="text-muted" style="font-size: 0.7rem;">Tiket Kendaraan</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="d-block fw-bold text-dark">
                                                Rp {{ number_format($price->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="p-3 border-top mt-auto">
                        <div class="d-flex align-items-center text-muted">
                            <i class="bx bx-shield-quarter me-1"></i>
                            <span style="font-size: 0.75rem;">Termasuk asuransi perjalanan</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



    <!-- Why Choose Us Section -->
    <section id="why-us" class="why-section reveal">
        <div style="max-width: 1100px; margin: 0 auto; padding: 0 1rem;">
            <h2>Kenapa Memilih Kami?</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem;">
                <div class="why-card">
                    <img src="{{ asset('assets/img/cyber-security.png') }}" alt="Keamanan">
                    <h4>Keamanan & Kenyaman</h4>
                    <p>Kami memastikan setiap transaksi berlangsung aman, cepat, dan mudah. Dengan sistem pembayaran
                        terenkripsi dan layanan pemesanan yang praktis, Anda bisa menikmati perjalanan tanpa khawatir.</p>
                </div>

                <div class="why-card">
                    <img src="{{ asset('assets/img/accessible.png') }}" alt="Kemudahan">
                    <h4>Kemudahan Pemesanan</h4>
                    <p>Kami memahami waktu Anda sangat berharga. Platform kami hadir untuk memberikan kemudahan dalam
                        memesan tiket kapal ferry secara online dengan sistem yang cepat dan efisien.</p>
                </div>

                <div class="why-card">
                    <img src="{{ asset('assets/img/best-price.png') }}" alt="Harga">
                    <h4>Harga Terjangkau</h4>
                    <p>Kami percaya perjalanan yang menyenangkan tidak harus mahal. Platform kami menawarkan harga tiket
                        yang terjangkau dan transparan, lengkap dengan berbagai promo menarik setiap minggunya.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="partners" class="about-section reveal">
        <div style="max-width: 1100px; margin: 0 auto; padding: 0 1rem;">
            <h2>Tentang Kami</h2>

            <div style="display: grid; gap: 1.5rem;">
                <div class="about-card">
                    <div class="about-card-content">
                        <img src="{{ asset('assets/img/kmp1.jpg') }}" alt="About">
                        <div class="about-card-body">
                            <h5>Visi Kami</h5>
                            <p>Menjadi platform terdepan dalam industri transportasi laut yang memberikan pengalaman terbaik
                                kepada setiap pengguna.</p>
                            <small>Sejak 2020</small>
                        </div>
                    </div>
                </div>

                <div class="about-card">
                    <div class="about-card-content" style="flex-direction: row-reverse;">
                        <img src="{{ asset('assets/img/kmp2.jpg') }}" alt="About">
                        <div class="about-card-body">
                            <h5>Misi Kami</h5>
                            <p>Menyediakan layanan pemesanan tiket ferry yang mudah, aman, dan terjangkau untuk semua
                                kalangan masyarakat Indonesia.</p>
                            <small>Melayani dengan sepenuh hati</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    window.HomePageData = {
        muaraId: {!! json_encode($ports->firstWhere('name', 'Muara')->id ?? null) !!},
        sipingganId: {!! json_encode($ports->firstWhere('name', 'Sipinggan')->id ?? null) !!}
    };

    window.AppConfig = {
        getDepartureTimesUrl: "{{ route('get.departure.times') }}"
    };
</script>

<script src="{{ asset('assets/js/home.js') }}"></script>

@endsection
