@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-10 animate-fade-in">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="fw-bold mb-0"><i class="bi bi-building me-2"></i>Profil MI Infarul Ghoyyi</h2>
                </div>
                <div class="card-body p-5">
                    <div class="row align-items-center mb-5">
                        <div class="col-md-5 mb-4 mb-md-0 text-center">
                            <div class="p-4 bg-light rounded-circle d-inline-block">
                                <i class="bi bi-mortarboard-fill text-primary" style="font-size: 8rem;"></i>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h4 class="fw-bold text-dark mb-3">Sejarah & Latar Belakang</h4>
                            <p class="text-secondary" style="line-height: 1.8;">
                                Madrasah Ibtidaiyah (MI) Infarul Ghoyyi Kalijambe adalah lembaga pendidikan tingkat dasar
                                yang bercirikan agama Islam. Kami berkomitmen untuk menyelenggarakan pendidikan dasar yang
                                tidak hanya mengedepankan prestasi akademik, namun juga membentuk karakter peserta didik
                                yang beriman, bertaqwa, dan berakhlakul karimah.
                            </p>
                        </div>
                    </div>

                    <hr class="my-5 opacity-25">

                    <h4 class="fw-bold text-center mb-4">Fasilitas Sekolah</h4>
                    <div class="row g-4 text-center">
                        <div class="col-md-3 col-6">
                            <div class="p-4 border rounded bg-light card-hover h-100">
                                <i class="bi bi-book fs-1 text-primary mb-3"></i>
                                <h6 class="fw-bold mt-2">Perpustakaan</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-4 border rounded bg-light card-hover h-100">
                                <i class="bi bi-moon-stars fs-1 text-success mb-3"></i>
                                <h6 class="fw-bold mt-2">Mushola</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-4 border rounded bg-light card-hover h-100">
                                <i class="bi bi-dribbble fs-1 text-warning mb-3"></i>
                                <h6 class="fw-bold mt-2">Lapangan Olahraga</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-4 border rounded bg-light card-hover h-100">
                                <i class="bi bi-heart-pulse fs-1 text-danger mb-3"></i>
                                <h6 class="fw-bold mt-2">UKS</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
