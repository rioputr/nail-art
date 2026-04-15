@extends('layouts.app')
@section('title', 'Jadwal Booking')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    :root {
        --primary-pink: #FF4D8D;
        --hover-pink: #E6457E;
        --light-pink: #fff5f8;
    }
    
    .calendar-container {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .calendar-nav-btn {
        background: transparent;
        border: 1px solid #eee;
        border-radius: 8px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        color: #666;
    }

    .calendar-nav-btn:hover {
        background: #f8f9fa;
        color: var(--primary-pink);
        border-color: var(--primary-pink);
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        text-align: center;
    }

    .calendar-day-header {
        color: #adb5bd;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        padding-bottom: 10px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
    }

    .calendar-day:not(.empty):hover {
        background-color: var(--light-pink);
        color: var(--primary-pink);
    }

    .calendar-day.selected {
        background-color: var(--primary-pink) !important;
        color: white !important;
    }

    .calendar-day.today {
        border: 1px solid var(--primary-pink);
        color: var(--primary-pink);
    }

    .calendar-day.empty {
        background: transparent;
        cursor: default;
    }

    .calendar-day.disabled {
        color: #dee2e6;
        background-color: #f8f9fa;
        cursor: not-allowed;
        pointer-events: none;
    }

    .time-slot-btn {
        width: 100%;
        padding: 10px;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        color: #4f4f4f;
        font-weight: 500;
        transition: all 0.2s;
    }

    .time-slot-btn:hover {
        border-color: var(--primary-pink);
        color: var(--primary-pink);
        background: var(--light-pink);
    }

    .time-slot-btn.selected {
        background-color: var(--primary-pink);
        color: white;
        border-color: var(--primary-pink);
        box-shadow: 0 2px 5px rgba(255, 77, 141, 0.3);
    }

    .time-slot-btn.disabled {
        background-color: #f8f9fa;
        color: #dee2e6;
        cursor: not-allowed;
        border-color: #eee;
        pointer-events: none;
    }

    .summary-label {
        color: #6c757d;
        font-weight: 600;
        font-size: 0.9em;
        margin-bottom: 4px;
    }
    
    .summary-value {
        font-weight: 600;
        color: #212529;
    }

    .total-price {
        color: var(--primary-pink);
        font-size: 1.5rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-pink);
        box-shadow: 0 0 0 0.25rem rgba(255, 77, 141, 0.15);
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-body p-5">
            <h2 class="text-center fw-bold mb-5">Jadwalkan Waktu Anda</h2>

            <form id="bookingForm" action="{{ route('booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_date" id="booking_date">
                <input type="hidden" name="booking_time" id="booking_time">
                <!-- Fallback user id if needed, logic is usually handled in controller via auth -->

                <div class="row g-5 mb-5">
                    <!-- Calendar Section -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-4">Pilih Tanggal</h5>
                        <div class="calendar-container">
                            <div class="calendar-header">
                                <button type="button" class="calendar-nav-btn" id="prevMonth">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <h6 class="mb-0 fw-bold" id="currentMonthYear">December 2025</h6>
                                <button type="button" class="calendar-nav-btn" id="nextMonth">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <div class="calendar-grid" id="calendarGrid">
                                <!-- Calendar Generated by JS -->
                            </div>
                        </div>
                    </div>

                    <!-- Time Slot Section -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-4">Pilih Waktu</h5>
                        <div class="row g-3" id="timeSlotsContainer">
                            <!-- Time Slots Generated by JS -->
                        </div>
                    </div>
                </div>

                <hr class="my-5 opacity-10">

                <!-- Contact & Notes -->
                <h4 class="fw-bold mb-4">Detail Kontak & Catatan</h4>
                @if(count($users) > 0)
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label class="form-label text-muted fw-bold small">Pilih Pelanggan (Hanya Admin)</label>
                        <select class="form-select form-select-lg rounded-3 fs-6" id="selectUser">
                            <option value="">-- Tamu (Guest) --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                        data-name="{{ $user->name }}" 
                                        data-email="{{ $user->email }}" 
                                        data-phone="{{ $user->phone }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="user_id" id="user_id">
                    </div>
                </div>
                @endif

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <label class="form-label text-muted fw-bold small">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" 
                               name="nama" id="inputName" 
                               value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fw-bold small">Email</label>
                        <input type="email" class="form-control form-control-lg rounded-3 fs-6" 
                               name="email" id="inputEmail" 
                               value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fw-bold small">Nomor Telepon</label>
                        <input type="tel" class="form-control form-control-lg rounded-3 fs-6" 
                               name="telepon" id="inputPhone" 
                               value="{{ Auth::check() ? Auth::user()->phone : '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fw-bold small">Jenis Layanan</label>
                        <select class="form-select form-select-lg rounded-3 fs-6" name="layanan" id="inputService" required>
                            <option value="" selected disabled>Pilih Layanan</option>
                            <option value="Basic Manicure" data-price="150000">Basic Pedicure (Rp 150.000)</option>
                            <option value="Gel Polish" data-price="200000">Gel Polish (Rp 200.000)</option>
                            <option value="Nail Art Design" data-price="350000">Nail Art Design (Rp 350.000)</option>
                            <option value="Nail Extensions" data-price="500000">Eyelash Extensions (Rp 500.000)</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted fw-bold small">Catatan Khusus (Opsional)</label>
                        <textarea class="form-control rounded-3" name="catatan" id="inputNotes" rows="4" 
                                  placeholder="Tambahkan catatan atau permintaan khusus..."></textarea>
                    </div>
                </div>

                <hr class="my-5 opacity-10">

                <!-- Summary -->
                <div class="bg-light p-4 rounded-4">
                    <h4 class="fw-bold mb-4">Ringkasan Pemesanan</h4>
                    <div class="row">
                         <div class="col-md-6">
                             <div class="mb-3">
                                 <div class="summary-label">Layanan Terpilih:</div>
                                 <div class="summary-value" id="summaryService">-</div>
                             </div>
                             <div class="mb-3">
                                 <div class="summary-label">Tanggal:</div>
                                 <div class="summary-value" id="summaryDate">-</div>
                             </div>
                             <div class="mb-3">
                                 <div class="summary-label">Waktu:</div>
                                 <div class="summary-value" id="summaryTime">-</div>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="mb-3">
                                 <div class="summary-label">Nama:</div>
                                 <div class="summary-value" id="summaryName">{{ Auth::check() ? Auth::user()->name : '-' }}</div>
                             </div>
                             <div class="mb-3">
                                 <div class="summary-label">Email:</div>
                                 <div class="summary-value" id="summaryEmail">{{ Auth::check() ? Auth::user()->email : '-' }}</div>
                             </div>
                             <div class="mb-3">
                                 <div class="summary-label">Telepon:</div>
                                 <div class="summary-value" id="summaryPhone">{{ Auth::check() ? Auth::user()->phone : '-' }}</div>
                             </div>
                         </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                         <h5 class="fw-bold mb-0">Total Estimasi:</h5>
                         <h4 class="fw-bold total-price mb-0" id="totalPrice">Rp 0</h4>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary-custom btn-lg px-5 py-3 rounded-pill shadow-sm" style="min-width: 250px;">
                        Konfirmasi Pemesanan
                    </button>
                   <!-- <p class="text-muted small mt-3"><i class="fas fa-lock me-1"></i> Data Anda aman & terjaga</p>-->
                </div>

            </form>

             <div class="mt-5 p-4 border rounded-4 bg-white">
                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-info-circle text-primary-custom me-2"></i>Kebijakan Pemesanan</h6>
                <ul class="text-muted small mb-0 ps-3">
                    <li class="mb-1">Pembatalan atau perubahan jadwal harus dilakukan setidaknya 24 jam sebelum waktu janji temu.</li>
                    <li class="mb-1">Keterlambatan lebih dari 15 menit dapat mengakibatkan penjadwalan ulang.</li>
                    <li>Harga dapat berubah tergantung pada kompleksitas request tambahan di lokasi.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // State
    let currentDate = new Date();
    let selectedDate = new Date();
    let selectedTime = null;

    // Elements
    const calendarGrid = document.getElementById('calendarGrid');
    const currentMonthYear = document.getElementById('currentMonthYear');
    const prevBtn = document.getElementById('prevMonth');
    const nextBtn = document.getElementById('nextMonth');
    const timeSlotsContainer = document.getElementById('timeSlotsContainer');
    
    // Inputs
    const dateInput = document.getElementById('booking_date');
    const timeInput = document.getElementById('booking_time');
    
    // Summary Els
    const summaryDate = document.getElementById('summaryDate');
    const summaryTime = document.getElementById('summaryTime');
    const summaryService = document.getElementById('summaryService');
    const totalPrice = document.getElementById('totalPrice');

    // Time Slots Data
    const timeSlots = [
        '09:00', '09:30', '10:00', '10:30',
        '11:00', '11:30', '13:00', '13:30',
        '14:00', '14:30', '15:00', '15:30',
        '16:00', '16:30', '17:00', '17:30'
    ];

    // Render Time Slots
    function renderTimeSlots() {
        timeSlotsContainer.innerHTML = '';
        
        const now = new Date();
        const isToday = selectedDate && 
                        selectedDate.getDate() === now.getDate() && 
                        selectedDate.getMonth() === now.getMonth() && 
                        selectedDate.getFullYear() === now.getFullYear();

        timeSlots.forEach(time => {
            const col = document.createElement('div');
            col.className = 'col-3';
            
            let isDisabled = false;
            
            if (isToday) {
                const [hours, minutes] = time.split(':').map(Number);
                const slotTime = new Date();
                slotTime.setHours(hours, minutes, 0, 0);
                
                // Add a small buffer (e.g., cannot book slot that already started or is within 15 mins)
                // For now, strict comparison
                if (slotTime <= now) {
                    isDisabled = true;
                }
            }
            
            const btn = document.createElement('button');
            btn.type = 'button';
            // If the selected time is now disabled, we should probably deselect it visually, 
            // but for now let's just render the class.
            // If the time was selected but is now disabled (e.g. time passed while on page), current logic keeps 'selected' class but adds 'disabled'.
            // CSS precedence: if disabled has !important or comes last? 
            // Better not to add 'selected' if it matches but is disabled.
            
            const isSelected = selectedTime === time;
            
            let classes = 'time-slot-btn';
            if (isSelected) classes += ' selected';
            if (isDisabled) classes += ' disabled';
            
            btn.className = classes;
            btn.textContent = time;
            
            if (isDisabled) {
                btn.disabled = true;
            } else {
                btn.onclick = () => selectTime(time);
            }
            
            col.appendChild(btn);
            timeSlotsContainer.appendChild(col);
        });
    }

    function selectTime(time) {
        selectedTime = time;
        timeInput.value = time;
        summaryTime.textContent = time;
        renderTimeSlots();
    }

    // Calendar Logic
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Update Header
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        currentMonthYear.textContent = `${monthNames[month]} ${year}`;

        calendarGrid.innerHTML = '';
        
        // Headers
        const days = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
        days.forEach(day => {
            const div = document.createElement('div');
            div.className = 'calendar-day-header';
            div.textContent = day;
            calendarGrid.appendChild(div);
        });

        // Days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Empty slots
        for (let i = 0; i < firstDay; i++) {
            const div = document.createElement('div');
            div.className = 'calendar-day empty';
            calendarGrid.appendChild(div);
        }

        // Day slots
        for (let i = 1; i <= daysInMonth; i++) {
            const div = document.createElement('div');
            div.className = `calendar-day`;
            div.textContent = i;
            
            const dayDate = new Date(year, month, i);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset time part for accurate comparison

            // Check selection
            if (selectedDate && 
                selectedDate.getDate() === i && 
                selectedDate.getMonth() === month && 
                selectedDate.getFullYear() === year) {
                div.classList.add('selected');
            }

            // Check Today
            if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                div.classList.add('today');
            }

            // Disable past dates
            if (dayDate < today) {
                div.classList.add('disabled');
            } else {
                div.onclick = () => selectDate(new Date(year, month, i));
            }

            calendarGrid.appendChild(div);
        }
    }

    function selectDate(date) {
        selectedDate = date;
        // Format YYYY-MM-DD for input
        const offset = date.getTimezoneOffset();
        const localDate = new Date(date.getTime() - (offset*60*1000));
        dateInput.value = localDate.toISOString().split('T')[0];
        
        // Format for summary
        summaryDate.textContent = date.toLocaleDateString('id-ID', { 
            weekday: 'long', 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        });
        
        // Re-render to update selected visuals
        // If changing month logic needed, we might update currentDate here too
        renderCalendar();
        renderTimeSlots(); // Re-check time availability for the new date
    }

    // Navigation
    prevBtn.onclick = () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    };

    nextBtn.onclick = () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    };

    // Live Summary Updates for Inputs
    document.getElementById('inputName').addEventListener('input', (e) => {
        document.getElementById('summaryName').textContent = e.target.value || '-';
    });
    document.getElementById('inputEmail').addEventListener('input', (e) => {
        document.getElementById('summaryEmail').textContent = e.target.value || '-';
    });
    document.getElementById('inputPhone').addEventListener('input', (e) => {
        document.getElementById('summaryPhone').textContent = e.target.value || '-';
    });

    document.getElementById('inputService').addEventListener('change', (e) => {
        const option = e.target.options[e.target.selectedIndex];
        summaryService.textContent = option.text; // value is ID usually, text is name
        
        const price = option.getAttribute('data-price');
        if(price) {
            totalPrice.textContent = 'Rp ' + parseInt(price).toLocaleString('id-ID');
        } else {
            totalPrice.textContent = 'Rp 0';
        }
    });

    // Admin User Selection Logic
    const selectUser = document.getElementById('selectUser');
    if (selectUser) {
        selectUser.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const userId = option.value;
            const name = option.getAttribute('data-name') || '';
            const email = option.getAttribute('data-email') || '';
            const phone = option.getAttribute('data-phone') || '';

            document.getElementById('user_id').value = userId;
            document.getElementById('inputName').value = name;
            document.getElementById('inputEmail').value = email;
            document.getElementById('inputPhone').value = phone;

            // Trigger input events to update summary
            document.getElementById('inputName').dispatchEvent(new Event('input'));
            document.getElementById('inputEmail').dispatchEvent(new Event('input'));
            document.getElementById('inputPhone').dispatchEvent(new Event('input'));
        });
    }

    // Initialize
    renderCalendar();
    renderTimeSlots();
    selectDate(new Date()); // Select today by default
});
</script>
@endsection