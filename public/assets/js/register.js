// ===============================
// Import Firebase SDKs
// ===============================
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
import {
  getAuth,
  createUserWithEmailAndPassword
} from "https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js";

// ===============================
// Firebase config
// ===============================
const firebaseConfig = {
  apiKey: "AIzaSyDOGpYwwYVAjGv50tkd4Oc6OpOIIGEQACM",
  authDomain: "kmp-muara-putih.firebaseapp.com",
  projectId: "kmp-muara-putih",
  storageBucket: "kmp-muara-putih.firebasestorage.app",
  messagingSenderId: "464742714279",
  appId: "1:464742714279:web:2cc8385f3bb3a0c1038482",
  measurementId: "G-L614DES47M"
};

// ===============================
// Init Firebase
// ===============================
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// ===============================
// UI elements
// ===============================
const form = document.getElementById("formAuthentication");
const registerBtn = document.getElementById("registerBtn");
const btnText = document.getElementById("btnText");
const btnLoading = document.getElementById("btnLoading");

// ===============================
// Helper UI
// ===============================
function setLoading(isLoading) {
  btnText.classList.toggle("d-none", isLoading);
  btnLoading.classList.toggle("d-none", !isLoading);
  registerBtn.disabled = isLoading;
}

// ===============================
// Submit handler
// ===============================
form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document.getElementById("phone_number").value.trim();
  const password = document.getElementById("password").value;
  const confirm = document.getElementById("confirm_password").value;

  // ===============================
  // Validasi frontend
  // ===============================
  if (!name || !email || !phone || !password || !confirm) {
    window.showAlert(
      "Semua field wajib diisi!",
      "warning",
      { title: "Validasi" }
    );
    return;
  }

  if (password !== confirm) {
    window.showAlert(
      "Password dan Konfirmasi Password tidak cocok!",
      "warning",
      { title: "Validasi" }
    );
    return;
  }

  setLoading(true);

  let firebaseUser = null;

  try {
    // ===============================
    // 1️⃣ Firebase Register
    // ===============================
    const userCredential = await createUserWithEmailAndPassword(
      auth,
      email,
      password
    );

    firebaseUser = userCredential.user;

    // ===============================
    // 2️⃣ Simpan ke Laravel
    // ===============================
    const response = await fetch(window.Laravel.registerUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": window.Laravel.csrfToken
      },
      body: JSON.stringify({
        uid: firebaseUser.uid,
        name,
        email,
        phone_number: phone
      })
    });

    const data = await response.json();

    if (!response.ok) {
      if (data.errors?.phone_number) {
        throw { type: "phone_exists", message: data.errors.phone_number[0] };
      }

      if (data.errors?.email) {
        throw { type: "email_exists", message: data.errors.email[0] };
      }

      throw { type: "server_error", message: data.message };
    }

    // ===============================
    // ✅ Sukses
    // ===============================
    window.showAlert(
      "Registrasi berhasil! Silakan login.",
      "success",
      { title: "Sukses" }
    );

    window.location.href = "/login";

  } catch (error) {
    console.error("Register error:", error);

    // ===============================
    // 🔥 ROLLBACK FIREBASE
    // ===============================
    if (firebaseUser) {
      try {
        await firebaseUser.delete();
        console.warn("Firebase user dihapus (rollback)");
      } catch (e) {
        console.error("Gagal rollback Firebase:", e);
      }
    }

    // ===============================
    // Pesan error spesifik
    // ===============================
    if (error.code === "auth/email-already-in-use") {
      window.showAlert(
        "Email sudah terdaftar. Silakan gunakan email lain.",
        "error",
        { title: "Email Duplikat" }
      );

    } else if (error.code === "auth/weak-password") {
      window.showAlert(
        "Password minimal 6 karakter.",
        "error",
        { title: "Password Lemah" }
      );

    } else if (error.type === "phone_exists") {
      window.showAlert(
        error.message,
        "error",
        { title: "Nomor Telepon Duplikat" }
      );

    } else if (error.type === "email_exists") {
      window.showAlert(
        error.message,
        "error",
        { title: "Email Duplikat" }
      );

    } else {
      window.showAlert(
        error.message || "Registrasi gagal",
        "error",
        { title: "Error" }
      );
    }

  } finally {
    setLoading(false);
  }
});
