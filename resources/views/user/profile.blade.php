@extends('layouts.app')

@section('content')
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <div class="card mb-6">
        <!-- Account -->
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
            <img
              src="../assets/img/avatars/1.png"
              alt="user-avatar"
              class="d-block w-px-100 h-px-100 rounded"
              id="uploadedAvatar"
            />
            <div class="button-wrapper">
              <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                <span class="d-none d-sm-block">Upload new photo</span>
                <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                <input
                  type="file"
                  id="upload"
                  class="account-file-input"
                  hidden
                  accept="image/png, image/jpeg"
                />
              </label>
              <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                <i class="icon-base bx bx-reset d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Reset</span>
              </button>
              <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
            </div>
          </div>
        </div>

        <!-- Form Section -->
        <div class="card-body pt-4">
          <form id="formAccountSettings" method="POST" onsubmit="return false">
            <div class="row g-6">
              
              <!-- Basic Info -->
              <div class="col-md-6">
                <label for="firstName" class="form-label">First Name</label>
                <input
                  class="form-control"
                  type="text"
                  id="firstName"
                  name="firstName"
                  value="{{ $user->name }}"
                  autofocus
                />
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input
                  class="form-control"
                  type="text"
                  id="email"
                  name="email"
                  value="{{ $user->email }}"
                  placeholder="john.doe@example.com"
                />
              </div>

            <div class="col-md-6">
                <label for="Jenis Kelamin" class="form-label">Jenis Kelamin</label>
                <select id="Jenis Kelamin" class="select2 form-select">
                  <option value="">Select Jenis Kelamin</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label" for="phoneNumber">Phone Number</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text">Indo(+62)</span>
                  <input
                    type="text"
                    id="phoneNumber"
                    name="phoneNumber"
                    class="form-control"
                    value="{{ $user->phone_number }}">
                </div>
              </div>

                <div class="col-md-6">
                <label for="Jenis Identitas" class="form-label">Jenis Identitas</label>
                <select id="Jenis Identitas" class="select2 form-select">
                  <option value="">Select Jenis Identitas</option>
                  <option value="KTP">KTP</option>
                  <option value="SIM">SIM</option>
                  <option value="Paspor">Paspor</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="nomor_identitas" class="form-label">nomor_identitas</label>
                <input
                  type="text"
                  class="form-control"
                  id="nomor_identitas"
                  name="nomor_identitas"
                  placeholder="nomor_identitas"
                  {{-- value="{{ $detail->nomor_identitas }}" --}}
                />
              </div>

              <div class="col-md-6">
                <label for="kota_asal" class="form-label">kota_asal</label>
                <input
                  class="form-control"
                  type="text"
                  id="kota_asal"
                  name="kota_asal"
                  placeholder="California"
                />
              </div>

              <div class="col-md-6">
                <label for="zipCode" class="form-label">Zip Code</label>
                <input
                  type="text"
                  class="form-control"
                  id="zipCode"
                  name="zipCode"
                  placeholder="231465"
                  maxlength="6"
                />
              </div>

            <!-- Buttons -->
            <div class="mt-6">
              <button type="submit" class="btn btn-primary me-3">Save changes</button>
              <button type="reset" class="btn btn-outline-secondary">Cancel</button>
            </div>
          </form>
        </div>
        <!-- /Account -->
      </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- /Layout wrapper -->
</body>
@endsection
