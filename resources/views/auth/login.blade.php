@extends('layouts.auth')

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">

      <!-- Login Card -->
      <div class="card">
        <div class="card-body">

          <!-- Logo -->
          <div class="app-brand justify-content-center mb-4">
            <a href="/" class="app-brand-link gap-2">
              <img src="{{ asset('assets/img/cruise.png') }}" alt="Seaventures" 
           class="d-inline-block align-text-top" style="height:50px;">
              <span class="app-brand-text demo text-heading fw-bold">KMP Muara Putih</span>
            </a>
          </div>
          <!-- /Logo -->
          <p class="mb-4">Please sign-in to your account and start the adventure</p>

          {{-- Alert jika login gagal --}}
         @if ($errors->any())
          <div class="alert alert-danger">
            {{ $errors->first() }}
          </div>
        @endif

          <form id="formLogin" method="POST" action="{{ route('Verify.login') }}">
          @csrf
            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="text"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                placeholder="Enter your email or username"
                value="{{ old('email') }}"
                autofocus
              />
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password"
                  class="form-control @error('password') is-invalid @enderror"
                  name="password"
                  placeholder="••••••••"
                  aria-describedby="password"
                />
                <span class="input-group-text cursor-pointer">
                  <i class="bx bx-hide"></i>
                </span>
              </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="mb-3 d-flex justify-content-between">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                <label class="form-check-label" for="remember-me"> Remember Me </label>
              </div>
              <a href="{{--  --}}">
                <small>Forgot Password?</small>
              </a>
            </div>

            <!-- Button -->
           <div class="mb-3">
            <button id="loginBtn" class="btn btn-primary d-grid w-100" type="submit">
              <span id="btnText">Login</span>
              <span id="btnLoading" class="d-none">
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Loading...
              </span>
            </button>
          </div>

          </form>

          <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{route('register')}}">
              <span>Create an account</span>
            </a>
          </p>

        </div>
      </div>
      <!-- /Login Card -->

    </div>
  </div>
</div>
@endsection  
<script>
document.getElementById('formLogin').addEventListener('submit', function () {
    document.getElementById('loginBtn').disabled = true;
    document.getElementById('btnText').classList.add('d-none');
    document.getElementById('btnLoading').classList.remove('d-none');
});
</script>
