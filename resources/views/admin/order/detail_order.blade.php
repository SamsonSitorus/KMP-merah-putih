@extends('admin.tamplate.admin.header')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
          
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <div class="mb-1">
        <span class="h5">Order Tiket#{{$order->id}} </span>
          @if($order->status == 'pending')
              <span class="badge bg-label-warning me-1 ms-2">Pending</span>
          @elseif($order->status == 'berhasil')
              <span class="badge bg-label-success me-1 ms-2">Selesai</span>
          @elseif($order->status == 'menunggu')
              <span class="badge bg-label-info me-1 ms-2">Menunggu Persetujuan</span>
          @elseif($order->status == 'ditolak')
              <span class="badge bg-label-danger me-1 ms-2">Ditolak</span>
          @elseif($order->status == 'cancel')
              <span class="badge bg-label-danger me-1 ms-2">Dibatalkan</span>
          @else
              <span class="badge bg-secondary me-1 ms-2">Unknown</span>
          @endif
      </div>
      <p class="mb-0">{{$order->created_at}}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-2">
      <a href=""><button class="btn btn-outline-danger">Tolak Pesanan</button></a>
      <a href="/admin/order/{{$order->id}}/update-status-order"><button class="btn btn-outline-success">Terima Pesanan</button></a>
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
                                <th class="w-50 dt-orderable-none">
                                    <span class="dt-column-title">Banyak</span>
                                    <span class="dt-column-order"></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td>
                                    <div class="w-50  d-flex justify-content-start align-items-center text-nowrap">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-body mb-0">Dewasa</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-type-numeric" >
                                    <span>{{$order->dewasa_count}}</span>
                                </td>
                            </tr>
                            <tr class="">
                                <td>
                                    <div class="w-50  d-flex justify-content-start align-items-center text-nowrap">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-body mb-0">Anak - anak</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-type-numeric" >
                                    <span>{{$order->anak_count}}</span>
                                </td>
                            </tr>
                            
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-order-details table dataTable dtr-column mb-0 collapsed" id="DataTables_Table_0" style="width: 100%;">
                        <colgroup><col data-dt-column="0" style="width: 60.2812px;"><col data-dt-column="1" style="width: 72.8438px;">
                            <col data-dt-column="2" style="width: 194.875px;">
                         </colgroup>
                         <thead>
                            <tr>
                                
                                <th class="w-50 dt-orderable-none" data-dt-column="2" rowspan="1" colspan="1" aria-label="products">
                                    <span class="dt-column-title">Tiket Kendaraan</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="w-50 dt-orderable-none">
                                    <span class="dt-column-title">Banyak</span>
                                    <span class="dt-column-order"></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($vehicles as $item)
                            <tr class="">
                                <td>
                                    <div class="d-flex justify-content-start align-items-center text-nowrap">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-body mb-0">{{$item->vehicle_type}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-type-numeric" >
                                    <span>{{$item->count}}</span>
                                </td>
                            </tr>
                          @endforeach
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
                <h6 class="mb-0">Rp. {{number_format($order->total_price)}}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="card-title m-0">Detail Pemesan</h5>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-start align-items-center mb-6">
            <div class="avatar me-3">
              <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
            </div>
            <div class="d-flex flex-column">
              <a href="app-user-view-account.html" class="text-body text-nowrap">
                <h6 class="mb-0">{{$order->user_name}}</h6>
              </a>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <h6 class="mb-1">Contact info</h6>
          </div>
          <p class=" mb-0">Mobile: {{$order->phone_number}}</p>
        </div>
      </div>
      <div class="card mb-6">
        <div class="card-header d-flex justify-content-between pb-2">
          <h5 class="card-title m-0">Bukti Pembayaran</h5>
          <h6 class="m-0"><a href=" javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addNewAddress">Lihat</a></h6>
        </div>
        <div class="card-body">
          <img src="{{ asset('storage/'.$order->payment_proof_path) }}" alt="Image">
        </div>
      </div>
    </div>
  </div>

</div>

@endsection