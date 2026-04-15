@extends('layouts.app')

@section('title', 'FAQ - Caroline Nail Art')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="fw-bold mb-4 text-primary-custom">Frequently Asked Questions</h1>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            Bagaimana cara memesan jadwal?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Anda dapat memesan jadwal secara langsung melalui menu "Booking" di website kami dengan memilih layanan dan waktu yang tersedia.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            Apakah saya bisa membatalkan booking?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Pembatalan dapat dilakukan melalui profil Anda di menu "Riwayat Booking" paling lambat 24 jam sebelum jadwal.
                        </div>
                    </div>
                </div>
                <!-- Additional FAQs can be added here -->
            </div>
        </div>
    </div>
</div>
@endsection
