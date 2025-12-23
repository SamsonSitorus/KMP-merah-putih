@extends('admin.tamplate.admin.header')

@section('content')
        <div class="container-xxl flex-grow-1 container-p-y">

              <!-- Basic Bootstrap Table -->
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rute dan Jadwal Berlayar</h5>

                    <div class="d-flex gap-2">
                        {{-- 🔍 FILTER --}}
                        <form method="GET" class="d-flex gap-2">
                            <select name="route" class="form-select">
                                <option value="">-- Rute Asal --</option>
                                <option value="Muara" {{ request('route') == 'Muara' ? 'selected' : '' }}>
                                    Muara
                                </option>
                                <option value="Simarpinggan" {{ request('route') == 'Simarpinggan' ? 'selected' : '' }}>
                                    Simarpinggan
                                </option>
                            </select>

                            <input
                                type="date"
                                name="date"
                                class="form-control"
                                value="{{ request('date') }}"
                            >

                            <button class="btn btn-primary">
                                <i class="bx bx-search"></i>
                            </button>
                        </form>

                        {{-- ➕ TAMBAH --}}
                        <button
                            class="btn btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#addScheduleModal"
                        >
                            <i class="bx bx-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Keberangkatan (Jam)</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach($ticketStocks as $item)

                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong>{{$item->origin_name}}</strong></td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong>{{$item->destination_name}}</strong></td>
                        <td>
                         {{$item -> departure_date}}
                        </td>
                        <td>{{$item -> departure_time}}</td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>

                            <div class="dropdown-menu">
                                  {{-- DETAIL --}}
                                  <a class="dropdown-item btn-detail"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    data-origin="{{ $item->origin_name }}"
                                    data-destination="{{ $item->destination_name }}"
                                    data-date="{{ $item->departure_date }}"
                                    data-time="{{ $item->departure_time }}"
                                    data-roda4="{{ $item->stock_roda_4 }}"
                                    data-roda2="{{ $item->stock_roda_2 }}"
                                    data-passenger="{{ $item->stock_passenger }}">
                                      <i class="bx bx-info-circle me-1"></i> Detail
                                  </a>

                                  {{-- DELETE --}}
                                  <a class="dropdown-item text-danger btn-delete"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-id="{{ $item->id }}"
                                    data-route="{{ $item->origin_name }} → {{ $item->destination_name }}"
                                    data-date="{{ $item->departure_date }}"
                                    data-time="{{ $item->departure_time }}">
                                      <i class="bx bx-trash me-1"></i> Delete
                                  </a>
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

            <!-- Modal Tambah Jadwal -->
            <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('admin.schedule.store') }}" method="POST">
                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Jadwal Berlayar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                {{-- Asal --}}
                                <div class="mb-3">
                                    <label class="form-label">Asal</label>
                                    <select name="origin" class="form-select" required>
                                        <option value="">-- Pilih Asal --</option>
                                        <option value="1">Muara</option>
                                        <option value="2">Simarpinggan</option>
                                    </select>
                                </div>

                                {{-- Tujuan --}}
                                <div class="mb-3">
                                    <label class="form-label">Tujuan</label>
                                    <select name="destination" class="form-select" required>
                                        <option value="">-- Pilih Tujuan --</option>
                                        <option value="1">Muara</option>
                                        <option value="2">Simarpinggan</option>
                                    </select>
                                </div>

                                {{-- Tanggal --}}
                                <div class="mb-4">
                                    <label class="form-label">Tanggal Berangkat</label>
                                    <input type="date" name="departure_date" class="form-control" required>
                                </div>

                                <hr>

                                {{-- Jadwal Dinamis --}}
                                <label class="form-label fw-bold mb-2">Detail Jadwal & Kendaraan</label>

                                <div id="scheduleWrapper">

                                    {{-- Item --}}
                                    <div class="row g-2 mb-2 schedule-item">
                                        <div class="col-md-4">
                                            <input
                                                type="time"
                                                name="schedules[0][time]"
                                                class="form-control"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-4">
                                            <input
                                                type="number"
                                                name="schedules[0][stock_roda_4]"
                                                class="form-control"
                                                min="1"
                                                placeholder="Stok Roda 4"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-3">
                                            <input
                                                type="number"
                                                name="schedules[0][stock_roda_2]"
                                                class="form-control"
                                                min="1"
                                                placeholder="Stok Roda 2/Motor/Becak"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-1 d-flex align-items-center">
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger remove-schedule"
                                            >
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm mt-2"
                                    id="addScheduleBtn"
                                >
                                    <i class="bx bx-plus"></i> Tambah Jadwal
                                </button>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Simpan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Detail -->
            <div class="modal fade" id="detailModal" tabindex="-1">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content">

                          <div class="modal-header">
                              <h5 class="modal-title">Detail Jadwal Berlayar</h5>
                              <button class="btn-close" data-bs-dismiss="modal"></button>
                          </div>

                          <div class="modal-body">
                              <table class="table table-borderless">
                                  <tr><th>Asal</th><td id="d-origin"></td></tr>
                                  <tr><th>Tujuan</th><td id="d-destination"></td></tr>
                                  <tr><th>Tanggal</th><td id="d-date"></td></tr>
                                  <tr><th>Jam</th><td id="d-time"></td></tr>
                                  <tr><th>Stok Roda 4</th><td id="d-roda4"></td></tr>
                                  <tr><th>Stok Roda 2</th><td id="d-roda2"></td></tr>
                                  <tr><th>Stok Penumpang</th><td id="d-passenger"></td></tr>
                              </table>
                          </div>

                          <div class="modal-footer">
                              <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>

                      </div>
                  </div>
              </div>

              <!-- Modal Delete -->
              <div class="modal fade" id="deleteModal" tabindex="-1">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">

                            <form method="POST" id="deleteForm">
                                @csrf
                                @method('DELETE')

                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">Hapus Jadwal</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body text-center">
                                    <p>Yakin ingin menghapus jadwal:</p>
                                    <strong id="del-route"></strong>
                                    <p class="text-muted mt-1">
                                        <span id="del-date"></span> | <span id="del-time"></span>
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-danger">Ya, Hapus</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>




<!-- script modal create stok ticket for rute and jadwal -->

<script>

let scheduleIndex = 1;

document.getElementById('addScheduleBtn').addEventListener('click', function () {
    const wrapper = document.getElementById('scheduleWrapper');

    const row = document.createElement('div');
    row.classList.add('row', 'g-2', 'mb-2', 'schedule-item');

    row.innerHTML = `
        <div class="col-md-4">
            <input type="time" name="schedules[${scheduleIndex}][time]" class="form-control" required>
        </div>

        <div class="col-md-4">
            <input type="number" name="schedules[${scheduleIndex}][stock_roda_4]" class="form-control" min="1" placeholder="Stok Roda 4" required>
        </div>

        <div class="col-md-3">
            <input type="number" name="schedules[${scheduleIndex}][stock_roda_2]" class="form-control" min="1" placeholder="Stok Roda 2/Motor/Becak" required>
        </div>

        <div class="col-md-1 d-flex align-items-center">
            <button type="button" class="btn btn-outline-danger remove-schedule">
                <i class="bx bx-x"></i>
            </button>
        </div>
    `;

    wrapper.appendChild(row);
    scheduleIndex++;
});

// remove item
document.addEventListener('click', function (e) {
    if (e.target.closest('.remove-schedule')) {
        const items = document.querySelectorAll('.schedule-item');

        if (items.length > 1) {
            e.target.closest('.schedule-item').remove();
        }
    }
});

document.querySelectorAll('.btn-detail').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('d-origin').innerText = this.dataset.origin;
        document.getElementById('d-destination').innerText = this.dataset.destination;
        document.getElementById('d-date').innerText = this.dataset.date;
        document.getElementById('d-time').innerText = this.dataset.time;
        document.getElementById('d-roda4').innerText = this.dataset.roda4;
        document.getElementById('d-roda2').innerText = this.dataset.roda2;
        document.getElementById('d-passenger').innerText = this.dataset.passenger;
    });
});

document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('del-route').innerText = this.dataset.route;
        document.getElementById('del-date').innerText = this.dataset.date;
        document.getElementById('del-time').innerText = this.dataset.time;

        document.getElementById('deleteForm').action =
            `/admin/schedule/${this.dataset.id}`;
    });
});

</script>

@endsection