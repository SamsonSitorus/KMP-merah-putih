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
          @if (session('failed'))
            <div class="alert alert-danger">{{ session('failed') }}</div>
          @endif

          <form id="formLogin">
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
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
  import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js";

  // 🔧 Firebase Configuration
  const firebaseConfig = {
    apiKey: "AIzaSyDOGpYwwYVAjGv50tkd4Oc6OpOIIGEQACM",
    authDomain: "kmp-muara-putih.firebaseapp.com",
    projectId: "kmp-muara-putih",
    storageBucket: "kmp-muara-putih.firebasestorage.app",
    messagingSenderId: "464742714279",
    appId: "1:464742714279:web:2cc8385f3bb3a0c1038482",
    measurementId: "G-L614DES47M"
  };

  // 🔥 Inisialisasi Firebase
  const app = initializeApp(firebaseConfig);
  const auth = getAuth(app);

  // 🧠 Handle Login Form
  document.getElementById("formLogin").addEventListener("submit", async (e) => {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    try {
      const userCredential = await signInWithEmailAndPassword(auth, email, password);
      const user = userCredential.user;
      const token = await user.getIdToken(); // Ambil token Firebase

      // Kirim token ke Laravel untuk verifikasi
      const response = await fetch("{{ route('firebase.verify') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ token })
      });

      const data = await response.json();

      if (response.ok) {
        alert("✅ Login berhasil!");
        window.location.href = "/dashboard";
      } else {
        alert("❌ Login gagal: " + data.message);
      }
    } catch (error) {
      console.error("Firebase login error:", error.message);
      alert("Gagal login: " + error.message);
    }
  });
</script>
