    @extends('layouts.app')

    @section('content')
        <!-- Hero Section -->
        <section id="hero" class="hero-section position-relative d-flex align-items-center justify-content-center"
            style="
                background-image: url('{{ asset('assets/img/ferry.jpeg') }}');
                background-size: cover;
                background-position: center;
                min-height: 90vh;
                position: relative;
            ">
            <!-- Overlay -->
            <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.55);"></div>

            <div class="container position-relative text-center text-white z-2">
                <h1 class="fw-bold display-4 mb-4 animate__animated animate__fadeInDown">Temukan Perjalananmu</h1>
                <p class="lead mb-5 animate__animated animate__fadeInUp">Set Your Arrival and Departure Schedule at the Port</p>

                <!-- Booking Form -->
                <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp" style="max-width: 850px; margin: auto;">
                    <div class="card-body p-4">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pelabuhan Asal</label>
                                    <select class="form-select shadow-sm">
                                        <option selected disabled>Pilih Pelabuhan Asal</option>
                                        <option>Muara</option>
                                        <option>Sipinggan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pelabuhan Tujuan</label>
                                    <select class="form-select shadow-sm">
                                        <option selected disabled>Pilih Pelabuhan Tujuan</option>
                                        <option>Muara</option>
                                        <option>Sipinggan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pilih Tanggal</label>
                                    <input type="date" class="form-control shadow-sm">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jam Keberangkatan</label>
                                    <input type="text" class="form-control shadow-sm" placeholder="08.00 - 10.00" readonly>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-info btn-lg rounded-pill shadow">
                                    <i class="fas fa-ticket-alt me-2"></i>Find Your Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest Offers Section -->
        <section id="latest-offers" class="py-3 bg-light">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold"><i class="fas fa-tag me-2 text-primary"></i>Latest Offers</h2>
                    <a href="#" class="btn btn-outline-primary rounded-pill">View All Special Offers</a>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 offer-card shadow-sm">
                            {{-- <img src="{{ asset('assets/img/Car_Grey.png') }}" class="card-img-top" alt="Mobil"> --}}
                            <div class="card-body">
                                <!-- Badge kategori -->
                                <span class="badge bg-primary mb-3">
                                    <i class="fas fa-car me-1"></i> Roda 4
                                </span>

                                <!-- Judul -->
                                <h5 class="card-title fw-bold">Daftar Harga Mobil</h5>

                                <!-- List harga -->
                                <ul class="list-group list-group-flush mt-3">
                                    <li class="list-group-item border-0 px-0 py-2">🚗 Mobil Sedan <span class="float-end fw-semibold">Rp 100.000</span></li>
                                    <li class="list-group-item border-0 px-0 py-2">🚚 Mobil Box <span class="float-end fw-semibold">Rp 150.000</span></li>
                                    <li class="list-group-item border-0 px-0 py-2">🚛 Mobil Truck <span class="float-end fw-semibold">Rp 250.000</span></li>
                                    <li class="list-group-item border-0 px-0 py-2">🚙 Mobil SUV <span class="float-end fw-semibold">Rp 300.000</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                    <div class="card h-100 offer-card shadow-sm">
                            {{-- <img src="{{ asset('assets/img/team.png') }}" class="card-img-top" alt="penumpang"> --}}
                            <div class="card-body">
                                <!-- Badge kategori -->
                                <span class="badge bg-warning mb-3 text-dark">
                                    <i class="fas fa-user-friends me-1"></i> Penumpang
                                </span>

                                <!-- Judul -->
                                <h5 class="card-title fw-bold">Daftar Harga Penumpang</h5>

                                <!-- List harga -->
                                <ul class="list-group list-group-flush mt-3">
                                    <li class="list-group-item border-0 px-0 py-2">👶 Anak-anak <span class="float-end fw-semibold">Rp 30.000</span></li>
                                    <li class="list-group-item border-0 px-0 py-2">🧑 Dewasa <span class="float-end fw-semibold">Rp 50.000</span></li>
                                    <li class="list-group-item border-0 px-0 py-2">👴 Lansia <span class="float-end fw-semibold">Rp 40.000</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 offer-card shadow-sm">
                            {{-- <img src="{{ asset('assets/img/scooter.png') }}" class="card-img-top" alt="Sepeda Motor"> --}}
                            <div class="card-body">
                                <!-- Badge kategori -->
                                <span class="badge bg-success mb-3">
                                    <i class="fas fa-motorcycle me-1"></i> Roda 2
                                </span>

                                <!-- Judul -->
                                <h5 class="card-title fw-bold">Daftar Harga Sepeda Motor</h5>

                                <!-- List harga -->
                                <ul class="list-group list-group-flush mt-3">
                                    <li class="list-group-item border-0 px-0 py-2">🛵 Motor Bebek <span class="float-end fw-semibold">Rp 50.000</span></li>
                                    <li class="list-group-item border-0 px-0 py-2">🏍️ Motor Sport <span class="float-end fw-semibold">Rp 75.000</span></li>
                                    <li class="list-group-item border-0 px-0 py-2">🛵 Motor Matic <span class="float-end fw-semibold">Rp 60.000</span></li>
                                    <li class="list-group-item border-0 px-0 py-2">🛻 Motor Trail <span class="float-end fw-semibold">Rp 80.000</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Use SEAVENTURES Section -->
        <section id="why-seaventures" class="py-5 bg-info text-white">
            <div class="container">
                <h2 class="text-center fw-bold mb-5">Kenapa Memilih Kami ?</h2>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="p-4 bg-white text-dark rounded-4 shadow-sm h-100">
                            <i class="fas fa-ship fa-3x text-primary mb-3"></i>
                            <img src="{{ asset('assets/img/cyber-security.png') }}" alt="Seaventures" 
                            class="d-inline-block align-text-top" style="height:50px;">
                            <h4 class="font-semibold text-gray-800">Keamanan & Kenyaman Anda Prioritas kami</h6>
                            <p>Kami memastikan setiap transaksi berlangsung aman, cepat, dan mudah.
                                Dengan sistem pembayaran terenkripsi dan layanan pemesanan yang praktis, Anda bisa menikmati perjalanan tanpa khawatir.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 bg-white text-dark rounded-4 shadow-sm h-100">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <img src="{{ asset('assets/img/accessible.png') }}" alt="Seaventures" 
                            class="d-inline-block align-text-top" style="height:50px;">
                            <h4 class="font-semibold text-gray-800">Kemudahan Pemesanan</h6>
                            <p>Kami memahami waktu Anda sangat berharga. Karena itu, platform kami hadir untuk memberikan kemudahan dalam memesan tiket kapal ferry secara online.
                                Pilih rute, tentukan jadwal, lakukan pembayaran, dan tiket langsung dikirim ke Anda — semua dalam satu sistem yang cepat dan efisien.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 bg-white text-dark rounded-4 shadow-sm h-100">
                            <i class="fas fa-tag fa-3x text-primary mb-3"></i>
                            <img src="{{ asset('assets/img/best-price.png') }}" alt="Seaventures" 
                                class="d-inline-block align-text-top" style="height:50px;">
                            <h4 class="font-semibold text-gray-800">Harga Terjangkau</h6>
                            <p>Kami percaya perjalanan yang menyenangkan tidak harus mahal.
                                Platform kami menawarkan harga tiket yang terjangkau dan transparan, lengkap dengan berbagai promo menarik setiap minggunya.
                                Kini, kamu bisa berlayar dengan nyaman tanpa khawatir soal biaya!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners Section -->
        <section id="partners" class="py-5">
            <div class="container">
                <h2 class="text-center fw-bold mb-5">Tentang Kami</h2>
                <div class="row mb-12 g-6">
                    <div class="col-md">
                    <div class="card">
                        <div class="d-flex flex-md-row flex-column">
                        <div>
                            <img class="card-img card-img-left" src="../assets/img/elements/18.png" alt="Card image" />
                        </div>
                        <div>
                            <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">
                                This is a wider card with supporting text below as a natural lead-in to additional content.
                                This content is a little bit longer.
                            </p>
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md">
                    <div class="card">
                        <div class="d-flex flex-md-row flex-column">
                        <div>
                            <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">
                                This is a wider card with supporting text below as a natural lead-in to additional content.
                                This content is a little bit longer.
                            </p>
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        <div>
                            <img class="card-img card-img-right" src="../assets/img/elements/19.png" alt="Card image" />
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

        </section>

        <!-- Customer Service Section -->
        {{-- <section id="customer-service" class="py-5 text-white"
            style="background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://via.placeholder.com/1200x400/4a90e2/ffffff?text=Ferry+Sunset');
                background-size: cover; background-position: center;">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 animate__animated animate__fadeInLeft">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-question-circle fa-2x me-3"></i>
                            <h2 class="fw-bold">Customer Service</h2>
                            <span class="badge bg-light text-dark ms-3">Need Help?</span>
                        </div>
                        <p class="lead">Visit our customer service page to find useful information on travelling by ferry, our FAQs, and how to contact us for help with your booking.</p>
                    </div>
                </div>
            </div>
        </section> --}}
    @endsection 
