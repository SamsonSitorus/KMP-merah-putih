@extends('layouts.app')

@section('content')
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <!-- Card Profil -->
      <div class="card mb-6">
        <div class="card-body">
          <form action="{{ route('profile.update', $user->id) }}" 
                method="POST" 
                enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Foto Profil -->
            <div class="d-flex align-items-center gap-4 pb-4 border-bottom">
              <div class="position-relative">
                <img 
                  src="{{ optional($detail)->foto_profil 
                          ? asset('storage/' . optional($detail)->foto_profil) 
                          : asset('assets/img/avatars/1.png') }}"
                  alt="Foto Profil"
                  class="rounded-circle border border-2"
                  id="uploadedAvatarForm"
                  style="width: 100px; height: 100px; object-fit: cover; border-color: #0d6efd;"
                >
              </div>

              <div class="button-wrapper">
                <label for="upload" class="btn btn-primary mb-2" tabindex="0">
                  <i class="bx bx-upload me-2"></i>
                  <span>Upload Foto Baru</span>
                  <input
                    type="file"
                    id="upload"
                    name="foto_profil"
                    class="account-file-input"
                    hidden
                    accept="image/png, image/jpeg, image/gif"
                  />
                </label>

                <div class="text-muted small">
                  <i class="bx bx-info-circle me-1"></i>
                  Format yang diizinkan: JPG, PNG, GIF.<br>
                  Ukuran maksimum: 800 KB.
                </div>
              </div>
            </div>
            <!-- /Foto Profil -->

            <!-- Form Info -->
            <div class="row g-4 pt-4">

              <div class="col-md-6">
                <label for="name" class="form-label">Nama</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  name="name"
                  value="{{ $user->name }}"
                  autofocus
                >
              </div>

              <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  value="{{ $user->email }}"
                  placeholder="john.doe@example.com"
                >
              </div>

              <div class="col-md-6">
                <label class="form-label" for="phone_number">Nomor Telepon</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text">🇮🇩</span>
                  <input
                    type="text"
                    id="phone_number"
                    name="phone_number"
                    class="form-control"
                    value="{{ old('phone_number', $user->phone_number) }}"
                    required
                  >
                </div>
                @error('phone_number')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input
                  type="date"
                  id="tanggal_lahir"
                  name="tanggal_lahir"
                  class="form-control"
                  value="{{ old('tanggal_lahir', $detail->tanggal_lahir ?? '') }}"
                  required
                >
                @error('tanggal_lahir')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select id="gender" name="gender" class="select2 form-select" required>
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="Laki-laki" {{ (old('gender', $detail->gender ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                  <option value="Perempuan" {{ (old('gender', $detail->gender ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="jenis_id" class="form-label">Jenis Identitas</label>
                <select id="jenis_id" name="jenis_id" class="select2 form-select" required>
                  <option value="">Pilih Jenis Identitas</option>
                  <option value="KTP" {{ (old('jenis_id', $detail->jenis_id ?? '') == 'KTP') ? 'selected' : '' }}>KTP</option>
                  <option value="SIM" {{ (old('jenis_id', $detail->jenis_id ?? '') == 'SIM') ? 'selected' : '' }}>SIM</option>
                  <option value="Paspor" {{ (old('jenis_id', $detail->jenis_id ?? '') == 'Paspor') ? 'selected' : '' }}>Paspor</option>
                </select>
                @error('jenis_id')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
                <input
                  type="text"
                  class="form-control"
                  id="nomor_identitas"
                  name="nomor_identitas"
                  placeholder="Nomor Identitas"
                  value="{{ old('nomor_identitas', $detail->nomor_identitas ?? '') }}"
                  required
                >
                @error('nomor_identitas')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="kota_asal" class="form-label">Kota Asal</label>
                <input
                  type="text"
                  class="form-control"
                  id="kota_asal"
                  name="kota_asal"
                  placeholder="Kota Asal"
                  value="{{ old('kota_asal', $detail->kota_asal ?? '') }}"
                  required
                >
                @error('kota_asal')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="ZipCode" class="form-label">Kode Pos</label>
                <input
                  type="text"
                  class="form-control"
                  id="ZipCode"
                  name="ZipCode"
                  placeholder="231465"
                  value="{{ old('ZipCode', $detail->ZipCode ?? '') }}"
                  maxlength="6"
                  required
                >
                @error('ZipCode')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

            </div>
            <!-- /Form Info -->

            <!-- Tombol -->
            <div class="mt-4 pt-2 border-top">
              <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
              <button type="reset" class="btn btn-outline-secondary">Batal</button>
              @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
              @endif
              @if($errors->any())
                <div class="alert alert-danger mt-3">
                  <ul class="mb-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </div>

          </form>
        </div>
      </div>
      <!-- /Card Profil -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
</body>
@endsection

@push('scripts')
<script type="module" src="{{ asset('assets/js/profile.js') }}"></script>
@endpush
