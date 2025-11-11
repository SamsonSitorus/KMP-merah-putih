@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Form Data Penumpang -->
        <div class="col-md-8">
            <p class="text-danger small mb-3">
                Your Time Left : <span class="fw-bold">09 Minutes 59 Seconds</span>
            </p>

            <h5 class="fw-bold mb-3">Customer Data Information</h5>
            <form action="#" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Customer Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="customer_email" class="form-control" placeholder="Email">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="1"></textarea>
                    </div>
                </div>

                <hr>

                <!-- Passenger 1 -->
                <h6 class="fw-bold mt-3">Adult Passenger Identity Information - Male (1)</h6>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="1" id="sameAsCustomer">
                    <label class="form-check-label" for="sameAsCustomer">
                        Customer data is the same as passenger data
                    </label>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob1" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender1" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <!-- Passenger 2 -->
                <h6 class="fw-bold mt-3">Adult Passenger Identity Information - Male (2)</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Passenger name 2</label>
                        <input type="text" name="passenger2_name" class="form-control" placeholder="Passenger name 2">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. Identity 2 (KTP, SIM, PASSPORT, KIA)</label>
                        <input type="text" name="passenger2_id" class="form-control" placeholder="No. Identity 2">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob2" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender2" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <!-- Terms & Captcha -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" required id="agree">
                    <label class="form-check-label" for="agree">
                        I agree to the <span class="text-danger">terms and conditions</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill">Book Now</button>
            </form>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    Tanjung Perak → Makassar
                </div>
                <div class="card-body">
                    <p class="fw-bold">NP-131-G | KM. LABOBAR</p>
                    <p class="text-muted small">KELAS EKONOMI / E</p>

                    <p class="mb-1"><strong>Departure:</strong><br>
                        Rabu, 28 Juli 2023 - Jam 16:00
                    </p>
                    <p class="mb-1"><strong>Arrival:</strong><br>
                        Kamis, 29 Juli 2023 - Jam 19:00
                    </p>

                    <hr>
                    <p class="mb-1">Total<br>
                        <span class="fw-bold">2 adults, 0 children</span>
                    </p>
                    <h4 class="fw-bold text-danger">Rp. 576.000</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
