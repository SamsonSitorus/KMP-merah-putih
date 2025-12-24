@extends('layouts.app')

@section('content')
<style>
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

            <!-- Detail Pemesanan -->
            <div class="booking-detail-card mb-4">
                <div class="bk-card-header">Detail Pemesanan</div>
                <div class="card-body">
                    <!-- @if(session('booking_id'))
                        <div class="mb-3 text-center">
                            <a href="{{ route('book_ticket.download', session('booking_id')) }}" target="_blank" class="btn bk-btn-primary w-50 rounded-pill">
                                Download E-Ticket
                            </a>
                        </div>
                    @endif -->
                    <!-- <form id="paymentForm" action="{{ route('book_ticket.detail') }}" method="POST" enctype="multipart/form-data">
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
                                <div class="text-end">
                                    @if(count($vehicleTypes))
                                        @foreach($vehicleTypes as $i => $vt)
                                            <div>{{ $vt }} × {{ $vehicleCounts[$i] ?? 0 }}</div>
                                        @endforeach
                                    @else
                                        Tidak membawa kendaraan
                                    @endif
                                </div>
                            </div>

                            <div class="bk-detail-row" style="border-bottom:none; padding-top:0.8rem;">
                                <div><span class="fw-semibold">Total Harga</span><div class="bk-small text-muted-2">Sudah termasuk biaya administrasi</div></div>
                                <div class="text-end bk-price">{{ $totalPrice ? 'Rp ' . number_format($totalPrice,0,',','.') : 'Rp 0' }}</div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 rounded-pill">
                                    Kembali
                                </a>
                                <button type="submit" class="btn bk-btn-primary w-100 rounded-pill" id="btnLanjut">
                                    Lanjut Pembayaran
                                </button>
                            </div>
                        </div>
                    </form> -->
                    <form id="paymentForm" action="{{ route('book_ticket.detail') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ticket_stock_id" value="{{ $ticketStockId }}">
                        <input type="hidden" name="departure_date" value="{{ $departureDate }}">
                        <input type="hidden" name="departure_time" value="{{ $departureTime }}">
                        <input type="hidden" name="dewasa_count" value="{{ $dewasaCount }}">
                        <input type="hidden" name="anak_count" value="{{ $anakCount }}">
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                        @foreach($vehicleTypes as $i => $vt)
                            <input type="hidden" name="vehicle_types[]" value="{{ $vt }}">
                            <input type="hidden" name="vehicle_counts[]" value="{{ $vehicleCounts[$i] }}">
                        @endforeach
                        <div class="mb-2">

                            <!-- <div class="bk-detail-row">
                                <div>
                                    <span class="fw-semibold">Ticket Stock ID</span>
                                    <div class="bk-small text-muted-2">ID untuk referensi pembayaran</div>
                                </div>
                                <div class="text-end">{{ $ticketStockId }}</div>
                            </div> -->

                            <div class="bk-detail-row">
                                <div>
                                    <span class="fw-semibold">Keberangkatan</span>
                                    <div class="bk-small text-muted-2">Tanggal & waktu</div>
                                </div>
                                <div class="text-end">
                                    {{ $departureDate }}<br>
                                    <small class="bk-small">{{ $departureTime }}</small>
                                </div>
                            </div>

                            <div class="bk-detail-row">
                                <div>
                                    <span class="fw-semibold">Penumpang</span>
                                    <div class="bk-small text-muted-2">Jumlah dan kategori</div>
                                </div>
                                <div class="text-end">
                                    {{ $dewasaCount }} Dewasa<br>
                                    <small class="bk-small">{{ $anakCount }} Anak-anak</small>
                                </div>
                            </div>

                            <div class="bk-detail-row">
                                <div>
                                    <span class="fw-semibold">Kendaraan</span>
                                    <div class="bk-small text-muted-2">Tipe & jumlah kendaraan</div>
                                </div>

                                <div class="text-end">
                                    @if(count($vehicleTypes))
                                        @foreach($vehicleTypes as $i => $vt)
                                            <div>{{ $vt }} × {{ $vehicleCounts[$i] }}</div>
                                        @endforeach
                                    @else
                                        Tidak membawa kendaraan
                                    @endif
                                </div>
                            </div>

                            <div class="bk-detail-row" style="border-bottom:none;">
                                <div>
                                    <span class="fw-semibold">Total Harga</span>
                                    <div class="bk-small text-muted-2">Sudah termasuk biaya administrasi</div>
                                </div>
                                <div class="text-end bk-price">
                                    Rp {{ number_format($totalPrice,0,',','.') }}
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 rounded-pill">
                                    Kembali
                                </a>
                                <button type="submit" class="btn bk-btn-primary w-100 rounded-pill" id="btnLanjut">
                                    Lanjut Pembayaran
                                </button>
                            </div>
                        </div>
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
