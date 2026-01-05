@section('content')
<div class="container py-4">
    @if(session('booking_id'))
        <div class="card shadow-sm p-4">
            <h5 class="mb-3 fw-semibold">E-Ticket</h5>
            <p class="text-muted mb-4">
                E-Ticket kamu sudah siap. Silakan unduh untuk ditunjukkan saat penggunaan layanan.
            </p>
            <div class="text-center">
                <a href="{{ route('book_ticket.download', session('booking_id')) }}"
                   target="_blank"
                   class="btn text-white w-75 py-3 rounded-pill fw-semibold"
                   style="
                        background: linear-gradient(90deg, #007bff 0%, #ff8c4a 100%);
                        font-size: 1.05rem;
                   ">
                    Download E-Ticket
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
