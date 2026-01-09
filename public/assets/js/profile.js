  const uploadInput = document.getElementById('upload');
  const uploadedAvatar = document.getElementById('uploadedAvatarForm');
  const resetButton = document.querySelector('.account-image-reset');
  const defaultAvatar = "{{ asset('assets/img/avatars/1.png') }}";

  uploadInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
      // Validasi ukuran file
      if (file.size > 800 * 1024) { // 800 KB
        alert("Ukuran file maksimal 800 KB");
        uploadInput.value = ""; // reset input
        return;
      }

      const reader = new FileReader();
      reader.onload = (e) => {
        uploadedAvatarForm.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  // Preview foto setelah upload
  document.getElementById('upload').addEventListener('change', function (event) {
    const [file] = event.target.files;
    if (file) {
      document.getElementById('uploadedAvatarForm').src = URL.createObjectURL(file);
    }
  });

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

