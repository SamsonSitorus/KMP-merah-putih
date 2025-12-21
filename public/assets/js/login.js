import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js";

// Firebase Configuration
const firebaseConfig = {
  apiKey: "AIzaSyDOGpYwwYVAjGv50tkd4Oc6OpOIIGEQACM",
  authDomain: "kmp-muara-putih.firebaseapp.com",
  projectId: "kmp-muara-putih",
  storageBucket: "kmp-muara-putih.firebasestorage.app",
  messagingSenderId: "464742714279",
  appId: "1:464742714279:web:2cc8385f3bb3a0c1038482",
  measurementId: "G-L614DES47M"
};

// Init Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Ambil elemen UI
const form = document.getElementById("formLogin");
const loginBtn = document.getElementById("loginBtn");
const btnText = document.getElementById("btnText");
const btnLoading = document.getElementById("btnLoading");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();

  if (!email || !password) {
    window.showAlert("Email dan Password wajib diisi!", 'warning', { title: 'Validasi' });
    return;
  }

  // 🔥 TAMPILKAN LOADING
  btnText.classList.add("d-none");
  btnLoading.classList.remove("d-none");
  loginBtn.disabled = true;

  try {
    // 1️⃣ Login Firebase
    const userCredential = await signInWithEmailAndPassword(auth, email, password);
    const user = userCredential.user;

    // 2️⃣ Ambil token (force refresh)
    const token = await user.getIdToken(true);
    console.debug("Firebase token:", token.substring(0, 40));

    // 3️⃣ Kirim token ke Laravel
    const response = await fetch(window.Laravel.verifyUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": window.Laravel.csrfToken
      },
      body: JSON.stringify({ token })
    });

    const text = await response.text();
    let data;

    try {
      data = JSON.parse(text);
    } catch {
      throw new Error("Response server bukan JSON");
    }

    if (!response.ok) {
      throw new Error(data.message || "Token tidak valid");
    }

    // ✅ Sukses
    window.showAlert("Login berhasil!", 'success', { title: 'Sukses' });

    // 🔄 INI YANG MEMUNCULKAN ICON TAB BERPUTAR (SEPERTI GPT)
    window.location.href = "/";

  } catch (error) {
    console.error("Login error:", error.message);
    window.showAlert("Gagal login: " + error.message, 'error', { title: 'Auth' });

    // ❌ Kembalikan tombol jika gagal
    btnText.classList.remove("d-none");
    btnLoading.classList.add("d-none");
    loginBtn.disabled = false;
  }
});
