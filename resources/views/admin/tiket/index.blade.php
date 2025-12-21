@extends('admin.tamplate.admin.header')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">Tiket Perorangan</h4>
              @foreach ($passengerPrices as $item)
              <!-- Examples -->
              <div class="row mb-5">
                <div class="col-md-6 col-lg-4 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="card-title">{{ $item->passenger_type }}</h5>
                      <h4 class="card-text">
                        {{ number_format($item->price) }}
                      </h4>
                      <a href="javascript:void(0)" class="btn btn-outline-primary">Detail</a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              <!-- Examples -->

              <hr>

              <h4 class="fw-bold py-3 mb-4">Tiket Kendaraan</h4>

              <!-- Examples -->
               @foreach ($vehiclePrices as $item)
              <div class="row mb-5">
                <div class="col-md-6 col-lg-4 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="card-title">{{ $item->vehicle_type }}</h5>
                      <h4 class="card-text">
                        {{ number_format($item->price) }}
                      </h4>
                      <a href="javascript:void(0)" class="btn btn-outline-primary">Detail</a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              <!-- Examples -->

             
              <!--/ Card layout -->
            </div>

@endsection