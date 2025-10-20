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

              <form id="formAuthentication" class="mb-6" action="index.html">
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
                <a href="auth-login-basic.html">
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
<script type="module">
  // Import Firebase SDKs
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
  import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js";

  // Konfigurasi Firebase Project kamu
  const firebaseConfig = {
   apiKey: "AIzaSyDOGpYwwYVAjGv50tkd4Oc6OpOIIGEQACM",
  authDomain: "kmp-muara-putih.firebaseapp.com",
  projectId: "kmp-muara-putih",
  storageBucket: "kmp-muara-putih.firebasestorage.app",
  messagingSenderId: "464742714279",
  appId: "1:464742714279:web:2cc8385f3bb3a0c1038482",
  measurementId: "G-L614DES47M"
  };

  // Inisialisasi Firebase
  const app = initializeApp(firebaseConfig);
  const auth = getAuth(app);

  // Handle register form
  document.getElementById("formAuthentication").addEventListener("submit", (e) => {
    e.preventDefault();
    
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone_number").value;
    const password = document.getElementById("password").value;

    createUserWithEmailAndPassword(auth, email, password)
      .then((userCredential) => {
        const user = userCredential.user;
        console.log("User registered:", user);

        // (Opsional) kirim data ke Laravel
          fetch("{{ route('firebase.register') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({
            uid: user.uid,
            name: name,
            email: email,
            phone_number: phone
          })
        })
          .then(response => response.json())
          .then(data => {
            console.log("Laravel response:", data);
            alert("Registrasi berhasil! Data tersimpan di database Laravel");
          })
          .catch(error => {
            console.error("Error dari Laravel:", error);
            alert("Gagal simpan ke database Laravel!");
          });
      });
  });
</script>
