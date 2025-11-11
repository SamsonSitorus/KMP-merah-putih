  const uploadInput = document.getElementById('upload');
  const uploadedAvatar = document.getElementById('uploadedAvatarForm');
  const resetButton = document.querySelector('.account-image-reset');
  const defaultAvatar = "{{ asset('assets/img/avatars/1.png') }}";

  uploadInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
      // Validasi ukuran file
      if (file.size > 800 * 1024) { // 800 KB
        alert("Ukuran file maksimal 800 KB");
        uploadInput.value = ""; // reset input
        return;
      }

      const reader = new FileReader();
      reader.onload = (e) => {
        uploadedAvatarForm.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  // Preview foto setelah upload
  document.getElementById('upload').addEventListener('change', function (event) {
    const [file] = event.target.files;
    if (file) {
      document.getElementById('uploadedAvatarForm').src = URL.createObjectURL(file);
    }
  });
