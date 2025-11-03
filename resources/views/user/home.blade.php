@extends('layouts.app')

@section('content')
<style>
    /* Enable smooth scrolling for anchor links */
    html { scroll-behavior: smooth; }
    :root {
        --primary: #0052a3; /* deeper blue */
        --primary-2: #0077d6;
        --secondary: #e6f5ff;
        --accent: #ff8c42; /* warm accent */
        --muted: #6b7280;
        --dark: #0f1724;
        --light: #ffffff;
        --glass: rgba(255,255,255,0.65);
        --border: rgba(15,23,36,0.06);
    }

    * {
        transition: background-color 220ms ease, color 220ms ease, transform 260ms ease, box-shadow 260ms ease;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(180deg, rgba(0,82,163,0.95) 0%, rgba(0,119,214,0.92) 40%, rgba(230,245,255,0.0) 100%);
        min-height: 74vh;
        position: relative;
        overflow: hidden;
        padding: 3rem 0 4rem 0;
        color: var(--light);
    }

    /* subtle background texture with ferry image */
    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: linear-gradient(180deg, rgba(0,82,163,0.18), rgba(0,119,214,0.06)), url('{{ asset('assets/img/ferry.jpeg') }}');
        background-size: cover;
        background-position: center;
        opacity: 0.95;
        filter: saturate(0.85) contrast(0.95) brightness(0.92);
        z-index: 1;
    }

    /* animated floating shapes in hero */
    .hero-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(18px);
        opacity: 0.14;
        z-index: 0;
        animation: float 8s infinite linear;
    }

    .hero-shape.shape-1 { width: 240px; height: 240px; background: radial-gradient(circle at 30% 30%, #00a3ff, #004b8a); left: -40px; top: 10%; animation-duration: 9s; }
    .hero-shape.shape-2 { width: 160px; height: 160px; background: radial-gradient(circle at 30% 30%, #ffd7b5, #ff8c42); right: -30px; top: 25%; animation-duration: 11s; }

    @keyframes float {
        0% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(-12px) translateX(6px); }
        100% { transform: translateY(0) translateX(0); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: var(--light);
        text-align: center;
        padding-top: 1rem;
    }

    .hero-content h1 {
        font-size: 2.8rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        text-shadow: 0 6px 28px rgba(2,6,23,0.45);
        animation: popIn 0.9s cubic-bezier(.2,.9,.3,1) both;
    }

    @keyframes popIn {
        0% { opacity: 0; transform: translateY(-18px) scale(.98); }
        60% { opacity: 1; transform: translateY(6px) scale(1.02); }
        100% { transform: translateY(0) scale(1); }
    }

    .hero-content p {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        opacity: 0.95;
        animation: slideUp 0.8s ease-out 0.2s both;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Booking Form */
    .booking-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,255,255,0.75));
        backdrop-filter: blur(6px) saturate(120%);
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 18px 50px rgba(2,6,23,0.12);
        padding: 1.5rem;
        max-width: 920px;
        margin: 0 auto;
        transform-origin: center top;
        animation: lift 0.8s cubic-bezier(.16,.8,.3,1) both;
    }

    @keyframes lift {
        0% { opacity: 0; transform: translateY(18px) scale(.995); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .booking-card .form-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
    }

    .booking-card .form-control,
    .booking-card .form-select {
        border: 1px solid rgba(15,23,36,0.06);
        border-radius: 12px;
        padding: 0.72rem 0.85rem;
        font-size: 0.95rem;
        background: transparent;
        box-shadow: inset 0 -1px 0 rgba(15,23,36,0.02);
        transition: box-shadow 220ms ease, transform 220ms ease, border-color 220ms ease;
    }

    .booking-card .form-control::placeholder { color: var(--muted); }

    .booking-card .form-control:focus,
    .booking-card .form-select:focus {
        border-color: var(--primary-2);
        box-shadow: 0 8px 26px rgba(3,37,76,0.08);
        transform: translateY(-2px);
        outline: none;
    }

    /* Updated passenger button to show selected passengers clearly */
    .btn-passenger-select {
        border: 2px solid var(--border);
        border-radius: 8px;
        padding: 0.8rem;
        font-size: 0.9rem;
        background: white;
        color: var(--dark);
        cursor: pointer;
        text-align: left;
        transition: all 0.3s ease;
        width: 100%;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-passenger-select:hover {
        border-color: var(--primary);
        background: var(--light);
    }

    /* New styling when passengers are selected - more prominent */
    .btn-passenger-select.has-passengers {
        border-color: var(--primary);
        background: linear-gradient(135deg, rgba(50, 147, 243, 0.08), rgba(224, 239, 245, 0.3));
        color: var(--primary);
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(50, 147, 243, 0.15);
    }

    .btn-passenger-select.has-passengers:hover {
        background: linear-gradient(135deg, rgba(50, 147, 243, 0.15), rgba(224, 239, 245, 0.4));
        box-shadow: 0 4px 12px rgba(50, 147, 243, 0.25);
    }

    .passenger-card {
        background: var(--light);
        border-radius: 10px;
        padding: 1rem;
        border: 1px solid var(--border);
    }

    .passenger-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7rem 0;
        border-bottom: 1px solid var(--border);
    }

    .passenger-row:last-child {
        border-bottom: none;
    }

    .passenger-info h6 {
        margin: 0;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.9rem;
    }

    .passenger-info small {
        color: #666;
        display: block;
        margin-top: 0.2rem;
        font-size: 0.75rem;
    }

    .price-display {
        font-size: 0.8rem;
        color: var(--accent);
        font-weight: 600;
        margin-top: 0.2rem;
    }

    .counter-group {
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .counter-btn {
        width: 32px;
        height: 32px;
        border: 1px solid var(--primary);
        background: white;
        color: var(--primary);
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .counter-btn:hover {
        background: var(--primary);
        color: white;
    }

    .counter-display {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        min-width: 25px;
        text-align: center;
    }

    .btn-done {
        background: linear-gradient(135deg, var(--primary-2), var(--primary));
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        margin-top: 0.8rem;
        width: 100%;
        cursor: pointer;
        font-size: 0.95rem;
        box-shadow: 0 10px 30px rgba(3,37,76,0.12);
        letter-spacing: 0.2px;
    }

    .btn-done:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 18px 40px rgba(3,37,76,0.16);
    }

    .btn-search {
        background: linear-gradient(90deg, var(--primary-2) 0%, var(--accent) 100%);
        border: none;
        color: white;
        font-weight: 800;
        border-radius: 12px;
        padding: 0.9rem 1rem;
        width: 100%;
        font-size: 1.02rem;
        cursor: pointer;
        margin-top: 1rem;
        box-shadow: 0 12px 32px rgba(3,37,76,0.12);
    }

    .btn-search:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 20px 48px rgba(3,37,76,0.16);
    }

    /* Modal styling */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        max-width: 450px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideUp 0.3s ease-out;
    }

    @keyframes modalSlideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* Offers Section */
    .offers-section {
        background: var(--light);
        padding: 2.5rem 0;
    }

    /* Reveal animation for sections */
    .reveal {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.7s ease, transform 0.7s ease;
        will-change: opacity, transform;
    }

    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Staggered items (cards inside a reveal section) */
    .stagger-item {
        opacity: 0;
        transform: translateY(18px);
        transition: opacity 0.6s ease, transform 0.6s ease;
        will-change: opacity, transform;
    }

    .stagger-item.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .offers-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .offers-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .offers-header a {
        background: white;
        border: 1px solid var(--primary);
        color: var(--primary);
        padding: 0.5rem 1.2rem;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .offers-header a:hover {
        background: var(--primary);
        color: white;
    }

    .offer-card {
        background: linear-gradient(180deg, #fff 0%, #fbfdff 100%);
        border-radius: 14px;
        padding: 1.3rem;
        border: 1px solid var(--border);
        box-shadow: 0 8px 30px rgba(2,6,23,0.06);
        height: 100%;
        transition: transform 300ms cubic-bezier(.2,.9,.3,1), box-shadow 300ms ease;
        position: relative;
        overflow: hidden;
    }

    .offer-card:hover {
        transform: translateY(-8px) rotate(-0.2deg);
        box-shadow: 0 22px 55px rgba(2,6,23,0.12);
    }

    .offer-card::after {
        content: '';
        position: absolute;
        right: -40px;
        top: -30px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle at 40% 40%, rgba(0,119,214,0.06), transparent 40%);
        transform: rotate(18deg);
        pointer-events: none;
    }

    .offer-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        margin-bottom: 0.8rem;
        font-size: 0.75rem;
    }

    .offer-card h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1rem;
    }

    .price-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--border);
        font-size: 0.85rem;
    }

    .price-item:last-child {
        border-bottom: none;
    }

    .price-item span:first-child {
        color: #666;
    }

    .price-item span:last-child {
        font-weight: 700;
        color: var(--accent);
    }

    /* Why Choose Us Section */
    .why-section {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        padding: 2.5rem 0;
        color: white;
    }

    .why-section h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
    }

    .why-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        color: var(--dark);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        height: 100%;
    }

    .why-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    .why-card img {
        height: 50px;
        margin-bottom: 0.8rem;
    }

    .why-card h4 {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--primary);
    }

    .why-card p {
        font-size: 0.85rem;
        line-height: 1.5;
        color: #666;
    }

    /* About Section */
    .about-section {
        padding: 2.5rem 0;
    }

    .about-section h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
        color: var(--dark);
    }

    .about-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .about-card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .about-card-content {
        display: flex;
        flex-direction: row;
        align-items: stretch;
    }

    .about-card img {
        width: 35%;
        object-fit: cover;
    }

    .about-card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .about-card-body h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.7rem;
    }

    .about-card-body p {
        color: #666;
        line-height: 1.5;
        margin-bottom: 0.4rem;
        font-size: 0.9rem;
    }

    .about-card-body small {
        color: #999;
        font-size: 0.8rem;
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 1.8rem;
        }

        .hero-content p {
            font-size: 0.9rem;
        }

        .booking-card {
            padding: 1rem;
        }

        .offers-header {
            flex-direction: column;
            gap: 0.8rem;
            text-align: center;
        }

        .about-card-content {
            flex-direction: column;
        }

        .about-card img {
            width: 100%;
            height: 200px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
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
</section>

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
            <div class="offer-card stagger-item">
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

            <!-- Passengers -->
            <div class="offer-card stagger-item">
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

            <!-- Motorcycles -->
            <div class="offer-card stagger-item">
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
    document.addEventListener('DOMContentLoaded', function() {
        const asalSelect = document.getElementById('asalSelect');
        const tujuanInput = document.getElementById('tujuanInput');
        const tujuanId = document.getElementById('tujuanId');
        const priceInput = document.getElementById('ticketPrice');
        const timeInput = document.getElementById('jamKeberangkatan');
        
        const passengerModal = document.getElementById('passengerModal');
        const passengerSelectBtn = document.getElementById('passengerSelectBtn');
        const dewasaPriceDisplay = document.getElementById('dewasaPriceDisplay');
        const anakPriceDisplay = document.getElementById('anakPriceDisplay');

        let dewasa = 0;
        let anak = 0;
        let dewasaPrice = 0;
        let anakPrice = 0;
    // Vehicle booking state
    let vehicleCount = 0;
    let vehiclePrice = 0;
    let vehicleType = '';

        const dewasaCount = document.getElementById('countDewasa');
        const anakCount = document.getElementById('countAnak');
    const vehicleCountDisplay = document.getElementById('countVehicle');
    const vehicleTypeSelect = document.getElementById('vehicleTypeSelect');
    const vehiclePriceDisplay = document.getElementById('vehiclePriceDisplay');

        function updatePassengerButtonText() {
            const totalPassengers = dewasa + anak;
            
            if (totalPassengers === 0) {
                passengerSelectBtn.innerHTML = '<span>👥</span> Pilih Penumpang';
                passengerSelectBtn.classList.remove('has-passengers');
            } else {
                let summary = '';
                const parts = [];
                
                if (dewasa > 0) {
                    parts.push(`${dewasa} Dewasa`);
                }
                if (anak > 0) {
                    parts.push(`${anak} Anak-anak`);
                }
                
                summary = '<span>👥</span> ' + parts.join(', ');
                passengerSelectBtn.innerHTML = summary;
                passengerSelectBtn.classList.add('has-passengers');
            }
        }

        // Open modal when button is clicked
        passengerSelectBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const origin = asalSelect.value;
            const destination = tujuanId.value;
            
            if (!origin || !destination) {
                alert('Pilih pelabuhan asal dan tujuan terlebih dahulu.');
                return;
            }
            
            fetchPrices(origin, destination, vehicleTypeSelect.value);
            passengerModal.classList.add('active');
        });

        // Close modal when clicking outside
        passengerModal.addEventListener('click', (e) => {
            if (e.target === passengerModal) {
                passengerModal.classList.remove('active');
            }
        });

        // Function to fetch prices from HomeController
        async function fetchPrices(origin, destination, vType = '') {
            try {
                const resDewasa = await fetch(
                    `/get-price?origin_port_id=${origin}&destination_port_id=${destination}&passenger_type=Dewasa`
                );
                const dataDewasa = await resDewasa.json();
                dewasaPrice = dataDewasa.price || 0;
                dewasaPriceDisplay.textContent = `Harga: ${dewasaPrice ? 'Rp ' + parseInt(dewasaPrice).toLocaleString('id-ID') : '-'}`;
                
                if (dataDewasa.departure_time) {
                    timeInput.value = dataDewasa.departure_time;
                }

                const resAnak = await fetch(
                    `/get-price?origin_port_id=${origin}&destination_port_id=${destination}&passenger_type=Anak-anak`
                );
                const dataAnak = await resAnak.json();
                anakPrice = dataAnak.price || 0;
                anakPriceDisplay.textContent = `Harga: ${anakPrice ? 'Rp ' + parseInt(anakPrice).toLocaleString('id-ID') : '-'}`;
                
                if (!timeInput.value && dataAnak.departure_time) {
                    timeInput.value = dataAnak.departure_time;
                }

                // Fetch vehicle price if vehicle type provided
                if (vType) {
                    const resVehicle = await fetch(
                        `/get-price?origin_port_id=${origin}&destination_port_id=${destination}&vehicle_type=${encodeURIComponent(vType)}`
                    );
                    const dataVehicle = await resVehicle.json();
                    vehiclePrice = dataVehicle.price || 0;
                    vehiclePriceDisplay.textContent = `Harga: ${vehiclePrice ? 'Rp ' + parseInt(vehiclePrice).toLocaleString('id-ID') : '-'}`;
                } else {
                    vehiclePrice = 0;
                    vehiclePriceDisplay.textContent = 'Harga: -';
                }
            } catch (err) {
                console.error('Error fetching prices:', err);
                alert('Gagal mengambil data harga tiket.');
            }
        }

        document.getElementById('plusDewasa').addEventListener('click', (e) => {
            e.preventDefault();
            dewasa++;
            dewasaCount.textContent = dewasa;
            document.getElementById('dewasaCountInput').value = dewasa;
            updateTotalPrice();
            updatePassengerButtonText();
        });

        document.getElementById('minusDewasa').addEventListener('click', (e) => {
            e.preventDefault();
            if (dewasa > 0) dewasa--;
            dewasaCount.textContent = dewasa;
            document.getElementById('dewasaCountInput').value = dewasa;
            updateTotalPrice();
            updatePassengerButtonText();
        });

        document.getElementById('plusAnak').addEventListener('click', (e) => {
            e.preventDefault();
            anak++;
            anakCount.textContent = anak;
            document.getElementById('anakCountInput').value = anak;
            updateTotalPrice();
            updatePassengerButtonText();
        });

        // Vehicle counter events
        document.getElementById('plusVehicle').addEventListener('click', (e) => {
            e.preventDefault();
            // Only allow adding vehicle if a type is selected
            const selected = vehicleTypeSelect.value;
            if (!selected) {
                alert('Pilih jenis kendaraan terlebih dahulu.');
                return;
            }
            vehicleType = selected;
            vehicleCount++;
            vehicleCountDisplay.textContent = vehicleCount;
            document.getElementById('vehicleCountInput').value = vehicleCount;
            document.getElementById('vehicleTypeInput').value = vehicleType;
            updateTotalPrice();
        });

        document.getElementById('minusVehicle').addEventListener('click', (e) => {
            e.preventDefault();
            if (vehicleCount > 0) vehicleCount--;
            vehicleCountDisplay.textContent = vehicleCount;
            document.getElementById('vehicleCountInput').value = vehicleCount;
            if (vehicleCount === 0) {
                // clear vehicle type if no vehicles
                document.getElementById('vehicleTypeInput').value = '';
                vehicleType = '';
            }
            updateTotalPrice();
        });

        // When vehicle type changes, fetch its price for selected route (if route chosen)
        vehicleTypeSelect.addEventListener('change', (e) => {
            vehicleType = e.target.value;
            document.getElementById('vehicleTypeInput').value = vehicleType;

            const origin = asalSelect.value;
            const destination = tujuanId.value;
            if (!origin || !destination) {
                vehiclePrice = 0;
                vehiclePriceDisplay.textContent = 'Harga: -';
                return;
            }

            if (vehicleType) {
                fetchPrices(origin, destination, vehicleType).then(() => {
                    // update hidden price input
                    document.getElementById('vehiclePriceInput').value = vehiclePrice;
                    updateTotalPrice();
                });
            } else {
                vehiclePrice = 0;
                vehiclePriceDisplay.textContent = 'Harga: -';
                document.getElementById('vehiclePriceInput').value = 0;
                updateTotalPrice();
            }
        });

        document.getElementById('minusAnak').addEventListener('click', (e) => {
            e.preventDefault();
            if (anak > 0) anak--;
            anakCount.textContent = anak;
            document.getElementById('anakCountInput').value = anak;
            updateTotalPrice();
            updatePassengerButtonText();
        });

        // Update total price in real-time
        function updateTotalPrice() {
            const vehicleTotal = vehicleCount * vehiclePrice;
            const total = (dewasa * dewasaPrice) + (anak * anakPrice) + vehicleTotal;
            if (total > 0) {
                priceInput.value = `Rp ${parseInt(total).toLocaleString('id-ID')}`;
            } else {
                priceInput.value = 'Rp 0';
            }
        }

        // Auto-set destination
        asalSelect.addEventListener('change', function() {
            const selectedAsal = asalSelect.options[asalSelect.selectedIndex].dataset.name;

            if (selectedAsal === 'muara') {
                tujuanInput.value = 'Sipinggan';
                tujuanId.value = '{{ $ports->firstWhere('name', 'Sipinggan')->id ?? '' }}';
            } else if (selectedAsal === 'sipinggan') {
                tujuanInput.value = 'Muara';
                tujuanId.value = '{{ $ports->firstWhere('name', 'Muara')->id ?? '' }}';
            } else {
                tujuanInput.value = '';
                tujuanId.value = '';
            }
            
            // Reset price display and passenger counts
            priceInput.value = 'Rp 0';
            dewasaPriceDisplay.textContent = 'Harga: -';
            anakPriceDisplay.textContent = 'Harga: -';
            vehiclePriceDisplay.textContent = 'Harga: -';
            
            dewasa = 0;
            anak = 0;
            vehicleCount = 0;
            vehiclePrice = 0;
            vehicleType = '';
            dewasaCount.textContent = '0';
            anakCount.textContent = '0';
            vehicleCountDisplay.textContent = '0';
            updatePassengerButtonText();
            document.getElementById('dewasaCountInput').value = 0;
            document.getElementById('anakCountInput').value = 0;
            document.getElementById('vehicleCountInput').value = 0;
            document.getElementById('vehiclePriceInput').value = 0;
            document.getElementById('vehicleTypeInput').value = '';
        });

        // Done selecting passengers
        document.getElementById('donePassenger').addEventListener('click', (e) => {
            e.preventDefault();
            
            // Store prices in hidden fields
            document.getElementById('dewasaPriceInput').value = dewasaPrice;
            document.getElementById('anakPriceInput').value = anakPrice;
            document.getElementById('vehiclePriceInput').value = vehiclePrice;
            document.getElementById('vehicleCountInput').value = vehicleCount;
            document.getElementById('vehicleTypeInput').value = vehicleType;
            
            passengerModal.classList.remove('active');
        });

        // Form submit validation: date must be >= today, anak cannot be booked without minimum 1 dewasa
        const ticketForm = document.getElementById('ticketForm');
        ticketForm.addEventListener('submit', function(e) {
            // ensure hidden inputs reflect current state
            document.getElementById('dewasaPriceInput').value = dewasaPrice;
            document.getElementById('anakPriceInput').value = anakPrice;
            document.getElementById('vehiclePriceInput').value = vehiclePrice;
            document.getElementById('vehicleCountInput').value = vehicleCount;
            document.getElementById('vehicleTypeInput').value = vehicleType;

            // Validate date
            const depInput = document.getElementById('departureDateInput');
            const depValue = depInput ? depInput.value : null;
            if (!depValue) {
                alert('Pilih tanggal keberangkatan.');
                e.preventDefault();
                return;
            }
            const today = new Date();
            today.setHours(0,0,0,0);
            const depDate = new Date(depValue + 'T00:00:00');
            if (depDate < today) {
                alert('Tanggal keberangkatan tidak boleh sebelum hari ini.');
                e.preventDefault();
                return;
            }

            // Validate children/adult rule
            if (anak > 0 && dewasa === 0) {
                alert('Jika memesan anak-anak, minimal harus ada 1 orang dewasa.');
                e.preventDefault();
                // open passenger modal to let user fix
                passengerModal.classList.add('active');
                return;
            }

            // Validate vehicle selection coherence
            if (vehicleCount > 0 && !vehicleType) {
                alert('Pilih jenis kendaraan untuk kendaraan yang dipesan.');
                e.preventDefault();
                passengerModal.classList.add('active');
                return;
            }
        });

        // --- Section reveal animations using IntersectionObserver ---
        const revealElements = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window) {
            const io = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // If the revealed section contains stagger items, reveal them one-by-one
                        const items = entry.target.querySelectorAll('.stagger-item');
                        if (items.length) {
                            items.forEach((it, i) => {
                                setTimeout(() => it.classList.add('visible'), i * 90);
                            });
                        }

                        // Reveal the section itself
                        entry.target.classList.add('visible');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealElements.forEach(el => io.observe(el));
        } else {
            // Fallback: just show all (and stagger a tiny bit)
            revealElements.forEach(el => {
                el.classList.add('visible');
                const items = el.querySelectorAll('.stagger-item');
                items.forEach((it, i) => setTimeout(() => it.classList.add('visible'), i * 90));
            });
        }

        // Collapse mobile navbar when clicking on internal anchor links
        const navLinks = document.querySelectorAll('.navbar-nav a[href^="#"]');
        navLinks.forEach(link => {
            link.addEventListener('click', (ev) => {
                // Collapse Bootstrap navbar if it's open (mobile)
                try {
                    const navbarCollapse = document.getElementById('navbar-collapse');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        // Use Bootstrap's collapse API if available
                        if (window.bootstrap && bootstrap.Collapse) {
                            const bs = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse);
                            bs.hide();
                        } else {
                            // fallback: remove show class
                            navbarCollapse.classList.remove('show');
                        }
                    }
                } catch (err) {
                    // ignore
                }

                // small link feedback
                link.classList.add('text-primary');
                setTimeout(() => link.classList.remove('text-primary'), 900);
            });
        });
    });
</script>
@endsection
