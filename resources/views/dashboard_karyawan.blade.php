@extends('layouts.app')

@section('content')
<div class="container-fluid">    
    <!-- profile -->
    <div class="row">
        <div class="col-md-5">
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/media/avatars/150-1.jpg') }}" alt="image" class="rounded-circle me-4" style="width: 100px; height: 100px; object-fit: cover;"/>
                        <div>
                            <span class="fw-bold m-0 mt-3">Selamat Datang,</span>
                            <h2 class="text-bolder">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Edit Profil</span>
                        <i class="bi bi-arrow-right-circle"></i>
                    </div>
                </div>
            </div>
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-body ms-7">
                    <div class="d-flex align-items-center">
                        <span>
                            <i class="bi bi-journal-bookmark-fill" style="font-size: 4.5rem;"></i>
                        </span>
                        <div class="ms-10">
                            <span class="fw-bold m-0 mt-3">Jumlah Work Package</span></br>
                            <span class="text-normal m-0 mt-3">yang dikerjakan</span>
                            <h1 class="text-bolder mt-3">XX</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-header border-bottom py-2">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Work Package yang sedang dikerjakan</h3>
                    </div>
                </div>
                <div class="card-body" style="min-height: 275px;">
                    <div class="tab-pane fade show active" id="kt_timesheet_status" role="tabpanel">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center mb-6 rounded bg-light-warning px-0 py-2">
                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-100px mh-100 me-4 bg-warning"></span>
                            <div class="flex-grow-1">
                                <div class="text-gray-800 fw-semibold fs-5 mb-1">
                                    WP 1.1 Merger & Acquisition (M&A) - Information Security Due Dilligence
                                </div>
                                <div class="text-gray-700 fw-semibold fs-6 mb-7">
                                    27 Februari 2025 - 16 Agustus 2025
                                </div>
                                <div class="text-gray-800 fw-semibold fs-7">
                                    Sudah mengisi Timesheet
                                </div>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">Timesheet</a>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center mb-6 rounded bg-light-primary px-0 py-2">
                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-100px mh-100 me-4 bg-primary"></span>
                            <div class="flex-grow-1">
                                <div class="text-gray-800 fw-semibold fs-5 mb-1">
                                    WP 1.1 Merger & Acquisition (M&A) - Information Security Due Dilligence
                                </div>
                                <div class="text-gray-700 fw-semibold fs-6 mb-7">
                                    27 Februari 2025 - 16 Agustus 2025
                                </div>
                                <div class="text-gray-800 fw-semibold fs-7">
                                    Sudah mengisi Timesheet
                                </div>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">Timesheet</a>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
