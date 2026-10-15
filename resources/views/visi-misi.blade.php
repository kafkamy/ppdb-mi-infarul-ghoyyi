@extends('layouts.app')

@section('title', 'Visi & Misi')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8 animate-fade-in">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-success text-white text-center py-4">
                    <h2 class="fw-bold mb-0"><i class="bi bi-book me-2"></i>Visi & Misi</h2>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <h3 class="fw-bold text-primary mb-4 border-bottom pb-2 d-inline-block">Visi</h3>
                        <p class="fs-5 fw-medium fst-italic text-secondary">
                            "TERWUJUDNYA GENERASI ISLAM YANG TEKUN BERIBADAH, BERAKHLAK KARIMAH, KREATIF DAN MANDIRI"
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="fw-bold text-success mb-4 border-bottom pb-2 d-inline-block">Misi</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent py-3 border-0 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <span class="fs-6">Menyelenggarakan pendidikan yang berkualitas dalam pencapaian prestasi
                                    akademik dan non akademik.</span>
                            </li>
                            <li class="list-group-item bg-transparent py-3 border-0 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <span class="fs-6">Mewujudkan pembelajaran dan pembiasaan dalam mempelajari Alqur'an dan
                                    menjalankan ajaran agama islam.</span>
                            </li>
                            <li class="list-group-item bg-transparent py-3 border-0 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <span class="fs-6">Mejudkan pembentukan karakter islami yang mampu mengaktualisasikan diri
                                    dalam masyarakat.</span>
                            </li>
                            <li class="list-group-item bg-transparent py-3 border-0 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <span class="fs-6">menyelenggarakan tata kelola madrasah yang efektif, efisien,
                                    transparan, dan akuntabel</span>
                            </li>
                            <li class="list-group-item bg-transparent py-3 border-0 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <span class="fs-6">mengembangkan kegiatan kewirausahaan yang bernilai ekonomis.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
