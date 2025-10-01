<nav class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="container-fluid">

    {{-- Logo --}}
    <a href="/" class="navbar-brand d-flex align-items-center">
      <img src="{{ asset('assets/img/logo.jpg') }}" alt="Seaventures" class="d-inline-block align-text-top" style="width:150px;height:70px;">
      <div class="ms-2">
        <span class="fw-bold">KMP Muara Putih</span><br>
        <small class="text-muted">Easy Ship Booking</small>
      </div>
    </a>

    {{-- Toggle untuk mobile --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Menu --}}
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="#home" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="#offers" class="nav-link">Latest Offers</a></li>
        <li class="nav-item"><a href="#why-us" class="nav-link">Why Us</a></li>
        <li class="nav-item"><a href="#partners" class="nav-link">Partners</a></li>
        <li class="nav-item"><a href="#contact" class="nav-link">Contact Us</a></li>

        {{-- User / Guest --}}
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
              <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User" class="w-px-40 h-auto rounded-circle me-2" />
              <span>{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
              <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
            </ul>
          </li>
        @else
          <li class="nav-item ms-2">
            <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
