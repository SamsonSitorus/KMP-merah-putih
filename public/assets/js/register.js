// Import Firebase SDKs
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js";

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
    e.preventDefault(); // Mencegah reload halaman

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone_number").value;
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;

    if (password !== confirm) {
        window.showAlert("Password dan Konfirmasi Password tidak cocok!", 'warning', { title: 'Validasi' });
        return;
    }

    createUserWithEmailAndPassword(auth, email, password)
    .then((userCredential) => {
        const user = userCredential.user;
        console.log("User registered:", user);

        // Kirim data ke Laravel
        fetch(window.Laravel.registerUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": window.Laravel.csrfToken
            },
            body: JSON.stringify({
                uid: user.uid,
                name: name,
                email: email,
                phone_number: phone
            })
        })
        .then(async response => {
            const text = await response.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error("Response bukan JSON:", text);
                window.showAlert("Gagal simpan ke Laravel, response bukan JSON", 'error', { title: 'Server' });
                return;
            }

            if (response.ok) {
                console.log("Laravel response:", data);
                window.showAlert("Registrasi berhasil! Data tersimpan di database Laravel", 'success', { title: 'Sukses' });
                window.location.href = "/login"; // bisa langsung pakai path
            } else {
                window.showAlert("Gagal registrasi: " + (data.message || "Terjadi kesalahan"), 'error', { title: 'Error' });
            }
        })
        .catch(error => {
            console.error("Error dari Laravel:", error);
            window.showAlert("Gagal simpan ke database Laravel!", 'error', { title: 'Server' });
        });

    })
    .catch((error) => {
        console.error("Firebase registration error:", error);
        window.showAlert("Gagal register di Firebase: " + error.message, 'error', { title: 'Auth' });
    });
});
