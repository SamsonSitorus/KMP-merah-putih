@extends('layouts.app')

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
        <p>Set Your Arrival and Departure Schedule at the Port</p>

        <!-- Booking Form -->
        <div class="booking-card">
            <form id="ticketForm" action="{{ route('find_ticket') }}" method="GET">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label class="form-label">Pelabuhan Asal</label>
                        <select id="asalSelect" name="origin_port_id" class="form-select">
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
                        <input type="text" id="tujuanInput" class="form-control" placeholder="Pelabuhan Tujuan" readonly>
                        <input type="hidden" id="tujuanId" name="destination_port_id">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label class="form-label">Pilih Tanggal</label>
                        <input type="date" name="departure_date" class="form-control" id="departureDateInput" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div>
                        <label class="form-label">Jam Keberangkatan</label>
                        <input type="text" id="jamKeberangkatan" name="departure_time" class="form-control" readonly>
                    </div>
                </div>

                <!-- Passenger selector button now displays selected passengers live -->
                <div style="margin-bottom: 1rem;">
                    <label class="form-label">Penumpang</label>
                    <button type="button" class="btn-passenger-select" id="passengerSelectBtn">
                        <span>👥</span> Pilih Penumpang
                    </button>
                    <input type="hidden" name="dewasa_count" id="dewasaCountInput" value="0">
                    <input type="hidden" name="anak_count" id="anakCountInput" value="0">
                    <input type="hidden" name="dewasa_price" id="dewasaPriceInput" value="0">
                    <input type="hidden" name="anak_price" id="anakPriceInput" value="0">
                    <!-- Vehicle booking fields -->
                    <input type="hidden" name="vehicle_type" id="vehicleTypeInput" value="">
                    <input type="hidden" name="vehicle_count" id="vehicleCountInput" value="0">
                    <input type="hidden" name="vehicle_price" id="vehiclePriceInput" value="0">
                </div>

                <!-- Total Price -->
                <div style="margin-bottom: 1rem;">
                    <label class="form-label">Total Harga Tiket</label>
                    <input type="text" id="ticketPrice" name="price" class="form-control" readonly style="background: var(--light); font-weight: 600; color: var(--accent); font-size: 1.1rem;">
                </div>

                <button type="submit" class="btn-search">
                    🎫 Find Your Ticket
                </button>
            </form>
        </div>
    </div>
    <!-- decorative wave -->
</section>

<!-- Hero wave SVG -->
<div style="margin-top:-6px;">
    <svg class="hero-wave" viewBox="0 0 1440 120" preserveAspectRatio="none" style="width:100%; height:80px; display:block;">
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
<div class="modal-overlay" id="passengerModal">
    <div class="modal-content">
        <div class="modal-header">Pilih Penumpang</div>
        
        <div class="passenger-card">
            <!-- Dewasa Row -->
            <div class="passenger-row">
                <div class="passenger-info">
                    <h6>Dewasa</h6>
                    <small>Usia 5 tahun ke atas</small>
                    <div class="price-display" id="dewasaPriceDisplay">Harga: -</div>
                </div>
                <div class="counter-group">
                    <button type="button" class="counter-btn" id="minusDewasa">−</button>
                    <span id="countDewasa" class="counter-display">0</span>
                    <button type="button" class="counter-btn" id="plusDewasa">+</button>
                </div>
            </div>

            <!-- Anak-anak Row -->
            <div class="passenger-row">
                <div class="passenger-info">
                    <h6>Anak-anak</h6>
                    <small>Usia 2–5 tahun</small>
                    <div class="price-display" id="anakPriceDisplay">Harga: -</div>
                </div>
                <div class="counter-group">
                    <button type="button" class="counter-btn" id="minusAnak">−</button>
                    <span id="countAnak" class="counter-display">0</span>
                    <button type="button" class="counter-btn" id="plusAnak">+</button>
                </div>
            </div>

            <!-- Kendaraan Row -->
            <div class="passenger-row" style="align-items: center;">
                <div class="passenger-info">
                    <h6>Kendaraan</h6>
                    <small>Tambahkan kendaraan (opsional)</small>
                    <div class="price-display" id="vehiclePriceDisplay">Harga: -</div>
                </div>
                <div class="counter-group">
                    <select id="vehicleTypeSelect" class="form-select" style="min-width: 140px; padding: 0.4rem;">
                        <option value="" selected>-- Pilih Kendaraan --</option>
                        @foreach($vehicleTypes as $vtype)
                            <option value="{{ $vtype }}">{{ $vtype }}</option>
                        @endforeach
                    </select>

                    <button type="button" class="counter-btn" id="minusVehicle">−</button>
                    <span id="countVehicle" class="counter-display">0</span>
                    <button type="button" class="counter-btn" id="plusVehicle">+</button>
                </div>
            </div>

            <button type="button" class="btn-done" id="donePassenger">SELESAI</button>
        </div>
    </div>
</div>

<!-- Latest Offers Section -->
<section id="offers" class="offers-section reveal">
    <div style="max-width: 1100px; margin: 0 auto; padding: 0 1rem;">
        <div class="offers-header">
            <h2>🏷️ Latest Offers</h2>
            <a href="#">View All Special Offers</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
            <!-- Vehicles -->
            <div class="offer-card stagger-item tilt">
                <div class="card-inner">
                <div class="offer-badge">🚗 Roda 4</div>
                <h5>Daftar Harga Mobil</h5>
                <div class="price-item">
                    <span>🚗 Mobil Sedan</span>
                    <span>{{ isset($vehiclePrices['Mobil Sedan']) ? 'Rp ' . number_format($vehiclePrices['Mobil Sedan'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                <div class="price-item">
                    <span>🚚 Mobil Box</span>
                    <span>{{ isset($vehiclePrices['Mobil Box']) ? 'Rp ' . number_format($vehiclePrices['Mobil Box'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                <div class="price-item">
                    <span>🚛 Mobil Truck</span>
                    <span>{{ isset($vehiclePrices['Mobil Truck']) ? 'Rp ' . number_format($vehiclePrices['Mobil Truck'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                <div class="price-item">
                    <span>🚙 Mobil SUV</span>
                    <span>{{ isset($vehiclePrices['Mobil SUV']) ? 'Rp ' . number_format($vehiclePrices['Mobil SUV'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                </div>
            </div>

            <!-- Passengers -->
            <div class="offer-card stagger-item tilt">
                <div class="card-inner">
                <div class="offer-badge">👥 Penumpang</div>
                <h5>Daftar Harga Penumpang</h5>
                <div class="price-item">
                    <span>👶 Anak-anak</span>
                    <span>{{ isset($passengerPrices['Anak-anak']) ? 'Rp ' . number_format($passengerPrices['Anak-anak'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                <div class="price-item">
                    <span>🧑 Dewasa</span>
                    <span>{{ isset($passengerPrices['Dewasa']) ? 'Rp ' . number_format($passengerPrices['Dewasa'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                </div>
            </div>

            <!-- Motorcycles -->
            <div class="offer-card stagger-item tilt">
                <div class="card-inner">
                <div class="offer-badge">🏍️ Roda 2</div>
                <h5>Daftar Harga Sepeda Motor</h5>
                <div class="price-item">
                    <span>🛵 Motor Bebek</span>
                    <span>{{ isset($vehiclePrices['Motor Bebek']) ? 'Rp ' . number_format($vehiclePrices['Motor Bebek'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                <div class="price-item">
                    <span>🏍️ Motor Sport</span>
                    <span>{{ isset($vehiclePrices['Motor Sport']) ? 'Rp ' . number_format($vehiclePrices['Motor Sport'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                <div class="price-item">
                    <span>🛵 Motor Matic</span>
                    <span>{{ isset($vehiclePrices['Motor Matic']) ? 'Rp ' . number_format($vehiclePrices['Motor Matic'], 0, ',', '.') : 'Rp 0' }}</span>
                </div>
                <div class="price-item">
                    <span>🛻 Motor Trail</span>
                    <span>{{ isset($vehiclePrices['Motor Trail']) ? 'Rp ' . number_format($vehiclePrices['Motor Trail'], 0, ',', '.') : 'Rp 0' }}</span>
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
                <p>Kami memastikan setiap transaksi berlangsung aman, cepat, dan mudah. Dengan sistem pembayaran terenkripsi dan layanan pemesanan yang praktis, Anda bisa menikmati perjalanan tanpa khawatir.</p>
            </div>

            <div class="why-card">
                <img src="{{ asset('assets/img/accessible.png') }}" alt="Kemudahan">
                <h4>Kemudahan Pemesanan</h4>
                <p>Kami memahami waktu Anda sangat berharga. Platform kami hadir untuk memberikan kemudahan dalam memesan tiket kapal ferry secara online dengan sistem yang cepat dan efisien.</p>
            </div>

            <div class="why-card">
                <img src="{{ asset('assets/img/best-price.png') }}" alt="Harga">
                <h4>Harga Terjangkau</h4>
                <p>Kami percaya perjalanan yang menyenangkan tidak harus mahal. Platform kami menawarkan harga tiket yang terjangkau dan transparan, lengkap dengan berbagai promo menarik setiap minggunya.</p>
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
                    <img src="../assets/img/elements/18.png" alt="About">
                    <div class="about-card-body">
                        <h5>Visi Kami</h5>
                        <p>Menjadi platform terdepan dalam industri transportasi laut yang memberikan pengalaman terbaik kepada setiap pengguna.</p>
                        <small>Sejak 2020</small>
                    </div>
                </div>
            </div>

            <div class="about-card">
                <div class="about-card-content" style="flex-direction: row-reverse;">
                    <img src="../assets/img/elements/19.png" alt="About">
                    <div class="about-card-body">
                        <h5>Misi Kami</h5>
                        <p>Menyediakan layanan pemesanan tiket ferry yang mudah, aman, dan terjangkau untuk semua kalangan masyarakat Indonesia.</p>
                        <small>Melayani dengan sepenuh hati</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5 bg-[#f8fafc] reveal">
    <div style="max-width:1100px; margin:0 auto; padding:0 1rem;">
        <h4 style="font-weight:700; margin-bottom:0.5rem;">Contact Us</h4>
        <p style="color:#555; margin-bottom:1rem;">Butuh bantuan? Hubungi kami di <strong>support@muaraputih.co.id</strong> atau telepon <strong>021-555-0123</strong>.</p>
        <div style="display:flex; gap:1rem; flex-wrap:wrap;">
            <a href="mailto:support@muaraputih.co.id" class="btn-search" style="width:auto; padding:0.6rem 1rem;">Email Us</a>
            <a href="tel:+62215550123" class="btn-done" style="width:auto; padding:0.6rem 1rem;">Call Us</a>
        </div>
    </div>
</section>

<!-- Scripts -->
<script>
    // minimal data for external home.js
    window.HomePageData = {
        muaraId: {!! json_encode($ports->firstWhere('name', 'Muara')->id ?? '') !!},
        sipingganId: {!! json_encode($ports->firstWhere('name', 'Sipinggan')->id ?? '') !!}
    };
</script>
<script src="{{ asset('assets/js/home.js') }}"></script>
@endsection
