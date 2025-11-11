@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Detail Pemesanan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    Detail Pemesanan
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-1">Tuesday, July 04, 2023</p>
                    <p class="fw-bold mb-2">NP-112-B | KM. LEUSER</p>
                    <p class="small text-muted mb-3">Economy Class | 1 Adult</p>

                    <div class="d-flex justify-content-between">
                        <span>Harga Satuan</span>
                        <span>Rp. 544.000</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Channel Cost</span>
                        <span>Rp. 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Final Price</span>
                        <span class="text-danger">Rp. 576.000</span>
                    </div>

                    <hr>

                    <p class="mb-1"><strong>Name:</strong> Satria</p>
                    <p class="mb-1"><strong>Deck/Kabin:</strong> 4 / 4065 / 1</p>

                    <div class="mt-3">
                        <p class="mb-1"><strong>Departure:</strong> Tanjung Perak, 08:00<br>
                            <small>Tuesday, 04 July 2023</small>
                        </p>
                        <p class="mb-1"><strong>Arrival:</strong> Labuan Bajo, 23:00<br>
                            <small>Thursday, 06 July 2023</small>
                        </p>
                    </div>

                    <div class="text-center mt-4">
                        <h4 class="fw-bold text-danger">Rp. 576.000</h4>
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Pembayaran -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white fw-bold">
                    Upload Bukti Pembayaran
                </div>
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label fw-semibold">Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="payment_proof" name="payment_proof" required>
                            <div class="form-text text-muted">
                                Format yang diperbolehkan: JPG, PNG, atau PDF
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 rounded-pill">
                            <i class="fas fa-upload me-2"></i>Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
