@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="mt-0 mb-2">
                Edit Work Package
            </h1>
        </div>
        <div class="text-end">
            <a href="{{ route('wp-management.detail', $workPackage->wp_id) }}" class="btn btn-light me-2">
                Batal
            </a>
            <button type="button" class="btn btn-primary" onclick="saveWorkPackage()">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <!-- Edit Form  -->
    <form id="editWorkPackageForm" method="POST" action="{{ route('wp-management.update', $workPackage->wp_id) }}">
        @csrf
        @method('PUT')

        {{-- Basic Information Card --}}
        <div class="card card-flush shadow-sm mb-6">
            <div class="card-header py-0">
                <h3 class="card-title">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Informasi Dasar Work Package
                </h3>
            </div>
            <div class="card-body py-0">
                <div class="row">
                    {{-- Category --}}
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold required">Kategori</label>
                        <select class="form-select form-select-solid" name="category_id" required>
                            <option value="">Pilih Work Package</option>
                            @if(isset($categories) && $categories->count() > 0)
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        {{ $workPackage->category_id == $category->category_id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    {{-- Nomor Work Package --}}
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Nomor Work Package</label>
                        <div class="input-group">
                            <span class="input-group-text" id="edit_wp_number_display" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nomor work package saat ini">
                                {{ $workPackage->wp_number }}
                            </span>
                            <input type="number" name="wp_sequence" id="edit_wp_sequence" class="form-control" placeholder="1" min="1" value="{{ explode('.', $workPackage->wp_number)[1] ?? '' }}" required/>
                        </div>
                        <div class="form-text">
                            Nomor urut dalam kategori (contoh: untuk kategori 3, input 2 akan menghasilkan 3.2)
                        </div>
                        <div class="invalid-feedback">
                            Nomor Work Package ini sudah digunakan
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold required">Nama Work Package</label>
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control" 
                            value="{{ $workPackage->name }}" 
                            placeholder="Masukkan nama work package" 
                            required
                        >
                    </div>

                    <!-- Duration -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold required">Durasi (Hari Kerja)</label>
                        <input 
                            type="number" 
                            name="duration" 
                            class="form-control" 
                            value="{{ $workPackage->duration }}" 
                            min="1" 
                            placeholder="20" 
                            required
                            disabled
                        >
                    </div>

                    <div class="col-md-6 mb-4"></div>

                    <!-- Actual Scope -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Actual Scope Contract</label>
                        <textarea 
                            name="actual_scope_contract" 
                            class="form-control" 
                            placeholder="Masukkan actual scope contract"
                        >{{ trim($workPackage->actual_scope_contract) }}</textarea>
                    </div>

                    <!-- Deliverable -->
                    <div class="mb-6">
                        <label class="form-label fw-bold">Deliverables</label>
                        <textarea 
                            name="deliverable" 
                            class="form-control" 
                            rows="8" 
                            placeholder="Masukkan deliverable"
                        >{{ trim($workPackage->deliverable) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Volume Management Card --}}
        <div class="card card-flush shadow-sm mb-6">
            <div class="card-header py-0">
                <h3 class="card-title">
                    <i class="bi bi-collection text-primary me-2"></i>
                    Manajemen Volume ({{ $volumesWithWorkOrderCount }}/{{ $totalVolumeQty }} volume)
                </h3>
                <div class="card-toolbar">
                    <!-- <button type="button" class="btn btn-light-info btn-sm me-2" onclick="openAssignWO()">
                        <i class="bi bi-plus-circle"></i> Assign Work Order
                    </button> -->
                    @if($remainingVolumeSlots > 0)
                        <button type="button" class="btn btn-light-primary btn-sm me-2" onclick="openAddVolume()">
                            <i class="bi bi-plus-circle"></i> Tambah Volume
                        </button>
                    @else
                        <span class="badge badge-light-success">
                            <i class="bi bi-check-circle me-1"></i>
                            Volume sudah penuh
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body py-0">
                <div class ="volume-cards-wrapper mb-4">
                    <div class="row flex-nowrap" id="volumeContainer" style="overflow-x: auto; padding-bottom: 10px;">
                        @foreach($volumesData as $index => $volume)
                            <div class="volume-card-item col-md-6 col-lg-4 mb-4" style="min-width: 300px;">
                                <div class="card card-bordered h-100 shadow-sm hover-elevate-up volume-item" data-volume-id="{{ $volume['volume_id'] }}" data-volume-index="{{ $index }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="card-title mb-0">
                                                <i class="bi bi-folder-fill text-primary me-2"></i>
                                                Volume {{ $volume['volume_number'] }}
                                            </h5>
                                            @if($volumesData->count() > 0)
                                                <button type="button" class="btn btn-light-danger btn-lg" onclick="removeVolume(this, '{{ $volume['volume_id'] }}')">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Hidden inputs -->
                                        <input type="hidden" name="volumes[{{ $index }}][volume_id]" value="{{ $volume['volume_id'] }}">
                                        <input type="hidden" name="volumes[{{ $index }}][volume_number]" value="{{ $volume['volume_number'] }}">

                                        <!-- Volume Status Badge -->
                                        <div class="mb-3">
                                            @if($volume['start_date'] && $volume['end_date'] && $volume['execution_year'] && $volume['wo_id'])
                                                <span class="badge badge-light-success">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Dikonfigurasi
                                                </span>
                                            @else
                                                <span class="badge badge-light-info">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                                    Belum Konfigurasi
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Volume Info -->
                                        <div class="mb-4">
                                            <div class="fw-bold mb-1">
                                                <i class="bi bi-hash me-1"></i>
                                                Work Order
                                            </div>
                                            <div class="fs-7">
                                                @if($volume['wo_number'] ?? false)
                                                    <span>WO {{ $volume['wo_number'] }}</span>
                                                @else
                                                    <span>Belum ditentukan</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="fw-bold mb-1">
                                                <i class="bi bi-calendar-range me-1"></i>
                                                Periode Pelaksanaan
                                            </div>
                                            <div class="fs-7">
                                                @if($volume['start_date'] && $volume['end_date'])
                                                    {{ $volume['period_formatted'] }}
                                                @else
                                                    <span>
                                                        Belum ditentukan
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="fw-bold mb-1">
                                                <i class="bi bi-people me-1"></i>
                                                Resources ({{ $volume['resources']->count() }})
                                            </div>
                                            <div class="fs-7 text-wrap">
                                                @if($volume['resources']->count() > 0)
                                                    {{ $volume['resources']->pluck('role_name')->unique()->implode(', ') }}
                                                @else
                                                    Belum ada resource
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="fw-bold mb-1">
                                                <i class="bi bi-list-task me-1"></i>
                                                Tasks & Progress
                                            </div>
                                            <div class="fs-7">
                                                @php
                                                    $taskCount = \App\Models\Task::where('volume_id', $volume['volume_id'])->count();
                                                    $subtaskCount = \App\Models\SubTask::whereHas('task', function($q) use ($volume) {
                                                        $q->where('volume_id', $volume['volume_id']);
                                                    })->count();
                                                @endphp
                                                
                                                @if($taskCount > 0)
                                                    {{ $taskCount }} Tasks, {{ $subtaskCount }} Sub Tasks
                                                @else
                                                    Belum ada task
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Edit Detail Button -->
                                        <div class="mt-auto">
                                            <button
                                                type="button" 
                                                class="btn {{ $volume['start_date'] && $volume['end_date'] ? 'btn-light-primary' : 'btn-warning' }} btn-sm w-100"
                                                onclick="editVolumeDetails('{{ $volume['volume_id'] }}')"
                                                title="Edit konfigurasi volume"
                                            >
                                                    @if($volume['start_date'] && $volume['end_date'])
                                                        <i class="bi bi-pencil-square me-1"></i>
                                                        Edit Volume
                                                    @else
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        Edit Volume
                                                    @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- No Volumes Message -->
                @if($volumesData->count() == 0)
                    <div class="text-center py-5" id="noVolumesMessage">
                        <i class="bi bi-collection fs-1 text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada volume</h6>
                        <p class="text-muted">Klik "Tambah Volume" untuk menambahkan volume work package</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Human Resources Management Card --}}
        <div class="card card-flush shadow-sm mb-6">
            <div class="card-header py-0">
                <h3 class="card-title">
                    <i class="bi bi-person-lines-fill text-primary me-2"></i>
                    Kebutuhan Tenaga Kerja
                </h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-light-primary btn-sm" onclick="addHumanResource()">
                        <i class="bi bi-plus-circle"></i> Tambah Resource
                    </button>
                </div>
            </div>
            
            <div class="card-body py-0">
                <div id="humanResourceContainer">
                    @foreach($humanResourcesData as $index => $hr)
                        <div class="human-resource-item mb-6 p-4 border rounded shadow-sm" data-index="{{ $index }}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Resource #{{ $index + 1 }}</h6>
                                <button 
                                    type="button" class="btn btn-light-danger"
                                    onclick="removeHumanResource(this)"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">Role/Peran</label>
                                    <select name="resources[{{ $index }}][role_id]" class="form-select" required>
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $role)
                                            @if($role->name !== 'admin' && $role->name !== 'karyawan')
                                                <option 
                                                    value="{{ $role->id }}" 
                                                    {{ $hr['role_id'] == $role->id ? 'selected' : '' }}
                                                >
                                                    {{ $role->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">JTK (Jumlah Tenaga Kerja)</label>
                                    <input 
                                        type="number" 
                                        name="resources[{{ $index }}][jtk]" 
                                        class="form-control" 
                                        value="{{ $hr['jtk'] }}" 
                                        min="1" 
                                        placeholder="1" 
                                        required
                                    >
                                    <div class="form-text">Jumlah orang dengan role ini</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">JHK (Jumlah Hari Kerja)</label>
                                    <input 
                                        type="number" 
                                        name="resources[{{ $index }}][jhk]" 
                                        class="form-control" 
                                        value="{{ $hr['jhk'] }}" 
                                        min="1" 
                                        placeholder="20" 
                                        required
                                    >
                                    <div class="form-text">Total hari kerja untuk role ini</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($humanResourcesData->count() == 0)
                    <div class="text-center py-4" id="noResourcesMessage">
                        <i class="bi bi-people fs-1 text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada kebutuhan tenaga kerja</h6>
                        <p class="text-muted">Klik "Tambah Resource" untuk menambahkan kebutuhan tenaga kerja</p>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <!-- Modal for Add Volume -->
    <div class="modal fade" tabindex="-1" id="kt_modal_add_volume" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="bi bi-plus-circle text-primary me-2"></i>
                        Tambah Volume
                    </h3>
                </div>

                <div class="modal-body">
                    <form id="addVolumeForm">
                        @csrf

                        <!-- Volume Selection -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-folder text-primary me-2 fs-4"></i>
                                <h5 class="mb-0">Pilih Nomor Volume</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold required">Nomor Volume</label>
                                    <select name="volume_number" id="volumeNumberSelect" class="form-select" required>
                                        <option value="">Pilih Nomor Volume</option>
                                    </select>
                                    <div class="form-text">Pilih nomor volume yang akan diaktifkan</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-light-info mt-4">
                                        <div class="small">
                                            <strong>Available:</strong> <span id="availableVolumeInfo">-</span><br>
                                            <strong>Remaining:</strong> <span id="remainingVolumeInfo">{{ $remainingVolumeSlots }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-4"></div>

                        <!-- Period Time -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-calendar-range text-primary me-2 fs-4"></i>
                                <h5 class="mb-0">Konfigurasi Periode</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold required">Start Date</label>
                                    <input type="date" name="start_date" id="addVolumeStartDate" 
                                        class="form-control" required>
                                    <div class="form-text">Tanggal mulai pelaksanaan volume</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold required">End Date</label>
                                    <input type="date" name="end_date" id="addVolumeEndDate" 
                                        class="form-control" required>
                                    <div class="form-text">Tanggal selesai pelaksanaan volume</div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Order Selection -->
                        <!-- <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-hash text-primary me-2 fs-4"></i>
                                <h5 class="mb-0">Pilih Work Order</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold required">Work Order</label>
                                    <select name="wo_id" id="addVolumeWoSelect" class="form-select mb-2" required>
                                        <option value="">Pilih Work Order</option>
                                        <option value="create_new">Buat Work Order Baru</option>
                                    </select>
                                    <div class="d-flex align-items-center">
                                        <span id="addVolumeWoStatusBadge" class="badge badge-light-dark">
                                            <i class="bi bi-clock me-1"></i>Belum dipilih
                                        </span>
                                    </div>
                                    <div class="form-text">Pilih WO yang tersedia atau buat baru</div>
                                </div>
                            </div>
                        </div> -->

                        <!-- New Work Order Form -->
                        <!-- <div id="addVolumeNewWoContainer" style="display: none;" class="mb-4">
                            <div class="alert alert-light-primary py-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <h6 class="mb-0">Buat Work Order Baru</h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold required">Nomor WO</label>
                                        <input type="number" name="new_wo_number" id="addVolumeNewWoNumber" 
                                            class="form-control" min="1" max="999" placeholder="1">
                                        <div class="invalid-feedback" id="addVolumeWoNumberFeedback">
                                            Nomor WO sudah digunakan
                                        </div>
                                        <div class="valid-feedback" id="addVolumeWoNumberValidFeedback">
                                            Nomor WO tersedia
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <div id="addVolumeWoStatusIndicator" class="pb-2">
                                            <i class="bi bi-clock text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Summary -->
                        <div id="addVolumeSummary" style="display: none;" class="alert alert-light-success">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-info-circle me-2"></i>
                                <h6 class="mb-0">Ringkasan</h6>
                            </div>
                            <div id="addVolumeSummaryContent">
                                <!-- Summary content -->
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="executeAddVolume()" id="addVolumeWoBtn">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Volume
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Assign Work Order -->
    <!-- <div class="modal fade" tabindex="-1" id="kt_modal_assign_wo" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Assign Work Order pada Volume
                    </h3>
                </div>

                <div class="modal-body">
                    <form id="assignWoForm">
                        @csrf

                        Work Order Selection
                        <div class="mb-2">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-hash text-primary me-2 fs-4"></i>
                                <h5 class="mb-0">Pilih Work Order</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold required">Work Order</label>
                                    <select name="wo_id" id="woSelect" class="form-select mb-2" required>
                                        <option value="">Pilih Work Order</option>
                                        <option value="create_new" class="text-primary fw-bold">
                                            <i class="bi bi-plus-circle"></i> Buat Work Order Baru
                                        </option>
                                    </select>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-light-dark" id="woStatusBadge">
                                            <i class="bi bi-clock me-1"></i>
                                            Belum dipilih
                                        </span>
                                    </div>
                                    <div class="form-text">Pilih WO yang tersedia atau buat baru</div>
                                </div>
                            </div>
                        </div>

                        New Work Order Form
                        <div id="newWoContainer" style="display: none;" class="mb-6">
                            <div class="alert alert-light-primary py-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <h6 class="mb-0">Buat Work Order Baru</h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold required">Nomor WO</label>
                                        <div class="input-group">
                                            <input 
                                                type="number" 
                                                name="new_wo_number" 
                                                id="newWoNumber" 
                                                class="form-control" 
                                                placeholder="1" 
                                                min="1"
                                                max="999"
                                                required
                                            />
                                            <span class="input-group-text" id="woStatusIndicator">
                                                <i class="bi bi-clock text-muted"></i>
                                            </span>
                                        </div>

                                        <div class="form-text" id="woNumberHelp">
                                            Masukkan nomor work order yang unik
                                        </div>

                                        Invalid feedback
                                        <div class="invalid-feedback" id="woNumberFeedback">
                                            Nomor WO ini sudah digunakan
                                        </div>
                                        
                                        Success feedback
                                        <div class="valid-feedback" id="woNumberValidFeedback">
                                            Nomor WO tersedia
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="alert alert-light-warning py-2 mt-4">
                                            <small>
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Pastikan nomor WO yang dimasukkan belum pernah digunakan sebelumnya
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-6"></div>

                        Volume Selection
                        <div class="mb-6">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-folder text-primary me-2 fs-4"></i>
                                    <h5 class="mb-0">Pilih Volume untuk Assign</h5>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-light-primary btn-sm me-2" onclick="selectAllVolumes()">
                                        Pilih Semua
                                    </button>
                                    <button type="button" class="btn btn-light-danger btn-sm" onclick="clearAllVolumes()">
                                        Bersihkan
                                    </button>
                                </div>
                            </div>

                            <div class="form-text mb-3">
                                Pilih volume yang akan ditetapkan work order. Volume yang sudah memiliki WO akan diganti.
                            </div>

                            <div id="volumeSelectionContainer" class="row mb-4">
                                Volume options akan ditambahkan secara dinamis
                            </div>
                            
                            <div class="invalid-feedback" id="volumeSelectionFeedback">
                                Pilih minimal satu volume untuk assign
                            </div>

                            Assignment Summary
                            <div id="assignmentSummary" style="display: none;" class="">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <h5 class="mb-0">Ringkasan Assignment</h5>
                                </div>
                                <div id="summaryContent">
                                    Summary akan diisi secara dinamis
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="executeAssignWo()" id="assignWoBtn">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection

<style>
.required::after {
    content: " *";
    color: #e63946;
}

.card.card-bordered {
    border: 1px solid #e4e6ef;
    transition: all 0.3s ease;
}

.card.card-bordered:hover {
    border-color: #0d6efd;
}

.hover-elevate-up {
    transition: all 0.3s ease;
}

.hover-elevate-up:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
}

.hover-elevate-up:hover .card-title {
    color: #0d6efd;
}

/* Human Resource Cards */
.human-resource-item {
    border: 1px solid #dee2e6;
    border-radius: 0.475rem;
    background-color: #ffffff;
    transition: all 0.3s ease;
}

.human-resource-item:hover {
    border-color: #0d6efd;
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
    transform: translateY(-2px);
}

/* Form Styling */
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn-light-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.btn-light-danger:hover {
    background-color: #f5c6cb;
    border-color: #f1b0b7;
    color: #721c24;
}

/* Volume Container Styling */
.volume-cards-wrapper .row {
    margin: 0;
}

.volume-cards-wrapper .col-md-6 {
    padding: 0 10px;
}

/* Horizontal scroll styling */
#volumeContainer {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f7fafc;
    padding: 10px 0 20px 0;
}

#volumeContainer::-webkit-scrollbar {
    height: 8px;
}

#volumeContainer::-webkit-scrollbar-track {
    background: #f7fafc;
    border-radius: 4px;
}

#volumeContainer::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 4px;
}

#volumeContainer::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}
</style>

@push('scripts')
<script>
let humanResourceIndex = {{ $humanResourcesData->count() }};
let volumeIndex = {{ $volumesData->count() }};
let maxVolumeNumber = {{ $volumesData->max('volume_number') ?? 0 }};

let originalWpNumber = "{{ $workPackage->wp_number }}";
let originalCategoryId = "{{ $workPackage->category_id }}";

let temporaryAssignments = {};

// Form validation
$(document).ready(function() {
    initEditFormValidation();

    // Date validation
    $('input[type="date"]').on('change', function() {
        const container = $(this).closest('.volume-item');
        const startDate = container.find('input[name*="[start_date]"]').val();
        const endDate = container.find('input[name*="[end_date]"]').val();
        
        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            Swal.fire({
                title: 'Tanggal Tidak Valid',
                text: 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai',
                icon: 'warning',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-warning'
                }
            });
            
            $(this).val('');
        }
    });
});

/**
 * Initialize edit form validation for WP number
 */
function initEditFormValidation() {
    // Auto-update WP number ketika kategori diubah
    $('select[name="category_id"]').on('change', function() {
        const categoryId = $(this).val();
        const sequence = $('#edit_wp_sequence').val();

        if (categoryId && sequence) {
            checkEditWpNumberAvailability(categoryId, sequence);
        } else if (categoryId) {
            // Get next available number for new category
            getNextWpNumber(categoryId);
        } else {
            $('#edit_wp_number_display').text('-');
        }
    });

    // Availability check when sequence manually changes
    $('#edit_wp_sequence').on('input', function() {
        const categoryId = $('select[name="category_id"]').val();
        const sequence = $(this).val();

        if (categoryId && sequence) {
            checkEditWpNumberAvailability(categoryId, sequence);
        }
    });

}

/**
 * Get next available WP number for selected category
 */
function getNextWpNumber(categoryId) {
    $.ajax({
        url: `{{ route('wp-management.next-wp-number') }}`,
        method: 'GET',
        data: { category_id: categoryId },
        success: function(response) {
            if (response.success) {
                // Extract sequence number
                const parts = response.wp_number.split('.');
                const sequence = parts[parts.length - 1];

                $('#edit_wp_sequence').val(sequence);
                $('#edit_wp_number_display').text(response.wp_number);
                $('#edit_wp_number_display').removeClass('text-danger').addClass('text-success');
                $('#edit_wp_sequence').removeClass('is-invalid');
            }
        },
        error: function() {
            console.error('Failed to get next WP number');
            $('#edit_wp_number_display').text('Error').removeClass('text-success').addClass('text-danger');
        }
    });
}

function checkEditWpNumberAvailability(categoryId, sequence) {
    $.ajax({
        url: `{{ route('wp-management.check-wp-number') }}`,
        method: 'GET',
        data: {
            category_id: categoryId,
            sequence: sequence
        },
        success: function(response) {
            if (response.success) {
                $('#edit_wp_number_display').text(response.wp_number);

                const isCurrentWpNumber = response.wp_number === originalWpNumber;

                if (response.available || isCurrentWpNumber) {
                    $('#edit_wp_number_display').removeClass('text-danger').addClass('text-success');
                    $('#edit_wp_sequence').removeClass('is-invalid');
                } else {
                    $('#edit_wp_number_display').removeClass('text-success').addClass('text-danger');
                    $('#edit_wp_sequence').addClass('is-invalid');
                }
            }
        },
        error: function() {
            $('#edit_wp_number_display').text('Error').removeClass('text-success').addClass('text-danger');        
        }
    });
}

/**
 * Save work package changes
 */
function saveWorkPackage() {
    // Validate WP number
    if ($('#edit_wp_sequence').hasClass('is-invalid')) {
        Swal.fire({
            title: 'Nomor Work Package Tidak Valid',
            text: 'Nomor Work Package yang dipilih sudah digunakan. Silakan pilih nomor lain.',
            icon: 'error',
            buttonsStyling: false,
            confirmButtonText: 'Tutup',
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
        return;
    }

    const form = document.getElementById('editWorkPackageForm');
    const formData = new FormData(form);

    // ✅ DEBUG: Check resources data
    console.log('=== Form Debug ===');
    const resourceInputs = document.querySelectorAll('input[name^="resources["], select[name^="resources["]');
    console.log('Resource inputs found:', resourceInputs.length);
    
    // Check each resource input
    resourceInputs.forEach((input, index) => {
        console.log(`Resource input ${index}:`, {
            name: input.name,
            value: input.value,
            type: input.type || input.tagName
        });
    });

    // ✅ DEBUG: Check FormData
    console.log('=== FormData Debug ===');
    for (let pair of formData.entries()) {
        if (pair[0].startsWith('resources[')) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    }

    // ✅ ENSURE: Add resources manually if missing
    let resourcesFound = false;
    for (let pair of formData.entries()) {
        if (pair[0].startsWith('resources[')) {
            resourcesFound = true;
            break;
        }
    }

    if (!resourcesFound) {
        console.warn('No resources found in FormData, checking existing data...');
        
        // Get resources from existing HTML
        const resourceElements = document.querySelectorAll('.human-resource-item');
        if (resourceElements.length === 0) {
            Swal.fire({
                title: 'Resources Diperlukan',
                text: 'Minimal harus ada 1 resource. Silakan tambah resource terlebih dahulu.',
                icon: 'warning',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-warning'
                }
            });
            return;
        }
    }
    // BATAS

    formData.append('wp_sequence', $('#edit_wp_sequence').val());

    if (Object.keys(temporaryAssignments).length > 0) {
        formData.append('work_order_assignments', JSON.stringify(temporaryAssignments));
    }

    // Show loading
    Swal.fire({
        title: 'Menyimpan perubahan...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Submit form via AJAX
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();

        if (data.success) {
            // Clear temporary assignments
            temporaryAssignments = {};

            Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            }).then(() => {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            });

        } else if (data.no_changes) {
            // No changes detected response
            Swal.fire({
                title: 'Tidak Ada Perubahan',
                text: 'Silakan lakukan perubahan terlebih dahulu atau klik Batal untuk kembali.',
                icon: 'info',
                buttonsStyling: false,
                showCancelButton: false,
                confirmButtonText: 'Tutup',
                customClass: {
                    confirmButton: 'btn btn-secondary'
                }
            });

        } else {
            let errorMessage = data.message;
            
            if (data.errors) {
                const errorList = Object.values(data.errors).flat();
                errorMessage += '\n\n' + errorList.join('\n');
            }

            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-secondary'
                }
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);

        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan saat menyimpan perubahan',
            icon: 'error',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-secondary'
            }
        });
    });
}

/**
 * Add new human resource
 */
function addHumanResource() {
    const container = document.getElementById('humanResourceContainer');
    const noResourcesMessage = document.getElementById('noResourcesMessage');
    
    if (noResourcesMessage) {
        noResourcesMessage.style.display = 'none';
    }

    const resourceHtml = `
        <div class="human-resource-item mb-4 p-4 border rounded" data-index="${humanResourceIndex}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Resource #${humanResourceIndex + 1}</h6>
                <button type="button" class="btn btn-sm btn-light-danger" onclick="removeHumanResource(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold required">Role/Peran</label>
                    <select name="resources[${humanResourceIndex}][role_id]" class="form-select" required>
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                            @if ($role->name !== 'admin' && $role->name !== 'karyawan')
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold required">JTK (Jumlah Tenaga Kerja)</label>
                    <input type="number" name="resources[${humanResourceIndex}][jtk]" 
                           class="form-control" min="1" placeholder="Contoh: 1" required>
                    <div class="form-text">Jumlah orang dengan role ini</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold required">JHK (Jumlah Hari Kerja)</label>
                    <input type="number" name="resources[${humanResourceIndex}][jhk]" 
                           class="form-control" min="1" placeholder="Contoh: 20" required>
                    <div class="form-text">Total hari kerja untuk role ini</div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', resourceHtml);
    humanResourceIndex++;
}

/**
 * Remove human resource
 */
function removeHumanResource(button) {
    const resourceItem = button.closest('.human-resource-item');
    const roleSelect = resourceItem.querySelector('select[name*="[role_id]"]');
    const selectedRoleId = roleSelect.value;
    const selectedRoleText = roleSelect.options[roleSelect.selectedIndex]?.text || 'Unknown Role';
    
    if (!selectedRoleId) {
        confirmRemoveResource(resourceItem, selectedRoleText, false, null);
        return;
    }

    // Show loading while checking
    Swal.fire({
        title: 'Memeriksa penggunaan peran...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // AJAX call for checking user assignments
    $.ajax({
        url: `{{ route('wp-management.check-role-assignments') }}`,
        method: 'GET',
        data: {
            wp_id: {{ $workPackage->wp_id }},
            role_id: selectedRoleId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.close();

            if (response.success) {
                confirmRemoveResource(
                    resourceItem, 
                    selectedRoleText, 
                    response.has_assignments, 
                    response.assignment_details
                );
            } else {
                // Fallback jika gagal cek
                confirmRemoveResource(resourceItem, selectedRoleText, true, null);
            }
        },
        error: function(xhr) {
            Swal.close();
            console.error('Error checking role assignments:', xhr);

            // Fallback pada error
            confirmRemoveResource(resourceItem, selectedRoleText, true, null);
        }
    });
}

/**
 * Confirm remove resource with different conditions
 */
function confirmRemoveResource(resourceItem, selectedRoleText, hasAssignments, assignmentDetails) {
    let confirmTitle = 'Konfirmasi Hapus Resource';
    let confirmHtml = '';

    if (hasAssignments && assignmentDetails) {
        confirmHtml = `
            <div class="text-center">
                <p class="mb-3">Apakah Anda yakin ingin menghapus resource <strong>${selectedRoleText}</strong>?</p>
            </div>
            <div class="text-start">
                <div class="alert alert-warning py-2 mb-3">
                    <div class="fw-bold mb-1">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Peringatan:
                    </div>
                    <div class="text-center small">
                        User dengan role ini akan dihapus dari semua Volume di Work Package
                    </div>
                </div>
                
                <div class="alert alert-light-info py-2 mb-3">
                    <div class="fw-bold mb-1">
                        <i class="bi bi-info-circle me-2"></i>
                        User yang akan terpengaruh:
                    </div>
                    <div class="small">
                        ${assignmentDetails.affected_users.map(user => 
                            `• ${user.name}`
                        ).join('<br>')}
                    </div>
                </div>
            </div>
        `;
    } else if (hasAssignments && !assignmentDetails) {
        confirmHtml = `
            <div class="text-center">
                <p class="mb-3">Apakah Anda yakin ingin menghapus resource <strong>${selectedRoleText}</strong>?</p>
            </div>
            <div class="text-start">
                <div class="alert alert-warning py-2 mb-3">
                    <div class="fw-bold mb-1">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Peringatan:
                    </div>
                    <div class="text-center small">
                        User dengan role ini akan dihapus dari semua Volume di Work Package
                    </div>
                </div>
            </div>
        `;
    } else {
        confirmHtml = `
            <div class="text-center">
                <p class="mb-3">Apakah Anda yakin ingin menghapus resource <strong>${selectedRoleText}</strong>?</p>
            </div>
        `;
    }

    Swal.fire({
        title: confirmTitle,
        html: confirmHtml,
        icon: hasAssignments ? 'warning' : 'question',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
    }).then((result) => {
        if (result.isConfirmed) {
            resourceItem.remove();
    
            // Update resource numbering
            updateResourceNumbering();
    
            // Show no resources message if no resources left
            const container = document.getElementById('humanResourceContainer');
            const noResourcesMessage = document.getElementById('noResourcesMessage');
            
            if (container.children.length === 0 && noResourcesMessage) {
                noResourcesMessage.style.display = 'block';
            }
        }
    });
}

/**
 * Update resource numbering after removal
 */
function updateResourceNumbering() {
    const resourceItems = document.querySelectorAll('.human-resource-item');
    
    resourceItems.forEach((item, index) => {
        const header = item.querySelector('h6');
        if (header) {
            header.textContent = `Resource #${index + 1}`;
        }
    });
}

/** VOLUME MANAGEMENT */
// Latest 2 Volume Management
/**
 * Open add volume modal
 */
function openAddVolume() {
    // Reset form
    resetAddVolumeForm();

    // Update modal info before load
    updateModalVolumeInfo();

    // Load available volume numbers
    loadAvailableVolumeNumbers();
    
    // Show modal
    $('#kt_modal_add_volume').modal('show');
}

/**
 * Reset add volume form
 */
function resetAddVolumeForm() {
    const form = document.getElementById('addVolumeForm');
    if (form) {
        form.reset();
    }

    // Reset validation states
    $('#addVolumeStartDate, #addVolumeEndDate').removeClass('is-invalid is-valid');
}

/**
 * Execute add volume
 */
function executeAddVolume() {
    const volumeNumber = $('#volumeNumberSelect').val();
    const startDate = $('#addVolumeStartDate').val();
    const endDate = $('#addVolumeEndDate').val();

    // Validation
    if (!volumeNumber) {
        Swal.fire({
            title: 'Nomor Volume Belum Dipilih',
            text: 'Silakan pilih nomor volume yang akan ditetapkan.',
            icon: 'warning',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-warning'
            }
        });
        return;
    }

    if (!startDate || !endDate) {
        Swal.fire({
            title: 'Periode Belum Lengkap',
            text: 'Silakan isi start date dan end date.',
            icon: 'warning',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-warning'
            }
        });
        return;
    }

    // Validate date range
    if (new Date(startDate) > new Date(endDate)) {
        Swal.fire({
            title: 'Periode Tidak Valid',
            text: 'End date harus sama atau setelah start date.',
            icon: 'error',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-secondary'
            }
        });
        return;
    }

    // Show loading
    Swal.fire({
        title: 'Menambahkan Volume...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Prepare form data
    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('wp_id', {{ $workPackage->wp_id }});
    formData.append('volume_number', volumeNumber);
    formData.append('start_date', startDate);
    formData.append('end_date', endDate);
    // formData.append('execution_year', executionYear);

    // Submit request
    fetch('{{ route("wp-management.add-volume-with-period") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();

        if (data.success) {
            $('#kt_modal_add_volume').modal('hide');

            Swal.fire({
                title: 'Volume Berhasil Ditambahkan!',
                html: `
                    <div class="text-center">
                        <p class="mb-2">Volume ${volumeNumber} telah berhasil ditambahkan</p>
                    </div>
                `,
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                } 
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                title: 'Gagal Menambahkan Volume',
                text: data.message,
                icon: 'error',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-secondary'
                }
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);

        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan saat menambahkan volume',
            icon: 'error',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-secondary'
            }
        });
    });
}

// Event handlers for add volume modal
$(document).ready(function() {
    // Date change handlers
    $('#addVolumeStartDate, #addVolumeEndDate').on('change', function() {
        // updateAddVolume();

        // Update end date minimum
        const startDate = $('#addVolumeStartDate').val();
        if (startDate) {
            $('#addVolumeEndDate').attr('min', startDate);
        }
    });

    // Update modal info when opened
    $('#kt_modal_add_volume').on('show.bs.modal', function () {
        console.log('Modal opening, updating volume info...');
        updateModalVolumeInfo();
        loadAvailableVolumeNumbers();
    });

    // Reset form when modal closed
    $('#kt_modal_add_volume').on('hidden.bs.modal', function() {
        console.log('Modal closed, resetting form...');
        resetAddVolumeForm();
    });
});

/**
 * Update modal volume information
 */
function updateModalVolumeInfo() {
    const totalVolumeQty = {{ $totalVolumeQty }};
    const currentVolumes = document.querySelectorAll('.volume-item');
    const currentVolumeNumbers = [];

    // Get current volume numbers
    currentVolumeNumbers.forEach(volume => {
        const titleElement = volume.querySelector('h5');
        if (titleElement) {
            const match = titleElement.textContent.match(/Volume (\d+)/);
            if (match) {
                currentVolumeNumbers.push(parseInt(match[1]));
            }
        }
    });

    // Update available volume info
    const availableCount = totalVolumeQty - currentVolumeNumbers.length;
    const remainingSlots = availableCount;
    
    // Update modal elements if they exist
    const availableInfo = document.getElementById('availableVolumeInfo');
    const remainingInfo = document.getElementById('remainingVolumeInfo');
    
    if (availableInfo) {
        availableInfo.textContent = `${availableCount} volume tersedia`;
        console.log('Available info updated:', availableInfo.textContent);
    }
    
    if (remainingInfo) {
        remainingInfo.textContent = remainingSlots;
        console.log('Remaining info updated:', remainingInfo.textContent);
    }
    
    // Update volume select options in modal if modal is open
    const modal = document.getElementById('kt_modal_add_volume');
    if (modal && modal.classList.contains('show')) {
        updateModalVolumeSelect(currentVolumeNumbers, totalVolumeQty);
    }
}

/**
 * Load available volume numbers
 */
function loadAvailableVolumeNumbers() {
    const select = $('#volumeNumberSelect');
    select.find('option:gt(0)').remove();
    
    const totalVolumeQty = {{ $totalVolumeQty }};
    // const currentVolumes = @json($volumesData->pluck('volume_number')->toArray());
    const currentVolumes = [];
    const volumeElements = document.querySelectorAll('.volume-item');

    volumeElements.forEach(volume => {
        const titleElement = volume.querySelector('h5');
        if (titleElement) {
            const match = titleElement.textContent.match(/Volume (\d+)/);
            if (match) {
                currentVolumes.push(parseInt(match[1]));
            }
        }
    });
    
    let availableCount = 0;
    
    for (let i = 1; i <= totalVolumeQty; i++) {
        if (!currentVolumes.includes(i)) {
            select.append(new Option(`Volume ${i}`, i));
            availableCount++;
        }
    }
    
    $('#availableVolumeInfo').text(`${availableCount} volume tersedia`);
    $('#remainingVolumeInfo').text(availableCount);
}

/**
 * Update volume select options in modal
 */
function updateModalVolumeSelect(currentVolumeNumbers, totalVolumeQty) {
    const select = document.getElementById('volumeNumberSelect');
    if (!select) return;
    
    // Clear existing options except the first one
    const options = select.querySelectorAll('option');
    for (let i = 1; i < options.length; i++) {
        options[i].remove();
    }

    // Add available volume options
    let availableCount = 0;
    for (let i = 1; i <= totalVolumeQty; i++) {
        if (!currentVolumeNumbers.includes(i)) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = `Volume ${i}`;
            select.appendChild(option);
            availableCount++;
        }
    }
    
    console.log('Modal select updated, available options:', availableCount);
    
    // Reset select value
    select.value = '';
    
    // Update summary
    const summaryContainer = document.getElementById('addVolumeSummary');
    if (summaryContainer) {
        summaryContainer.style.display = 'none';
    }
}

// Latest Volume Management
/**
 * Open add volume modal
 */
function openAddVolumeEarly() {
    // Reset form
    // resetAddVolumeWOForm();

    // Update modal info before load
    // updateModalVolumeInfo();

    // Load available volume numbers
    // loadAvailableVolumeNumbers();
    
    // Load available work orders
    // loadWorkOrdersForAddVolume();
    
    // Show modal
    // $('#kt_modal_add_volume_wo').modal('show');
}

/**
 * Reset add volume work order form
 */
// function resetAddVolumeWOForm() {
//     const form = document.getElementById('addVolumeWoForm');
//     if (form) {
//         form.reset();
//     }
    
//     $('#addVolumeNewWoContainer').hide();
//     $('#addVolumeSummary').hide();
//     $('#addVolumeWoStatusBadge').html('<i class="bi bi-clock me-1"></i>Belum dipilih')
//                                 .removeClass()
//                                 .addClass('badge badge-light-dark');
    
//     // Reset validation states
//     $('#addVolumeNewWoNumber').removeClass('is-invalid is-valid');
// }

// EARLIER VOLUME MANAGEMENT
/**
 * Add new volume
 */
// function addVolume() {
//     const container = document.getElementById('volumeContainer');
//     const noVolumesMessage = document.getElementById('noVolumesMessage');
    
//     if (noVolumesMessage) {
//         noVolumesMessage.style.display = 'none';
//     }

//     // Increase volume number
//     maxVolumeNumber++;

//     const volumeHtml = `
//         <div class="col-md-6 col-lg-4 mb-4">
//             <div class="card card-bordered h-100 hover-elevate-up volume-item" data-volume-id="new_${volumeIndex}" data-volume-index="${volumeIndex}">
//                 <div class="card-body">
//                     <div class="d-flex justify-content-between align-items-start mb-3">
//                         <h5 class="card-title mb-0">
//                             <i class="bi bi-folder-fill text-primary me-2"></i>
//                             Volume ${maxVolumeNumber}
//                         </h5>
//                         <button type="button" class="btn btn-light-danger btn-sm" onclick="removeVolume(this, 'new_${volumeIndex}')">
//                             <i class="bi bi-trash"></i>
//                         </button>
//                     </div>

//                     <!-- Hidden inputs for new volume -->
//                     <input type="hidden" name="volumes[${volumeIndex}][volume_id]" value="new">
//                     <input type="hidden" name="volumes[${volumeIndex}][volume_number]" value="${maxVolumeNumber}">

//                     <!-- New Volume Status -->
//                     <div class="mb-3">
//                         <span class="badge badge-light-dark">
//                             <i class="bi bi-plus-circle me-1"></i>
//                             Volume Baru
//                         </span>
//                     </div>

//                     <!-- New Volume Info -->
//                     <div class="alert alert-success py-2">
//                         <div class="d-flex align-items-center">
//                             <i class="bi bi-check-circle me-2"></i>
//                             <div>
//                                 <strong>Volume Baru Ditambahkan</strong>
//                                 <div class="small">
//                                     Setelah menyimpan, Anda dapat mengkonfigurasi detail volume.
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     `;

//     container.insertAdjacentHTML('beforeend', volumeHtml);
//     volumeIndex++;

//     // Update volume count in header
//     updateVolumeCount();
    
//     // Scroll to show new volume
//     setTimeout(() => {
//         container.scrollLeft = container.scrollWidth;
//     }, 100);
// }

// LATEST REMOVE VOLUME MECHANISM
/**
 * Remove volume (delete work order, period time, and execution year from volume)
 */
function removeVolume(buttonElement, volumeId) {
    const volumeCard = buttonElement.closest('.volume-card-item');
    const volumeElement = buttonElement.closest('.volume-item');
    const volumeNumber = volumeElement.querySelector('h5').textContent.match(/Volume (\d+)/)[1];

    // Show confirmation dialog
    Swal.fire({
        title: 'Hapus Volume',
        html: `
            <div class="text-center">
                <p class="mb-3">Apakah Anda yakin ingin menghapus Volume ${volumeNumber}?</p>
                <div class="alert alert-light-warning py-2">
                    <div class="small">
                        <strong>Data yang akan dihapus:</strong><br>
                        <div class="text-start">
                            • Work Order Assignment<br>
                            • Periode Pelaksanaan (Start Date & End Date)<br>
                            • Tahun Pelaksanaan<br><br>
                        </div>
                    </div>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            executeRemoveVolume(volumeCard, volumeId, volumeNumber);
        }
    });
}

/**
 * Execute remove work order from volume via AJAX
 */
function executeRemoveVolume(volumeCard, volumeId, volumeNumber) {
    // Show loading
    Swal.fire({
        title: 'Menghapus Work Order...',
        html: `
            <div class="text-center">
                <p>Sedang menghapus Work Order dari volume...</p>
                <div class="mt-3">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        `,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false
    });

    // Ajax call
    $.ajax({
        url: `{{ route('wp-management.remove-volume-data', ['volume_id' => ':volume_id']) }}`.replace(':volume_id', volumeId),
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        data: JSON.stringify({
            remove_wo_only: false
        }),
        success: function(response) {
            if (response.success) {
                // Remove volume card from DOM (since it no longer has WO)
                volumeCard.remove();

                // Update volume count in header
                updateVolumeCount();

                // Show success message
                Swal.fire({
                    title: `Volume ${volumeNumber} Berhasil Dihapus`,
                    // text: `Volume ${volumeNumber} telah dihapus, serta Work Order telah dilepas dari volume tersebut.`,
                    html: `
                        <div class="text-center">
                            <p class="mb-2">Volume ${volumeNumber} telah dihapus.</p>
                            <div class="alert alert-light-info py-2 mt-3">
                                <div class="small">
                                    <strong>Data yang dihapus:</strong><br>
                                    <div class="text-start">
                                        • Work Order Assignment<br>
                                        • Periode Pelaksanaan (Start Date & End Date)<br>
                                        • Tahun Pelaksanaan
                                    </div>
                                </div>
                            </div>
                        </div>
                    `,
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                
            } else {
                Swal.fire({
                    title: 'Gagal Menghapus Volume',
                    text: response.message || 'Terjadi kesalahan saat menghapus volume',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'Tutup',
                    customClass: {
                        confirmButton: 'btn btn-secondary'
                    }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan saat menghapus volume';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }

            Swal.fire({
                title: 'Error',
                text: errorMessage,
                icon: 'error',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-secondary'
                }
            });
        }
    });
}

/**
 * Update remaining volume slots info
 */
function updateRemainingVolumeSlots() {
    const volumeCards = document.querySelectorAll('.volume-item');
    const currentVolumeCount = volumeCards.length;
    const totalVolumeQty = {{ $totalVolumeQty }};
    const remainingSlots = totalVolumeQty - currentVolumeCount;

    console.log('=== Remaining Slots Debug ===');
    console.log('Current volume count:', currentVolumeCount);
    console.log('Total volume qty:', totalVolumeQty);
    console.log('Remaining slots:', remainingSlots);

    // Update toolbar
    const toolbar = document.querySelector('.card-toolbar');
    if (toolbar && remainingSlots > 0) {
        // Show add button if there are remaining slots
        const addButton = toolbar.querySelector('button');
        const badge = toolbar.querySelector('.badge');

        if (badge && remainingSlots > 0) {
            // Replace badge with button
            badge.outerHTML = `
                <button type="button" class="btn btn-light-primary btn-sm me-2" onclick="openAddVolume()">
                    <i class="bi bi-plus-circle"></i> Tambah Volume
                </button>
            `;
        }
    }
}

/**
 * Update volume count in header
 */
function updateVolumeCount() {
    const volumeCards = document.querySelectorAll('.volume-item');
    const volumeCount = volumeCards.length;
    const totalVolumeQty = {{ $totalVolumeQty }};

    console.log('=== Volume Count Debug ===');
    console.log('Volume cards found:', volumeCount);
    console.log('Total volume qty:', totalVolumeQty);

    // Update header title
    const volumeManagementCard = document.querySelector('.card-flush.shadow-sm.mb-6:has(.bi-collection)');
    const headerTitle = volumeManagementCard ? volumeManagementCard.querySelector('.card-title') : null;
    if (headerTitle && headerTitle.textContent.includes('Manajemen Volume')) {
        headerTitle.innerHTML = `<i class="bi bi-collection text-primary me-2"></i>Manajemen Volume (${volumeCount}/${totalVolumeQty} volume)`;
        console.log('Header updated:', headerTitle.innerHTML);
    }

    updateNoVolumeMessage();

    updateRemainingVolumeSlots();
}

/**
 * Show no volume message
 */
function updateNoVolumeMessage() {
    const remainingVolumes = document.querySelectorAll('.volume-item').length;
    const noVolumesMessage = document.getElementById('noVolumesMessage');

    if (remainingVolumes === 0) {
        if (noVolumesMessage) {
            noVolumesMessage.style.display = 'block';
        } else {
            const volumeCardsWrapper = document.querySelector('.volume-cards-wrapper');
            if (volumeCardsWrapper) {
                const newNoVolumesMessage = document.createElement('div');
                newNoVolumesMessage.id = 'noVolumesMessage';
                newNoVolumesMessage.className = 'text-center py-5';
                newNoVolumesMessage.innerHTML = `
                    <i class="bi bi-collection fs-1 text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada volume</h6>
                    <p class="text-muted">Klik "Tambah Volume" untuk menambahkan volume work package</p>
                `;

                volumeCardsWrapper.parentNode.insertBefore(newNoVolumesMessage, volumeCardsWrapper.nextSibling);
            }
        }
    } else {
        if (noVolumesMessage) {
            noVolumesMessage.style.display = 'none';
        }
    }

    // Update modal information
    updateModalVolumeInfo();
}

/**
 * Update volume select options in modal
 */
// function updateModalVolumeSelect(currentVolumeNumbers, totalVolumeQty) {
//     const select = document.getElementById('volumeNumberSelect');
//     if (!select) return;
    
//     // Clear existing options except the first one
//     const options = select.querySelectorAll('option');
//     for (let i = 1; i < options.length; i++) {
//         options[i].remove();
//     }

//     // Add available volume options
//     let availableCount = 0;
//     for (let i = 1; i <= totalVolumeQty; i++) {
//         if (!currentVolumeNumbers.includes(i)) {
//             const option = document.createElement('option');
//             option.value = i;
//             option.textContent = `Volume ${i}`;
//             select.appendChild(option);
//             availableCount++;
//         }
//     }
    
//     console.log('Modal select updated, available options:', availableCount);
    
//     // Reset select value
//     select.value = '';
    
//     // Update summary
//     const summaryContainer = document.getElementById('addVolumeSummary');
//     if (summaryContainer) {
//         summaryContainer.style.display = 'none';
//     }
// }

/**
 * Update volume numbering after removal
 */
// function updateVolumeNumbering() {
//     const volumeCards = document.querySelectorAll('.volume-item');
    
//     volumeCards.forEach((card, index) => {
//         const volumeNumber = index + 1;
//         const header = card.querySelector('h5');
//         if (header) {
//             header.innerHTML = `<i class="bi bi-folder-fill text-primary me-2"></i>Volume ${volumeNumber}`;
//         }

//         // Update hidden input for volume number
//         const volumeNumberInput = card.querySelector('input[name*="[volume_number]"]');
//         if (volumeNumberInput) {
//             volumeNumberInput.value = volumeNumber;
//         }
//     });

//     // Update maxVolumeNumber
//     maxVolumeNumber = volumeCards.length;
// }

/**
 * Edit volume details - rediect to volume detail page
 */
function editVolumeDetails(volumeId) {
    if (volumeId && !volumeId.toString().startsWith('new_')) {
        const referrerUrl = `{{ route('work-package.detail', ['volume_id' => ':volume_id']) }}`.replace(':volume_id', volumeId) + '?referrer=edit&wp_id={{ $workPackage->wp_id }}';
        // window.location.href = `{{ route('work-package.detail', ['volume_id' => ':volume_id']) }}`.replace(':volume_id', volumeId);
        window.location.href = referrerUrl;
    } else {
        Swal.fire({
            title: 'Volume Belum Tersimpan',
            text: 'Silakan simpan work package terlebih dahulu sebelum mengedit detail volume.',
            icon: 'info',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
    }
}
</script>
@endpush