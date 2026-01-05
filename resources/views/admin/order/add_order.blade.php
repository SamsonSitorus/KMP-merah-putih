@extends('admin.tamplate.admin.header')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex align-items-center mb-4">
        <i class="bx bx-receipt fs-3 me-2 text-primary"></i>
        <h4 class="fw-bold mb-0">
            Form Pembelian Tiket Langsung ke Tempat
        </h4>
    </div>

    <form action="" method="POST">
    @csrf

    <h5 class="fw-bold mb-3">Data Penumpang</h5>

<div id="passengerWrapper">

    <div class="row g-2 mb-2 passenger-item">
        <div class="col-md-5">
            <input
                type="text"
                name="passengers[0][name]"
                class="form-control"
                placeholder="Nama Lengkap Penumpang"
                required
            >
        </div>

        <div class="col-md-4">
            <select
                name="passengers[0][category]"
                class="form-select"
                required
            >
                <option value="">Kategori Penumpang</option>
                <option value="dewasa">Dewasa</option>
                <option value="anak">Anak-anak</option>
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-center">
            <button type="button" class="btn btn-outline-danger remove-passenger">
                <i class="bx bx-x"></i>
            </button>
        </div>
    </div>

</div>

<button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addPassengerBtn">
    <i class="bx bx-plus"></i> Tambah Penumpang
</button>

<h5 class="fw-bold mb-3">Data Kendaraan</h5>

<div id="vehicleWrapper">

    <div class="row g-2 mb-2 vehicle-item">
        <div class="col-md-3">
            <input
                type="text"
                name="vehicles[0][plate]"
                class="form-control"
                placeholder="No Plat Kendaraan"
            >
        </div>

        <div class="col-md-4">
            <select name="vehicles[0][vehicle_name]" class="form-select">
                <option value="">Jenis Kendaraan</option>
                <option value="Motor">Motor</option>
                <option value="Mobil">Mobil</option>
                <option value="Minibus">Minibus</option>
                <option value="Bus">Bus</option>
                <option value="Pickup">Pickup</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="vehicles[0][type]" class="form-select">
                <option value="">Kategori Roda</option>
                <option value="roda_2">Roda 2</option>
                <option value="roda_4">Roda 4</option>
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-center">
            <button type="button" class="btn btn-outline-danger remove-vehicle">
                <i class="bx bx-x"></i>
            </button>
        </div>
    </div>

</div>

<button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addVehicleBtn">
    <i class="bx bx-plus"></i> Tambah Kendaraan
</button>

<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-primary btn-lg px-5">
        <i class="bx bx-check-circle me-1"></i> Booking Tiket
    </button>
</div>

</form>
    

</div>


<script>
let passengerIndex = 1;
let vehicleIndex = 1;

// ADD PASSENGER
document.getElementById('addPassengerBtn').addEventListener('click', function () {
    const wrapper = document.getElementById('passengerWrapper');

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2 passenger-item">
            <div class="col-md-5">
                <input type="text" name="passengers[${passengerIndex}][name]"
                    class="form-control" placeholder="Nama Lengkap Penumpang" required>
            </div>
            <div class="col-md-4">
                <select name="passengers[${passengerIndex}][category]"
                    class="form-select" required>
                    <option value="">Kategori Penumpang</option>
                    <option value="dewasa">Dewasa</option>
                    <option value="anak">Anak-anak</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-outline-danger remove-passenger">
                    <i class="bx bx-x"></i>
                </button>
            </div>
        </div>
    `);

    passengerIndex++;
});

// ADD VEHICLE
document.getElementById('addVehicleBtn').addEventListener('click', function () {
    const wrapper = document.getElementById('vehicleWrapper');

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2 vehicle-item">
            <div class="col-md-3">
                <input type="text" name="vehicles[${vehicleIndex}][plate]"
                    class="form-control" placeholder="No Plat Kendaraan">
            </div>
            <div class="col-md-4">
                <select name="vehicles[${vehicleIndex}][vehicle_name]" class="form-select">
                    <option value="">Jenis Kendaraan</option>
                    <option value="Motor">Motor</option>
                    <option value="Mobil">Mobil</option>
                    <option value="Minibus">Minibus</option>
                    <option value="Bus">Bus</option>
                    <option value="Pickup">Pickup</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="vehicles[${vehicleIndex}][type]" class="form-select">
                    <option value="">Kategori Roda</option>
                    <option value="roda_2">Roda 2</option>
                    <option value="roda_4">Roda 4</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-outline-danger remove-vehicle">
                    <i class="bx bx-x"></i>
                </button>
            </div>
        </div>
    `);

    vehicleIndex++;
});

// REMOVE ITEM
document.addEventListener('click', function (e) {
    if (e.target.closest('.remove-passenger')) {
        const items = document.querySelectorAll('.passenger-item');
        if (items.length > 1) e.target.closest('.passenger-item').remove();
    }

    if (e.target.closest('.remove-vehicle')) {
        const items = document.querySelectorAll('.vehicle-item');
        if (items.length > 1) e.target.closest('.vehicle-item').remove();
    }
});
</script>



@endsection