@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-10 mt-2">Timesheet Activity</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-7">
                <a href="{{route('work-package')}}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <h2 class="my-3 mb-3">WP 3.1 Human Security Risk Awareness Program Planning</h2>
            </div>
            <div class="d-flex align-items-center justify-content-end">                
                <div class="d-flex align-items-center">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6 me-2">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">February</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">March</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">April</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4">May</a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-light btn-sm border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; margin-bottom: 10px;">
                        <i class="bi bi-plus fs-2 text-dark" style="margin-left: 5px"></i>
                    </a>
                </div>                
            </div>
            <div class="d-flex justify-content-start">
                <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCard" aria-expanded="false" aria-controls="filterCard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                    </svg>
                    Filter Data
                </button>
            </div>
            <div class="collapse" id="filterCard">
                <div class="card card-flush shadow-lg mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                            </svg>
                            <div class="m-2">
                            Filter Data
                            </div>
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 25px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label fw-bold">Pekan</label>
                                <select class="form-select form-select-solid" id="kategoriFilter" style="cursor: pointer;   ">
                                    <option value="">Pilih Pekan</option>
                                    <option value="management">Pekan ke-1</option>
                                    <option value="awareness">Pekan ke-2</option>
                                    <option value="training">Pekan ke-3</option>
                                    <option value="assessment">Pekan ke-4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="padding: 15px;">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-danger me-3" id="resetFilter">
                                Hapus Filter
                            </button>
                            <button type="button" class="btn btn-primary" id="applyFilter">
                                Terapkan
                            </button>
                        </div>
                    </div>  
                </div>
            </div>
            <form class="d-flex justify-content-end align-items-center">
                <label class="me-5 mt-3 mb-0" for="searchTask">Cari: </label>
                <input class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary mt-3" style="width:200px" type="search" placeholder="Cari Data" aria-label="Search">                    
            </form>
            <div class="table-responsive">
                <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                    <thead>
                        <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                            <th scope="col" style="width: 40px;">No</th>
                            <th scope="col" style="width: 70px; min-width: 40px;">Tanggal</th>
                            <th scope="col" style="width: 80px;">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Project Manager">Oki</span>
                            </th>
                            <th scope="col" style="width: 80px;">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Senior Consultant">Restia</span>
                            </th>
                            <th scope="col" style="width: 80px;">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Associate Consultant">Yudis</span>
                            </th>
                            <th scope="col" style="width: 80px;">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Junior Consultant">Annisa</span>
                            </th>
                            <th scope="col" style="width: 80px;">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Technical Writer">Vanika</span>
                            </th>
                            <th scope="col" style="width: 30px;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        <tr>
                            <th scope="row">1</th>
                            <td>14</td>
                            <td>Eu minim eiusmod eiusmod ex velit exercitation occaecat do.</td>
                            <td>Ullamco nulla occaecat incididunt nulla.</td>
                            <td>Ullamco nulla occaecat incididunt nulla.</td>
                            <td>Ullamco nulla occaecat incididunt nulla.</td>
                            <td>Ullamco nulla occaecat incididunt nulla.</td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots fs-3 text-dark"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <i class="bi bi-pencil ms-1 me-3 text-dark"></i>Edit</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <i class="bi bi-trash ms-1 me-3 text-dark"></i>Hapus</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <i class="bi bi-plus fs-2 me-1 text-dark"></i>Tambah Baris di Atas</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <i class="bi bi-plus fs-2 me-1 text-dark"></i>Tambah Baris di Bawah</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>            
                    </tbody>
                </table>
            </div> 
            {{-- <ul class="pagination justify-content-end">
                <li class="page-item previous"><a href="#" class="page-link"><i class="previous"></i></a></li>
                <li class="page-item active"><a href="#" class="page-link">1</a></li>
                <li class="page-item "><a href="#" class="page-link">2</a></li>
                <li class="page-item "><a href="#" class="page-link">3</a></li>
                <li class="page-item "><a href="#" class="page-link">...</a></li>
                <li class="page-item "><a href="#" class="page-link">5</a></li>
                <li class="page-item "><a href="#" class="page-link">6</a></li>
                <li class="page-item next"><a href="#"  class="page-link"><i class="next"></i></a></li>
            </ul> --}}
            <div class="col-md-6" style="width: 50%; min-width: 350px;">
                <button class="btn btn-link px-0 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#mandaysSummaryTable" aria-expanded="false" aria-controls="mandaysSummaryTable" style="font-weight:600; text-decoration:none; color:#3b3b3b;">
                    <i class="bi bi-chevron-down me-2"></i>Lihat Ringkasan Mandays
                </button>
                <div class="collapse" id="mandaysSummaryTable">
                    <table class="table border bordered-gray-300 table-row-bordered table-sm table-row-gray-300 gs-3">
                        <thead>
                            <tr>
                                <th scope="col" colspan="3" class="text-center bg-light">Total Mandays Sementara</th>
                            </tr>
                            <tr>
                                <th scope="col" rowspan="2" class="align-middle">Roles</th>
                                <th scope="col" colspan="2" class="text-center align-middle">Mandays</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Rencana</th>
                                <th class="text-center align-middle">Realisasi</th>                            
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle">Project Manager</td>
                                <td class="text-center align-middle" style="color:gray">10</td>
                                <td class="text-center align-middle">{!! mandaysLabel(10, 4) !!}</td>
                            </tr>
                            <tr>
                                <td class="align-middle">Senior Consultant</td>
                                <td class="text-center align-middle" style="color:gray">10</td>
                                <td class="text-center align-middle">{!! mandaysLabel(10, 4) !!}</td>
                            </tr>
                            <tr>
                                <td class="align-middle">Associate Consultant</td>
                                <td class="text-center align-middle" style="color:gray">10</td>
                                <td class="text-center align-middle">{!! mandaysLabel(10, 4) !!}</td>
                            </tr>
                            <tr>
                                <td class="align-middle">Junior Consultant</td>
                                <td class="text-center align-middle" style="color:gray">10</td>
                                <td class="text-center align-middle">{!! mandaysLabel(10, 4) !!}</td>
                            </tr>
                            <tr>
                                <td class="align-middle">Technical Writer</td>
                                <td class="text-center align-middle" style="color:gray">10</td>
                                <td class="text-center align-middle">{!! mandaysLabel(10, 20) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection

<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Deskripsi Task Personel</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="taskDescription" rows="3" placeholder="Deskripsi/sub-task"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="utilizationPercentage" class="form-label">Persentase Utilisasi</label>
                        <input type="number" step="0.01" class="form-control" id="utilizationPercentage" placeholder="% Utilisasi">
                    </div>
                    <div class="mb-3">
                        <label for="taskDate" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="taskDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light rounded-0" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-0" id="saveSuccessful">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const button = document.getElementById('saveSuccessful');

    button.addEventListener('click', e => {
        e.preventDefault();

        Swal.fire({
            text: "Data berhasil disimpan!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
    });

     // Initialize the DataTable
    $(document).ready(function() {
        initTabelTimesheet();
    });

    function initTabelTimesheet() {
        $('#kt_datatable_example_2').DataTable({
            // "scrollY": '500px',
            "scrollX": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "ordering": false // Disable sorting
        });
    }

    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@php
    function mandaysLabel($plan, $realization) {
        $bg = ($realization >= $plan) ? '#dc3545' : 'transparent';
        $color = ($realization >= $plan) ? 'white' : 'black';
        return '<span class="d-inline-block px-3 py-1 text-center" style="border-radius:8px; background:' . $bg . '; color:' . $color . '; min-width:40px; min-height:24px;">' . $realization . '</span>';
    }
@endphp
