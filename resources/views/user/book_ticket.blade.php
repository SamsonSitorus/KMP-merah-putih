@extends('layouts.app')

@section('content')
<style>
    /* Booking page small UI polish */
    .bk-card-header {
        background: linear-gradient(90deg,#0077d6 0%,#00a3ff 100%);
        color: #fff;
        font-weight: 800;
        letter-spacing: .2px;
    }
    .bk-field-label { font-weight:700; color:#0f1724; }
    .bk-small { font-size:0.85rem; color:#6b7280; }
    .bk-price { font-weight:900; color:#d43f3a; font-size:1.05rem; }
    .bk-detail-row { display:flex; justify-content:space-between; align-items:center; padding:0.6rem 0; border-bottom:1px dashed rgba(15,23,36,0.04); }
    .bk-file-preview { border:1px dashed rgba(3,37,76,0.08); padding:0.8rem; border-radius:8px; display:flex; gap:0.8rem; align-items:center; }
    .bk-file-thumb { width:72px; height:72px; object-fit:cover; border-radius:6px; background:#f3f4f6; display:block; }
    .bk-file-meta { flex:1; }
    .bk-btn-primary { background: linear-gradient(90deg,#0077d6 0%, #ff8c42 100%); border:none; color:white; font-weight:800; }
    .bk-note { font-size:0.82rem; color:#525252; }
    .text-muted-2 { color:#7b8794; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @if(session('payment_path'))
                    <div class="mb-3">File tersimpan: <a target="_blank" href="{{ asset('storage/' . session('payment_path')) }}">Lihat bukti</a></div>
                @endif
            @endif

            @php
                $ticketStockId = request()->query('ticket_stock_id');
                $departureDate = request()->query('departure_date');
                $departureTime = request()->query('departure_time');
                $dewasaCount = (int) request()->query('dewasa_count', 0);
                $anakCount = (int) request()->query('anak_count', 0);
                $vehicleType = request()->query('vehicle_type');
                $vehicleCount = (int) request()->query('vehicle_count', 0);
                $totalPrice = request()->query('total_price');
            @endphp

            <!-- Detail Pemesanan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bk-card-header">Detail Pemesanan</div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:64px; height:64px; background:linear-gradient(135deg,#e6f5ff,#fff); border-radius:12px; display:flex; align-items:center; justify-content:center; box-shadow:0 6px 18px rgba(0,0,0,0.06);">
                                <img src="{{ asset('assets/img/ticket_icon.png') }}" alt="ticket" style="width:38px; opacity:0.95;">
                            </div>
                            <div>
                                <div class="bk-field-label">Rincian Pemesanan</div>
                                <div class="bk-small">Mohon cek kembali detail sebelum mengunggah bukti pembayaran.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bk-detail-row">
                            <div><span class="fw-semibold">Ticket Stock ID</span><div class="bk-small text-muted-2">ID untuk referensi pembayaran</div></div>
                            <div class="text-end">{{ $ticketStockId ?? '-' }}</div>
                        </div>

                        <div class="bk-detail-row">
                            <div><span class="fw-semibold">Keberangkatan</span><div class="bk-small text-muted-2">Tanggal & waktu</div></div>
                            <div class="text-end">{{ $departureDate ?? '-' }} <br><small class="bk-small">{{ $departureTime ?? '-' }}</small></div>
                        </div>

                        <div class="bk-detail-row">
                            <div><span class="fw-semibold">Penumpang</span><div class="bk-small text-muted-2">Jumlah dan kategori</div></div>
                            <div class="text-end">{{ $dewasaCount }} Dewasa<br><small class="bk-small">{{ $anakCount }} Anak-anak</small></div>
                        </div>

                        <div class="bk-detail-row">
                            <div><span class="fw-semibold">Kendaraan</span><div class="bk-small text-muted-2">Tipe & jumlah kendaraan</div></div>
                            <div class="text-end">{{ $vehicleType ? $vehicleType . ' × ' . $vehicleCount : 'Tidak membawa kendaraan' }}</div>
                        </div>

                        <div class="bk-detail-row" style="border-bottom:none; padding-top:0.8rem;">
                            <div><span class="fw-semibold">Total Harga</span><div class="bk-small text-muted-2">Sudah termasuk biaya administrasi</div></div>
                            <div class="text-end bk-price">{{ $totalPrice ? 'Rp ' . number_format($totalPrice,0,',','.') : 'Rp 0' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Pembayaran -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bk-card-header">Upload Bukti Pembayaran</div>
                <div class="card-body">
                    <form id="paymentForm" action="{{ route('book_ticket.confirm') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ticket_stock_id" value="{{ $ticketStockId }}">
                        <input type="hidden" name="departure_date" value="{{ $departureDate }}">
                        <input type="hidden" name="departure_time" value="{{ $departureTime }}">
                        <input type="hidden" name="dewasa_count" value="{{ $dewasaCount }}">
                        <input type="hidden" name="anak_count" value="{{ $anakCount }}">
                        <input type="hidden" name="vehicle_type" value="{{ $vehicleType }}">
                        <input type="hidden" name="vehicle_count" value="{{ $vehicleCount }}">
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                        <div class="mb-3">
                            <label for="payment_proof" class="form-label fw-semibold bk-field-label">Bukti Pembayaran</label>
                            <div class="bk-file-preview" id="filePreview">
                                <img id="fileThumb" class="bk-file-thumb" src="" alt="Preview" style="display:none;">
                                <div class="bk-file-meta">
                                    <div id="fileName" class="fw-semibold bk-small">Belum ada file yang dipilih</div>
                                    <div id="fileHelp" class="bk-note">Format: JPG, PNG atau PDF. Ukuran maks 2MB.</div>
                                </div>
                                <div>
                                    <label class="btn btn-sm bk-btn-primary" for="payment_proof" style="cursor:pointer; padding:8px 12px; border-radius:8px;">Pilih File</label>
                                </div>
                            </div>
                            <input type="file" class="form-control d-none" id="payment_proof" name="payment_proof" accept="image/*,.pdf" required>
                        </div>

                        <div class="mb-2">
                            <div class="bk-small text-muted-2">Pastikan bukti pembayaran terlihat jelas. Nama file akan ditampilkan dan gambar akan diperlihatkan jika berformat gambar.</div>
                        </div>

                        <button type="submit" class="btn bk-btn-primary w-100 rounded-pill" id="submitPayment">Kirim Bukti & Konfirmasi</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const realInput = document.getElementById('payment_proof');
        const fileThumb = document.getElementById('fileThumb');
        const fileName = document.getElementById('fileName');
        const fileHelp = document.getElementById('fileHelp');
        const filePreview = document.getElementById('filePreview');
        const allowedTypes = ['image/jpeg','image/png','application/pdf'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        // When user clicks the custom label, it triggers the hidden input via for attribute
        realInput.addEventListener('change', function(e){
            const f = this.files[0];
            if (!f) return;

            // Validate type
            if (!allowedTypes.includes(f.type)) {
                if (window.showAlert) window.showAlert('Tipe file tidak didukung. Gunakan JPG, PNG, atau PDF.', 'warning', { title: 'Tipe File' });
                this.value = '';
                return;
            }

            // Validate size
            if (f.size > maxSize) {
                if (window.showAlert) window.showAlert('Ukuran file melebihi 2MB. Kompres atau pilih file yang lebih kecil.', 'warning', { title: 'Ukuran File' });
                this.value = '';
                return;
            }

            // Update UI
            fileName.textContent = f.name;
            fileHelp.textContent = (f.type === 'application/pdf') ? 'PDF terpilih — pratinjau tidak tersedia.' : 'Pratinjau gambar di samping.';

            if (f.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(ev){
                    fileThumb.src = ev.target.result;
                    fileThumb.style.display = 'block';
                };
                reader.readAsDataURL(f);
            } else {
                fileThumb.style.display = 'none';
                fileThumb.src = '';
            }
        });

        // Form submit: small client-side guard
        const form = document.getElementById('paymentForm');
        form.addEventListener('submit', function(e){
            const f = realInput.files[0];
            if (!f) {
                if (window.showAlert) window.showAlert('Silakan unggah bukti pembayaran sebelum melanjutkan.', 'warning', { title: 'Bukti Pembayaran' });
                e.preventDefault();
                return;
            }
            // Already validated on change, but re-check
            if (!allowedTypes.includes(f.type) || f.size > maxSize) {
                if (window.showAlert) window.showAlert('File tidak valid. Periksa tipe atau ukuran file.', 'error', { title: 'File Invalid' });
                e.preventDefault();
                return;
            }

            // Show small feedback toast
            if (window.showAlert) window.showAlert('Mengunggah bukti... Mohon tunggu.', 'info', { title: 'Upload' });
        });
    });
</script>

@endsection
