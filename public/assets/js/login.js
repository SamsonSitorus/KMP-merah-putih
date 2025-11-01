 import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
  import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js";

  //  Firebase Configuration
  const firebaseConfig = {
    apiKey: "AIzaSyDOGpYwwYVAjGv50tkd4Oc6OpOIIGEQACM",
    authDomain: "kmp-muara-putih.firebaseapp.com",
    projectId: "kmp-muara-putih",
    storageBucket: "kmp-muara-putih.firebasestorage.app",
    messagingSenderId: "464742714279",
    appId: "1:464742714279:web:2cc8385f3bb3a0c1038482",
    measurementId: "G-L614DES47M"
  };

  //  Inisialisasi Firebase
  const app = initializeApp(firebaseConfig);
  const auth = getAuth(app);

  //  Handle Login Form
  document.getElementById("formLogin").addEventListener("submit", async (e) => {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    if (!email || !password) {
      alert("⚠️ Email dan Password wajib diisi!");
      return;
    }

    try {
      //  Login ke Firebase
      const userCredential = await signInWithEmailAndPassword(auth, email, password);
      const user = userCredential.user;
      const token = await user.getIdToken(); // ambil token login firebase

      //  Kirim token ke server Laravel
      const response = await fetch(window.Laravel.verifyUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": window.Laravel.csrfToken
        },
        body: JSON.stringify({ token })
      });
        // Tangani response
        const text = await response.text(); // ambil teks dulu
        let data;
        try {
          data = JSON.parse(text); // parse JSON
        } catch(e) {
          console.error("Response bukan JSON:", text);
          alert("❌ Login gagal: Response server bukan JSON");
          return;
        }
      // const data = await response.json();

      if (response.ok) {
        alert("✅ Login berhasil!");
        window.location.href = "/home";
      } else {
        alert("❌ Login gagal: " + (data.message || "Token tidak valid"));
      }
    } catch (error) {
      console.error("Firebase login error:", error.message);
      alert("⚠️ Gagal login: " + error.message);
    }
  });