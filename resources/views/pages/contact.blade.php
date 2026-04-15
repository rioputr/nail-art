@extends('layouts.app')

@section('title', 'Contact Us - Caroline Nail Art')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="fw-bold mb-4 text-primary-custom">Contact Us</h1>
            <div class="card border-0 shadow-sm p-4 rounded-4">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5 class="fw-bold mb-3">Informasi Kontak</h5>
                        <p><i class="bi bi-geo-alt me-2 text-primary-custom"></i> Jl. Kecantikan No. 123, Jakarta</p>
                        <p><i class="bi bi-envelope me-2 text-primary-custom"></i> halo@carolinenailart.com</p>
                        <p><i class="bi bi-whatsapp me-2 text-primary-custom"></i> +62 812 3456 7890</p>
                    </div>
                    <div class="col-md-6">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" placeholder="Nama Lengkap">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Email Anda">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pesan</label>
                                <textarea class="form-control" rows="4" placeholder="Apa yang bisa kami bantu?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
