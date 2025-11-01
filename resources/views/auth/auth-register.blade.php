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
                  <span class="app-brand-logo demo">
                    <span class="text-primary">
                    </span>
                  </span>
                  <img src="{{ asset('assets/img/cruise.png') }}" alt="Seaventures" 
                  class="d-inline-block align-text-top" style="height:50px;">
                  <span class="app-brand-text demo text-heading fw-bold">KMP Muara Putih</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">Adventure starts here 🚀</h4>
              {{-- <p class="mb-6">Make your app management easy and fun!</p> --}}

              <form id="formAuthentication" class="mb-6">
                <div class="mb-6">
                  <label for="name" class="form-label">Nama</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    placeholder="Enter your name"
                    autofocus />
                </div>
                <div class="mb-6">
                  <label for="phone_number" class="form-label">Nomor Telepon</label>
                  <input
                    type="number"
                    class="form-control"
                    id="phone_number"
                    name="phone_number"
                    placeholder="Enter your phone_number"
                    autofocus />
                </div>
                <div class="mb-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
                </div>
                <div class="form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                  </div>

                  <div class="form-password-toggle">
                 <label class="form-label" for="confirm_password">Confirm Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="confirm_password"
                      class="form-control"
                      name="confirm_password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="Confirm_password"
                      />
                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                  </div>
                </div> 
                </div>

                <div class="my-7">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                      I agree to
                      <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Sign up</button>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="{{ route('login') }}">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->
@endsection
@push('scripts')
  {{-- Import file JavaScript eksternal --}}
  <script type="module" src="{{ asset('assets/js/register.js') }}"></script>
  {{-- Kirim route dan token ke JS --}}
  <script>
    window.Laravel = {
      registerUrl: "{{ route('firebase.register') }}",
      csrfToken: "{{ csrf_token() }}",
    };
  </script>
@endpush  