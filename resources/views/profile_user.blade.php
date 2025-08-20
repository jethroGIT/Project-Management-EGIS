@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card card-flush mb-6">
        <div class="card-body shadow py-5">
            <!--begin::Toolbar-->
            <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
                <div class="page-title d-flex flex-column me-3">
                    <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Account Overview</h1>
                    <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li class="breadcrumb-item text-gray-600">
                            <a href="{{ url('/') }}" class="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item text-gray-600">Account</li>
                        <li class="breadcrumb-item text-gray-500">Overview</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center py-2 py-md-1">
                    <a href="#" class="btn btn-light fw-bolder me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                            <!-- SVG icon here -->
                        </span>
                        Filter
                    </a>
                    <a href="#" class="btn btn-dark fw-bolder" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">Create</a>
                </div>
            </div>
            <!--end::Toolbar-->

            <!--begin::Profile Card-->
            <div class="card mb-5 mb-xl-10">
                <div class="card-body shadow-sm pt-9 pb-0">
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ asset('assets/media/avatars/150-26.jpg') }}" alt="image" />
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">Max Smith</a>
                                        <a href="#" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">Upgrade to Pro</a>
                                    </div>
                                    <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">Developer</a>
                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">SF, Bay Area</a>
                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">max@kt.com</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap flex-stack">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <div class="d-flex flex-wrap">
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">Earnings</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="75">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">Projects</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">Success Rate</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Profile Card-->
            <!--begin::Profile Details-->
            <div class="card shadow-sm mb-5 mb-xl-10" id="kt_profile_details_view">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Profile Details</h3>
                    </div>
                    <a href="#" class="btn btn-primary align-self-center">Edit Profile</a>
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Full Name</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800">Max Smith</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Company</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fw-bold text-gray-800 fs-6">Keenthemes</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Contact Phone
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
                        </label>
                        <div class="col-lg-8 d-flex align-items-center">
                            <span class="fw-bolder fs-6 text-gray-800 me-2">044 3276 454 935</span>
                            <span class="badge badge-success">Verified</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Company Site</label>
                        <div class="col-lg-8">
                            <a href="#" class="fw-bold fs-6 text-gray-800 text-hover-primary">keenthemes.com</a>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Country
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i>
                        </label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800">Germany</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Communication</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800">Email, Phone</span>
                        </div>
                    </div>
                    <div class="row mb-10">
                        <label class="col-lg-4 fw-bold text-muted">Allow Changes</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">Yes</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Profile Details-->
        </div>
    </div>
</div>
@endsection
<!--end::Main-->
@push('scripts')
<script></script>
@endpush