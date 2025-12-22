@extends('layouts.auth')

@section('content')

 <!-- Content -->
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card px-sm-6 px-0">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-6">
                <a href="index.html" class="app-brand-link gap-2">
                  <img src="{{ asset('assets/img/cruise.png') }}" alt="Seaventures" 
                  class="d-inline-block align-text-top" style="height:50px;">
                  <span class="app-brand-text demo text-heading fw-bold">KMP Muara Putih</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">Adventure starts here 🚀</h4>

             <form id="formAuthentication"
                method="POST"
                action="{{ route('verify.register') }}"
                class="mb-6">
              @csrf

              {{-- Nama --}}
              <div class="mb-3">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input 
                    type="text" 
                    id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name" 
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap Anda"
                    autocomplete="name"
                    autofocus
                  >
                  @error('name') 
                    <div class="invalid-feedback">{{ $message }}</div> 
                  @enderror
              </div>

              {{-- Nomor Telepon --}}
              <div class="mb-3">
                  <label for="phone_number" class="form-label">Nomor Telepon</label>
                  <input 
                    type="tel" 
                    id="phone_number"
                    class="form-control @error('phone_number') is-invalid @enderror"
                    name="phone_number" 
                    value="{{ old('phone_number') }}"
                    placeholder="Contoh: 081234567890"
                    autocomplete="tel"
                  >
                  @error('phone_number') 
                    <div class="invalid-feedback">{{ $message }}</div> 
                  @enderror
              </div>

              {{-- Email --}}
              <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input 
                    type="email" 
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="nama@contoh.com"
                    autocomplete="email"
                  >
                  @error('email') 
                    <div class="invalid-feedback">{{ $message }}</div> 
                  @enderror
              </div>

              {{-- Password --}}
              <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group">
                    <input 
                      type="password" 
                      id="password"
                      class="form-control @error('password') is-invalid @enderror"
                      name="password"
                      placeholder="Minimal 8 karakter"
                      autocomplete="new-password"
                    >
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                      <i class="bx bx-hide"></i>
                    </button>
                  </div>
                  @error('password') 
                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                  @enderror
                  <small class="text-muted">Minimal 8 karakter dengan kombinasi huruf dan angka</small>
              </div>

              {{-- Confirm Password --}}
              <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                  <div class="input-group">
                    <input 
                      type="password" 
                      id="password_confirmation"
                      class="form-control"
                      name="password_confirmation"
                      placeholder="Ketik ulang password Anda"
                      autocomplete="new-password"
                    >
                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                      <i class="bx bx-hide"></i>
                    </button>
                  </div>
              </div>

              {{-- Terms --}}
              <div class="mb-3">
                  <div class="form-check">
                      <input 
                        class="form-check-input @error('terms') is-invalid @enderror" 
                        type="checkbox" 
                        name="terms" 
                        id="terms"
                        {{ old('terms') ? 'checked' : '' }}
                      >
                      <label class="form-check-label" for="terms">
                          Saya setuju dengan <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">kebijakan privasi & syarat layanan</a>
                      </label>
                      @error('terms') 
                        <div class="invalid-feedback d-block">{{ $message }}</div> 
                      @enderror
                  </div>
                  <!-- Error message untuk client-side validation -->
                  <div id="termsError" class="text-danger mt-1" style="display: none;">
                      Anda harus menyetujui syarat dan ketentuan terlebih dahulu
                  </div>
              </div>

              {{-- Button --}}
              <button id="registerBtn" class="btn btn-primary w-100" type="submit">
                  <span id="btnText">Daftar Sekarang</span>
                  <span id="btnLoading" class="d-none">
                      <span class="spinner-border spinner-border-sm me-2"></span>
                      Memproses...
                  </span>
              </button>
          </form>

              <p class="text-center mb-0">
                <span>Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="ms-1">
                  <span>Masuk di sini</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- Modal for Terms -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Syarat dan Ketentuan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Dengan mendaftar, Anda menyetujui:</p>
            <ol>
              <li>Data yang Anda berikan adalah benar dan akurat</li>
              <li>Anda bertanggung jawab atas kerahasiaan akun Anda</li>
              <li>Kami akan melindungi data pribadi Anda sesuai kebijakan privasi</li>
              <li>Layanan ini tunduk pada peraturan yang berlaku</li>
            </ol>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="acceptTerms">
              Saya Setuju
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Toast Notification -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div id="termsToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bx bx-error-circle me-2"></i>
                    Anda harus menyetujui syarat dan ketentuan terlebih dahulu
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- / Content -->

    @push('scripts')
    <script>
      // Pastikan DOM sudah dimuat sepenuhnya
      document.addEventListener('DOMContentLoaded', function() {
        
        // Initialize Bootstrap Toast
        const termsToast = new bootstrap.Toast(document.getElementById('termsToast'), {
          animation: true,
          autohide: true,
          delay: 5000
        });

        // Toggle password visibility function
        function setupPasswordToggle(buttonId, inputId) {
          const toggleBtn = document.getElementById(buttonId);
          const input = document.getElementById(inputId);
          
          if (!toggleBtn || !input) return;
          
          toggleBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (input.type === 'password') {
              input.type = 'text';
              icon.classList.remove('bx-hide');
              icon.classList.add('bx-show');
              this.setAttribute('aria-label', 'Sembunyikan password');
            } else {
              input.type = 'password';
              icon.classList.remove('bx-show');
              icon.classList.add('bx-hide');
              this.setAttribute('aria-label', 'Tampilkan password');
            }
            // Fokus kembali ke input setelah toggle
            input.focus();
          });
        }

        // Setup password toggles
        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');

        // Handle accept terms button in modal
        document.getElementById('acceptTerms')?.addEventListener('click', function() {
          document.getElementById('terms').checked = true;
          document.getElementById('termsError').style.display = 'none';
        });

        // Form submission handler
        document.getElementById('formAuthentication').addEventListener('submit', function(e) {
          const termsCheckbox = document.getElementById('terms');
          const termsError = document.getElementById('termsError');
          
          if (!termsCheckbox.checked) {
            e.preventDefault();
            
            // Show error message
            termsError.style.display = 'block';
            termsCheckbox.classList.add('is-invalid');
            
            // Scroll to error
            termsCheckbox.scrollIntoView({ 
              behavior: 'smooth', 
              block: 'center' 
            });
            
            // Focus on checkbox
            termsCheckbox.focus();
            
            // Show toast notification
            termsToast.show();
            
            return false;
          }
          
          // Hide error if checkbox is checked
          termsError.style.display = 'none';
          termsCheckbox.classList.remove('is-invalid');
          
          // Show loading state
          const btn = document.getElementById('registerBtn');
          const btnText = document.getElementById('btnText');
          const btnLoading = document.getElementById('btnLoading');
          
          btnText.classList.add('d-none');
          btnLoading.classList.remove('d-none');
          btn.disabled = true;
          btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mendaftarkan...';
          
          // Re-enable button after 30 seconds if something goes wrong
          setTimeout(() => {
            btn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
            btn.innerHTML = '<span id="btnText">Daftar Sekarang</span>';
          }, 30000);
        });

        // Remove error when checkbox is checked
        document.getElementById('terms')?.addEventListener('change', function() {
          const termsError = document.getElementById('termsError');
          if (this.checked) {
            termsError.style.display = 'none';
            this.classList.remove('is-invalid');
          } else {
            termsError.style.display = 'block';
            this.classList.add('is-invalid');
          }
        });

        // Save form data to localStorage (excluding passwords)
        document.querySelectorAll('#formAuthentication input').forEach(input => {
          if (input.type !== 'password' && input.type !== 'checkbox') {
            input.addEventListener('input', debounce(function() {
              const formData = JSON.parse(localStorage.getItem('registerFormData') || '{}');
              formData[this.name] = this.value;
              localStorage.setItem('registerFormData', JSON.stringify(formData));
            }, 500));
          }
        });

        // Restore form data on page load
        const savedData = JSON.parse(localStorage.getItem('registerFormData') || '{}');
        Object.keys(savedData).forEach(key => {
          const input = document.querySelector(`[name="${key}"]`);
          if (input && input.type !== 'password' && input.type !== 'checkbox') {
            input.value = savedData[key];
          }
        });

        // Clear saved data when form is successfully submitted
        window.addEventListener('beforeunload', function() {
          // Check if form was submitted
          if (document.querySelector('#formAuthentication').classList.contains('submitted')) {
            localStorage.removeItem('registerFormData');
          }
        });

        // Mark form as submitted when submit button is clicked
        document.getElementById('registerBtn')?.addEventListener('click', function() {
          document.getElementById('formAuthentication').classList.add('submitted');
        });

        // Debounce function for performance
        function debounce(func, wait) {
          let timeout;
          return function executedFunction(...args) {
            const later = () => {
              clearTimeout(timeout);
              func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
          };
        }

        // Auto format phone number
        const phoneInput = document.getElementById('phone_number');
        if (phoneInput) {
          phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
              if (value.startsWith('0')) {
                value = value.replace(/^0+/, '0');
              } else if (!value.startsWith('0') && value.length <= 15) {
                value = '0' + value;
              }
            }
            e.target.value = value;
          });
        }

        // Password strength indicator (optional)
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
          passwordInput.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            updatePasswordStrengthIndicator(strength);
          });
        }

        function checkPasswordStrength(password) {
          let score = 0;
          if (password.length >= 8) score++;
          if (/[A-Z]/.test(password)) score++;
          if (/[0-9]/.test(password)) score++;
          if (/[^A-Za-z0-9]/.test(password)) score++;
          return score;
        }

        function updatePasswordStrengthIndicator(score) {
          // Optional: Add password strength indicator UI
          console.log('Password strength score:', score);
        }
      });

      // Clear saved data when navigating away
      window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.navigation.type === 2) {
          localStorage.removeItem('registerFormData');
        }
      });
    </script>
    @endpush
