@extends('admin.tamplate.admin.header')

@section('content')
        <div class="container-xxl flex-grow-1 container-p-y">

              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Data Pemesanan Tiket</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Rute</th>
                        <th>Nama</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach($orders as $item)
                        <tr>
                          <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong>Balige - Onan Runggu</strong></td>
                          <td>{{$item -> user_name}}</td>
                          <td>
                            {{$item -> total_price}}
                          </td>
                          <td>
                            @if($item->status == 'pending')
                                <span class="badge bg-label-warning me-1 ms-2">Pending</span>
                            @elseif($item->status == 'berhasil')
                                <span class="badge bg-label-success me-1 ms-2">Selesai</span>
                            @elseif($item->status == 'menunggu')
                                <span class="badge bg-label-info me-1 ms-2">Menunggu Persetujuan</span>
                            @elseif($item->status == 'ditolak')
                                <span class="badge bg-label-danger me-1 ms-2">Ditolak</span>
                            @elseif($item->status == 'cancel')
                                <span class="badge bg-label-danger me-1 ms-2">Dibatalkan</span>
                            @else
                                <span class="badge bg-secondary me-1 ms-2">Unknown</span>
                            @endif
                          </td>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="/admin/order-detail/{{$item->id}}"
                                  ><i class="bx bx-edit-alt me-2"></i> Detail</a
                                >
                              </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->
            </div>

@endsection