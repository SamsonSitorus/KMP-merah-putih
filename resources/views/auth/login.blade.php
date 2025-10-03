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
              <span class="app-brand-text demo text-heading fw-bold">Sneat</span>
            </a>
          </div>
          <!-- /Logo -->

          <h4 class="mb-1">Welcome to Sneat! 👋</h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>

          {{-- Alert jika login gagal --}}
          @if (session('failed'))
            <div class="alert alert-danger">{{ session('failed') }}</div>
          @endif

          <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email or Username</label>
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
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
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
              <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
            </div>
          </form>

          <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{--  --}}">
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
  