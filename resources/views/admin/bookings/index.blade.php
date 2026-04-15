@extends('layouts.admin')

@section('content')
<style>
    .booking-item {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .booking-item:hover {
        background-color: #f8f9fa;
        transform: translateX(4px);
    }
    .bg-light-primary {
        background-color: #f0f7ff;
    }
    .transition-all-2 {
        transition: all 0.2s ease-in-out;
    }
</style>
<div class="row g-4">

    <!-- KIRI -->
    <div class="col-lg-4">
        @include('admin.bookings.partials.list')
    </div>

    <!-- KANAN -->
    <div class="col-lg-8">
        @include('admin.bookings.partials.detail')
    </div>

</div>

@if($selectedBooking)
<!-- Reschedule Modal -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.bookings.reschedule', $selectedBooking->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Jadwal Ulang Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-4">Silakan pilih tanggal dan waktu baru untuk <strong>{{ $selectedBooking->name }}</strong>.</p>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tanggal Baru</label>
                        <input type="date" name="booking_date" class="form-control" 
                               value="{{ $selectedBooking->booking_date }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Waktu Baru</label>
                        <select name="booking_time" class="form-select" required>
                            @php
                                $slots = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
                            @endphp
                            @foreach($slots as $slot)
                                <option value="{{ $slot }}" {{ $selectedBooking->booking_time == $slot ? 'selected' : '' }}>
                                    {{ $slot }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
