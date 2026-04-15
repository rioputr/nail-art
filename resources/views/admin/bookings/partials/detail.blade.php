<div class="card">
    <div class="card-body">

        @if($selectedBooking)
            <h4 class="fw-bold">{{ $selectedBooking->user->name ?? 'Guest' }}</h4>

            <hr>

            <h6>Informasi Klien</h6>
            <p>📧 {{ $selectedBooking->email ?? '-' }}</p>
            <p>📞 {{ $selectedBooking->phone ?? '-' }}</p>

            <h6>Detail Layanan</h6>
            <p>{{ $selectedBooking->service_details }}</p>
            <!-- <p>{{ $selectedBooking->duration }} jam</p> -->
            <p>Rp {{ number_format($selectedBooking->estimated_price) }}</p>

            <h6>Waktu Pemesanan</h6>
            <p>{{ $selectedBooking->booking_date }} - {{ $selectedBooking->booking_time }}</p>

            <h6>Status Pembayaran</h6>
            <span class="badge bg-success">Lunas</span>

            <h6>Catatan</h6>
            <p>{{ $selectedBooking->notes ?? '-' }}</p>

            <div class="d-flex gap-2 mt-4">
                <form method="POST" action="{{ route('admin.bookings.confirm', $selectedBooking->id) }}">
                    @csrf
                    <button class="btn btn-primary">Konfirmasi</button>
                </form>

                <button class="btn btn-outline-secondary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#rescheduleModal">
                    Jadwal Ulang
                </button>

                <form method="POST" action="{{ route('admin.bookings.cancel', $selectedBooking->id) }}">
                    @csrf
                    <button class="btn btn-danger">Batalkan</button>
                </form>

                <form method="POST" action="{{ route('admin.bookings.destroy', $selectedBooking->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">Hapus</button>
                </form>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-calendar-x fs-1"></i>
                <p class="mt-3 mb-0">Silakan pilih pemesanan untuk melihat detail.</p>
            </div>
        @endif

    </div>
</div>
