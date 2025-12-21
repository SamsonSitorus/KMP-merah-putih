@extends('admin.tamplate.admin.header')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Pemberitahuan</h5>
          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">1</span>
        </div>

      <div class="card-body pt-4">
          <ul class="p-0 m-0">
            
            
            <li class="d-flex align-items-center mb-6">
              <div class="avatar flex-shrink-0 me-3">
                <img src="../../assets/img/icons/unicons/chart.png" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <div class="mb-1">
                    <span class="h5">Order #32543 </span>
                    <span class="badge bg-label-success  me-1 ms-2">Paid</span> 
                    <span class="badge bg-label-info">Menunggu Persetujuan</span>
                  </div>
                  <h6 class="fw-normal mb-0">Pengiriman Bukti Pembayaran Pembelian Tiket | Gabriel Panjaitan | Rp.2000.000</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">
                  <a
                    class="github-button"
                    href="/admin/order-detail"
                    data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                    >Lihat</a
                  >
                </div>
              </div>
            </li>
          </ul>
        </div>

    </div>
  </div>
@endsection