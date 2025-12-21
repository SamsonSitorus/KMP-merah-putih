@extends('layouts.app')

@section('content')
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  
  // Preview image upload
  const imageUpload = document.getElementById('imageUpload');
  const avatarPreview = document.getElementById('uploadedAvatarPreview');
  const uploadProgress = document.getElementById('uploadProgress');
  const progressBar = document.getElementById('progressBar');
  const progressPercentage = document.getElementById('progressPercentage');
  
  if (imageUpload) {
    imageUpload.addEventListener('change', function(e) {
      const file = e.target.files[0];
      
      if (file) {
        // Validasi file
        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const maxSize = 800 * 1024; // 800KB
        
        if (!validTypes.includes(file.type)) {
          showToast('error', 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
          return;
        }
        
        if (file.size > maxSize) {
          showToast('error', 'Ukuran file terlalu besar. Maksimal 800KB.');
          return;
        }
        
        // Show progress bar
        uploadProgress.classList.remove('d-none');
        
        // Simulate upload progress
        let progress = 0;
        const progressInterval = setInterval(() => {
          progress += 10;
          progressBar.style.width = `${progress}%`;
          progressPercentage.textContent = `${progress}%`;
          
          if (progress >= 100) {
            clearInterval(progressInterval);
            
            // Preview image
            const reader = new FileReader();
            reader.onload = function(event) {
              avatarPreview.src = event.target.result;
              
              // Hide progress bar after 500ms
              setTimeout(() => {
                uploadProgress.classList.add('d-none');
                progressBar.style.width = '0%';
                progressPercentage.textContent = '0%';
                showToast('success', 'Foto berhasil diunggah!');
              }, 500);
            };
            reader.readAsDataURL(file);
          }
        }, 100);
      }
    });
  }
  
  // Phone number formatting
  const phoneInput = document.getElementById('phone_number');
  if (phoneInput) {
    phoneInput.addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      
      // Format to Indonesian phone number
      if (value.length > 0) {
        if (value.startsWith('0')) {
          value = value.replace(/^0+/, '0');
        } else if (!value.startsWith('0') && value.length <= 15) {
          value = '0' + value;
        }
      }
      
      e.target.value = value.substring(0, 13); // Limit to 13 digits
    });
  }
  
  // Zip code validation
  const zipCodeInput = document.getElementById('ZipCode');
  if (zipCodeInput) {
    zipCodeInput.addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      e.target.value = value.substring(0, 6); // Limit to 6 digits
    });
  }
  
  // Form submission handler
  const profileForm = document.getElementById('profileForm');
  const submitBtn = document.getElementById('submitBtn');
  
  if (profileForm && submitBtn) {
    profileForm.addEventListener('submit', function(e) {
      // Validate form
      const requiredFields = profileForm.querySelectorAll('[required]');
      let isValid = true;
      
      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          field.classList.add('is-invalid');
          isValid = false;
        } else {
          field.classList.remove('is-invalid');
        }
      });
      
      if (!isValid) {
        e.preventDefault();
        showToast('error', 'Harap lengkapi semua field yang wajib diisi!');
        return;
      }
      
      // Show loading state
      const originalText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2"></span>
        Menyimpan...
      `;
      
      // Re-enable after 10 seconds if something goes wrong
      setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
      }, 10000);
    });
  }
  
  // Real-time validation
  const formInputs = document.querySelectorAll('#profileForm input, #profileForm select');
  formInputs.forEach(input => {
    input.addEventListener('input', function() {
      if (this.value.trim()) {
        this.classList.remove('is-invalid');
      }
    });
    
    input.addEventListener('change', function() {
      if (this.value.trim()) {
        this.classList.remove('is-invalid');
      }
    });
  });
  
  // Toast notification function
  function showToast(type, message) {
    const toastContainer = document.createElement('div');
    toastContainer.className = `toast-container position-fixed bottom-0 end-0 p-3`;
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">
          <i class="bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'} me-2"></i>
          ${message}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    `;
    
    toastContainer.appendChild(toast);
    document.body.appendChild(toastContainer);
    
    const bsToast = new bootstrap.Toast(toast, {
      autohide: true,
      delay: 3000
    });
    
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
      toastContainer.remove();
    });
  }
  
  // Auto-format date input
  const dateInput = document.getElementById('tanggal_lahir');
  if (dateInput && !dateInput.value) {
    // Set max date to today
    const today = new Date().toISOString().split('T')[0];
    dateInput.max = today;
    
    // Set default value to 18 years ago
    const defaultDate = new Date();
    defaultDate.setFullYear(defaultDate.getFullYear() - 18);
    if (!dateInput.value) {
      dateInput.value = defaultDate.toISOString().split('T')[0];
    }
  }
});
</script>
@endpush

@push('styles')
<style>
.bg-gradient-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.avatar-upload {
  position: relative;
  max-width: 120px;
}

.avatar-preview {
  width: 120px;
  height: 120px;
}

.avatar-edit {
  transform: translate(25%, 25%);
}

.avatar-edit label {
  width: 34px;
  height: 34px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.card {
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.form-label {
  font-weight: 500;
  color: #495057;
  margin-bottom: 0.5rem;
}

.input-group-text {
  background-color: #f8f9fa;
  border-color: #dee2e6;
}

.form-control:focus, .form-select:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
}

.btn-primary:hover {
  background: linear-gradient(135deg, #5a6fd8 0%, #6a4290 100%);
  transform: translateY(-1px);
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.toast-container {
  z-index: 9999;
}

.progress-bar {
  transition: width 0.3s ease;
}

.page-header {
  padding: 1.5rem 0;
  border-bottom: 1px solid #e9ecef;
}

@media (max-width: 768px) {
  .profile-header {
    padding: 2rem 1rem !important;
  }
  
  .card-body {
    padding: 1rem !important;
  }
  
  .d-flex.justify-content-between {
    flex-direction: column;
    gap: 1rem;
  }
  
  .d-flex.gap-2 {
    width: 100%;
  }
  
  .d-flex.gap-2 button {
    flex: 1;
  }
}
</style>
@endpush