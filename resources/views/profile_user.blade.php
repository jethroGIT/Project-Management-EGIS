@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card card-flush mb-6">
        <div class="card-body shadow py-5 pb-1">
            <!--begin::Toolbar-->
            <div class="toolbar mb-5 mb-lg-5" id="kt_toolbar">
                <div class="page-title d-flex flex-column me-3">
                    <h1 class="d-flex text-dark fw-bolder my-1 fs-3">User Profile</h1>
                </div>
            </div>
            <!--end::Toolbar-->

            <!--begin::Profile Card-->
            <div class="card mb-5 mb-xl-6">
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
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{auth()->user()->name ?? '-'}}</a>
                                        @php
                                            $roles = auth()->user()->getRoleNames();
                                        @endphp
                                        <a href="#" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">{{$roles->get(1) ?? $roles->first() ?? '-'}}</a>
                                    </div>
                                    <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">{{auth()->user()->email}}</a>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->hasRole('admin'))
                            <div class="d-flex flex-wrap flex-stack">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <div class="d-flex flex-wrap">
                                        <div class="border border-gray-300 border-dashed rounded min-w-100px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{$workPackagesCount}}">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">Work Packages</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="d-flex flex-wrap flex-stack">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <div class="d-flex flex-wrap">
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{$resourceCost}}" data-kt-countup-prefix="Rp">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">Biaya Tenaga Kerja</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-100px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{$workPackagesUserCount}}">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">WP Volume</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Profile Card-->
            <!--begin::Profile Details-->
            <div class="card shadow-sm mb-5 mb-xl-10" id="kt_profile_details_view">
                <div class="card-header">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Profile Details</h3>
                    </div>
                    <button type="button" class="btn btn-primary mt-4 mb-4 px-4" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_profile">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </button>
                </div>
                <div class="card-body p-9 pb-2">
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Full Name</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800">{{auth()->user()->name}}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Email</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800">{{auth()->user()->email}}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Role</label>
                        <div class="col-lg-8">
                            @php
                                $roles = auth()->user()->getRoleNames();
                                $role0 = $roles->get(0);
                                $role1 = $roles->get(1);
                            @endphp
                            <span class="fw-bold fs-6 text-gray-800">
                                @if($role1)
                                    {{ $role1 }} ({{ $role0 }})
                                @elseif($role0)
                                    {{ $role0 }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Company</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fw-bold text-gray-800 fs-6">PT LAPI Divusi</span>
                        </div>
                    </div>
                    {{-- <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Contact Phone
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
                        </label>
                        <div class="col-lg-8 d-flex align-items-center">
                            <span class="fw-bolder fs-6 text-gray-800 me-2">044 3276 454 935</span>
                            <span class="badge badge-success">Verified</span>
                        </div>
                    </div> --}}
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Company Site</label>
                        <div class="col-lg-8">
                            <a href="#" class="fw-bold fs-6 text-gray-800 text-hover-primary">divusi.com</a>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Country
                            {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i> --}}
                        </label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">Indonesia</span>
                        </div>
                    </div>
                    {{-- <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Communication</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800">Email, Phone</span>
                        </div>
                    </div> --}}
                    {{-- <div class="row mb-10">
                        <label class="col-lg-4 fw-bold text-muted">Allow Changes</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">Yes</span>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!--end::Profile Details-->
        </div>
    </div>
</div>
@endsection
<!--end::Main-->

<div class="modal fade" tabindex="-1" id="kt_modal_edit_profile">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Profil</h3>
            </div>

            <div class="modal-body">
                <form id="editProfileForm" method="POST" action="{{ route('profile.edit', auth()->user()->user_id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" id="editFullName" class="form-control" value="{{auth()->user()->name}}"/>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" value="{{auth()->user()->email}}"/>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" id="editPassword" class="form-control" minlength="8" placeholder="minimal 8 karakter"/>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitEditProfile()">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function submitEditProfile() {
        const form = document.getElementById('editProfileForm');
        const passwordInput = document.getElementById('editPassword');
        const passwordValue = passwordInput.value;
        const formData = new FormData(form);
        const url = form.action;

        if (passwordValue && passwordValue.length < 8) {
            Swal.fire({
                text: "Password minimal 8 karakter.",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: { confirmButton: "btn btn-danger" }
            });
            passwordInput.focus();
            return;
        }

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Terjadi kesalahan saat memproses permintaan.');
                });
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                text: data.message || "Data berhasil diubah!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-secondary" }
            }).then(() => {
                // Tutup modal dengan Bootstrap Modal API
                const modalEl = document.getElementById('kt_modal_edit_profile');
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalInstance.hide();
                // Reload setelah modal benar-benar tertutup
                modalEl.addEventListener('hidden.bs.modal', function handler() {
                    location.reload();
                    modalEl.removeEventListener('hidden.bs.modal', handler);
                });
            });
        })
        .catch(error => {
            Swal.fire({
                text: error.message || "Terjadi kesalahan yang tidak terduga.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: { confirmButton: "btn btn-danger" }
            });
        });
    }
</script>
@endpush