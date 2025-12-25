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
              {{-- <!-- /Logo -->
              <h4 class="mb-1">Petualangan dimulai di sini 🚀</h4> --}}

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
                  <label for="password" class="form-label">Kata Sandi</label>
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
                  
                  {{-- Password Strength Indicator --}}
                  <div class="mt-2" id="passwordStrengthContainer" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <small class="text-muted">Kekuatan password:</small>
                      <small id="passwordStrengthText" class="fw-medium"></small>
                    </div>
                    <div class="progress" style="height: 5px;">
                      <div id="passwordStrengthBar" 
                           class="progress-bar" 
                           role="progressbar" 
                           style="width: 0%; transition: width 0.3s;">
                      </div>
                    </div>
                    <div id="passwordCriteria" class="mt-2">
                      <small class="d-block">
                        <i id="criteriaLength" class="bx bx-x text-danger me-1"></i>
                        Minimal 8 karakter
                      </small>
                      <small class="d-block">
                        <i id="criteriaLowercase" class="bx bx-x text-danger me-1"></i>
                        Minimal 1 huruf kecil
                      </small>
                      <small class="d-block">
                        <i id="criteriaUppercase" class="bx bx-x text-danger me-1"></i>
                        Minimal 1 huruf besar
                      </small>
                      <small class="d-block">
                        <i id="criteriaNumber" class="bx bx-x text-danger me-1"></i>
                        Minimal 1 angka
                      </small>
                      <small class="d-block">
                        <i id="criteriaSpecial" class="bx bx-x text-danger me-1"></i>
                        Minimal 1 karakter khusus (@$!%*?&)
                      </small>
                    </div>
                  </div>
                  
                  @error('password') 
                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                  @enderror
                  <small class="text-muted">Password harus mengandung kombinasi huruf besar, huruf kecil, angka, dan karakter khusus</small>
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
                  <div id="passwordMatch" class="mt-1" style="display: none;">
                    <small>
                      <i class="bx bx-check text-success"></i>
                      <span>Password cocok</span>
                    </small>
                  </div>
                  <div id="passwordMismatch" class="mt-1" style="display: none;">
                    <small class="text-danger">
                      <i class="bx bx-x"></i>
                      <span>Password tidak cocok</span>
                    </small>
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
              <button id="registerBtn" class="btn btn-primary w-100" type="submit" disabled>
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

        // Password validation and strength checking
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordStrengthContainer = document.getElementById('passwordStrengthContainer');
        const passwordStrengthBar = document.getElementById('passwordStrengthBar');
        const passwordStrengthText = document.getElementById('passwordStrengthText');
        const registerBtn = document.getElementById('registerBtn');

        // Check password strength and combination
        function checkPasswordStrength(password) {
          const criteria = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[@$!%*?&]/.test(password)
          };

          let score = 0;
          let totalCriteria = Object.keys(criteria).length;
          
          Object.values(criteria).forEach(met => {
            if (met) score++;
          });

          // Update criteria icons
          updateCriteriaIcons(criteria);

          // Calculate percentage
          let percentage = (score / totalCriteria) * 100;

          // Determine strength level
          let strengthLevel = '';
          let barColor = '';
          
          if (score === 0) {
            strengthLevel = 'Sangat Lemah';
            barColor = '#dc3545'; // Red
          } else if (score <= 2) {
            strengthLevel = 'Lemah';
            barColor = '#ffc107'; // Yellow
          } else if (score <= 3) {
            strengthLevel = 'Cukup';
            barColor = '#17a2b8'; // Teal
          } else if (score <= 4) {
            strengthLevel = 'Kuat';
            barColor = '#28a745'; // Green
          } else {
            strengthLevel = 'Sangat Kuat';
            barColor = '#007bff'; // Blue
          }

          // Update UI
          if (password.length > 0) {
            passwordStrengthContainer.style.display = 'block';
            passwordStrengthBar.style.width = percentage + '%';
            passwordStrengthBar.style.backgroundColor = barColor;
            passwordStrengthText.textContent = strengthLevel;
            passwordStrengthText.className = 'fw-medium';
            
            // Set text color based on strength
            if (score <= 1) {
              passwordStrengthText.classList.add('text-danger');
              passwordStrengthText.classList.remove('text-warning', 'text-info', 'text-success', 'text-primary');
            } else if (score <= 2) {
              passwordStrengthText.classList.add('text-warning');
              passwordStrengthText.classList.remove('text-danger', 'text-info', 'text-success', 'text-primary');
            } else if (score <= 3) {
              passwordStrengthText.classList.add('text-info');
              passwordStrengthText.classList.remove('text-danger', 'text-warning', 'text-success', 'text-primary');
            } else if (score <= 4) {
              passwordStrengthText.classList.add('text-success');
              passwordStrengthText.classList.remove('text-danger', 'text-warning', 'text-info', 'text-primary');
            } else {
              passwordStrengthText.classList.add('text-primary');
              passwordStrengthText.classList.remove('text-danger', 'text-warning', 'text-info', 'text-success');
            }
          } else {
            passwordStrengthContainer.style.display = 'none';
          }

          return {
            score: score,
            criteria: criteria,
            isValid: score >= 3 && criteria.length && criteria.lowercase && criteria.uppercase && criteria.number && criteria.special
          };
        }

        // Update criteria icons based on validation
        function updateCriteriaIcons(criteria) {
          const icons = {
            length: document.getElementById('criteriaLength'),
            lowercase: document.getElementById('criteriaLowercase'),
            uppercase: document.getElementById('criteriaUppercase'),
            number: document.getElementById('criteriaNumber'),
            special: document.getElementById('criteriaSpecial')
          };

          for (const [key, icon] of Object.entries(icons)) {
            if (criteria[key]) {
              icon.classList.remove('bx-x', 'text-danger');
              icon.classList.add('bx-check', 'text-success');
            } else {
              icon.classList.remove('bx-check', 'text-success');
              icon.classList.add('bx-x', 'text-danger');
            }
          }
        }

        // Check password match
        function checkPasswordMatch() {
          const password = passwordInput.value;
          const confirmPassword = confirmPasswordInput.value;
          const matchDiv = document.getElementById('passwordMatch');
          const mismatchDiv = document.getElementById('passwordMismatch');

          if (confirmPassword.length === 0) {
            matchDiv.style.display = 'none';
            mismatchDiv.style.display = 'none';
            return false;
          }

          if (password === confirmPassword) {
            matchDiv.style.display = 'block';
            mismatchDiv.style.display = 'none';
            return true;
          } else {
            matchDiv.style.display = 'none';
            mismatchDiv.style.display = 'block';
            return false;
          }
        }

        // Validate form before enabling submit button
        function validateForm() {
          const password = passwordInput.value;
          const confirmPassword = confirmPasswordInput.value;
          const termsChecked = document.getElementById('terms').checked;
          
          const passwordStrength = checkPasswordStrength(password);
          const passwordsMatch = checkPasswordMatch();
          
          const isValidPassword = passwordStrength.isValid;
          const isValidForm = isValidPassword && passwordsMatch && termsChecked;
          
          // Enable/disable submit button
          registerBtn.disabled = !isValidForm;
          
          // Add/remove visual feedback
          if (!isValidPassword && password.length > 0) {
            passwordInput.classList.add('is-invalid');
            passwordInput.classList.remove('is-valid');
          } else if (isValidPassword) {
            passwordInput.classList.add('is-valid');
            passwordInput.classList.remove('is-invalid');
          } else {
            passwordInput.classList.remove('is-invalid', 'is-valid');
          }
          
          if (!passwordsMatch && confirmPassword.length > 0) {
            confirmPasswordInput.classList.add('is-invalid');
            confirmPasswordInput.classList.remove('is-valid');
          } else if (passwordsMatch && confirmPassword.length > 0) {
            confirmPasswordInput.classList.add('is-valid');
            confirmPasswordInput.classList.remove('is-invalid');
          } else {
            confirmPasswordInput.classList.remove('is-invalid', 'is-valid');
          }
          
          return isValidForm;
        }

        // Event listeners for password validation
        passwordInput.addEventListener('input', function() {
          checkPasswordStrength(this.value);
          checkPasswordMatch();
          validateForm();
        });

        confirmPasswordInput.addEventListener('input', function() {
          checkPasswordMatch();
          validateForm();
        });

        document.getElementById('terms').addEventListener('change', function() {
          validateForm();
        });

        // Initial form validation
        validateForm();

        // Form submission handler
        document.getElementById('formAuthentication').addEventListener('submit', function(e) {
          const password = passwordInput.value;
          const confirmPassword = confirmPasswordInput.value;
          const termsCheckbox = document.getElementById('terms');
          const termsError = document.getElementById('termsError');
          
          // Validate password strength
          const passwordStrength = checkPasswordStrength(password);
          if (!passwordStrength.isValid) {
            e.preventDefault();
            
            // Show error message
            const errorMessage = 'Password harus mengandung minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&)';
            
            // Create or update error display
            let existingError = passwordInput.parentElement.querySelector('.password-error');
            if (!existingError) {
              existingError = document.createElement('div');
              existingError.className = 'invalid-feedback password-error d-block';
              passwordInput.parentElement.appendChild(existingError);
            }
            existingError.textContent = errorMessage;
            passwordInput.classList.add('is-invalid');
            
            // Scroll to error
            passwordInput.scrollIntoView({ 
              behavior: 'smooth', 
              block: 'center' 
            });
            
            // Focus on password input
            passwordInput.focus();
            
            return false;
          }
          
          // Validate password match
          if (password !== confirmPassword) {
            e.preventDefault();
            
            confirmPasswordInput.classList.add('is-invalid');
            confirmPasswordInput.scrollIntoView({ 
              behavior: 'smooth', 
              block: 'center' 
            });
            confirmPasswordInput.focus();
            
            return false;
          }
          
          // Validate terms
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
      });

      // Clear saved data when navigating away
      window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.navigation.type === 2) {
          localStorage.removeItem('registerFormData');
        }
      });
    </script>
    
    <style>
      .progress {
        background-color: #e9ecef;
        border-radius: 0.375rem;
        overflow: hidden;
      }
      
      .progress-bar {
        border-radius: 0.375rem;
      }
      
      #passwordCriteria small {
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
      }
      
      #passwordCriteria i {
        font-size: 0.9rem;
      }
      
      .is-valid {
        border-color: #28a745 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
      }
      
      .is-invalid {
        border-color: #dc3545 !important;
      }
    </style>
    @endpush