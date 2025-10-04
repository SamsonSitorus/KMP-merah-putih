<nav class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme shadow-sm container pe-0 "  id="layout-navbar">
  <div class="container-fluid">

    {{-- Logo --}}
    <a href="/" class="navbar-brand d-flex align-items-center">
      <img src="{{ asset('assets/img/cruise.png') }}" alt="Seaventures" 
           class="d-inline-block align-text-top" style="height:50px;">
      <div class="ms-2 lh-1">
        <span class="fw-bold text-dark">KMP Muara Putih</span><br>
        <small class="text-muted">Easy Ship Booking</small>
      </div>
    </a>

    {{-- Toggle untuk mobile --}}
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Menu --}}
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link fw-medium">Home</a></li>
        <li class="nav-item"><a href="#offers" class="nav-link fw-medium">Latest Offers</a></li>
        <li class="nav-item"><a href="#why-us" class="nav-link fw-medium">Why Us</a></li>
        <li class="nav-item"><a href="#partners" class="nav-link fw-medium">Partners</a></li>
        <li class="nav-item"><a href="#contact" class="nav-link fw-medium">Contact Us</a></li>

        {{-- User / Guest --}}
        @auth
          <li class="nav-item dropdown ms-3">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
              <img src="{{ asset('assets/img/avatars/1.png') }}" 
                   alt="User" class="w-px-40 h-auto rounded-circle border me-2" />
              <span class="fw-medium">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
              <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
            </ul>
          </li>
        @else
          <li class="nav-item ms-3">
            <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
