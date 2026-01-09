@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ asset('assets/ss/profile.css') }}">
<body class="bg-light">
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <div class="container-fluid p-0"> 
        <!-- Main Card -->
        <div class="card shadow-sm border-0 overflow-hidden">
          <div class="card-body p-0">

            <!-- Profile Form -->
            <div class="p-5">
              <form action="{{ route('profile.update', $user->id) }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                    id="profileForm">
                @csrf
                @method('PUT')

                <!-- Progress Bar (hidden by default) -->
                <div class="mb-4 d-none" id="uploadProgress">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">Mengunggah foto...</span>
                    <span class="text-muted small" id="progressPercentage">0%</span>
                  </div>
                  <div class="progress" style="height: 6px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                         role="progressbar" 
                         style="width: 0%"
                         id="progressBar"></div>
                  </div>
                </div>

                <!-- Notification Messages -->
                @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bx bx-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
                @if(session('warning'))
                  <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                       <i class="bx bx-check-circle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    Terjadi kesalahan. Silakan periksa formulir di bawah.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                <!-- Form Sections -->
                <div class="row g-4">
                  
                  <!-- Section 1: Informasi Pribadi -->
                  <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                      <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="mb-0">
                          <i class="bx bx-user-circle me-2"></i>Informasi Pribadi
                        </h5>
                      </div>
                      <div class="card-body">
                        
                        <!-- Nama -->
                        <div class="mb-3">
                          <label for="name" class="form-label">
                            <i class="bx bx-user me-1"></i>Nama Lengkap
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                              <i class="bx bx-edit"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control @error('name') is-invalid @enderror"
                              id="name"
                              name="name"
                              value="{{ old('name', $user->name) }}"
                              placeholder="Masukkan nama lengkap"
                              required
                            >
                          </div>
                          @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                          <label for="email" class="form-label">
                            <i class="bx bx-envelope me-1"></i>Alamat Email
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                              <i class="bx bx-at"></i>
                            </span>
                            <input
                              type="email"
                              class="form-control @error('email') is-invalid @enderror"
                              id="email"
                              name="email"
                              value="{{ old('email', $user->email) }}"
                              placeholder="nama@contoh.com"
                              required
                            >
                          </div>
                          @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="mb-3">
                          <label for="phone_number" class="form-label">
                            <i class="bx bx-phone me-1"></i>Nomor Telepon
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                              <i class="bx bx-mobile-alt"></i>
                            </span>
                            <input
                              type="tel"
                              id="phone_number"
                              name="phone_number"
                              class="form-control @error('phone_number') is-invalid @enderror"
                              value="{{ old('phone_number', $user->phone_number) }}"
                              placeholder="08xxxxxxxxxx"
                              required
                            >
                          </div>
                          @error('phone_number')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                          <label for="tanggal_lahir" class="form-label">
                            <i class="bx bx-calendar me-1"></i>Tanggal Lahir
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                              <i class="bx bx-cake"></i>
                            </span>
                            <input
                              type="date"
                              id="tanggal_lahir"
                              name="tanggal_lahir"
                              class="form-control @error('tanggal_lahir') is-invalid @enderror"
                              value="{{ old('tanggal_lahir', $detail->tanggal_lahir ?? '') }}"
                              required
                            >
                          </div>
                          @error('tanggal_lahir')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                      </div>
                    </div>
                  </div>

                  <!-- Section 2: Detail Tambahan -->
                  <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                      <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="mb-0">
                          <i class="bx bx-id-card me-2"></i>Detail Tambahan
                        </h5>
                      </div>
                      <div class="card-body">

                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                          <label for="gender" class="form-label">
                            <i class="bx bx-male-female me-1"></i>Jenis Kelamin
                            <span class="text-danger">*</span>
                          </label>
                          <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ (old('gender', $detail->gender ?? '') == 'Laki-laki') ? 'selected' : '' }}>
                              Laki-laki
                            </option>
                            <option value="Perempuan" {{ (old('gender', $detail->gender ?? '') == 'Perempuan') ? 'selected' : '' }}>
                              Perempuan
                            </option>
                          </select>
                          @error('gender')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                        <!-- Jenis Identitas -->
                        <div class="mb-3">
                          <label for="jenis_id" class="form-label">
                            <i class="bx bx-card me-1"></i>Jenis Identitas
                            <span class="text-danger">*</span>
                          </label>
                          <select id="jenis_id" name="jenis_id" class="form-select @error('jenis_id') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Identitas</option>
                            <option value="KTP" {{ (old('jenis_id', $detail->jenis_id ?? '') == 'KTP') ? 'selected' : '' }}>KTP</option>
                            <option value="SIM" {{ (old('jenis_id', $detail->jenis_id ?? '') == 'SIM') ? 'selected' : '' }}>SIM</option>
                            <option value="Paspor" {{ (old('jenis_id', $detail->jenis_id ?? '') == 'Paspor') ? 'selected' : '' }}>Paspor</option>
                          </select>
                          @error('jenis_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                        <!-- Nomor Identitas -->
                        <div class="mb-3">
                          <label for="nomor_identitas" class="form-label">
                            <i class="bx bx-barcode me-1"></i>Nomor Identitas
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                              <i class="bx bx-hash"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control @error('nomor_identitas') is-invalid @enderror"
                              id="nomor_identitas"
                              name="nomor_identitas"
                              placeholder="Nomor identitas"
                              value="{{ old('nomor_identitas', $detail->nomor_identitas ?? '') }}"
                              required
                            >
                          </div>
                          @error('nomor_identitas')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                        <!-- Kota Asal -->
                        <div class="mb-3">
                          <label for="kota_asal" class="form-label">
                            <i class="bx bx-buildings me-1"></i>Kota Asal
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                              <i class="bx bx-map"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control @error('kota_asal') is-invalid @enderror"
                              id="kota_asal"
                              name="kota_asal"
                              placeholder="Kota asal"
                              value="{{ old('kota_asal', $detail->kota_asal ?? '') }}"
                              required
                            >
                          </div>
                          @error('kota_asal')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                        <!-- Kode Pos -->
                        <div class="mb-3">
                          <label for="ZipCode" class="form-label">
                            <i class="bx bx-map-pin me-1"></i>Kode Pos
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                              <i class="bx bx-navigation"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control @error('ZipCode') is-invalid @enderror"
                              id="ZipCode"
                              name="ZipCode"
                              placeholder="123456"
                              value="{{ old('ZipCode', $detail->ZipCode ?? '') }}"
                              maxlength="6"
                              pattern="[0-9]{5,6}"
                              required
                            >
                          </div>
                          @error('ZipCode')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                          <small class="text-muted">Masukkan 5-6 digit kode pos</small>
                        </div>

                      </div>
                    </div>
                  </div>

                </div>

                <!-- Form Actions -->
                <div class="row mt-4">
                  <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center p-4 bg-light rounded-3">
                      <div>
                        <p class="mb-0 small text-muted">
                          <i class="bx bx-info-circle me-1"></i>
                          Pastikan semua informasi yang Anda berikan benar dan valid
                        </p>
                      </div>
                      <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-secondary px-4">
                          <i class="bx bx-reset me-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                          <i class="bx bx-save me-2"></i>Simpan Perubahan
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
</body>
<script src="{{ asset('assets/js/profile.js') }}"></script>
@endsection

