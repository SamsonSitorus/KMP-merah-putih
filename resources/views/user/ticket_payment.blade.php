@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ asset('assets/ss/ticket_payment.css') }}">
<div class="payment-container">
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                
                <h4 class="fw-bold mb-4 text-center">Finalisasi Pembayaran</h4>

                {{-- 1. INFORMASI REKENING TUJUAN --}}
                <div class="card bank-info-card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="text-uppercase fw-bold text-muted mb-0">Transfer Ke:</h6>
                            <img src="{{ asset('assets/img/Logo BRI.png') }}" alt="BRI" class="bank-logo">
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">Nomor Rekening</small>
                            <div class="d-flex align-items-center gap-2">
                                <span class="account-number" id="accNumber">00990-10008-41560</span>
                                <button class="btn btn-outline-primary btn-sm btn-copy rounded-pill" onclick="copyText()">
                                    <i class="bx bx-copy"></i> Salin
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Nama Pemilik Rekening</small>
                            <h5 class="fw-bold text-dark">Renward H sianturi</h5>
                        </div>

                        <div class="total-amount-box d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <small class="text-muted">Total Bayar</small>
                                <h4 class="mb-0 fw-bolder text-danger">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h4>
                            </div>
                            <i class="bx bx-info-circle fs-3 text-warning"></i>
                        </div>
                    </div>
                </div>

                {{-- 2. FORM UPLOAD BUKTI --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar bg-label-primary p-2 rounded me-3">
                                <i class="bx bx-upload fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Unggah Bukti Transfer</h5>
                                <small class="text-muted">Status: <span class="badge bg-label-warning text-uppercase">{{ $booking->status }}</span></small>
                            </div>
                        </div>

                        <form id="paymentForm" action="{{ route('book_ticket.confirm') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                            {{-- Hidden inputs lainnya tetap di sini --}}

                            <div class="mb-4">
                                <div class="bk-file-preview d-flex align-items-center gap-3" id="filePreview">
                                    <img id="fileThumb" class="bk-file-thumb" src="" alt="Preview" style="display:none;">
                                    <div class="flex-grow-1">
                                        <div id="fileName" class="fw-bold text-dark small">Pilih foto bukti transfer Anda</div>
                                        <div id="fileHelp" class="text-muted" style="font-size: 0.75rem;">JPG, PNG atau PDF (Maks. 2MB)</div>
                                    </div>
                                    <label class="btn btn-primary btn-sm px-3 py-2 rounded-pill" for="payment_proof" style="cursor:pointer;">
                                        Pilih File
                                    </label>
                                </div>
                                <input type="file" class="d-none" id="payment_proof" name="payment_proof" accept="image/*,.pdf" required>
                            </div>

                            <div class="alert alert-info border-0 shadow-none d-flex mb-4" style="background: #e7e7ff;">
                                <i class="bx bx-help-circle me-2 fs-4 text-primary"></i>
                                <small class="text-primary">Tim kami akan memverifikasi pembayaran Anda maksimal 15 menit setelah bukti diunggah.</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn bk-btn-primary rounded-pill shadow-sm">
                                    <i class="bx bx-check-circle me-1"></i> Konfirmasi Pembayaran
                                </button>
                                <a href="{{ route('history.status', 'pending') }}" class="btn btn-link text-muted btn-sm">Batal, kembali ke Riwayat</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/ticket_payment.js') }}"></script>

@endsection