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
    .passenger-section { background: #f8fafc; padding: 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; }
    .passenger-inputs-row { display: flex; flex-direction: column; gap: 0.8rem; }
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
                $vehicleTypes = (array) request()->query('vehicle_types', []);
                $vehicleCounts = (array) request()->query('vehicle_counts', []);
                $vehicleCounts = array_map(fn($v) => (int) $v, $vehicleCounts);
                $vehicleType = $vehicleTypes[0] ?? null;
                $vehicleCount = (int) ($vehicleCounts[0] ?? 0);
                $totalPrice = request()->query('total_price');
            @endphp

            <!-- Detail Pemesanan -->
            <div class="booking-detail-card mb-4">
                <div class="bk-card-header">Detail Pemesanan & Nama Penumpang</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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

                            @if($dewasaCount > 0 || $anakCount > 0)
                                <div class="passenger-section mt-4">
                                    <h5 class="bk-field-label mb-3">Masukkan Nama Penumpang</h5>

                                    @if($dewasaCount > 0)
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" style="color:#0f1724;">👤 Penumpang Dewasa</label>
                                            <div class="passenger-inputs-row">
                                                @for($i = 1; $i <= $dewasaCount; $i++)
                                                    <input 
                                                        type="text" 
                                                        name="passengers[dewasa][]" 
                                                        class="form-control" 
                                                        placeholder="Nama penumpang dewasa #{{ $i }}"
                                                        required>
                                                @endfor
                                            </div>
                                        </div>
                                    @endif

                                    @if($anakCount > 0)
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" style="color:#0f1724;">👶 Penumpang Anak-anak</label>
                                            <div class="passenger-inputs-row">
                                                @for($i = 1; $i <= $anakCount; $i++)
                                                    <input 
                                                        type="text" 
                                                        name="passengers[anak][]" 
                                                        class="form-control" 
                                                        placeholder="Nama penumpang anak-anak #{{ $i }}"
                                                        required>
                                                @endfor
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="passenger-section mt-4">
    <h5 class="bk-field-label mb-3">Data Kendaraan</h5>
    @foreach($vehicleTypes as $i => $vt)
        @php 
            $count = $vehicleCounts[$i];
        @endphp

        <div class="vehicle-card mb-3 p-3"
            style="background:#f1f5f9;border-radius:12px;border:1px solid #dbe2ea;">

            <h6 class="fw-bold mb-3" style="color:#0f1724;">
                🚗 {{ ucfirst($vt) }} — {{ $count }} unit
            </h6>

            @for($n = 1; $n <= $count; $n++)
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nomor Plat #{{ $n }}
                        @if(strtolower($vt) === 'sepeda')
                            <small class="text-muted">(opsional)</small>
                        @endif
                    </label>

                    <input 
                        type="text"
                        name="no_plat[{{ $i }}][]"
                        class="form-control"
                        placeholder="Cth: BB1234XY">
                </div>
            @endfor

        </div>
    @endforeach
</div>
                            @endif
                            <div class="d-flex gap-2 mt-4">
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
    const allowedTypes = ['image/jpeg','image/png','application/pdf'];
    const maxSize = 2 * 1024 * 1024;

    if (realInput) {
        realInput.addEventListener('change', function(e){
            const f = this.files[0];
            if (!f) return;

            if (!allowedTypes.includes(f.type)) {
                if (window.showAlert) window.showAlert('Tipe file tidak didukung.', 'warning');
                this.value = '';
                return;
            }

            if (f.size > maxSize) {
                if (window.showAlert) window.showAlert('Ukuran file lebih dari 2MB.', 'warning');
                this.value = '';
                return;
            }

            fileName.textContent = f.name;
            fileHelp.textContent = (f.type === 'application/pdf') 
                ? 'PDF terpilih — pratinjau tidak tersedia.' 
                : 'Pratinjau gambar di samping.';

            if (f.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = ev => {
                    fileThumb.src = ev.target.result;
                    fileThumb.style.display = 'block';
                };
                reader.readAsDataURL(f);
            } else {
                fileThumb.style.display = 'none';
                fileThumb.src = '';
            }
        });
    }
    const form = document.getElementById('paymentForm');
    form.addEventListener('submit', function(e){
        const nameInputs = form.querySelectorAll('input[name^="passengers"]');
        for (let input of nameInputs) {
            if (!input.value.trim()) {
                e.preventDefault();
                window.showAlert?.('Harap isi semua nama penumpang.', 'warning');
                return;
            }
        }
        const vehicleRows = document.querySelectorAll('[data-vehicle-row]');
        for (let row of vehicleRows) {
            let type = row.getAttribute('data-type'); 
            let plateInputs = row.querySelectorAll('.vehicle-plate-input');
            if (type !== 'sepeda') {
                for (let inp of plateInputs) {
                    if (!inp.value.trim()) {
                        e.preventDefault();
                        window.showAlert?.(
                            `Harap isi nomor plat untuk kendaraan tipe ${type}.`,
                            'warning'
                        );
                        return;
                    }
                }
            }
        }
    });
});
</script>
@endsection
