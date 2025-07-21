@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-10 mt-2">Performance Task</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-10">
                <a href="{{ route('work-package.detail', ['volume_id' => $volume_id ?? 1]) }}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <h2 class="my-3 mb-3">
                    @if(isset($workPackage))
                        WP {{ $workPackage->wp_number }} {{ $workPackage->name }}
                    @else
                        WP 3.1 Human Security Risk Awareness Program Planning
                    @endif
                </h2>
            </div>
            <div class="justify-content-between row mb-3">
                <div class="row mb-3 align-items-center" style="height: 50px; padding: 0px 10px;">
                    <div class="col-md-4 d-flex align-items-center" style="height: 40px">
                        <div class="border bg-light h-100 d-flex align-items-center justify-content-center w-100">
                            <span class="fw-bold">Total % Complete</span>
                        </div>
                        <div class="border h-100 d-flex align-items-center justify-content-center w-100">
                            <span class="text">{{ $totalCompletion ?? 0 }}%</span>
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

                        @if(isset($tasksWithUtilization) && $tasksWithUtilization->count() > 0)
                            @foreach($tasksWithUtilization as $index => $task)
                                <tr class="task-row">
                                    <td style="cursor:pointer;">
                                        <a class="toggle-collapse" data-bs-toggle="collapse" data-bs-target="#task{{ $task->task_id }}-details" aria-expanded="false" aria-controls="task{{ $task->task_id }}-details">
                                            <i class="bi bi-plus fs-2 me-2 text-dark" id="icon-task{{ $task->task_id }}"></i>
                                        </a>
                                    </td>
                                    <th scope="row" style="width: 70px;">{!! statusLabel($task->status) !!}</th>
                                    <td>{{ $task->name }}</td>
                                    <td></td>
                                    <td>{{ $task->utilization }}%</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots fs-3 text-dark"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end rounded-0">                                        
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                                        <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                        <span>Tambah Sub Baris</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Sub Tasks -->
                                @if($task->subTask->count() > 0)
                                    @foreach($task->subTask as $subTask)
                                        <tr class="collapse deskripsi-row" id="task{{ $task->task_id }}-details">
                                            <td></td>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td>{{ $subTask->name }}</td>
                                            <td>{{ $subTask->completeness }}%</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots fs-3 text-dark"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item d-flex align-items-center deleteConfirmation text-danger">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>Hapus</a>
                                                        </li>
                                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>Tambah Baris di Atas</a>
                                                        </li>
                                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>Tambah Baris di Bawah</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>                                              
                                    @endforeach
                                @else
                                    <tr class="collapse deskripsi-row" id="task{{ $task->task_id }}-details">
                                        <td></td>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td class="text-muted">Tidak ada sub task</td>
                                        <td>0%</td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots fs-3 text-dark"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                                    <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                                        <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>Tambah Sub Task</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <!-- Fallback jika tidak ada data -->
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Tidak ada data task untuk work package ini
                                </td>
                            </tr>
                        @endif
                        <!-- <tr class="task-row">
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
                                            <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                                <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                <span>Tambah Sub Baris</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr> -->
                        <!-- <tr class="collapse deskripsi-row" id="task1-details">
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
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>Edit</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center deleteConfirmation text-danger">
                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>Hapus</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>Tambah Baris di Atas</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>Tambah Baris di Bawah</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr> -->
                        <!-- <tr class="task-row">
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
                                            <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                                <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
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
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>Edit</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center deleteConfirmation text-danger">
                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>Hapus</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>Tambah Baris di Atas</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#subtaskModal">
                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>Tambah Baris di Bawah</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>                                               -->
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

<div class="modal fade" tabindex="-1" id="subtaskModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola Sub Task Personel</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Sub Task</label>
                        <textarea class="form-control" id="taskDescription" rows="3" placeholder="Deskripsi/sub-task"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="utilizationPercentage" class="form-label">Persentase Utilisasi</label>
                        <input type="number" step="0.01" class="form-control" id="utilizationPercentage" placeholder="% Utilisasi">
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
    const saveButton = document.getElementById('saveSuccessful');

    saveButton.addEventListener('click', e => {
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

    // Use event delegation for delete confirmation
    $(document).on('click', '.deleteConfirmation', function(e) {
        e.preventDefault();
        Swal.fire({
            text: "Apakah Anda yakin ingin menghapus data ini?",
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            cancelButtonText: 'batal',
            confirmButtonText: "Hapus",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    text: "Data berhasil dihapus!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        });
    });

    // Initialize the DataTable
    $(document).ready(function() {
        initTabelPerformanceTask();

        // Dynamic toggle icon on collapse for all task details
        @if(isset($tasksWithUtilization) && $tasksWithUtilization->count() > 0)
            @foreach($tasksWithUtilization as $task)
                $('#task{{ $task->task_id }}-details').on('show.bs.collapse', function () {
                    $('#icon-task{{ $task->task_id }}').removeClass('bi-plus').addClass('bi-dash');
                });
                $('#task{{ $task->task_id }}-details').on('hide.bs.collapse', function () {
                    $('#icon-task{{ $task->task_id }}').removeClass('bi-dash').addClass('bi-plus');
                });
            @endforeach
        @endif
    });

    function initTabelPerformanceTask() {
        $('#kt_datatable_example_2').DataTable({
            "scrollY": '400px',
            "scrollX": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "ordering": false, // Disable sorting
            "paging": false
        });
    }
</script>
@endpush

