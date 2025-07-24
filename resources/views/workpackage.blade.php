@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Work Package</h1>

    <div class="card card-flush shadow-sm mb-8">
        <div class="card-header flex-column">
            <!-- Title Section -->
            <div class="mt-6">
                @if(isset($workPackage) && isset($volume))
                    <h3 class="card-title">WP {{ $workPackage->wp_number }} {{ $workPackage->name }}</h3>
                    <p>Periode {{ \Carbon\Carbon::parse($volume->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($volume->end_date)->format('d M Y') }}</p>
                @else
                    <h3 class="card-title">WP 3.1 Human Security Risk Awareness Program Planning</h3>
                    <p>Periode 3 Maret 2025 - 19 November 2025</p>
                @endif
            </div>

            <!-- Navigation Tabs -->
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_7">Detail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_8">Kuantitas</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body py-5">
            <div class="tab-content" id="myTabContent">
                <!-- TAB WP DETAIL -->
                <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                    <div class="mb-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label fw-bold fs-6 text-dark mb-3">Task List</label>
                            
                            <!-- Search Form -->
                            <div>
                                <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
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
                        </div>
    
                        <!-- Task List Section -->
                        <div class="table-responsive">
                            <table id="tabel_wp_task" class="table table-striped border gy-5 gs-7 border rounded w-100">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="align-middle border-bottom min-w-100px">No</th>
                                        <th class="align-middle border-bottom min-w-200px">Task</th>
                                        <th class="align-middle border-bottom">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($volume) && $volume->task->count() > 0)
                                        @foreach($volume->task as $index => $task)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $task->name }}</td>
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
                                                                <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask({{ $task->task_id }})">
                                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                                    Hapus
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Atas
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Bawah
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <!-- Fallback jika tidak ada data -->
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Tidak ada data task untuk work package ini
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal for Adding Task -->
                        <div class="modal fade" tabindex="-1" id="kt_modal_insert_task">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Tambah Task</h3>

                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Nama Task</label>
                                            <input type="text" class="form-control" placeholder="Masukkan Nama Task"/>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-flush shadow mb-6">
                        <div class="card-body py-5">
                            <div class="d-flex justify-content-end mb-4">
                                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_data">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                    </svg>
                                    Edit Data
                                </button>

                                <div class="modal fade" tabindex="-1" id="kt_modal_edit_data">
                                    <div class="modal-dialog">
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
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Actual Scope</label>
                                                    <input type="text" class="form-control" placeholder="Masukkan Actual Scope"/>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Deliverables</label>
                                                    <textarea class="form-control" aria-label="With textarea" placeholder="Masukkan Deliverables"></textarea>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Start Date</label>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" id="startDate" placeholder="Pilih Tanggal Mulai"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">End Date</label>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" id="endDate" placeholder="Pilih Tanggal Selesai"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Resource Names</label>
                                                    <div id="resourceContainer">
                                                        <div class="input-group mb-2" id="resource-0">
                                                            <select class="form-select" name="resources[]">
                                                                <option value="">Pilih Resource</option>
                                                                <option value="pm">Project Manager (PM)</option>
                                                                <option value="sc">Senior Consultant (SC)</option>
                                                                <option value="asc">Associate Consultant (ASC)</option>
                                                                <option value="jc">Junior Consultant (JC)</option>
                                                                <option value="tw">Technical Writer (TW)</option>
                                                                <option value="osc">On-Site Consultant (OSC)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-light-primary" id="addResourceBtn">
                                                        <i class="bi bi-plus-lg"></i>
                                                        Tambah Resource
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-primary">Simpan</button>
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
                                            <h3 class="card-title fw-bold">Actual Scope</h3>
                                            <p class="mb-0 fs-6 text-dark fw-semibold">
                                                <!-- "Human firewall design program (awareness) - IS competency matrix" -->
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
                                            <h3 class="card-title fw-bold">Total % Complete</h3>
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
                                            <h3 class="card-title fw-bold">Deliverables</h3>
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
                                <div class="col-md-12">
                                    <div class="card card-flush shadow-sm">
                                        <div class="card-header">
                                            <h3 class="card-title fw-bold">Resource Names</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3 justify-content-center">
                                                @if(isset($assignedUsers) && $assignedUsers->count() > 0)
                                                    @foreach($assignedUsers as $user)
                                                        <div class="col-md-4">
                                                            <div class="card card-bordered h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title fs-6 fw-bold">{{ $user->name }}</h5>
                                                                    <span>{{ $user->role->name ?? 'N/A' }}</span>
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

                <!-- TAB WP KUANTITAS -->
                <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
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
                            <button type="button" class="btn btn-light-primary" onclick="window.location.href='{{ route('timesheet.detail', $volume->volume_id) }}'">
                                Timesheet
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Kebutuhan Tenaga Kerja Section -->
                        <div class="card card-flush shadow-sm mb-6">
                            <div class="card-header py-0">
                                <h3 class="card-title fw-bold">Kebutuhan Tenaga Kerja</h3>
                            </div>
                            <div class="card-body py-0">
                                <div class="table-responsive">
                                    <table id="tabel_wp_tenaga_kerja" class="table table-striped border gy-4 gs-7 border rounded w-100">
                                        <thead>
                                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                                <th class="align-middle border-bottom min-w-200px  mb-3">Personel</th>
                                                <th class="align-middle border-bottom  mb-3">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah Tenaga Kerja">JTK</span>                                                    
                                                </th>                                                
                                                <th class="align-middle border-bottom  mb-3">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah Hari Kerja">JHK</span>                                                    
                                                </th>
                                                <th class="align-middle border-bottom  mb-3 ">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($humanResources as $hResource)
                                            <tr data-hresource-id="{{ $hResource->hresource_id }}" data-role-id="{{ $hResource->role_id }}" data-wp-id="{{ $hResource->wp_id }}">
                                                <td class="fw-bold">{{$hResource->role->name}}</td>
                                                <td>{{$hResource->jtk}}</td>
                                                <td>{{$hResource->jhk}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center edit-resource-btn" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal" 
                                                                    data-hresource-id="{{$hResource->hresource_id}}" 
                                                                    data-role-id="{{$hResource->role_id}}" 
                                                                    data-wp-id="{{$hResource->wp_id}}" 
                                                                    data-jtk="{{ $hResource->jtk }}" 
                                                                    data-jhk="{{ $hResource->jhk }}">
                                                                    <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            {{-- <li>
                                                                <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                                    Hapus
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Atas
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Bawah
                                                                </a>
                                                            </li> --}}
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" tabindex="-1" id="jtkandjhkModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola JTK dan JHK Personel</h3>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{route('work-package.hResource.edit', $volume->volume_id)}}" id="jtkJhkForm">
                    {{-- action="{{route('work-package.hResource.edit')}}"  --}}
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="hresource_id" id="form_hresource_id">
                    <input type="hidden" name="role_id" id="form_role_id">

                    <div class="row">
                        {{-- <div class="col-md-6 mb-3">
                            <label for="jumlahTenagaKerja" class="form-label">Jumlah Tenaga Kerja</label>
                            <input type="number" class="form-control" name="jtk" id="jumlahTenagaKerja" placeholder="0">
                        </div> --}}
                        <div class="col mb-3">
                            <label for="jumlahHariKerja" class="form-label">Jumlah Hari Kerja</label>                        
                            <input type="number" class="form-control" name="jhk" id="jumlahHariKerja" placeholder="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitJtkJhkForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let resourceCounter = 2;

$(document).ready(function () {
    initTabelWPTask();
    initTabelWPTenagaKerja();

    // Resource management
    
    // Add Resource Button Click Event
    $('#addResourceBtn').on('click', function() {
        addNewResource();
    });
});

/**
 * Inisiasi Tabel Work Package Task
 */
function initTabelWPTask() {
    const table = $('#tabel_wp_task').DataTable({
        'scrollY': '300px',
        "scrollX": true,
        // "fixedHeader": {
        //     "header":true,
        //     "headerOffset": 10
        // },
        "ordering": false,
        "searching": true,
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
 * Inisiasi Tabel Work Package Tenaga Kerja
 */
function initTabelWPTenagaKerja() {
    $('#tabel_wp_tenaga_kerja').DataTable({
        "ordering": false,
        "paging": false,
        "lengthChange": false
    });
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

/**
 * RESOURCE MANAGEMENT
 */
/* ADD RESOURCE BUTTON FORM */
function addNewResource() {
    const resourceHtml = `
        <div class="input-group mb-2" id="resource-${resourceCounter}">
            <select class="form-select" name="resources[]">
                <option value="">Pilih Resource</option>
                <option value="pm">Project Manager (PM)</option>
                <option value="sc">Senior Consultant (SC)</option>
                <option value="asc">Associate Consultant (ASC)</option>
                <option value="jc">Junior Consultant (JC)</option>
                <option value="tw">Technical Writer (TW)</option>
                <option value="osc">On-Site Consultant (OSC)</option>
            </select>
            <button type="button" class="btn btn-light-danger" onclick="removeResource(${resourceCounter})">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                </svg>
            </button>
        </div>
    `;
    
    $('#resourceContainer').append(resourceHtml);
    resourceCounter++;
}

function removeResource(index) {
    const resourceCount = $('#resourceContainer .input-group').length;
    
    // Pastikan minimal ada 1 resource yang tersisa
    if (resourceCount > 1) {
        $(`#resource-${index}`).remove();
    } else {
        alert('Minimal harus ada 1 resource!');
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

const jtkJhkModal = new bootstrap.Modal(document.getElementById('jtkandjhkModal')); 
const jtkJhkForm = document.getElementById('jtkJhkForm');
const submitJtkJhkButton = document.getElementById('submitJtkJhkForm');

document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(event){
        if(event.target.classList.contains('edit-resource-btn')){
            const button = event.target.closest('.edit-resource-btn');

            // ini yang bakal diedit dan tidak ada di parameter url
            document.getElementById('form_hresource_id').value = button.dataset.hresourceId;
            document.getElementById('form_role_id').value = button.dataset.roleId;
            // document.getElementById('jumlahTenagaKerja').value = button.dataset.jtk;
            document.getElementById('jumlahHariKerja').value = button.dataset.jhk;
        }
    })
});

if (submitJtkJhkButton) {
    submitJtkJhkButton.addEventListener('click', function(e) {
        e.preventDefault();

        const formData = new FormData(jtkJhkForm); // Ambil semua data dari form
        const url = jtkJhkForm.action; // Ambil URL dari atribut action form
        const method = 'POST';

        // Kirim permintaan AJAX
        fetch(url, {
            method: method,
            body: formData, // FormData akan otomatis mengatur Content-Type: multipart/form-data
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Menandai ini adalah permintaan AJAX
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ambil CSRF token
            }
        })
        .then(response => {
            if (!response.ok) {
                // Jika respons bukan 2xx (misal 422 untuk validasi, 500 untuk error server)
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Terjadi kesalahan saat memproses permintaan.');
                });
            }
            return response.json(); // Parse respons JSON
        })
        .then(data => {
            // Logika jika permintaan sukses
            Swal.fire({
                text: data.message || "Data berhasil diperbarui!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-secondary" }
            }).then(() => {
                jtkJhkModal.hide(); // Sembunyikan modal
                location.reload(); // Reload halaman untuk melihat perubahan
                // ATAU update UI tanpa reload:
                // updateTableRow(data.data); // Panggil fungsi untuk update baris di tabel utama
            });
        })
        .catch(error => {
            // Logika jika ada error (jaringan, validasi, server error)
            console.error('Error updating resource:', error);
            Swal.fire({
                text: error.message || "Terjadi kesalahan yang tidak terduga.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: { confirmButton: "btn btn-danger" }
            });
        });
    });
}
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
</style>