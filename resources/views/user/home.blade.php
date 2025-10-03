@extends('layouts.app')

@section('content')
     <!-- Hero Section -->
    <section id="hero" class="hero-section position-relative" 
    style=" 
        background-image: url('{{ asset('assets/img/ferry.jpeg') }}'); 
        background-size: cover; 
        background-position: center; 
        min-height: 80vh; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        position: relative;
    ">

    <!-- Overlay biar teks/form lebih jelas -->
    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4);"></div>

    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-10">
                <!-- Booking Form -->
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <div class="bg-primary text-white p-3 rounded mb-4">
                            <h3 class="mb-0">Temukan Perjalanan mu</h3>
                        </div>
                        <p class="text-muted small mb-4">Set Your Arrival and Departure Schedule at the Port</p>
                        
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pelabuhan Asal</label>
                                     <select class="form-select">
                                        <option>Pilih Pelabuhan Asal</option>
                                        <option>Muara </option>
                                        <option>Sipinggan</option>
                                    </select>
                                    </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pelabuhan Tujuan</label>
                                    <select class="form-select">
                                        <option>Pilih Pelabuhan tujuan</option>
                                        <option>Muara </option>
                                        <option>Sipinggan</option>
                                    </select>
                               </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pilih Tanggal </label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jam Keberangkatan</label>
                                  <input type="text" class="form-control" placeholder="08.00-10.00" readonly>
                                
                               </div>   
                            </div>
                            
                            {{-- <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Adults</label>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-secondary btn-sm">-</button>
                                        <span class="mx-3">0</span>
                                        <button type="button" class="btn btn-outline-secondary btn-sm">+</button>
                                        <small class="text-muted ms-2">Ages 6 and over</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Children</label>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-secondary btn-sm">-</button>
                                        <span class="mx-3">0</span>
                                        <button type="button" class="btn btn-outline-secondary btn-sm">+</button>
                                        <small class="text-muted ms-2">2-5 years old</small>
                                    </div>
                                </div>
                            </div>
                             --}}
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-success flex-fill">Find Your Ticket</button>
                               </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Latest Offers Section -->
    <section id="latest-offers" class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-tag me-2"></i>Latest Offers</h2>
                <a href="#" class="btn btn-outline-primary">View All Special Offers</a>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card h-100 offer-card">
                        <img src="https://via.placeholder.com/300x200/4a90e2/ffffff?text=Greek+Island" class="card-img-top" alt="Greek Island">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><i class="fas fa-tag me-1"></i>Offers and Promotions</span>
                            <h5 class="card-title">Greek Island: 30% OFF the return of Golden Star Ferries</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 offer-card">
                        <img src="https://via.placeholder.com/300x200/2c5aa0/ffffff?text=Golden+Queen" class="card-img-top" alt="Golden Queen">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><i class="fas fa-tag me-1"></i>Offers and Promotions</span>
                            <h5 class="card-title">Up to 25% OFF with Golden Queen Fast Boat</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 offer-card">
                        <img src="https://via.placeholder.com/300x200/1e88e5/ffffff?text=Baltic+Sea" class="card-img-top" alt="Baltic Sea">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><i class="fas fa-tag me-1"></i>Offers and Promotions</span>
                            <h5 class="card-title">Baltic Sea: up to 40% OFF with Tallink Silja</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 offer-card">
                        <img src="https://via.placeholder.com/300x200/0277bd/ffffff?text=High+Speed" class="card-img-top" alt="High Speed">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><i class="fas fa-tag me-1"></i>Offers and Promotions</span>
                            <h5 class="card-title">High-speed sailing</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Use SEAVENTURES Section -->
    <section id="why-seaventures" class="py-5 bg-primary text-white">
        <div class="container">
            <h2 class="text-center mb-5">Why use SEAVENTURES?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card bg-white text-dark h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-ship fa-3x text-primary mb-3"></i>
                            <h5>Ferries from 4412 routes and 901 ports worldwide</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card bg-white text-dark h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5>Trusted by over 2.5 million customers</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card bg-white text-dark h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-tag fa-3x text-primary mb-3"></i>
                            <h5>We check up to 1 million prices for our customers daily</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Partners Section -->
    <section id="partners" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Partners</h2>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-2 col-6 mb-4 text-center">
                    <div class="partner-logo p-3">
                        <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=Blue+Star" alt="Blue Star Ferries" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4 text-center">
                    <div class="partner-logo p-3">
                        <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=DFDS" alt="DFDS" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4 text-center">
                    <div class="partner-logo p-3">
                        <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=Hellenic" alt="Hellenic Seaways" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4 text-center">
                    <div class="partner-logo p-3">
                        <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=P%26O" alt="P&O Ferries" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4 text-center">
                    <div class="partner-logo p-3">
                        <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=SeaJets" alt="SeaJets" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Service Section -->
    <section id="customer-service" class="py-5" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://via.placeholder.com/1200x400/4a90e2/ffffff?text=Ferry+Sunset'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="row text-white">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-question-circle fa-2x me-3"></i>
                        <h2>Customer Service</h2>
                        <span class="badge bg-light text-dark ms-3">Need Help?</span>
                    </div>
                    <p class="lead">Visit our customer service page to find useful information on travelling by ferry, our FAQs, and how to contact us for help with your booking.</p>
                </div>
            </div>
        </div>
    </section>


@endsection
