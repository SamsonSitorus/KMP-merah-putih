@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Header Result -->
    <div class="bg-white shadow-sm p-4 rounded-4 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Surabaya → Makassar</h4>
            <p class="text-muted mb-0">
                16 June 2023, Fri | Reguler | 
                <i class="fas fa-user"></i> 2 Dewasa + 1 Anak-anak
            </p>
        </div>
        <a href="{{--  --}}" class="btn btn-outline-success rounded-pill">
            <i class="fas fa-search me-2"></i>Find Ticket
        </a>
    </div>

    <!-- Result Ticket Card -->
    <div class="card border-0 shadow-lg rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <!-- Info Section -->
                <div class="col-md-9">
                    <p class="text-success fw-semibold mb-2">Available Seat (238)</p>

                    <h5 class="fw-bold mb-1">
                        Surabaya, Jawa Timur <i class="fas fa-arrow-right mx-2 text-primary"></i> 
                        Makassar, Sulawesi Selatan
                    </h5>
                    <p class="text-muted small mb-3">
                        SBY - TANJUNG PERAK → MAK - MAKASSAR
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><span class="fw-semibold">Departure Date:</span></p>
                            <p class="text-muted">16 June 2023, Fri</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><span class="fw-semibold">Shipping Lines:</span></p>
                            <p class="text-muted">PELNI SHIP</p>
                        </div>
                    </div>

                        <div class="d-flex gap-4 mt-2 small fw-semibold">
                            <a href="#" class="text-success border-bottom border-2 border-success">Pricing Details</a>
                            <a href="#" class="text-muted">Trip Details</a>
                            <a href="#" class="text-muted">Terms and Conditions</a>
                        </div>
                </div>

                <!-- Price Section -->
                <div class="col-md-3 text-center">
                    <h4 class="fw-bold text-danger mb-4">Rp. 576.000</h4>
                    <a href="{{--  --}}" class="btn btn-success rounded-pill px-4 py-2">
                        <i class="fas fa-ticket-alt me-2"></i>Book Ticket
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
