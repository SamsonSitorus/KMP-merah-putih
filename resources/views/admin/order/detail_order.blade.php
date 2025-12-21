@extends('admin.tamplate.admin.header')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
          
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <div class="mb-1"><span class="h5">Order #32543 </span><span class="badge bg-label-success me-1 ms-2">Paid</span> <span class="badge bg-label-info">Ready to Pickup</span></div>
      <p class="mb-0">Aug 17, <span id="orderYear">2025</span>, 5:48 (ET)</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-2">
      <button class="btn btn-danger">Delete Order</button>
    </div>
  </div>

  <!-- Order Details Table -->

  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card mb-6">
        <div class="card-datatable table-responsive">
          <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row card-header border-bottom mx-0 px-3"><div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto px-3">
                <h5 class="card-title mb-0">Order details</h5>
                </div><div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto px-3">

                </div>
            </div>
            <div class="justify-content-between dt-layout-table">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-order-details table dataTable dtr-column mb-0 collapsed" id="DataTables_Table_0" style="width: 100%;">
                        <colgroup><col data-dt-column="0" style="width: 60.2812px;"><col data-dt-column="1" style="width: 72.8438px;">
                            <col data-dt-column="2" style="width: 194.875px;">
                         </colgroup>
                        <thead>
                            <tr>
                                
                                <th class="w-50 dt-orderable-none" data-dt-column="2" rowspan="1" colspan="1" aria-label="products">
                                    <span class="dt-column-title">Tiket</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-none">
                                    <span class="dt-column-title">Harga</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-none">
                                    <span class="dt-column-title">Banyak</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-none">
                                    <span class="dt-column-title">Total</span>
                                    <span class="dt-column-order"></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td>
                                    <div class="d-flex justify-content-start align-items-center text-nowrap">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-body mb-0">Oneplus 10</h6>
                                            <small>Storage:128gb</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-type-numeric" >
                                    <span>$896</span>
                                </td>
                                <td class="dt-type-numeric" >
                                    <span class="text-body">3</span>
                                </td>
                                <td class="dt-type-numeric">
                                    <span class="text-body">2688</span>
                                </td>
                            </tr>
                            
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="mt-0"><div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto px-3">

            </div>
            <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto px-3">

            </div>
        </div>
    </div>
          <div class="d-flex justify-content-end align-items-center m-6 mb-2">
            <div class="order-calculations">
              <div class="d-flex justify-content-start">
                <h6 class="w-px-100 mb-0">Total:</h6>
                <h6 class="mb-0">$2113</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="card-title m-0">Customer details</h5>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-start align-items-center mb-6">
            <div class="avatar me-3">
              <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
            </div>
            <div class="d-flex flex-column">
              <a href="app-user-view-account.html" class="text-body text-nowrap">
                <h6 class="mb-0">Shamus Tuttle</h6>
              </a>
              <span>Customer ID: #58909</span>
            </div>
          </div>
          <div class="d-flex justify-content-start align-items-center mb-6">
            <span class="avatar rounded-circle bg-label-success me-3 d-flex align-items-center justify-content-center"><i class="icon-base bx bx-cart icon-lg"></i></span>
            <h6 class="text-nowrap mb-0">12 Orders</h6>
          </div>
          <div class="d-flex justify-content-between">
            <h6 class="mb-1">Contact info</h6>
          </div>
          <p class=" mb-1">Email: Shamus889@yahoo.com</p>
          <p class=" mb-0">Mobile: +1 (609) 972-22-22</p>
        </div>
      </div>
      <div class="card mb-6">
        <div class="card-header d-flex justify-content-between pb-2">
          <h5 class="card-title m-0">Bukti Pembayaran</h5>
          <h6 class="m-0"><a href=" javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addNewAddress">Lihat</a></h6>
        </div>
        <div class="card-body">
          
        </div>
      </div>
    </div>
  </div>

</div>

@endsection