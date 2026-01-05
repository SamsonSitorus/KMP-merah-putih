@extends('admin.tamplate.admin.header')

@section('content')

        <div class="container-xxl flex-grow-1 container-p-y">
              <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Daftar Tiket Tersedia</h4>

                    {{-- FILTER --}}
                    <select class="form-select w-auto" id="filterType">
                        <option value="all">Semua Tiket</option>
                        @foreach($ticketTypes as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
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
                @foreach ($ticketPrices as $item)
                <div class="col-md-6 col-lg-4 mb-4 ticket-item" data-type="{{ $item->ticketType->id }}">
                    <div class="card shadow-sm border-0 ticket-expand-card">

                        {{-- HEADER --}}
                        <div class="card-header bg-gradient-info text-white d-flex justify-content-between align-items-center">

                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $item->name }}</h6>
                                <small class="opacity-75">{{ $item->ticketType->name }}</small>
                            </div>

                            <div class="d-flex align-items-center gap-2">

                                {{-- Delete --}}
                                <button
                                    class="btn btn-sm btn-danger btn-icon rounded-circle"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteTiketModal"
                                    data-id="{{ $item->id }}"
                                >
                                    <i class="bx bx-x"></i>
                                </button>

                                {{-- Toggle --}}
                                <button
                                    class="btn btn-sm btn-light btn-toggle"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#detail-{{ $item->id }}"
                                >
                                    <i class="bx bx-chevron-down"></i>
                                </button>

                            </div>
                        </div>

                        {{-- COLLAPSE BODY --}}
                        <div class="collapse" id="detail-{{ $item->id }}">
                            <div class="card-body">

                                {{-- Harga --}}
                                <div class="mb-3 text-center">
                                    <small class="text-muted">Harga Tiket</small>
                                    <h4 class="fw-bold text-primary mb-0">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </h4>
                                </div>

                                <hr>

                                {{-- Passenger --}}
                                @if($item->passenger_type)
                                <p class="mb-2">
                                    <i class="bx bx-user me-1 text-primary"></i>
                                    {{ $item->passenger_type }}
                                </p>
                                @endif

                                {{-- Vehicle --}}
                                @if($item->vehicle_type)
                                <p class="mb-2">
                                    <i class="bx bx-car me-1 text-primary"></i>
                                    {{ $item->vehicle_type }}
                                </p>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
                @endforeach



              </div>
              <!-- Examples -->

              <hr>

              
            
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

                {{-- Ticket Type --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Tiket</label>
                    <select name="ticket_type_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($ticketTypes as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Passenger Category --}}
                <div class="mb-3">
                    <label class="form-label">Kategori Penumpang</label>
                    <input
                        type="text"
                        name="passenger_type"
                        class="form-control"
                        placeholder="Contoh: Dewasa / Bayi / Motor / Mini Bus / dll"
                    >
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        min="0"
                        required
                    >
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
        <div class="modal-content border-0 shadow-lg ticket-modal">

            {{-- Header --}}
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title">
                    <i class="bx bx-receipt me-2"></i> Detail Tiket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">

                {{-- Ticket Card --}}
                <div class="ticket-card-view p-4">

                    <div class="text-center mb-4">
                        <h6 class="text-muted mb-1">Jenis Tiket</h6>
                        <h4 class="fw-bold" id="modal_type_text">Passenger</h4>
                    </div>

                    <hr class="ticket-divider">

                    {{-- Passenger --}}
                    <div class="d-flex justify-content-between mb-3" id="passengerField">
                        <span class="text-muted">
                            <i class="bx bx-user me-1"></i> Passenger
                        </span>
                        <strong id="modal_passenger">-</strong>
                    </div>

                    {{-- Vehicle --}}
                    <div class="d-flex justify-content-between mb-3" id="vehicleField">
                        <span class="text-muted">
                            <i class="bx bx-car me-1"></i> Kendaraan
                        </span>
                        <strong id="modal_vehicle">-</strong>
                    </div>

                    <hr class="ticket-divider">

                    {{-- Price --}}
                    <div class="text-center">
                        <small class="text-muted">Harga Tiket</small>
                        <h3 class="fw-bold text-primary mt-1">
                            Rp <span id="modal_price">0</span>
                        </h3>
                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
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

        //fiter ticket
        document.getElementById('filterType').addEventListener('change', function () {
            const selected = this.value;
            const items = document.querySelectorAll('.ticket-item');

            items.forEach(item => {
                const type = item.dataset.type;

                if (selected === 'all' || type === selected) {
                    item.classList.remove('d-none');
                } else {
                    item.classList.add('d-none');
                }
            });
        });

    </script>

    

@endsection