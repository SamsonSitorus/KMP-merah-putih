<footer class="footer bg-white mt-auto" style="border-top: 2px solid #e8f0f7;">
  <div class="container-fluid px-0">
    <!-- Main Footer Content -->
    <div class="footer-main py-5">
      <div class="container">
        <div class="row g-4">
          <!-- Brand & Description -->
          <div class="col-lg-4 col-md-6">
            <div class="footer-brand mb-4">
              <div class="d-flex align-items-center gap-2 mb-3">
                <img src="{{ asset('assets/img/cruise.png') }}" alt="KMP Muara Putih" 
                     class="img-fluid" style="height: 50px;">
                <h4 class="fw-bold mb-0" style="color: #0066cc;">KMP Muara Putih</h4>
              </div>
              <p class="text-secondary mb-4" style="line-height: 1.6;">
                Penyelenggara transportasi laut terpercaya yang menghubungkan berbagai destinasi dengan layanan berkualitas, 
                kenyamanan, dan keamanan terbaik bagi penumpang.
              </p>
              <div class="d-flex align-items-center gap-3">
                <div class="feature-item d-flex align-items-center gap-2">
                  <i class="bx bx-shield-check text-primary"></i>
                  <span class="small text-muted">Terpercaya</span>
                </div>
                <div class="feature-item d-flex align-items-center gap-2">
                  <i class="bx bx-time-five text-primary"></i>
                  <span class="small text-muted">Tepat Waktu</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="col-lg-2 col-md-6">
            <h5 class="footer-title mb-4 fw-semibold" style="color: #1a1a1a;">
              <i class="bx bx-link-external me-2"></i>Tautan Cepat
            </h5>
            <ul class="footer-links list-unstyled">
              <li class="mb-3">
                <a href="{{ route('home') }}" class="footer-link d-flex align-items-center gap-2">
                  <i class="bx bx-home-alt text-muted" style="width: 20px;"></i>
                  <span>Beranda</span>
                </a>
              </li>
              <li class="mb-3">
                <a href="{{ route('profile') }}" class="footer-link d-flex align-items-center gap-2">
                  <i class="bx bx-user text-muted" style="width: 20px;"></i>
                  <span>Profil</span>
                </a>
              </li>
              <li class="mb-3">
                <a href="#services" class="footer-link d-flex align-items-center gap-2">
                  <i class="bx bx-wrench text-muted" style="width: 20px;"></i>
                  <span>Layanan</span>
                </a>
              </li>
              <li class="mb-3">
                <a href="#schedules" class="footer-link d-flex align-items-center gap-2">
                  <i class="bx bx-calendar text-muted" style="width: 20px;"></i>
                  <span>Jadwal</span>
                </a>
              </li>
            </ul>
          </div>

          <!-- Kontak & Support -->
          <div class="col-lg-3 col-md-6">
            <h5 class="footer-title mb-4 fw-semibold" style="color: #1a1a1a;">
              <i class="bx bx-headphone me-2"></i>Kontak & Dukungan
            </h5>
            <ul class="footer-contact list-unstyled">
              <li class="mb-3">
                <div class="d-flex align-items-start gap-3">
                  <div class="contact-icon rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 40px; height: 40px; background: rgba(0, 102, 204, 0.1);">
                    <i class="bx bx-phone text-primary"></i>
                  </div>
                  <div>
                    <h6 class="mb-1 small fw-semibold">Telepon</h6>
                    <a href="tel:+62215550123" class="text-secondary text-decoration-none">0821-6319-2246</a>
                    <p class="small text-muted mb-0">Senin - Minggu, 08:00 - 22:00 WIB</p>
                  </div>
                </div>
              </li>
              <li>
                <div class="d-flex align-items-start gap-3">
                  <div class="contact-icon rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 40px; height: 40px; background: rgba(0, 102, 204, 0.1);">
                    <i class="bx bx-map text-primary"></i>
                  </div>
                  <div>
                    <h6 class="mb-1 small fw-semibold">Alamat</h6>
                    <p class="text-secondary mb-0">Jl. Singa, Unte Mungkur,<br>Kabupaten Tapanuli Utara, Sumatera Utara 22476, Indonesia.</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>

          <!-- Newsletter & Social -->
          <div class="col-lg-3 col-md-6">
             <h5 class="footer-title mb-4 fw-semibold" style="color: #1a1a1a;">
              <i class="bx bx-headphone me-2"></i>Ikuti kami
            </h5>
            <div class="social-section">
              <div class="d-flex gap-2">
                <a href="#" class="social-btn btn-facebook d-flex align-items-center justify-content-center">
                  <i class="bx bxl-facebook"></i>
                </a>
                <a href="https://www.instagram.com/kmp_muaraputih_1?igsh=M29pa250NmNrcW0z" class="social-btn btn-instagram d-flex align-items-center justify-content-center">
                  <i class="bx bxl-instagram"></i>
                </a>
                <a href="https://youtube.com/@muaraputih2172?si=fwkz0VI-kcAUbeu_" class="social-btn btn-youtube d-flex align-items-center justify-content-center">
                  <i class="bx bxl-youtube"></i>
                </a>
                <a href="https://wa.me/6282163192246?text=Halo%20saya%20ingin%20bertanya" target="_blank" class="social-btn btn-whatsapp d-flex align-items-center justify-content-center">
                  <i class="bx bxl-whatsapp"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom py-3" style="background: rgba(0, 102, 204, 0.05);">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <p class="mb-0 small text-muted">
              &copy; {{ date('Y') }} PT. Muara Putih. Semua hak dilindungi undang-undang.
            </p>
          </div>
          <div class="col-md-6">
            <div class="d-flex justify-content-md-end gap-4">
              <a href="#" class="text-muted small text-decoration-none hover-text-primary">Kebijakan Privasi</a>
              <a href="#" class="text-muted small text-decoration-none hover-text-primary">Syarat & Ketentuan</a>
              <a href="#" class="text-muted small text-decoration-none hover-text-primary">FAQ</a>
              <a href="#" class="text-muted small text-decoration-none hover-text-primary">Peta Situs</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Back to Top Button -->
    <button class="btn btn-primary back-to-top" id="backToTop">
      <i class="bx bx-chevron-up"></i>
    </button>
  </div>
</footer>

<style>
/* Footer Styles */
.footer {
  position: relative;
  background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
}

.footer-main {
  background: white;
}

.footer-title {
  font-size: 1.1rem;
  position: relative;
  padding-bottom: 0.75rem;
}

.footer-title::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 40px;
  height: 3px;
  background: linear-gradient(90deg, #0066cc, #00b4d8);
  border-radius: 2px;
}

.footer-links li a {
  color: #666;
  text-decoration: none;
  transition: all 0.3s ease;
  padding: 0.25rem 0;
  display: inline-block;
  position: relative;
}

.footer-links li a:hover {
  color: #0066cc;
  transform: translateX(5px);
}

.footer-links li a:hover i {
  color: #0066cc;
}

.footer-contact .contact-icon {
  flex-shrink: 0;
  transition: all 0.3s ease;
}

.footer-contact .contact-icon:hover {
  background: rgba(0, 102, 204, 0.2) !important;
  transform: translateY(-2px);
}

/* Newsletter Form */
.newsletter-form .form-control:focus {
  border-color: #0066cc;
  box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
}

.newsletter-form .btn-primary {
  background: linear-gradient(135deg, #0066cc 0%, #004a99 100%);
  border: none;
  transition: all 0.3s ease;
}

.newsletter-form .btn-primary:hover {
  background: linear-gradient(135deg, #004a99 0%, #003366 100%);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

/* Social Media Buttons */
.social-btn {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  text-decoration: none;
  transition: all 0.3s ease;
  color: white;
  font-size: 1.2rem;
}

.social-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.btn-facebook { background: #1877f2; }
.btn-twitter { background: #1da1f2; }
.btn-instagram { 
  background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
}
.btn-youtube { background: #ff0000; }
.btn-whatsapp { background: #25d366; }

.social-btn:hover {
  opacity: 0.9;
}

/* Back to Top Button */
.back-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: none;
  z-index: 1000;
  box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
  transition: all 0.3s ease;
}

.back-to-top:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
}

/* Footer Link Hover Effects */
.hover-text-primary:hover {
  color: #0066cc !important;
}

/* Footer Bottom Links */
.footer-bottom a {
  position: relative;
  padding-bottom: 2px;
}

.footer-bottom a::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 1px;
  background: #0066cc;
  transition: width 0.3s ease;
}

.footer-bottom a:hover::after {
  width: 100%;
}

/* Responsive Design */
@media (max-width: 768px) {
  .footer-main {
    padding-top: 3rem !important;
    padding-bottom: 3rem !important;
  }
  
  .footer-title {
    margin-top: 1.5rem;
  }
  
  .footer-links li {
    margin-bottom: 0.5rem;
  }
  
  .social-btn {
    width: 38px;
    height: 38px;
    font-size: 1rem;
  }
  
  .back-to-top {
    bottom: 20px;
    right: 20px;
    width: 45px;
    height: 45px;
  }
}

@media (max-width: 576px) {
  .footer-contact li {
    margin-bottom: 1.5rem;
  }
  
  .footer-bottom {
    text-align: center;
  }
  
  .footer-bottom .d-flex {
    justify-content: center !important;
    margin-top: 1rem;
  }
}

/* Animation for scroll to top */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.footer {
  animation: fadeInUp 0.5s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Back to Top Button
  const backToTopBtn = document.getElementById('backToTop');
  
  // Show/hide button on scroll
  window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
      backToTopBtn.style.display = 'flex';
      backToTopBtn.style.animation = 'fadeInUp 0.3s ease-out';
    } else {
      backToTopBtn.style.display = 'none';
    }
  });
  
  // Scroll to top when clicked
  backToTopBtn.addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
  
  // Newsletter Form Submission
  const newsletterForm = document.getElementById('newsletterForm');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const emailInput = this.querySelector('input[type="email"]');
      const email = emailInput.value;
      
      if (email && validateEmail(email)) {
        // Simulate form submission
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalHTML = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';
        
        // Simulate API call
        setTimeout(() => {
          submitBtn.innerHTML = '<i class="bx bx-check"></i>';
          submitBtn.style.background = '#28a745';
          
          // Show success message
          showToast('success', 'Terima kasih! Anda telah berlangganan newsletter kami.');
          
          // Reset after 2 seconds
          setTimeout(() => {
            submitBtn.innerHTML = originalHTML;
            submitBtn.disabled = false;
            submitBtn.style.background = '';
            emailInput.value = '';
          }, 2000);
        }, 1500);
      } else {
        showToast('error', 'Silakan masukkan alamat email yang valid.');
      }
    });
  }
  
  // Email validation function
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
  
  // Toast notification function
  function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 position-fixed`;
    toast.style.cssText = 'bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;';
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
    
    document.body.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast, {
      autohide: true,
      delay: 5000
    });
    
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
      document.body.removeChild(toast);
    });
  }
  
  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href !== '#') {
        e.preventDefault();
        const targetElement = document.querySelector(href);
        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      }
    });
  });
});
</script>