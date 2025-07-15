@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-10 mt-2">Performance Task</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-10">
                <a href="#" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <h2 class="my-3 mb-3">WP 3.1 Human Security Risk Awareness Program Planning</h2>
            </div>
            <div class="justify-content-between row mb-3">
                <div class="row mb-3 align-items-center" style="height: 50px; padding: 0px 10px;">
                    <div class="col-md-4 d-flex align-items-center" style="height: 40px">
                        <div class="border bg-light h-100 d-flex align-items-center justify-content-center w-100">
                            <span class="fw-bold">Total % Complete</span>
                        </div>
                        <div class="border h-100 d-flex align-items-center justify-content-center w-100">
                            <span class="text">23.44%</span>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <form class="d-flex align-items-center mb-0">
                            <label class="me-3" for="searchTask">Cari: </label>
                            <input class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" style="width:200px" type="search" placeholder="Cari Data" aria-label="Search">
                        </form>
                    </div>
                </div> 
            </div>
            <div class="table-responsive">
                <table class="table border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                    <thead>
                        <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                            <th scope="col" style="width: 20px;"></th>
                            <th scope="col" style="width: 70px;">Status</th>
                            <th scope="col" style="width: 170px;">Task</th>
                            <th scope="col" style="width: 170px;">Sub Task</th>
                            <th scope="col" style="width: 90px;">% Utilisasi</th>
                            <th scope="col" style="width: 50px;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @php
                            function statusLabel($status) {
                                $status = strtolower($status);
                                if ($status === 'open') {
                                    return '<span class="d-inline-block text-white px-3 py-1" style="border-radius:8px; background:#48c837; min-width:60px; min-height:24px; text-align:center;">Open</span>';
                                } elseif ($status === 'closed') {
                                    return '<span class="d-inline-block text-white px-3 py-1" style="border-radius:8px; background:#6c757d; min-width:60px; min-height:24px; text-align:center;">Closed</span>';
                                } else {
                                    return '<span class="d-inline-block px-3 py-1" style="border-radius:8px; background:#adb5bd; min-width:60px; min-height:24px; text-align:center;">' . ucfirst($status) . '</span>';
                                }
                            }
                        @endphp
                        <tr class="task-row">
                            <td style="cursor:pointer;">
                                <a class="toggle-collapse" data-bs-toggle="collapse" data-bs-target="#task1-details" aria-expanded="false" aria-controls="task1-details">
                                    <i class="bi bi-plus fs-2 me-2 text-dark" id="icon-task1"></i>
                                </a>
                            </td>
                            <th scope="row" style="width: 70px;">{!! statusLabel('Closed') !!}</th>
                            <td>Officia cupidatat proident ullamco reprehenderit ex deserunt cupidatat deserunt dolore irure anim exercitation et qui.</td>
                            <td></td>
                            <td>100.00%</td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots fs-3 text-dark"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end rounded-0">                                        
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                                <i class="bi bi-plus fs-2 me-2 text-dark"></i>
                                                <span>Tambah Sub Baris</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="collapse deskripsi-row" id="task1-details">
                            <td></td>
                            <th scope="row"></th>
                            <td></td>
                            <td>Deskripsi untuk task 1.</td>
                            <td>100.00%</td>
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
                        <tr class="task-row">
                            <td style="cursor:pointer;">
                                <a class="toggle-collapse" data-bs-toggle="collapse" data-bs-target="#task2-details" aria-expanded="false" aria-controls="task2-details">
                                    <i class="bi bi-plus fs-2 me-2 text-dark" id="icon-task2"></i>
                                </a>
                            </td>
                            <th scope="row" style="width: 70px;">{!! statusLabel('Open') !!}</th>
                            <td>Officia cupidatat proident ullamco reprehenderit ex deserunt cupidatat deserunt dolore irure anim exercitation et qui.</td>
                            <td></td>
                            <td>0%</td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots fs-3 text-dark"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end rounded-0">                                        
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                                <i class="bi bi-plus fs-2 me-2 text-dark"></i>
                                                <span>Tambah Sub Baris</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="collapse deskripsi-row" id="task2-details">
                            <td></td>
                            <th scope="row"></th>
                            <td></td>
                            <td>Deskripsi untuk task 2.</td>
                            <td>0%</td>
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
        </div>
    </div>
</div>
@endsection

<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Deskripsi Task Personel</h3>

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
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveSuccessful">Simpan</button>
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
        initTabelPerformanceTask();
        // Toggle icon on collapse show/hide for multiple rows
        $('#task1-details').on('show.bs.collapse', function () {
            $('#icon-task1').removeClass('bi-plus').addClass('bi-dash');
        });
        $('#task1-details').on('hide.bs.collapse', function () {
            $('#icon-task1').removeClass('bi-dash').addClass('bi-plus');
        });
        $('#task2-details').on('show.bs.collapse', function () {
            $('#icon-task2').removeClass('bi-plus').addClass('bi-dash');
        });
        $('#task2-details').on('hide.bs.collapse', function () {
            $('#icon-task2').removeClass('bi-dash').addClass('bi-plus');
        });
    });

    function initTabelPerformanceTask() {
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
</script>
@endpush

