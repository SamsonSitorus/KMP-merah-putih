
<footer class="mt-auto bg-white text-dark pt-5 pb-3" style="border-top: 2px solid #e8f0f7;">
  <div class="container">
    <div class="row gy-4">
      <!-- About -->
      <div class="col-md-4">
        <h5 class="fw-bold mb-3">About Us</h5>
        <p class="small text-secondary">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ac ante mollis quam tristique convallis.
        </p>
      </div>
      <!-- Quick Links -->
      <div class="col-md-4">
        <h5 class="fw-bold mb-3">Quick Links</h5>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="{{ route('home') }}" class="text-dark text-decoration-none footer-link">Home</a></li>
          <li class="mb-2"><a href="#offers" class="text-dark text-decoration-none footer-link">Latest Offers</a></li>
          <li class="mb-2"><a href="#contact" class="text-dark text-decoration-none footer-link">Contact</a></li>
        </ul>
      </div>
      <!-- Follow Us -->
      <div class="col-md-4">
        <h5 class="fw-bold mb-3">Follow Us</h5>
        <ul class="list-inline">
          <li class="list-inline-item">
            <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle me-2" style="width:40px; height:40px; border:1px solid rgba(0,102,204,0.12);">
              <i class="bi bi-facebook" style="color:#0066cc;"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle me-2" style="width:40px; height:40px; border:1px solid rgba(0,102,204,0.12);">
              <i class="bi bi-twitter" style="color:#0066cc;"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle me-2" style="width:40px; height:40px; border:1px solid rgba(0,102,204,0.12);">
              <i class="bi bi-instagram" style="color:#0066cc;"></i>
            </a>
          </li>
        </ul>
        <div class="mt-3">
          <a href="mailto:support@muaraputih.co.id" class="btn footer-cta me-2">Email Us</a>
          <a href="tel:+62215550123" class="btn footer-cta-outline">Call Us</a>
        </div>
      </div>
    </div>
    <hr class="border-secondary my-4">
    <div class="row">
      <div class="col text-center">
        <p class="small text-secondary mb-0">&copy; 2023 KMP Muara Putih. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>

<style>
  /* Footer link hover similar to navbar */
  .footer-link:hover {
    color: #0066cc !important;
    text-decoration: none;
    background-color: transparent;
  }

  /* CTA button matching navbar gradient */
  .footer-cta {
    display: inline-block;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    color: #fff;
    border: none;
    padding: 0.5rem 0.9rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
  }

  .footer-cta-outline {
    display: inline-block;
    background: #fff;
    color: #0066cc;
    border: 1px solid rgba(0,102,204,0.12);
    padding: 0.45rem 0.85rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
  }

  .footer-cta:hover, .footer-cta-outline:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,102,204,0.12);
  }

  .hover-link { transition: color .2s ease; }
</style>

