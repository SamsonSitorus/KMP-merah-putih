@extends('admin.tamplate.admin.header')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">Tiket Perorangan</h4>
              <!-- Examples -->
              <div class="row mb-5">

              {{-- 🔹 Card CREATE TIKET --}}
                  <div class="col-md-6 col-lg-4 mb-3">
                      <div class="card h-100 border border-dashed text-center">
                          <div class="card-body d-flex flex-column justify-content-center align-items-center">
                              <div class="mb-3">
                                  <i class="bx bx-plus-circle bx-lg text-primary"></i>
                              </div>
                              <h5 class="card-title">Tambah Tiket</h5>
                              <p class="text-muted mb-3">Buat tiket baru</p>
                              <a href="javascript:void(0)"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#createTiketModal">
                                  Create Tiket
                              </a>
                          </div>
                      </div>
                  </div>

                  {{-- 🔹 Card PASSENGER --}}
                  @foreach ($passengerPrices as $item)
                  <div class="col-md-6 col-lg-4 mb-3">
                      <div class="card h-100 position-relative">

                          {{-- ❌ Delete Icon --}}
                          <button class="btn btn-sm btn-icon btn-danger position-absolute top-0 end-0 m-2 btn-delete"
                              data-bs-toggle="modal"
                              data-bs-target="#deleteTiketModal"
                              data-id="{{ $item->id }}"
                              data-name="{{ $item->passenger_type }}">
                              <i class="bx bx-x"></i>
                          </button>

                          <div class="card-body">
                              <h5 class="card-title">{{ $item->passenger_type }}</h5>
                              <h4>Rp {{ number_format($item->price, 0, ',', '.') }}</h4>

                              <button class="btn btn-outline-primary btn-detail"
                                  data-bs-toggle="modal"
                                  data-bs-target="#updateTiketModal"
                                  data-id="{{ $item->id }}"
                                  data-type="passenger"
                                  data-passenger="{{ $item->passenger_type }}"
                                  data-price="{{ $item->price }}">
                                  Detail
                              </button>
                          </div>
                      </div>
                  </div>
                  @endforeach

              </div>
              <!-- Examples -->

              <hr>

              <h4 class="fw-bold py-3 mb-4">Tiket Kendaraan</h4>

              <!-- Examples -->
              <div class="row mb-5">
                 @foreach ($vehiclePrices as $item)
                  <div class="col-md-6 col-lg-4 mb-3">
                      <div class="card h-100 position-relative">

                          {{-- ❌ Delete Icon --}}
                          <button class="btn btn-sm btn-icon btn-danger position-absolute top-0 end-0 m-2 btn-delete"
                              data-bs-toggle="modal"
                              data-bs-target="#deleteTiketModal"
                              data-id="{{ $item->id }}"
                              data-name="{{ $item->vehicle_type }}">
                              <i class="bx bx-x"></i>
                          </button>

                          <div class="card-body">
                              <h5 class="card-title">{{ $item->vehicle_type }}</h5>
                              <h4>Rp {{ number_format($item->price, 0, ',', '.') }}</h4>

                              <button class="btn btn-outline-primary btn-detail"
                                  data-bs-toggle="modal"
                                  data-bs-target="#updateTiketModal"
                                  data-id="{{ $item->id }}"
                                  data-type="vehicle"
                                  data-vehicle="{{ $item->vehicle_type }}"
                                  data-price="{{ $item->price }}">
                                  Detail
                              </button>
                          </div>
                      </div>
                  </div>
                  @endforeach
              </div>
            
              <!-- Examples -->

             
              <!--/ Card layout -->
            </div>


            <!-- Modal Create Tiket -->
    <div class="modal fade" id="createTiketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.tiket.store') }}" method="POST" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{-- Type --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Tiket</label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="passenger">Passenger</option>
                        <option value="vehicle">Vehicle</option>
                    </select>
                </div>

                {{-- Passenger --}}
                <div class="mb-3 d-none" id="passengerField">
                    <label class="form-label">Passenger Type</label>
                    <select name="passenger_type" class="form-select">
                        <option value="">-- Pilih Passenger --</option>
                        <option value="Dewasa">Dewasa</option>
                        <option value="Anak">Anak</option>
                        <option value="Bayi">Bayi</option>
                    </select>
                </div>

                {{-- Vehicle --}}
                <div class="mb-3 d-none" id="vehicleField">
                    <label class="form-label">Vehicle Type</label>
                    <select name="vehicle_type" class="form-select">
                        <option value="">-- Pilih Kendaraan --</option>
                        <option value="Sepeda Dayung">Sepeda Dayung</option>
                        <option value="Sepeda Motor">Sepeda Motor</option>
                        <option value="Becak / Sepeda Motor > 500 cc">Becak / Sepeda Motor > 500 cc</option>
                        <option value="Mini Bus Roda 4">Mini Bus Roda 4</option>
                        <option value="Pick Up">Pick Up</option>
                        <option value="Bus Sedang Roda 4">Bus Sedang Roda 4</option>
                        <option value="Kendaraan Barang Roda 4">Kendaraan Barang Roda 4</option>
                    </select>
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Tiket -->
<div class="modal fade" id="updateTiketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.tiket.update') }}" class="modal-content">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="modal_id">
            <input type="hidden" name="type" id="modal_type">

            <div class="modal-header">
                <h5 class="modal-title">Update Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- Passenger --}}
                <div class="mb-3 d-none" id="passengerField">
                    <label class="form-label">Passenger Type</label>
                    <input type="text" name="passenger_type"
                        id="modal_passenger"
                        class="form-control">
                </div>

                {{-- Vehicle --}}
                <div class="mb-3 d-none" id="vehicleField">
                    <label class="form-label">Vehicle Type</label>
                    <input type="text" name="vehicle_type"
                        id="modal_vehicle"
                        class="form-control">
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price"
                        id="modal_price"
                        class="form-control" required>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Modal Delete -->
 <div class="modal fade" id="deleteTiketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.tiket.delete') }}" class="modal-content">
            @csrf
            @method('DELETE')

            <input type="hidden" name="id" id="delete_ticket_id">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Hapus Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    Yakin ingin menghapus tiket
                    <strong id="delete_ticket_name"></strong> ?
                </p>
                <small class="text-muted">Data yang dihapus tidak bisa dikembalikan.</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" class="btn btn-danger">
                    Ya, Hapus
                </button>
            </div>

        </form>
    </div>
</div>

//java script

    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const typeSelect = document.querySelector('select[name="type"]');
          const passengerField = document.getElementById('passengerField');
          const vehicleField = document.getElementById('vehicleField');

          typeSelect.addEventListener('change', function () {
              passengerField.classList.toggle('d-none', this.value !== 'passenger');
              vehicleField.classList.toggle('d-none', this.value !== 'vehicle');
          });
      });

      //js for modal update
      document.addEventListener('DOMContentLoaded', function () {
          document.querySelectorAll('.btn-detail').forEach(btn => {
              btn.addEventListener('click', function () {

                  const type = this.dataset.type;

                  document.getElementById('modal_id').value = this.dataset.id;
                  document.getElementById('modal_type').value = type;
                  document.getElementById('modal_price').value = this.dataset.price;

                  // Reset
                  document.getElementById('passengerField').classList.add('d-none');
                  document.getElementById('vehicleField').classList.add('d-none');

                  if (type === 'passenger') {
                      document.getElementById('passengerField').classList.remove('d-none');
                      document.getElementById('modal_passenger').value = this.dataset.passenger;
                  }

                  if (type === 'vehicle') {
                      document.getElementById('vehicleField').classList.remove('d-none');
                      document.getElementById('modal_vehicle').value = this.dataset.vehicle;
                  }
              });
          });
      });

      //js for delete ticket
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('delete_ticket_id').value = this.dataset.id;
                    document.getElementById('delete_ticket_name').innerText = this.dataset.name;
                });
            });
        });

    </script>

    

@endsection