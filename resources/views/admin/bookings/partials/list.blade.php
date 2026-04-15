<div class="card">
    <div class="card-body">

        <input type="text" id="bookingSearch" class="form-control mb-3"
               placeholder="Cari pemesanan...">

        <div id="bookingList">
            @foreach($bookings as $booking)
            <a href="{{ route('admin.bookings.index', ['id' => $booking->id]) }}" 
               class="text-decoration-none text-dark d-block mb-3 booking-card"
               data-name="{{ strtolower($booking->name) }}"
               data-service="{{ strtolower($booking->service_details) }}">
                <div class="booking-item p-3 border rounded transition-all-2
                    {{ (isset($selectedBooking) && $selectedBooking->id == $booking->id) ? 'border-primary bg-light-primary shadow-sm' : '' }}">
        
                    <h6 class="fw-bold mb-1">{{ $booking->name }}</h6>
                    <div class="small text-secondary mb-1">{{ $booking->service_details }}</div>
        
                    <div class="d-flex justify-content-between align-items-end">
                        <small class="text-muted">
                            {{ $booking->booking_date }} • {{ $booking->booking_time }}
                        </small>
        
                        <span class="badge 
                            {{ $booking->status == 'confirmed' ? 'bg-success' : ($booking->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <script>
            document.getElementById('bookingSearch').addEventListener('keyup', function() {
                let searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.booking-card').forEach(card => {
                    let name = card.getAttribute('data-name');
                    let service = card.getAttribute('data-service');
                    if (name.includes(searchTerm) || service.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        </script>

    </div>
</div>
