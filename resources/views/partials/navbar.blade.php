<nav class="navbar navbar-expand-xl navbar-light bg-white shadow-sm sticky-top" id="layout-navbar" style="border-bottom: 2px solid #e8f0f7;">
  <div class="container-fluid px-4">

  {{-- Logo --}}
  <a href="/" class="navbar-brand d-flex align-items-center gap-2">
      <div class="p-2 rounded-lg" style="background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);">
        <img src="{{ asset('assets/img/cruise.png') }}" alt="Seaventures" 
             class="d-inline-block align-text-top" style="height: 40px; filter: brightness(0) invert(1);">
      </div>
      <div class="lh-1">
        <span class="fw-bold text-dark d-block" style="font-size: 16px;">KMP Muara Putih</span>
        <small class="text-muted" style="font-size: 12px;">Easy Ship Booking</small>
      </div>
    </a>

    {{-- Toggle untuk mobile --}}
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Menu --}}
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="navbar-nav ms-auto align-items-center gap-1">
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link fw-500 text-dark transition-all" 
             style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">Home</a>
        </li>
        <li class="nav-item">
          <a href="#offers" class="nav-link fw-500 text-dark transition-all" 
             style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">Latest Offers</a>
        </li>
        <li class="nav-item">
          <a href="#why-us" class="nav-link fw-500 text-dark transition-all" 
             style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">Why Us</a>
        </li>
      <li class="nav-item">
       <a href="#partners" class="nav-link fw-500 text-dark transition-all" 
         style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">Partners</a>
      </li>
      <li class="nav-item">
       <a href="#contact" class="nav-link fw-500 text-dark transition-all" 
         style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">Contact Us</a>
      </li>

        {{-- User / Guest --}}
        @auth
          <li class="nav-item dropdown ms-3">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" 
               data-bs-toggle="dropdown" style="padding: 6px 12px;">
              <img src="{{ asset('assets/img/avatars/1.png') }}" 
                   alt="User" class="w-px-40 h-auto rounded-circle border border-2" 
                   style="border-color: #0066cc !important;" />
              <span class="fw-600 text-dark d-none d-sm-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius: 8px;">
              <li><a class="dropdown-item fw-500" href="{{ route('profile') }}">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger fw-500">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item ms-3">
            <a href="{{ route('login') }}" class="btn btn-primary fw-600 px-4" 
               style="background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); border: none; border-radius: 8px; transition: all 0.3s ease;">
              Sign In
            </a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<style>
  .nav-link:hover {
    background-color: #f0f5ff !important;
    color: #0066cc !important;
  }
  
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 102, 204, 0.3) !important;
  }
  
  .navbar-brand:hover {
    opacity: 0.9;
  }
</style>