    // Fungsi Salin Rekening
    function copyText() {
        const accNo = "009901000841560"; // Angka bersih tanpa strip
        navigator.clipboard.writeText(accNo);
        alert("Nomor rekening berhasil disalin!");
    }

    document.addEventListener('DOMContentLoaded', function(){
        const realInput = document.getElementById('payment_proof');
        const fileThumb = document.getElementById('fileThumb');
        const fileName = document.getElementById('fileName');
        const fileHelp = document.getElementById('fileHelp');

        realInput.addEventListener('change', function(e){
            const f = this.files[0];
            if (!f) return;

            fileName.textContent = f.name;
            
            if (f.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(ev){
                    fileThumb.src = ev.target.result;
                    fileThumb.style.display = 'block';
                };
                reader.readAsDataURL(f);
                fileHelp.textContent = "Pratinjau gambar siap unggah.";
            } else {
                fileThumb.style.display = 'none';
                fileHelp.textContent = "Dokumen PDF terpilih.";
            }
        });
    });
