@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Work Package</h1>

    <!-- Title Section -->
    <div class="d-flex justify-content-between align-items-center mt-0 mb-5">
        @if(isset($workPackage) && isset($volume))
            <div>
                <h4 class="">WP {{ $workPackage->wp_number }} {{ $workPackage->name }}</h4>
                <p>Periode 
                    @if(isset($volume->start_date) && ($volume->end_date))
                        {{ \Carbon\Carbon::parse($volume->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($volume->end_date)->format('d M Y') }}
                    @else
                        Belum Tersedia
                    @endif
                </p>
            </div>
        @endif
        <div class="">
            <a href="{{ $backUrl ?? route('wp-management') }}" class="btn btn-light me-2">
                <i class="bi bi-arrow-left"></i> {{ $backText ?? 'Kembali' }}
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_data">
                <i class="bi bi-pencil-square"></i> Edit Data
            </button>
        </div>
    </div>

    <!-- Card Kuantitas -->
    <div class="card card-flush shadow-sm mb-8">
        <div class="card-header py-0">
            <h3 class="card-title">Kuantitas</h3>
        </div>
        <div class="card-body py-0">
            <div class="mb-6">
                <div class="row">
                    <!-- Duration Section -->
                    <div class="col-md-4">
                        <div class="card card-flush shadow-sm mb-4 duration-card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Duration</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-center h-100 gap-2 mb-3">
                                    @if(isset($workPackage) && isset($volume))
                                        <span class="fs-1 fw-bold text-primary duration-highlight">{{ $workPackage->duration }}</span>
                                        <span class="fs-1 text-primary duration-highlight">Hari</span>
                                    @else
                                        <span class="fs-1 fw-bold text-primary duration-highlight">0</span>
                                        <span class="fs-1 text-primary duration-highlight">Hari</span>                                            
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Finance Performance -->
                    <div class="col-md-4">
                        <div class="card card-flush shadow-sm mb-4 performance-card position-relative overlay-performance-card" onclick="window.location.href='{{ route('performance-finance.detail', ['volume_id' => $volume_id ?? 1]) }}'" style="transition: box-shadow 0.2s, border-color 0.2s, background 0.2s; cursor:pointer;">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Finance Performance</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-center h-100 mb-3">
                                    <span class="fs-1 fw-bold text-success">{{ number_format($realizationPercentage ?? 0, 0)}} %</span>
                                </div>
                            </div>
                            <!-- Overlay -->
                            <div class="performance-overlay d-flex align-items-center justify-content-center">
                                <span class="text-white fs-4 fw-bold">lihat detail &rarr;</span>
                            </div>
                        </div>
                    </div>

                    <!-- WP Performance -->
                    <div class="col-md-4">
                        <div class="card card-flush shadow-sm mb-4 performance-card position-relative overlay-performance-card" onclick="window.location.href='{{ route('performance-task.detail', ['volume_id' => $volume_id ?? 1]) }}'" style="transition: box-shadow 0.2s, border-color 0.2s, background 0.2s; cursor:pointer;">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">WP Performance</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-center h-100 mb-3">
                                    <span class="fs-1 fw-bold text-info">{{ $totalCompletion ?? 0 }} %</span>
                                </div>
                            </div>
                            <!-- Overlay -->
                            <div class="performance-overlay d-flex align-items-center justify-content-center">
                                <span class="text-white fs-4 fw-bold">lihat detail &rarr;</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                    </div> --}}

                    <!-- Timesheet Button -->
                    <div class="d-flex justify-content-end mb-4">
                        @if(auth()->user()->hasRole('admin'))
                            <button type="button" class="btn btn-light-primary" onclick="window.location.href='{{ route('timesheet.detail', $volume->volume_id) }}'">
                                Timesheet
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </button>
                        @else
                            <button type="button" class="btn btn-light-primary" onclick="window.location.href='{{ route('timesheet.detail.user', [$volume->volume_id, auth()->user()->user_id]) }}'">
                                Timesheet
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Task List -->
    <div class="card card-flush shadow-sm mb-8">
        <div class="card-header py-0">
            <h3 class="card-title">Task List</h3>
        </div>
        <div class="card-body py-0">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-light-primary mb-3" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task" aria-expanded="false" aria-controls="filterCard" style="padding: 8px 12px">
                     <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-plus mb-1 me-2" viewBox="0 0 15 15">
                        <path d="M8 4a.5.5 0 0 1 .5.5V7.5H11.5a.5.5 0 0 1 0 1H8.5V11.5a.5.5 0 0 1-1 0V8.5H4.5a.5.5 0 0 1 0-1H7.5V4.5A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Tambah Task
                </button>
                <form class="d-flex justify-content-end" onsubmit="return false;">
                    <label class="me-5 mt-3" for="searchTaskInput">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search"
                        id="searchTaskInput" 
                        placeholder="Cari Task" 
                        aria-label="Search"
                    >                    
                </form>
            </div>

            <!-- Task List Section -->
            <div class="mb-4">
                <table id="tabel_wp_task" class="table gy-4 gs-3 border rounded w-100">
                    <thead>
                        <tr class="fw-bolder fs-4 text-gray-1000 px-7">
                            <th></th>
                            <th class="align-middle border-bottom" style="width: 20px;">No</th>
                            <th class="align-middle border-bottom" style="width: 300px;">Task</th>
                            <th class="align-middle border-bottom" style="width: 300px;">Sub Task</th>
                            <th class="align-middle border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @if(isset($tasksWithUtilization) && $tasksWithUtilization->count() > 0)
                            @foreach($tasksWithUtilization as $index => $task)
                                <tr class="align-middle">
                                    <td style="cursor:pointer;">
                                        <a class="toggle-collapse" data-bs-toggle="collapse" data-bs-target="#task{{ $task->task_id }}-details" aria-expanded="false" aria-controls="task{{ $task->task_id }}-details">
                                            <i class="bi bi-plus fs-2 me-2 text-dark" id="icon-task{{ $task->task_id }}"></i>
                                        </a>
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                    <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="editTask({{ $task->task_id }})">
                                                        <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask({{ $task->task_id }}, '{{ addslashes($task->name) }}')">
                                                        <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                        Hapus
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                {{-- <li>
                                                    <!-- data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task" -->
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onClick="insertTaskAbove({{ $task->task_id }}, '{{ $task->name }}')">
                                                        <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                        Masukkan di Atas
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onClick="insertTaskBelow({{ $task->task_id }}, '{{ $task->name }}')">
                                                        <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                        Masukkan di Bawah
                                                    </a>
                                                </li> --}}
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onClick="insertSubTask({{ $task->task_id }}, '{{ addslashes($task->name) }}')">
                                                        <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                        <span>Tambah Sub Task</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @if($task->subTask->count() > 0)
                                    @foreach($task->subTask as $subTask)
                                        <tr class="collapse deskripsi-row" id="task{{ $task->task_id }}-details" data-sub-task-id="{{ $subTask->sub_task_id }}">
                                            <td></td>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td>{{ $subTask->name }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots fs-3 text-dark"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center" href="#" onClick="editSubTask({{ $subTask->sub_task_id }})">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center text-danger" href="#" onClick="deleteSubTaskConfirmation({{ $subTask->sub_task_id }}, '{{ addslashes($subTask->name) }}')">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>Hapus</a>
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
                                        <td></td>
                                    </tr>
                                @endif
                            @endforeach
                        {{-- @else
                            <!-- Fallback jika tidak ada data -->
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-center text-muted">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <h6 class="text-muted">Belum Ada Task</h6>
                                        <p class="text-muted">
                                            Tidak ada data task untuk work package ini
                                        </p>
                                        <button type="button" class="btn btn-light-primary d-flex align-items-center" onclick="insertFirstTask()">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Tambah Task
                                        </button>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif --}}
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal for Adding Task -->
    <div class="modal fade" tabindex="-1" id="kt_modal_insert_task">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="insertTaskModalTitle">Tambah Task</h3>
                </div>
                <div class="modal-body">
                    <form id="insertTaskForm" method="POST" action="{{ route('work-package.task.store') }}">
                        @csrf
                        <input type="hidden" name="volume_id" value="{{ $volume_id }}" id="modalVolumeId">
                        {{-- <input type="hidden" name="reference_task_id" id="referenceTaskId" value="">
                        <input type="hidden" name="insert_position" id="insertPosition" value=""> --}}
                        
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Nama Task</label>
                            <input type="text" name="task_name" class="form-control" placeholder="Masukkan Nama Task" required/>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onClick="submitInsertTask()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Sub Task -->
    <div class="modal fade" tabindex="-1" id="kt_modal_insert_subtask">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header flex-column align-items-start pb-1">
                    <h3 class="modal-title" id="insertSubTaskModalTitle">Tambah Sub Task</h3>
                    <p id="insertSubTaskModalSubTitle">Task</p>
                </div>
                <div class="modal-body">
                    <form id="insertSubTaskForm" method="POST" action="{{ route('work-package.subtask.store') }}">
                        {{-- action="{{ route('work-package.subtask.store') }}" --}}
                        @csrf
                        <input type="hidden" name="task_id" id="modalTaskId" value="">
                        {{-- <input type="hidden" name="volume_id" value="{{ $volume_id }}" id="modalSubTaskVolumeId"> --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Nama Sub Task</label>
                            <input type="text" name="subtask_name" class="form-control" placeholder="Masukkan Nama Sub Task" required/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onClick="submitInsertSubTask()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Task -->
    <div class="modal fade" tabindex="-1" id="kt_modal_edit_task">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="editTaskModalTitle">Edit Task</h3>
                </div>

                <div class="modal-body">
                    <form id="editTaskForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="task_id" id="editTaskId" value="">
                        <input type="hidden" name="volume_id" value="{{ $volume_id ?? '' }}" id="editModalVolumeId">

                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Nama Task</label>
                            <input 
                                type="text" 
                                name="task_name" 
                                id="editTaskName" 
                                class="form-control" 
                                placeholder="Masukkan Nama Task" 
                                required 
                                maxlength="255" />
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitEditTask()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Sub Task -->
    <div class="modal fade" tabindex="-1" id="kt_modal_edit_subtask">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header flex-column align-items-start pb-1">
                    <h3 class="modal-title" id="editSubTaskModalTitle">Edit Sub Task</h3>
                </div>
                <div class="modal-body">
                    <form id="editSubTaskForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="sub_task_id" id="editSubTaskId" value="">
                        <input type="hidden" name="task_id" id="editSubTaskParentTaskId" value="">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Task</label>
                            <input type="text" id="editSubTaskTaskName" class="form-control bg-light" readonly>
                            <div class="form-text text-muted">Task induk untuk sub task ini</div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Nama Sub Task</label>
                            <textarea name="name" id="editSubTaskName" class="form-control" placeholder="Masukkan Nama Sub Task" rows="3" required maxlength="255"></textarea>
                            <div class="form-text text-muted">Deskripsi detail dari sub task (maksimal 255 karakter)</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitEditSubTask()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-flush shadow mb-6">
        <div class="card-header py-0">
            <h3 class="card-title">
                Detail Informasi
            </h3>
        </div>
        <div class="card-body py-0">
            <div class="d-flex justify-content-end mb-4">
                <!-- <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_data">
                    <i class="bi bi-pencil-square"></i>
                    Edit Data
                </button> -->

                <div class="modal fade" tabindex="-1" id="kt_modal_edit_data">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Edit Data</h3>

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <!--end::Close-->
                            </div>

                            <div class="modal-body">
                                <!-- <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Actual Scope</label>
                                    <input type="text" class="form-control" placeholder="Masukkan Actual Scope"/>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Deliverables</label>
                                    <textarea class="form-control" aria-label="With textarea" placeholder="Masukkan Deliverables"></textarea>
                                </div> -->
                                <form id="editDataForm" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Start Date</label>
                                            <div class="input-group">
                                                <input 
                                                    type="date" 
                                                    name="start_date"
                                                    id="editStartDate" 
                                                    class="form-control" 
                                                    value="{{ isset($volume) && isset($volume->start_date) ? \Carbon\Carbon::parse($volume->start_date)->format('Y-m-d') : '' }}"
                                                    required 
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">End Date</label>
                                            <div class="input-group">
                                                <input 
                                                    type="date" 
                                                    name="end_date" 
                                                    id="editEndDate" 
                                                    class="form-control" 
                                                    value="{{ isset($volume) && isset($volume->end_date) ? \Carbon\Carbon::parse($volume->end_date)->format('Y-m-d') : '' }}"
                                                    required
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="mb-1">
                                            <div class="row g-2">
                                                <div class="col-md-8">
                                                    <label class="form-label fw-bold">Resource Names</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label fw-bold">JHK</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="editResourceContainer">
                                            <!-- Ditambahkan oleh JavaScript -->
                                        </div>
                                        <button type="button" class="btn btn-light-primary" id="addEditResourceBtn">
                                            <i class="bi bi-plus-lg"></i>
                                            Tambah Resource
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" onclick="submitEditData()">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Actual Scope -->
                <div class="col-md-8 mb-4">
                    <div class="card card-flush shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="symbol symbol-50px me-3">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="bi bi-bullseye text-primary fs-2"></i>
                                    </div>
                                </div>
                                <h3 class="card-title fw-bold">Actual Scope</h3>
                            </div>
                            <p class="mb-0 fs-6 text-dark fw-semibold">
                                @if(isset($workPackage))
                                    {{ $workPackage->actual_scope_contract ?? 'N/A' }}
                                @else
                                    <p class="text-muted">
                                        Belum ada Actual Scope Contract
                                    </p>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total % Complete -->
                <div class="col-md-4 mb-4">
                    <div class="card card-flush shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="symbol symbol-50px me-3">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="bi bi-percent text-primary fs-2"></i>
                                    </div>
                                </div>
                                <h3 class="card-title fw-bold">Total Complete</h3>
                            </div>
                            <div class="d-flex justify-content-center h-100 total-complete">
                                <span class="fs-1">
                                    {{ $totalCompletion ?? 0 }} %
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deliverables -->
                <div class="col-md-12 mb-4">
                    <div class="card card-flush shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="symbol symbol-50px me-3">
                                    <div class="symbol-label bg-light-info">
                                        <i class="bi bi-list-check text-info fs-2"></i>
                                    </div>
                                </div>
                                <h3 class="card-title fw-bold">Deliverables</h3>
                            </div>
                            <div class="mb-2 fs-7">
                                @if(isset($workPackage))
                                    {!! nl2br(e($workPackage->deliverable ?? 'N/A')) !!}
                                @else
                                    <p class="text-muted">
                                        Belum ada Deliverables
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resource Names -->
                <div class="col-md-12 mb-4">
                    <div class="card card-flush shadow-sm mb-6">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="symbol symbol-50px me-3">
                                    <div class="symbol-label bg-light-warning">
                                        <i class="bi bi-people text-warning fs-2"></i>
                                    </div>
                                </div>
                                <h3 class="card-title fw-bold">Resource Names</h3>
                                <span class="badge badge-light-success ms-auto">{{ isset($assignedUsers) ? $assignedUsers->count() : 0 }} Members</span>
                            </div>
                            <div class="row g-3 justify-content-center mb-4">
                                @if(isset($assignedUsers) && $assignedUsers->count() > 0)
                                    @foreach($assignedUsers as $user)
                                        <div class="col-md-4">
                                            <div class="card card-bordered h-100">
                                                <div class="card-body text-center position-relative pb-3">
                                                    <h5 class="card-title fs-6 fw-bold">{{ $user['name'] }}</h5>
                                                    <span>{{ $user['role_name'] ?? 'N/A' }}</span>
                                                    <!-- Toggle button -->
                                                    <div class="mb-0">
                                                        <button type="button" class="btn btn-sm btn-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#user-details-{{ $loop->index }}"
                                                            aria-expanded="false"
                                                            aria-controls="user-details-{{ $loop->index }}">
                                                            <i class="bi bi-chevron-down"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Hidden details -->
                                                <div id="user-details-{{ $loop->index }}" class="collapse card-details text-center pb-1">
                                                    <div class="separator separator-content border-dark my-3">Mandays</div>
                                                    <div class="row my-2">
                                                        <div class="col-md-6">
                                                            <span>Rencana</span>
                                                            <div>
                                                                <span class="badge badge-square badge-light">{{$user['jhk'] ?? ''}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span>Realisasi</span>
                                                            <div>
                                                                <span class="badge badge-square {{$user['timesheets_count'] > $user['jhk'] ? 'badge-danger text-light' : 'badge-light'}}">
                                                                    {{$user['timesheets_count'] ?? ''}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="py-0">
                                                        <button type="button" class="btn btn-sm btn-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#user-details-{{ $loop->index }}"
                                                            aria-expanded="false"
                                                            aria-controls="user-details-{{ $loop->index }}">
                                                            <i class="bi bi-chevron-down"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-12">
                                        <div class="d-flex flex-column align-items-center justify-content-center py-5">
                                            <div class="text-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-people text-muted mb-3" viewBox="0 0 16 16">
                                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                                </svg>
                                            </div>
                                            <h5 class="text-muted fw-bold mb-2">Belum Ada Resource Yang Ditugaskan</h5>
                                            <p class="text-muted mb-4 text-center">
                                                Resource belum ditugaskan untuk work package ini.<br>
                                                Silakan assign resource terlebih dahulu.
                                            </p>
                                            <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_data">
                                                <i class="bi bi-plus-circle me-2"></i>
                                                Assign Resource
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let editResourceCounter = 1;

// Mendapatkan semua user yang tersedia untuk dropdown
const availableUsers = @json(\App\Models\User::with('roles')->get()->map(function($user) {
    return [
        'user_id' => $user->user_id,
        'name' => $user->name,
        'role_name' => $user->getRoleNames()->get(1) ?? $user->getRoleNames()->first() ?? 'No Role'
    ];
}));
console.log('availableUsers:', availableUsers);

// Mendapatkan user saat ini
const currentlyAssignedUsers = @json($assignedUsers ? $assignedUsers->pluck('user_id') : []);
const currentlyAssignedUsersAllData = @json($assignedUsers);
console.log('currentlyAssignedUsersAllData:', currentlyAssignedUsersAllData);

console.log('Available users from Blade:', @json(\App\Models\User::with('roles')->get()));


$(document).ready(function () {
    initTabelWPTask();

    // Resource management

    // Add Resource Button Click Event
    $('#addEditResourceBtn').off('click').on('click', function() {
        console.log('Add Resource button clicked');
        console.log('Button element:', this);
        addEditResource();
    });

    // Inisialisasi edit modal ketika membuka
    $('#kt_modal_edit_data').on('show.bs.modal', function () {
        initializeEditModal();
    });

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

/**
 * Inisiasi Tabel Work Package Task
 */
function initTabelWPTask() {
    const table = $('#tabel_wp_task').DataTable({
        'scrollY': '300px',
        "scrollX": true,
        "responsive": true,
        "ordering": false,
        "searching": true,
        "paging": false,    
        "language": {
            "search": "",
            "searchPlaceholder": "Cari Task",
            "zeroRecords": "Tidak ada task yang cocok dengan pencarian",
            "emptyTable": "Tidak ada data task untuk Work Package ini"
        }
    });

    // Search input to DataTables
    setupTaskSearch(table);
}

/**
 * Function untuk search pada tabel
 */
function setupTaskSearch(table) {
    const searchInput = $('#searchTaskInput');

    // Search input handler
    searchInput.on('keyup change input', function() {
        const searchValue = this.value.trim();
        table.search(searchValue).draw();
    });

    // Clear button handler
    searchInput.on('search', function() {
        if (this.value === '') {
            table.search('').draw();
        }
    });

    // ESC key untuk clear search
    searchInput.on('keydown', function(e) {
        if (e.which === 27) { // ESC key
            e.preventDefault();
            this.value = '';
            $(this).trigger('input');
            this.focus();
        }
    });
}

/* WORK PACKAGE MANAGEMENT */
/**
 * Inisialisasi edit modal dengan data saat ini
 */
function initializeEditModal() {
    // Reset container
    $('#editResourceContainer').empty();
    editResourceCounter = 1;

    // Debug log
    console.log('availableUsers:', availableUsers);
    console.log('currentlyAssignedUsers:', currentlyAssignedUsers);
    
    // Menambahkan assigned user saat ini
    if (currentlyAssignedUsers && currentlyAssignedUsers.length > 0) {
        currentlyAssignedUsers.forEach(function(userId) {
            addEditResource(userId);
        });
    } else {
        // Menambahkan setidaknya 1 field kosong
        addEditResource();
    }
    
    // Update end date min when start date changes
    $('#editStartDate').on('change', function() {
        const startDate = this.value;
        $('#editEndDate').attr('min', startDate);
        
        // Reset end date if it's before start date
        const endDate = $('#editEndDate').val();
        if (endDate && endDate < startDate) {
            $('#editEndDate').val('');
        }
    });

    // Mengatur inisial end date minimum berdasarkan start date saat ini
    const currentStartDate = $('#editStartDate').val();
    if (currentStartDate) {
        $('#editEndDate').attr('min', currentStartDate);
    }
}

/**
 * Submit edit data form
 */
function submitEditData() {
    const form = $('#editDataForm');
    const formData = new FormData(form[0]);
    
    // Get volume ID from current page
    const volumeId = {{ $volume_id ?? 'null' }};
    
    if (!volumeId) {
        Swal.fire({
            text: "Volume ID tidak ditemukan.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Manual validation
    const startDate = formData.get('start_date');
    const endDate = formData.get('end_date');
    const resources = formData.getAll('resources[]');
    const jhk = formData.getAll('jhk[]');

    if (!startDate || !endDate) {
        Swal.fire({
            text: "Start Date dan End Date harus diisi.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    if (new Date(startDate) > new Date(endDate)) {
        Swal.fire({
            text: "End Date harus sama atau setelah Start Date.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Filter out empty resource selections
    // const validResources = resources.filter(resource => resource !== '');
    const validResources = resources.filter(resource => {
        return resource !== '' && resource !== null && resource !== undefined && !isNaN(resource);
    });
    
    // Debug log
    console.log('Edit Data Form Submission:', {
        volumeId: volumeId,
        startDate: startDate,
        endDate: endDate,
        resources: validResources,
        jhk: jhk
    });
    
    // Create clean FormData with filtered resources
    const cleanFormData = new FormData();
    cleanFormData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    cleanFormData.append('_method', 'PUT');
    cleanFormData.append('start_date', startDate);
    cleanFormData.append('end_date', endDate);
    
    // Add valid resources
    validResources.forEach(function(resource) {
        cleanFormData.append('resources[]', resource);
    });

    // Add JHK values
    jhk.forEach(function(jhkValue) {
        cleanFormData.append('jhk[]', jhkValue);
    });
    
    // Submit via AJAX
    $.ajax({
        url: `/work-package/volume/${volumeId}/data`,
        method: 'POST', // Laravel method spoofing requires POST
        data: cleanFormData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Show loading
            Swal.fire({
                title: 'Memperbarui...',
                text: 'Sedang memproses pembaruan data',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            console.log('Edit Data Success Response:', response);
            
            if (response.success) {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Data berhasil diperbarui!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    window.location.reload();
                });
                
                $('#kt_modal_edit_data').modal('hide');

            } else if (response.no_changes) {
                Swal.fire({
                    title: "Tidak Ada Perubahan",
                    text: "Tidak ada data yang diubah. Silakan lakukan perubahan terlebih dahulu atau klik Batal.",
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    }
                });

            } else {
                Swal.fire({
                    title: "Gagal!",
                    text: response.message || "Terjadi kesalahan saat memperbarui data",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            console.log('Edit Data Error Response:', xhr);
            
            let errorTitle = "Gagal Memperbarui Data";
            let errorMessage = "Terjadi kesalahan saat memperbarui data";
            
            if (xhr.responseJSON) {
                console.log('Response JSON:', xhr.responseJSON);
                
                if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // Handle validation errors
                if (xhr.responseJSON.errors) {
                    console.log('Validation Errors:', xhr.responseJSON.errors);
                    const errorDetails = Object.entries(xhr.responseJSON.errors)
                        .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                        .join('\n');
                    errorMessage += '\n\nDetail errors:\n' + errorDetails;
                }
            }
            
            Swal.fire({
                title: errorTitle,
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        }
    });
}

/* Resource Management */
/**
 * Tambah resource field baru di edit modal
 */
function addEditResource(selectedUserId = null) {
    // Validasi availableUsers
    if (!availableUsers || availableUsers.length === 0) {
        console.error('No available users found in addEditResource');
        Swal.fire({
            text: "Tidak ada data user yang tersedia. Pastikan ada user dalam sistem.",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "OK",
            customClass: {
                confirmButton: "btn btn-warning"
            }
        });
        return;
    }

    let optionsHtml = '<option value="">Pilih Resource</option>';
    let defaultJhk = 0; 
    
    availableUsers.forEach(function(user) {
        const selected = selectedUserId && selectedUserId == user.user_id ? 'selected' : '';
        optionsHtml += `<option value="${user.user_id}" ${selected}>${user.name} (${user.role_name})</option>`;
        if (selectedUserId && selectedUserId == user.user_id && typeof currentlyAssignedUsersAllData !== 'undefined') {
            const assigned = currentlyAssignedUsersAllData.find(a => a.user_id == selectedUserId);
            if (assigned) {
                defaultJhk = assigned.jhk;
            }
            console.log('selected:', selected, 'assigned', assigned);
        }
    });
    
    const resourceHtml = `
        <div class="input-group mb-2" id="edit-resource-${editResourceCounter}">
            <div class="row g-2 align-items-end">
                <div class="col-md-8">
                    <select class="form-select" name="resources[]" onchange="handleResourceChange(this)">
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="jhk[]" placeholder="0" min="0" value="${defaultJhk}"/>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-light-danger" onclick="removeEditResource(${editResourceCounter})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    $('#editResourceContainer').append(resourceHtml);
    editResourceCounter++;
}

/**
 * Menghapus resource field di edit modal
 */
function removeEditResource(index) {
    const resourceCount = $('#editResourceContainer .input-group').length;

    $(`#edit-resource-${index}`).remove();
}

/**
 * Menangani perubahan seleksi resource untuk menghindari duplikasi
 */
function handleResourceChange(selectElement) {
    const selectedValue = selectElement.value;
    const allSelects = document.querySelectorAll('#editResourceContainer select');
    
    // Check for duplicates
    let duplicateCount = 0;
    allSelects.forEach(function(select) {
        if (select.value === selectedValue && selectedValue !== '') {
            duplicateCount++;
        }
    });
    
    if (duplicateCount > 1) {
        Swal.fire({
            text: "User ini sudah dipilih di resource lain!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "OK",
            customClass: {
                confirmButton: "btn btn-warning"
            }
        });
        selectElement.value = ''; // Reset selection
    }
}

// Function untuk toggle sub-rows
function toggleSubRows(rowId) {
    const icon = document.getElementById('icon-' + rowId);
    const subRows = document.getElementById('subRows-' + rowId);
    
    if (subRows.classList.contains('show')) {
        // Collapse
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-right');
    } else {
        // Expand
        icon.classList.remove('bi-chevron-right');
        icon.classList.add('bi-chevron-down');
    }
}

/** TASK MANAGEMENT **/
/** Insert Task */
/**
 * Function untuk menambah task pertama (jika belum ada task di tabel)
 */
// function insertFirstTask() {
//     // Reset semua field reference
//     $('#referenceTaskId').val('');
//     $('#insertPosition').val('');
//     $('#insertTaskModalTitle').text('Tambah Task');

//     // Pastikan volume_id tersedia
//     const volumeId = {{ $volume_id ?? 'null' }};
//     if (volumeId) {
//         $('#modalVolumeId').val(volumeId);
//     } else {
//         Swal.fire({
//             text: "Volume ID tidak ditemukan. Tidak dapat menambahkan task.",
//             icon: "error",
//             buttonsStyling: false,
//             confirmButtonText: "Tutup",
//             customClass: {
//                 confirmButton: "btn btn-secondary"
//             }
//         });
//         return;
//     }

//     // Reset form
//     $('#insertTaskForm')[0].reset();
//     $('#modalVolumeId').val(volumeId);
//     $('#referenceTaskId').val('');
//     $('#insertPosition').val('');

//     // Show modal
//     $('#kt_modal_insert_task').modal('show');
// }

/**
 * Function untuk insert task di atas
 */
// function insertTaskAbove(taskId, taskName) {
//     $('#referenceTaskId').val(taskId);
//     $('#insertPosition').val('above');
//     $('#insertTaskModalTitle').text('Masukkan Task di Atas');

//     // Pastikan volume_id tersedia
//     const volumeId = {{ $volume_id ?? 'null' }};
//     if (volumeId) {
//         $('#modalVolumeId').val(volumeId);
//     }

//     // Reset form
//     $('#insertTaskForm')[0].reset();
//     $('#referenceTaskId').val(taskId);
//     $('#insertPosition').val('above');
//     $('#modalVolumeId').val(volumeId);

//     // Show modal
//     $('#kt_modal_insert_task').modal('show');
// }

/**
 * Function untuk insert task di bawah
 */
// function insertTaskBelow(taskId, taskName) {
//     $('#referenceTaskId').val(taskId);
//     $('#insertPosition').val('below');
//     $('#insertTaskModalTitle').text('Masukkan Task di Bawah');

//     // Pastikan volume_id tersedia
//     const volumeId = {{ $volume_id ?? 'null' }};
//     if (volumeId) {
//         $('#modalVolumeId').val(volumeId);
//     }

//     // Reset form
//     $('#insertTaskForm')[0].reset();
//     $('#referenceTaskId').val(taskId);
//     $('#insertPosition').val('below');
//     $('#modalVolumeId').val(volumeId);

//     // Show modal
//     $('#kt_modal_insert_task').modal('show');
// }

/**
 * Function untuk insert sub task
 */
function insertSubTask(taskId, taskName) {
    $('#modalTaskId').val(taskId);
    $('#insertSubTaskModalSubTitle').text(`${taskName}`);

    // Reset form
    $('#insertSubTaskForm')[0].reset();
    $('#modalTaskId').val(taskId);
    $('#modalVolumeId').val({{ $volume_id ?? 'null' }});

    // Show modal
    $('#kt_modal_insert_subtask').modal('show');
}

/**
 * Function untuk membuka modal edit subtask dan mengisi data
 */
function editSubTask(subTaskId) {
    $.ajax({
        url: `/work-package/subtask/${subTaskId}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success && response.subtask) {
                // Isi field modal dengan data subtask
                $('#editSubTaskId').val(response.subtask.sub_task_id);
                $('#editSubTaskParentTaskId').val(response.subtask.task_id);
                $('#editSubTaskName').val(response.subtask.name);
                // if (response.subtask.completeness !== undefined) {
                //     $('#editSubTaskCompleteness').val(response.subtask.completeness);
                // }
                $('#editSubTaskTaskName').val(response.subtask.task_name || 'Task');

                // Set form action jika perlu
                // $('#editSubTaskForm').attr('action', `/work-package/subtask/${subTaskId}`);

                // Tampilkan modal
                $('#kt_modal_edit_subtask').modal('show');
            } else {
                Swal.fire({
                    text: response.message || "Gagal mengambil data sub task",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat mengambil data sub task";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-secondary" }
            });
        }
    });
}

/**
 * Function untuk submit insert task
 */
function submitInsertTask() {
    const form = $('#insertTaskForm');
    const formData = new FormData(form[0]);

    // Validasi form
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return;
    }

    // Validasi manual untuk field wajib
    const volumeId = formData.get('volume_id');
    const taskName = formData.get('task_name');
    // const insertPosition = formData.get('insert_position');
    // const referenceTaskId = formData.get('reference_task_id');
    
    if (!volumeId || !taskName) {
        Swal.fire({
            text: "Data tidak lengkap. Pastikan semua field terisi.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Jika ada reference task, maka insert_position wajib diisi
    // if (referenceTaskId && !insertPosition) {
    //     Swal.fire({
    //         text: "Posisi insert harus dipilih (above/below).",
    //         icon: "error",
    //         buttonsStyling: false,
    //         confirmButtonText: "Tutup",
    //         customClass: {
    //             confirmButton: "btn btn-secondary"
    //         }
    //     });
    //     return;
    // }

    // Disable form dan button saat loading
    const submitButton = $('button[onclick="submitInsertTask()"]');
    const originalButtonText = submitButton.html();

    // Submit
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Disable form elements
            form.find('input, button').prop('disabled', true);
            
            // Change button to loading state
            submitButton.html(`
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Menyimpan...
            `).prop('disabled', true);
            
            // Show loading modal
            Swal.fire({
                title: 'Menambahkan Task...',
                text: 'Sedang memproses penambahan task baru',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    text: "Task berhasil ditambahkan!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    window.location.reload();
                });

                // Tutup modal
                $('kt_modal_insert_task').modal('hide');
            } else {
                Swal.fire({
                    text: response.message || "Terjadi kesalahan saat menambahkan task",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat menambahkan task";
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                errorMessage = errors.join('\n');
            }
            
            Swal.fire({
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        },
        complete: function() {
            // Reset form state setelah request selesai
            // Re-enable form elements
            form.find('input, button').prop('disabled', false);
            
            // Reset button text
            submitButton.html(originalButtonText).prop('disabled', false);
        }
    });
}

/** Edit Task */
/**
 * Function untuk edit task
 */
function editTask(taskId) {
    // Get task data via AJAX
    $.ajax({
        url: `/work-package/task/${taskId}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Populate modal dengan data task
                $('#editTaskId').val(response.task.task_id);
                $('#editTaskName').val(response.task.name);
                $('#editModalVolumeId').val(response.task.volume_id);
                
                // Show modal
                $('#kt_modal_edit_task').modal('show');
            } else {
                Swal.fire({
                    text: response.message || "Gagal mengambil data task",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat mengambil data task";
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            Swal.fire({
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        }
    });
}

/**
 * Function untuk submit edit task
 */
function submitEditTask() {
    const form = $('#editTaskForm');
    const taskId = $('#editTaskId').val();

    // Validasi taskId
    if (!taskId) {
        Swal.fire({
            text: "Task ID tidak ditemukan. Silakan coba lagi.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Create FormData manually dengan validasi
    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('_method', 'PUT');
    formData.append('task_name', $('#editTaskName').val().trim());
    formData.append('volume_id', $('#editModalVolumeId').val());

    // Debug log
    console.log('Manual FormData:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': "' + pair[1] + '"');
    }

    // Validasi manual
    const taskName = formData.get('task_name');
    const volumeId = formData.get('volume_id');
    
    if (!taskName || !taskName === '') {
        Swal.fire({
            text: "Nama task harus diisi.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    if (!volumeId || volumeId === '') {
        Swal.fire({
            text: "Volume ID tidak ditemukan.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Button loading state
    const submitButton = $('button[onclick="submitEditTask()"]');
    const originalButtonText = submitButton.html();

    // Submit via AJAX
    $.ajax({
        url: `/work-package/task/${taskId}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-HTTP-Method-Override': 'PUT'
        },
        beforeSend: function() {
            console.log('Sending request to:', `/work-package/task/${taskId}`);

            // Disable form elements
            form.find('input, button').prop('disabled', true);
            
            // Change button to loading state
            submitButton.html(`
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Memperbarui...
            `).prop('disabled', true);
            
            // Show loading modal
            Swal.fire({
                title: 'Memperbarui Task...',
                text: 'Sedang memproses pembaruan task',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            console.log('Update Success Response:', response);
            
            if (response.success) {
                Swal.fire({
                    text: "Task berhasil diperbarui!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    window.location.reload();
                });
                
                $('#kt_modal_edit_task').modal('hide');
            } else {
                Swal.fire({
                    text: response.message || "Terjadi kesalahan saat memperbarui task",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            console.log('Update Error Response:', xhr);
            
            let errorMessage = "Terjadi kesalahan saat mengupdate task";
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                errorMessage = errors.join('\n');
            }
            
            Swal.fire({
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        },
        complete: function() {
            // Reset form state setelah request selesai
            // Re-enable form elements
            form.find('input, button').prop('disabled', false);
            
            // Reset button text
            submitButton.html(originalButtonText).prop('disabled', false);
        }
    });
}

/**
 * Function untuk delete task
 */
function deleteTask(taskId, taskName) {
    // Validasi taskId
    if (!taskId) {
        Swal.fire({
            text: "Task ID tidak ditemukan.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // cek jumlah sub task
    $.ajax({
        url: `/work-package/task/${taskId}/subtask-count`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            let warningText = ``;
            if (response.success && response.subtask_count > 0) {
                warningText = `<span style="font-size:0.95em">Task "<b>${taskName}</b>" ini memiliki ${response.subtask_count} sub task.<br>Menghapus task akan menghapus semua sub task terkait.<br></span>`;
            }
            warningText += `<br><span class="text-muted" style="font-size:0.85em;">Tindakan ini tidak dapat dibatalkan.</span>`;
            Swal.fire({
                title: "Konfirmasi Hapus Task",
                html: warningText,
                icon: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: "Ya, Hapus",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    performDeleteTask(taskId);
                }
            });
        },
        error: function() {
            // Jika gagal cek subtask (tidak ada sub task), tetap tampilkan konfirmasi standar
            Swal.fire({
                title: "Konfirmasi Hapus Task",
                html: `Apakah Anda yakin ingin menghapus task ${taskName}?`,
                icon: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: "Ya, Hapus",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    performDeleteTask(taskId);
                }
            });
        }
    });
}

/**
 * Function untuk melakukan delete task via AJAX
 */
function performDeleteTask(taskId) {
    $.ajax({
        url: `/work-package/task/${taskId}`,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        beforeSend: function() {
            // Menampilkan loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Sedang memproses penghapusan task',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            console.log('Delete Success Response: ', response);

            if (response.success) {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Task berhasil dihapus',
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'Tutup',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal',
                    text: response.message || "Terjadi kesalahan saat menghapus task",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            console.log('Delete Error Response:', xhr);
            
            let errorTitle = "Gagal Menghapus Task";
            let errorMessage = "Terjadi kesalahan saat menghapus task";
            let iconType = "error";
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                console.log('Response JSON:', xhr.responseJSON);
                
                errorMessage = xhr.responseJSON.message;
            }
            
            Swal.fire({
                title: errorTitle,
                text: errorMessage,
                icon: iconType,
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        }
    });
}

/**
 * Function untuk submit insert sub task
 */
function submitInsertSubTask() {
    const form = $('#insertSubTaskForm');
    const formData = new FormData(form[0]);

    // Validasi form
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return;
    }

    // Validasi manual
    const taskId = formData.get('task_id');
    const subtaskName = formData.get('subtask_name');

    if (!taskId || !subtaskName) {
        Swal.fire({
            text: "Data tidak lengkap. Pastikan semua field terisi.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: { confirmButton: "btn btn-secondary" }
        });
        return;
    }

    // Button loading state
    const submitButton = $('button[onclick="submitInsertSubTask()"]');
    const originalButtonText = submitButton.html();

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Disable form elements
            form.find('input, button').prop('disabled', true);

            // Change button to loading state
            submitButton.html(`
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Menyimpan...
            `).prop('disabled', true);

            Swal.fire({
                title: 'Menambahkan Sub Task...',
                text: 'Sedang memproses penambahan sub task baru',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading() }
            });
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    text: "Sub Task berhasil ditambahkan!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-primary" }
                }).then(() => {
                    window.location.reload();
                });

                $('#kt_modal_insert_subtask').modal('hide');
            } else {
                Swal.fire({
                    text: response.message || "Terjadi kesalahan saat menambahkan sub task",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat menambahkan sub task";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                errorMessage = errors.join('\n');
            }
            Swal.fire({
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-secondary" }
            });
        },
        complete: function() {
            // Re-enable form elements
            form.find('input, button').prop('disabled', false);
            submitButton.html(originalButtonText).prop('disabled', false);
        }
    });
}

/**
 * Function untuk submit edit subtask
 */
function submitEditSubTask() {
    const form = $('#editSubTaskForm');
    const subTaskId = $('#editSubTaskId').val();

    // Validasi subTaskId
    if (!subTaskId) {
        Swal.fire({
            text: "Sub Task ID tidak ditemukan. Silakan coba lagi.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: { confirmButton: "btn btn-secondary" }
        });
        return;
    }

    // Validasi form
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return;
    }

    // Buat FormData
    const formData = new FormData(form[0]);
    formData.append('_method', 'PUT');

    // Button loading state
    const submitButton = $('button[onclick="submitEditSubTask()"]');
    const originalButtonText = submitButton.html();

    $.ajax({
        url: `/work-package/subtask/${subTaskId}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-HTTP-Method-Override': 'PUT'
        },
        beforeSend: function() {
            form.find('input, button').prop('disabled', true);
            submitButton.html(`
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Memperbarui...
            `).prop('disabled', true);

            Swal.fire({
                title: 'Memperbarui Sub Task...',
                text: 'Sedang memproses pembaruan sub task',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading() }
            });
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    text: "Sub Task berhasil diperbarui!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-primary" }
                }).then(() => {
                    window.location.reload();
                });
                $('#kt_modal_edit_subtask').modal('hide');
            } else {
                Swal.fire({
                    text: response.message || "Terjadi kesalahan saat memperbarui sub task",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat memperbarui sub task";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                errorMessage = errors.join('\n');
            }
            Swal.fire({
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-secondary" }
            });
        },
        complete: function() {
            form.find('input, button').prop('disabled', false);
            submitButton.html(originalButtonText).prop('disabled', false);
        }
    });
}

/**
 * Konfirmasi dan hapus sub task
 */
function deleteSubTaskConfirmation(subTaskId, subTaskName) {
    Swal.fire({
        title: "Konfirmasi Hapus Sub Task",
        html: `
            <span>Apakah Anda yakin ingin menghapus sub task:</span>
            <p>${subTaskName}?</p>
            <p class="text-muted"><small>Tindakan ini tidak dapat dibatalkan</small></p>
        `,
        icon: "warning",
        buttonsStyling: false,
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: "Ya, Hapus",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            performDeleteSubTask(subTaskId);
        }
    });
}

/**
 * AJAX hapus sub task
 */
function performDeleteSubTask(subTaskId) {
    console.log('Performing delete for sub task ID:', subTaskId);
    $.ajax({
        url: `/work-package/subtask/${subTaskId}`,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Menghapus...',
                text: 'Sedang memproses penghapusan sub task',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Sub task berhasil dihapus',
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'Tutup',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal',
                    text: response.message || "Terjadi kesalahan saat menghapus sub task",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat menghapus sub task";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
                title: "Gagal Menghapus Sub Task",
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        }
    });
}

// detail resources
document.addEventListener("DOMContentLoaded", function () {
    const collapseElements = document.querySelectorAll('.collapse');

    collapseElements.forEach(collapse => {
        collapse.addEventListener('show.bs.collapse', function () {
            const icon = document.querySelector(`button[data-bs-target="#${this.id}"] i`);
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        });

        collapse.addEventListener('hide.bs.collapse', function () {
            const icon = document.querySelector(`button[data-bs-target="#${this.id}"] i`);
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        });
    });
});
</script>
@endpush

<style>
.performance-card {
    box-shadow: 0 0.5rem 1.5rem rgba(33, 37, 41, 0.25), 0 0.25rem 0.5rem rgba(33, 37, 41, 0.18);
    background: #f8fafc;
}
.performance-card:hover {
    box-shadow: 0 1.5rem 3rem rgba(0,0,0, 0.9), 0 0.5rem 1rem rgba(0,0,0, 0.9);
    background: #ffffff;
    transform: translateY(-2px) scale(0.985);
}

/* Custom style for Kebutuhan Tenaga Kerja table */
#tabel_wp_tenaga_kerja tbody tr {
    height: 32px;
}
#tabel_wp_tenaga_kerja td {
    padding-bottom: 0rem !important;
}
#tabel_wp_tenaga_kerja th {
    padding-bottom: 1.1rem !important;
}

.total-complete {
    transition: transform 0.25s cubic-bezier(.4,2,.6,1), color 0.25s;
}
.total-complete:hover {
    transform: scale(1.10);
}

/* Highlight Duration card number and text on hover */
.duration-card .duration-highlight {
    transition: transform 0.25s cubic-bezier(.4,2,.6,1), color 0.25s;
}
.duration-card:hover .duration-highlight {
    transform: scale(1.18);
}

/* HOVER EFFECT UNTUK RESOURCE NAMES CARDS */
.card-bordered {
    transition: all 0.3s ease;
    cursor: pointer;
}

.card-bordered:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.15);
    border-color: #007bff;
}

.card-bordered:hover .card-title {
    color: #007bff;
    transition: color 0.3s ease;
}

.card-bordered:hover span {
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Smooth transition untuk semua elemen dalam card */
.card-bordered .card-body {
    transition: all 0.3s ease;
}

.card-bordered .card-title {
    transition: color 0.3s ease;
}

.card-bordered span {
    transition: all 0.3s ease;
}

.card-bordered:hover .card-body {
    background-color: #f8f9fa;
}

/* for overlay card */
.overlay-performance-card {
    position: relative;
    overflow: hidden;
}

.performance-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(30, 30, 30, 0.7);
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    z-index: 2;
    pointer-events: none;
}

.overlay-performance-card:hover .performance-overlay {
    opacity: 1.2;
    pointer-events: auto;
}

.duration-card .card-body,
.performance-card .card-body
{
    padding-top: 0px !important;
}

.card-details {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10;
    background: white;
    border-top: 1px solid #dee2e6;
    box-shadow: 0 -2px 6px rgba(0,0,0,0.1);
    padding: 1rem;
}
</style>