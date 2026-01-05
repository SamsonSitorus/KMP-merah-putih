@extends('admin.tamplate.admin.header')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dashboard Admin</h4>
            <p class="text-muted mb-0">Ringkasan aktivitas sistem hari ini</p>
        </div>
    </div>
    <div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-label-primary me-3">
                    <i class="bx bx-user fs-4"></i>
                </div>
                <div>
                    <small class="text-muted">Total Penumpang</small>
                    <h5 class="fw-bold mb-0">1.245</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-label-success me-3">
                    <i class="bx bx-car fs-4"></i>
                </div>
                <div>
                    <small class="text-muted">Total Kendaraan</small>
                    <h5 class="fw-bold mb-0">356</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-label-warning me-3">
                    <i class="bx bx-receipt fs-4"></i>
                </div>
                <div>
                    <small class="text-muted">Transaksi Hari Ini</small>
                    <h5 class="fw-bold mb-0">89</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-label-danger me-3">
                    <i class="bx bx-money fs-4"></i>
                </div>
                <div>
                    <small class="text-muted">Total Pendapatan</small>
                    <h5 class="fw-bold mb-0">Rp 125.000.000</h5>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row mb-4">

    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <h6 class="fw-semibold mb-0">Aktivitas Penjualan Tiket</h6>
            </div>
            <div class="card-body text-center text-muted">
                <i class="bx bx-line-chart fs-1 mb-2"></i>
                <p class="mb-0">
                    Grafik penjualan tiket akan ditampilkan di sini
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <h6 class="fw-semibold mb-0">Informasi Cepat</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-1"></i>
                        Sistem berjalan normal
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-time-five text-warning me-1"></i>
                        Jadwal hari ini aktif
                    </li>
                    <li>
                        <i class="bx bx-user text-primary me-1"></i>
                        Admin online
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between">
        <h6 class="fw-semibold mb-0">Transaksi Terbaru</h6>
        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Pemesan</th>
                    <th>Jumlah Tiket</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ahmad</td>
                    <td>3</td>
                    <td>Rp 350.000</td>
                    <td>
                        <span class="badge bg-success">Paid</span>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Siti</td>
                    <td>1</td>
                    <td>Rp 150.000</td>
                    <td>
                        <span class="badge bg-warning">Pending</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
              
@endsection