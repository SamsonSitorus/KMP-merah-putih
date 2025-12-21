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
                // Support multiple vehicle types passed from the search step
                $vehicleTypes = (array) request()->query('vehicle_types', []);
                $vehicleCounts = (array) request()->query('vehicle_counts', []);
                $vehicleCounts = array_map(fn($v) => (int) $v, $vehicleCounts);
                // legacy single values (for backward compatibility)
                $vehicleType = $vehicleTypes[0] ?? null;
                $vehicleCount = (int) ($vehicleCounts[0] ?? 0);
                $totalPrice = request()->query('total_price');
            @endphp
            <div class="booking-detail-card">
            <!-- <div class="bk- card-header">Upload Bukti Pembayaran</div> -->
                <div class="card-body">
                    <form id="paymentForm" 
                        action="{{ route('book_ticket.confirm') }}" 
                        method="POST" 
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="ticket_stock_id" value="{{ $ticketStockId }}">
                        <input type="hidden" name="departure_date" value="{{ $departureDate }}">
                        <input type="hidden" name="departure_time" value="{{ $departureTime }}">
                        <input type="hidden" name="dewasa_count" value="{{ $dewasaCount }}">
                        <input type="hidden" name="anak_count" value="{{ $anakCount }}">
                        @foreach($vehicleTypes as $i => $vt)
                            <input type="hidden" name="vehicle_types[]" value="{{ $vt }}">
                            <input type="hidden" name="vehicle_counts[]" value="{{ $vehicleCounts[$i] ?? 0 }}">
                        @endforeach
                        <input type="hidden" name="vehicle_type" value="{{ $vehicleType }}">
                        <input type="hidden" name="vehicle_count" value="{{ $vehicleCount }}">
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                        <!-- <div class="mb-3">
                            <label class="form-label">Upload Bukti Pembayaran</label>
                            <input type="file" name="payment_proof" class="form-control" required>
                        </div> -->
                        <div class="mb-3"> 
                            <label for="payment_proof" class="form-label fw-semibold bk-field-label">
                                Bukti Pembayaran
                            </label> 
                            <div class="bk-file-preview" id="filePreview"> 
                                <img id="fileThumb" class="bk-file-thumb" src="" alt="Preview" style="display:none;"> 
                                <div class="bk-file-meta"> 
                                    <div id="fileName" class="fw-semibold bk-small">
                                        Belum ada file yang dipilih
                                    </div> 
                                    <div id="fileHelp" class="bk-note">
                                        Format: JPG, PNG atau PDF. Ukuran maks 2MB.
                                    </div> 
                                </div> 
                                <div> 
                                    <label class="btn btn-sm bk-btn-primary" for="payment_proof" style="cursor:pointer; padding:8px 12px; border-radius:8px;">
                                        Pilih File
                                    </label>
                                </div> 
                            </div> 
                            <input type="file" class="form-control d-none" id="payment_proof" name="payment_proof" accept="image/*,.pdf" required> 
                        </div> 
                        <div class="mb-2"> 
                            <div class="bk-small text-muted-2">
                                Pastikan bukti pembayaran terlihat jelas. Nama file akan ditampilkan dan gambar akan diperlihatkan jika berformat gambar.
                            </div>
                            </form>
                            <div class="d-flex mt-4 gap-2">
                                <form action="{{ route('booking.cancel') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                        <button 
                            type="submit"class="btn bk-btn-primary rounded-pill w-100"form="paymentForm">
                            Kirim Bukti & Konfirmasi
                        </button>
                    </div>
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
        const maxSize = 2 * 1024 * 1024;

        realInput.addEventListener('change', function(e){
            const f = this.files[0];
            if (!f) return;

            if (!allowedTypes.includes(f.type)) {
                if (window.showAlert) window.showAlert('Tipe file tidak didukung. Gunakan JPG, PNG, atau PDF.', 'warning', { title: 'Tipe File' });
                this.value = '';
                return;
            }

            if (f.size > maxSize) {
                if (window.showAlert) window.showAlert('Ukuran file melebihi 2MB. Kompres atau pilih file yang lebih kecil.', 'warning', { title: 'Ukuran File' });
                this.value = '';
                return;
            }

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

        const form = document.getElementById('paymentForm');
        form.addEventListener('submit', function(e){
            const f = realInput.files[0];
            if (!f) {
                if (window.showAlert) window.showAlert('Silakan unggah bukti pembayaran sebelum melanjutkan.', 'warning', { title: 'Bukti Pembayaran' });
                e.preventDefault();
                return;
            }
            if (!allowedTypes.includes(f.type) || f.size > maxSize) {
                if (window.showAlert) window.showAlert('File tidak valid. Periksa tipe atau ukuran file.', 'error', { title: 'File Invalid' });
                e.preventDefault();
                return;
            }

            if (window.showAlert) window.showAlert('Mengunggah bukti... Mohon tunggu.', 'info', { title: 'Upload' });
        });
    });
</script>

@endsection
