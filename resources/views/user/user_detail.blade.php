@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Form Data Penumpang -->
        <div class="col-lg-8">
            <!-- Timer Alert -->
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bx bx-time-five me-2 fs-5"></i>
                <div class="flex-grow-1">
                    <strong>Waktu Anda Tersisa:</strong>
                    <span class="fw-bold fs-5 ms-2 text-danger" id="countdownTimer">09:59</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- Customer Information Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="bx bx-user me-2"></i>Informasi Data Pelanggan</h5>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="customer_name" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="customer_email" class="form-control" placeholder="email@contoh.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="tel" name="phone" class="form-control" placeholder="0812-3456-7890" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Alamat</label>
                                <input type="text" name="address" class="form-control" placeholder="Alamat lengkap">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Passenger Information -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bx bx-group me-2"></i>Informasi Penumpang</h5>
                </div>
                <div class="card-body">
                    <!-- Auto-fill checkbox -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="sameAsCustomer">
                        <label class="form-check-label fw-medium" for="sameAsCustomer">
                            <i class="bx bx-copy-alt me-1"></i>Gunakan data pelanggan untuk penumpang 1
                        </label>
                    </div>

                    <!-- Passenger 1 -->
                    <div class="passenger-card mb-4 p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Penumpang 1 - Dewasa</h6>
                            <span class="badge bg-primary">Dewasa</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Penumpang</label>
                                <input type="text" name="passenger1_name" class="form-control" placeholder="Nama penumpang">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. Identitas</label>
                                <input type="text" name="passenger1_id" class="form-control" placeholder="KTP/SIM/Paspor">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="dob1" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender1" class="form-select">
                                    <option value="Male">Laki-laki</option>
                                    <option value="Female">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Passenger 2 -->
                    <div class="passenger-card mb-4 p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Penumpang 2 - Dewasa</h6>
                            <span class="badge bg-primary">Dewasa</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Penumpang</label>
                                <input type="text" name="passenger2_name" class="form-control" placeholder="Nama penumpang">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. Identitas</label>
                                <input type="text" name="passenger2_id" class="form-control" placeholder="KTP/SIM/Paspor">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="dob2" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender2" class="form-select">
                                    <option value="Male">Laki-laki</option>
                                    <option value="Female">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Submit -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" required id="agree">
                        <label class="form-check-label" for="agree">
                            Saya setuju dengan <a href="#" class="text-primary fw-semibold">syarat dan ketentuan</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                        <i class="bx bx-credit-card me-2"></i>Lanjutkan Pembayaran
                    </button>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="bx bx-receipt me-2"></i>Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <!-- Route Info -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="text-center flex-grow-1">
                            <h6 class="fw-bold mb-1">Tanjung Perak</h6>
                            <small class="text-muted">Keberangkatan</small>
                        </div>
                        <div class="px-3">
                            <i class="bx bx-right-arrow-alt fs-4 text-primary"></i>
                        </div>
                        <div class="text-center flex-grow-1">
                            <h6 class="fw-bold mb-1">Makassar</h6>
                            <small class="text-muted">Kedatangan</small>
                        </div>
                    </div>

                    <!-- Ship Details -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Kapal</span>
                            <span class="badge bg-info">KM. LABOBAR</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Kelas</span>
                            <span class="badge bg-light text-dark border">Ekonomi</span>
                        </div>
                    </div>

                    <!-- Schedule -->
                    <div class="border-top border-bottom py-3 mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <i class="bx bx-calendar-check text-primary me-2"></i>
                                <small>Berangkat</small>
                            </div>
                            <span class="fw-semibold">Rabu, 28 Jul 2023</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <i class="bx bx-time text-primary me-2"></i>
                                <small>Pukul</small>
                            </div>
                            <span class="fw-semibold">16:00 WIB</span>
                        </div>
                    </div>

                    <!-- Passenger Summary -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Penumpang</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>2 Dewasa</span>
                            <span class="fw-semibold">Rp 288.000</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>0 Anak-anak</span>
                            <span class="fw-semibold">Rp 0</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Subtotal</span>
                            <span class="fw-bold">Rp 576.000</span>
                        </div>
                    </div>

                    <!-- Total Price -->
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Total</h5>
                            <h4 class="mb-0 text-danger fw-bold">Rp 576.000</h4>
                        </div>
                        <small class="text-muted d-block mt-1">Termasuk semua pajak dan biaya</small>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bx bx-download me-2"></i>Simpan Ringkasan
                        </a>
                        <a href="#" class="btn btn-light w-100">
                            <i class="bx bx-help-circle me-2"></i>Butuh Bantuan?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    }
    
    .passenger-card {
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    
    .passenger-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .sticky-top {
        position: sticky;
        z-index: 1;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0,102,204,0.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,102,204,0.3);
    }
    
    .badge {
        border-radius: 6px;
        padding: 5px 10px;
        font-weight: 500;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Countdown Timer
    let minutes = 9;
    let seconds = 59;
    const timerElement = document.getElementById('countdownTimer');
    
    function updateTimer() {
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (seconds === 0) {
            if (minutes === 0) {
                // Time's up
                clearInterval(timerInterval);
                alert('Waktu pemesanan telah habis!');
                return;
            }
            minutes--;
            seconds = 59;
        } else {
            seconds--;
        }
    }
    
    const timerInterval = setInterval(updateTimer, 1000);
    
    // Auto-fill passenger data
    const sameAsCustomerCheckbox = document.getElementById('sameAsCustomer');
    const customerNameInput = document.querySelector('input[name="customer_name"]');
    const passenger1NameInput = document.querySelector('input[name="passenger1_name"]');
    
    sameAsCustomerCheckbox.addEventListener('change', function() {
        if (this.checked && customerNameInput.value) {
            passenger1NameInput.value = customerNameInput.value;
        } else {
            passenger1NameInput.value = '';
        }
    });
    
    // Real-time validation
    const phoneInput = document.querySelector('input[name="phone"]');
    const emailInput = document.querySelector('input[name="customer_email"]');
    
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (!value.startsWith('0') && value.length <= 15) {
                value = '0' + value;
            }
        }
        e.target.value = value;
    });
    
    emailInput.addEventListener('blur', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (this.value && !emailRegex.test(this.value)) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    // Add animation to form submission
    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.addEventListener('click', function(e) {
        const requiredInputs = document.querySelectorAll('input[required]');
        let valid = true;
        
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                valid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        if (!valid) {
            e.preventDefault();
            this.classList.add('shake');
            setTimeout(() => {
                this.classList.remove('shake');
            }, 500);
        }
    });
    
    // Add shake animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake {
            animation: shake 0.5s;
        }
        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection