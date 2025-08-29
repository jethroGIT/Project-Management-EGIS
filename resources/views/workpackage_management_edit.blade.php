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
                        <select class="form-select form-select-solid" name="category_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    {{ $workPackage->category_id == $category->category_id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
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
                    Manajemen Volume ({{ $volumesData->count() }})
                </h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-light-info btn-sm me-2" onclick="openAssignWO()">
                        <i class="bi bi-plus-circle"></i> Assign Work Order
                    </button>
                    <button type="button" class="btn btn-light-success btn-sm me-2" onclick="addVolume()">
                        <i class="bi bi-plus-circle"></i> Tambah Volume
                    </button>
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
                                            @if($volumesData->count() > 1)
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
                                            @if($volume['start_date'] && $volume['end_date'] && $volume['execution_year'])
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

    <!-- Modal for Assign Work Order -->
    <div class="modal fade" tabindex="-1" id="kt_modal_assign_wo" data-bs-backdrop="static" data-bs-keyboard="false">
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

                        <!-- Work Order Selection -->
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
                                    <div class="form-text">Pilih WO yang sudah ada atau buat baru</div>
                                </div>
                            </div>
                        </div>

                        <!-- New Work Order Form -->
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

                                        <!-- Invalid feedback -->
                                        <div class="invalid-feedback" id="woNumberFeedback">
                                            Nomor WO ini sudah digunakan
                                        </div>
                                        
                                        <!-- Success feedback -->
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

                        <!-- Volume Selection -->
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
                                <!-- Volume options akan ditambahkan secara dinamis -->
                            </div>
                            
                            <div class="invalid-feedback" id="volumeSelectionFeedback">
                                Pilih minimal satu volume untuk assign
                            </div>

                            <!-- Assignment Summary -->
                            <div id="assignmentSummary" style="display: none;" class="">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <h5 class="mb-0">Ringkasan Assignment</h5>
                                </div>
                                <div id="summaryContent">
                                    <!-- Summary akan diisi secara dinamis -->
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
    </div>
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
/**
 * Add new volume
 */
function addVolume() {
    const container = document.getElementById('volumeContainer');
    const noVolumesMessage = document.getElementById('noVolumesMessage');
    
    if (noVolumesMessage) {
        noVolumesMessage.style.display = 'none';
    }

    // Increase volume number
    maxVolumeNumber++;

    const volumeHtml = `
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-bordered h-100 hover-elevate-up volume-item" data-volume-id="new_${volumeIndex}" data-volume-index="${volumeIndex}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-folder-fill text-primary me-2"></i>
                            Volume ${maxVolumeNumber}
                        </h5>
                        <button type="button" class="btn btn-light-danger btn-sm" onclick="removeVolume(this, 'new_${volumeIndex}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                    <!-- Hidden inputs for new volume -->
                    <input type="hidden" name="volumes[${volumeIndex}][volume_id]" value="new">
                    <input type="hidden" name="volumes[${volumeIndex}][volume_number]" value="${maxVolumeNumber}">

                    <!-- New Volume Status -->
                    <div class="mb-3">
                        <span class="badge badge-light-dark">
                            <i class="bi bi-plus-circle me-1"></i>
                            Volume Baru
                        </span>
                    </div>

                    <!-- New Volume Info -->
                    <div class="alert alert-success py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle me-2"></i>
                            <div>
                                <strong>Volume Baru Ditambahkan</strong>
                                <div class="small">
                                    Setelah menyimpan, Anda dapat mengkonfigurasi detail volume.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', volumeHtml);
    volumeIndex++;

    // Update volume count in header
    updateVolumeCount();
    
    // Scroll to show new volume
    setTimeout(() => {
        container.scrollLeft = container.scrollWidth;
    }, 100);
}

/**
 * Remove last volume with validation
 */
function removeVolume(buttonElement, volumeId) {
    const volumeCard = buttonElement.closest('.col-md-6');
    const volumeElement = buttonElement.closest('.volume-item');
    const volumeNumber = volumeElement.querySelector('h5').textContent.match(/Volume (\d+)/)[1];

    // Remove new volume
    if (volumeId.toString().startsWith('new_')) {
        confirmRemoveVolume(volumeCard, null, volumeNumber);
        return;
    }

    // Check if existing volume has associated data
    checkVolumeAssociations(volumeId, volumeCard, volumeNumber);
}

/**
 * Check volume associations before deletion
 */
function checkVolumeAssociations(volumeId, volumeCard, volumeNumber) {
    // Show loading
    Swal.fire({
        title: 'Memeriksa data terkait...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Make AJAX call to check associations
    $.ajax({
        url: `{{ route('wp-management.check-volume-associations', ['volume_id' => ':volume_id']) }}`.replace(':volume_id', volumeId),
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.close();

            if (response.success) {
                if (response.has_associations) {
                    // Volume has associations, show warning
                    showVolumeAssociationWarning(response.associations, volumeCard, volumeNumber, volumeId);
                } else {
                    // Safe to delete
                    confirmRemoveVolume(volumeCard, volumeId, volumeNumber);
                }
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message || 'Gagal memeriksa data volume',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-secondary'
                    }
                });
            }
        },
        error: function(xhr) {
            Swal.close();

            let errorMessage = 'Terjadi kesalahan saat memeriksa data volume';
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
 * Show volume association warning with force deletion
 */
function showVolumeAssociationWarning(associations, volumeCard, volumeNumber, volumeId) {
    let warningText = `Volume ${volumeNumber} memiliki data terkait yang akan ikut terhapus:\n\n`;
    
    let associationsList = [];
    if (associations.tasks_count > 0) {
        associationsList.push(`• ${associations.tasks_count} Task(s)`);
        // warningText += `• ${associations.tasks_count} Task(s)\n`;
    }
    if (associations.subtasks_count > 0) {
        associationsList.push(`• ${associations.subtasks_count} Sub Task(s)`);
        // warningText += `• ${associations.subtasks_count} Sub Task(s)\n`;
    }
    if (associations.resources_count > 0) {
        associationsList.push(`• ${associations.resources_count} Resource Assignment(s)`);
        // warningText += `• ${associations.resources_count} Resource Assignment(s)\n`;
    }
    if (associations.timesheets_count > 0) {
        associationsList.push(`• ${associations.timesheets_count} Timesheet Record(s)`);
        // warningText += `• ${associations.timesheets_count} Timesheet Record(s)\n`;
    }

    const associationsText = associationsList.join('\n');

    Swal.fire({
        title: 'Konfirmasi Hapus Volume',
        html: `
            <div class="text-start">
                <p class="mb-3">Volume <strong>${volumeNumber}</strong> memiliki data terkait yang akan ikut terhapus:</p>
                <div class="alert alert-warning py-2 mb-3">
                    <div class="fw-bold mb-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Data yang akan dihapus:
                    </div>
                    <div style="white-space: pre-line;">${associationsText}</div>
                </div>
                <div class="py-2">
                    <div class="fw-bolder text-danger">
                        Peringatan
                    </div>
                    <div class="small">
                        Tindakan ini tidak dapat dibatalkan. Semua data di atas akan dihapus secara permanen.
                    </div>
                </div>
            </div>
        `,
        // text: warningText,
        icon: 'warning',
        buttonsStyling: false,
        confirmButtonText: 'Ya, Hapus',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        width: '500px'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to volume detail page
            // const volumeElement = volumeCard.querySelector('.volume-item');
            // const volumeId = volumeElement.getAttribute('data-volume-id');
            // editVolumeDetails(volumeId);

            // Procees with force delete
            confirmForceRemoveVolume(volumeCard, volumeId, volumeNumber, associations);
        }
    });
}

/**
 * Confirm volume removal with all associated data 
 */
function confirmForceRemoveVolume(volumeCard, volumeId, volumeNumber, associations) {
    // Show final confirmation
    Swal.fire({
        title: 'Konfirmasi Hapus Volume',
        html: `
            <div class="text-center">
                <p class="mb-2">Anda yakin ingin menghapus <strong>Volume ${volumeNumber}</strong>?</p>
            </div>
        `,
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Execute force delete
            executeVolumeForceDelete(volumeCard, volumeId, volumeNumber, associations);
        }
    });
}

/**
 * Execute volume force delete via AJAX
 */
function executeVolumeForceDelete(volumeCard, volumeId, volumeNumber, associations) {
    // Show loading
    Swal.fire({
        title: "Menghapus Volume...",
        html: `
            <div class="text-center">
                <p>Sedang menghapus volume...</p>
                <div class="mt-3">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        `,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false
    });

    // AJAX call to force delete volume
    $.ajax({
        url: `{{ route('wp-management.force-delete-volume', ['volume_id' => ':volume_id']) }}`.replace(':volume_id', volumeId),
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        data: JSON.stringify({
            force: true,
            associations: associations
        }),
        success: function(response) {
            if (response.success) {
                // Remove from DOM
                volumeCard.remove();

                // Update numbering and UI
                updateVolumeNumbering();
                updateVolumeCount();

                // Show success message with summary
                let deletedSummary = [];
                if (associations.tasks_count > 0) {
                    deletedSummary.push(`${associations.tasks_count} Task(s)`);
                }
                if (associations.subtasks_count > 0) {
                    deletedSummary.push(`${associations.subtasks_count} Sub Task(s)`);
                }
                if (associations.resources_count > 0) {
                    deletedSummary.push(`${associations.resources_count} Resource Assignment(s)`);
                }
                if (associations.timesheets_count > 0) {
                    deletedSummary.push(`${associations.timesheets_count} Timesheet Record(s)`);
                }

                Swal.fire({
                    title: 'Volume Berhasil Dihapus',
                    html: `
                        <div class="text-center">
                            <p class="mb-2">Volume ${volumeNumber} berhasil dihapus.</p>
                            ${deletedSummary.length > 0 ? `
                                <div class="alert alert-info py-2 mt-3">
                                    <div class="fw-bold mb-1">Data yang ikut terhapus:</div>
                                    <div class="small">${deletedSummary.join(', ')}</div>
                                </div>
                            ` : ''}
                        </div>
                    `,
                    icon: 'success',
                    timer: 4000,
                    timerProgressBar: true,
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });

                // Show no volumes message if no volumes left
                const remainingVolumes = document.querySelectorAll('.volume-item').length;
                const noVolumesMessage = document.getElementById('noVolumesMessage');
                if (remainingVolumes === 0 && noVolumesMessage) {
                    noVolumesMessage.style.display = 'block';
                }
            } else {
                Swal.fire({
                    title: 'Gagal Menghapus Volume',
                    text: response.message || 'Terjadi kesalahan saat menghapus volume',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
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
 * Confirm volume removal
 */
function confirmRemoveVolume(volumeCard, volumeId, volumeNumber) {
    Swal.fire({
        title: 'Konfirmasi Hapus Volume',
        text: `Apakah Anda yakin ingin menghapus Volume ${volumeNumber}?`,
        icon: 'warning',
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
            // If it's an existing volume, mark for deletion
            if (volumeId && !volumeId.startsWith('new_')) {
                // Add hidden input to mark for deletion
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'deleted_volumes[]';
                deleteInput.value = volumeId;
                document.getElementById('editWorkPackageForm').appendChild(deleteInput);
            }

            // Remove from DOM
            volumeCard.remove();

            // Update numbering and UI
            updateVolumeNumbering();
            updateVolumeCount();

            // Show success message
            Swal.fire({
                title: 'Volume Dihapus',
                text: `Volume ${volumeNumber} berhasil dihapus.`,
                icon: 'success',
                timer: 2000,
                timerProgressBar: true,
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });

            // Show no volumes message if no volumes left
            const remainingVolumes = document.querySelectorAll('.volume-item').length;
            const noVolumesMessage = document.getElementById('noVolumesMessage');
            if (remainingVolumes === 0 && noVolumesMessage) {
                noVolumesMessage.style.display = 'block';
            }
        }
    });
}

/**
 * Update volume numbering after removal
 */
function updateVolumeNumbering() {
    const volumeCards = document.querySelectorAll('.volume-item');
    
    volumeCards.forEach((card, index) => {
        const volumeNumber = index + 1;
        const header = card.querySelector('h5');
        if (header) {
            header.innerHTML = `<i class="bi bi-folder-fill text-primary me-2"></i>Volume ${volumeNumber}`;
        }

        // Update hidden input for volume number
        const volumeNumberInput = card.querySelector('input[name*="[volume_number]"]');
        if (volumeNumberInput) {
            volumeNumberInput.value = volumeNumber;
        }
    });

    // Update maxVolumeNumber
    maxVolumeNumber = volumeCards.length;
}

/**
 * Update volume count
 */
function updateVolumeCount() {
    const volumeCount = document.querySelectorAll('.volume-item').length;
    const headerTitle = document.querySelector('.card-title');
    if (headerTitle && headerTitle.textContent.includes('Manajemen Volume')) {
        headerTitle.innerHTML = `<i class="bi bi-collection text-primary me-2"></i>Manajemen Volume (${volumeCount})`;
    }
}

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

/* Work Order Assignment */
let availableWorkOrders = [];
let selectedVolumes = [];
let temporaryAssignments = {};

/**
 * Open assign work order modal
 */
function openAssignWO() {
    // reset form and variables
    resetAssignWOForm();

    // Load available work orders
    loadAvailableWorkOrders();

    // Load volume options
    loadVolumeOptions();

    // Show modal
    $('#kt_modal_assign_wo').modal('show');
}

/**
 * Reset assign work order form
 */
function resetAssignWOForm() {
    const assignWoForm = document.getElementById('assignWoForm');
    if (assignWoForm) {
        assignWoForm.reset();
    }

    // $('#assignWoForm')[0].reset();
    $('#newWoContainer').hide();
    $('#assignmentSummary').hide();
    $('#woStatusBadge').html('<i class="bi bi-clock me-1"></i>Belum dipilih')
                        .removeClass()
                        .addClass('badge badge-light-dark');
    selectedVolumes = [];
    updateAssignmentSummary();
}

/**
 * Load available work orders
 */
function loadAvailableWorkOrders() {
    $.ajax({
        url: '{{ route("wp-management.available-work-orders") }}',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                availableWorkOrders = response.work_orders;
                populateWorkOrderSelect();
            } else {
                console.error('Failed to load work orders:', response.message);
            }
        },
        error: function(xhr) {
            console.error('Error loading work orders:', xhr);
        }
    });
}

/**
 * Populate work order select dropdown
 */
function populateWorkOrderSelect() {
    const select = $('#woSelect');

    // Clear existing options except default ones
    select.find('option:gt(1)').remove();
    
    // Add available work orders
    availableWorkOrders.forEach(function(wo) {
        const isUsed = wo.usage_count > 0;
        const statusIcon = isUsed ? '🔄' : '✅';
        const statusText = isUsed ? ` (Digunakan ${wo.usage_count} kali)` : ' (Tersedia)';
        
        const option = new Option(
            `WO ${wo.wo_number} ${statusText}`,
            wo.wo_id
        );
        
        // if (isUsed) {
        //     option.style.color = '#6c757d';
        // }
        
        select.append(option);
    });
}

/**
 * Load volume options for selection
 */
function loadVolumeOptions() {
    const container = $('#volumeSelectionContainer');
    container.empty();

    // Get volumes from current page data
    const volumes = @json($volumesData);

    if (volumes.length === 0) {
        container.html(`
            <div class="text-center py-4">
                <i class="bi bi-folder fs-2 text-muted mb-2"></i>
                <p class="text-muted mb-0">Tidak ada volume tersedia</p>
            </div>
        `);
        return;
    }

    volumes.forEach(function(volume, index) {
        const currentAssignment = temporaryAssignments[volume.volume_id];
        const hasWo = currentAssignment || volume.wo_number;
        const woText = currentAssignment ? 
            `(Akan di-assign: ${currentAssignment.wo_number})` : 
            (volume.wo_number ? `(WO ${volume.wo_number})` : 'Belum ada WO');
        const badgeClass = currentAssignment ? 
            'badge-light-info' : 
            (hasWo ? 'badge-light-info' : 'badge-light-dark');

        const volumeHtml = `
            <div class="col-md-6 mb-3">
                <div class="form-check volume-option d-flex justify-content-between align-items-center" data-volume-id="${volume.volume_id}">
                    <input 
                        class="form-check-input volume-checkbox" 
                        type="checkbox" 
                        value="${volume.volume_id}" 
                        id="volume_${volume.volume_id}"
                        onchange="handleVolumeSelection()"
                    >
                    <label class="form-check-label w-100 ps-2" for="volume_${volume.volume_id}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Volume ${volume.volume_number}</strong>
                                <div class="small text-muted">${volume.period_formatted || 'Belum dikonfigurasi'}</div>
                            </div>
                            <span class="badge ${badgeClass}">
                                ${woText}
                            </span>
                        </div>
                    </label>
                </div>
            </div>
        `;

        container.append(volumeHtml);
    });
}

/**
 * Handle volume selection changes
 */
function handleVolumeSelection() {
    selectedVolumes = [];
    $('.volume-checkbox:checked').each(function() {
        const volumeId = $(this).val();
        const container = $(`.volume-option[data-volume-id="${volumeId}"]`);
        
        if ($(this).prop('checked')) {
            selectedVolumes.push($(this).val());
            container.addClass('selected');
        } else {
            container.removeClass('selected');
        }
    });

    updateAssignmentSummary();
}

/**
 * Select all volumes
 */
function selectAllVolumes() {
    $('.volume-checkbox').prop('checked', true);
    $('.volume-option').addClass('selected');
    handleVolumeSelection();
}

/**
 * Clear all volume selections
 */
function clearAllVolumes() {
    $('.volume-checkbox').prop('checked', false);
    $('.volume-option').removeClass('selected');
    handleVolumeSelection();
}

/**
 * Update assignment summary
 */
function updateAssignmentSummary() {
    const summaryContainer = $('#assignmentSummary');
    const summaryContent = $('#summaryContent');

    if (selectedVolumes.length === 0) {
        summaryContainer.hide();
        return;
    }

    const woSelect = $('#woSelect').val();
    let woText = 'Belum dipilih';
    
    if (woSelect === 'create_new') {
        const newWoNumber = $('#newWoNumber').val();
        if (newWoNumber) {
            woText = `Buat baru: ${newWoNumber}`;
        } else {
            woText = 'Buat baru: (nomor belum diisi)';
        }
    } else if (woSelect) {
        const selectedWo = availableWorkOrders.find(wo => wo.wo_id == woSelect);
        if (selectedWo) {
            woText = `${selectedWo.wo_number}`;
        }
    }

    summaryContent.html(`
        <div class="row alert">
            <div class="col-md-6">
                <div class="fw-bold">Work Order:</div>
                <div class="">${woText}</div>
            </div>
            <div class="col-md-6">
                <div class="fw-bold">Volume Terpilih:</div>
                <div class="">${selectedVolumes.length} volume</div>
            </div>
        </div>
    `);

    summaryContainer.show();
}

$(document).ready(function() {
    // Work order select change handler
    $('#woSelect').on('change', function() {
        const selectedValue = $(this).val();

        if (selectedValue === 'create_new') {
            $('#newWoContainer').show();
            $('#woStatusBadge').html('<i class="bi bi-plus-circle me-1"></i>Buat Baru')
                                .removeClass()
                                .addClass('badge badge-light-primary');
            loadNextWoNumber();
        } else if (selectedValue) {
            $('#newWoContainer').hide();
            const selectedWo = availableWorkOrders.find(wo => wo.wo_id == selectedValue);
            if (selectedWo) {
                const statusClass = 'badge-light-success';
                const statusIcon = 'check-circle';
                const statusText = `Tersedia (${selectedWo.usage_count} penggunaan)`;
                
                $('#woStatusBadge').html(`<i class="bi bi-${statusIcon} me-1"></i>${statusText}`)
                                  .removeClass()
                                  .addClass(`badge ${statusClass}`);
            }
        } else {
            $('#newWoContainer').hide();
            $('#woStatusBadge').html('<i class="bi bi-clock me-1"></i>Belum dipilih')
                                .removeClass()
                                .addClass('badge badge-light-dark');
        }

        updateAssignmentSummary();
    });

    // New WO number input handler
    let woValidationTimeout;
    $('#newWoNumber').on('input', function() {
        const woNumber = $(this).val();

        // Clear previous timeout
        clearTimeout(woValidationTimeout);

        // Reset states
        resetWoNumberValidation();

        if (woNumber && woNumber.trim() !== '') {
            // Show loading state
            showWoNumberLoading();

            woValidationTimeout = setTimeout(() => {
                checkWoNumberAvailability(woNumber);
            }, 500);
        }

        updateAssignmentSummary();
    });

    // WO number blur validation
    $('#newWoNumber').on('blur', function() {
        const woNumber = $(this).val();

        if (woNumber && woNumber.trim() !== '') {
            clearTimeout(woValidationTimeout);
            showWoNumberLoading();
            checkWoNumberAvailability(woNumber);
        }
    });
});

/**
 * Load next available WO number
 */
function loadNextWoNumber() {
    // Show loading state
    showWoNumberLoading();

    $.ajax({
        url: '{{ route("wp-management.next-wo-number") }}',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('#newWoNumber').val(response.next_wo_number);

                // Auto-validate the suggested number
                setTimeout(() => {
                    checkWoNumberAvailability(response.next_wo_number);
                }, 100);

                updateAssignmentSummary();
            } else {
                showWoNumberError('Gagal memuat nomor WO berikutnya');
            }
        },
        error: function(xhr) {
            console.error('Error loading next WO number:', xhr);
            showWoNumberError('Gagal memuat nomor WO berikutnya');
        }
    });
}

/**
 * Execute work order assignment
 */
function executeAssignWo() {
    // Validation
    if (selectedVolumes.length === 0) {
        Swal.fire({
            title: 'Volume Belum Dipilih',
            text: 'Silakan pilih minimal satu volume untuk di-assign work order.',
            icon: 'warning',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-warning'
            }
        });
        return;
    }

    const woSelect = $('#woSelect').val();
    if (!woSelect) {
        Swal.fire({
            title: 'Work Order Belum Dipilih',
            text: 'Silakan pilih work order atau buat work order baru.',
            icon: 'warning',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-warning'
            }
        });
        return;
    }

    if (woSelect === 'create_new') {
        const newWoNumber = $('#newWoNumber').val();
        const woInput = $('#newWoNumber');

        if (!newWoNumber) {
            Swal.fire({
                title: 'Nomor WO Belum Diisi',
                text: 'Silakan isi nomor work order yang akan dibuat.',
                icon: 'warning',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-warning'
                }
            });
            woInput.focus();
            return;
        }

        // Check if WO number has validation error
        if (woInput.hasClass('is-invalid')) {
            Swal.fire({
                title: 'Nomor WO Tidak Valid',
                text: 'Nomor WO yang dimasukkan sudah digunakan. Silakan gunakan nomor lain.',
                icon: 'error',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-secondary'
                }
            });
            woInput.focus();
            return;
        }

        // Check if WO number validation is still loading
        const indicator = $('#woStatusIndicator');
        if (indicator.find('.spinner-border').length > 0) {
            Swal.fire({
                title: 'Validasi Sedang Berlangsung',
                text: 'Mohon tunggu hingga validasi nomor WO selesai.',
                icon: 'info',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-info'
                }
            });
            return;
        }
    }

    // Store temporary assignments
    let assignmentDetails = {};
    
    if (woSelect === 'create_new') {
        const newWoNumber = parseInt($('#newWoNumber').val());
        assignmentDetails = {
            type: 'new',
            wo_number: newWoNumber
        };
    } else {
        const selectedWo = availableWorkOrders.find(wo => wo.wo_id == woSelect);
        assignmentDetails = {
            type: 'existing',
            wo_id: selectedWo.wo_id,
            wo_number: selectedWo.wo_number
        };
    }

    // Store temporary assignments
    selectedVolumes.forEach(volumeId => {
        temporaryAssignments[volumeId] = assignmentDetails;
    });

    Swal.fire({
        title: 'Assignment Disimpan Sementara',
        html: `
            <div class="text-center">
                <div class="alert alert-light-info">
                    <div class="fw-bold mb-2">Detail Assignment:</div>
                    <div class="small">
                        <strong>Work Order:</strong> ${assignmentDetails.wo_number}<br>
                        <strong>Volume Assigned:</strong> ${selectedVolumes.length}
                    </div>
                </div>
                <div class="alert alert-light-warning">
                    <small><i class="bi bi-info-circle me-1"></i>Assignment akan disimpan secara permanen saat tombol "Simpan Perubahan" ditekan.</small>
                </div>
            </div>
        `,
        icon: 'success',
        buttonsStyling: false,
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-primary'
        }
    }).then(() => {
        // Close modal and refresh volume display
        $('#kt_modal_assign_wo').modal('hide');
        refreshVolumeDisplay();
    });
}

/**
 * Refresh volume display to show temporary assignments
 */
function refreshVolumeDisplay() {
    // Update volume cards to show temporary assignments
    Object.keys(temporaryAssignments).forEach(volumeId => {
        const assignment = temporaryAssignments[volumeId];
        const volumeCard = $(`.volume-item[data-volume-id="${volumeId}"]`);
        
        if (volumeCard.length) {
            const woInfo = volumeCard.find('.mb-4:has(.bi-hash)');
            if (woInfo.length) {
                woInfo.find('.fs-7').html(`
                    <span class="badge badge-light-info">
                        ${assignment.wo_number} (Belum disimpan)
                    </span>
                `);
            }
        }
    });
}

/**
 * Check WO number availability
 */
function checkWoNumberAvailability(woNumber) {
    $.ajax({
        url: '{{ route("wp-management.check-wo-number") }}',
        method: 'GET',
        data : {wo_number : woNumber},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                if (response.available) {
                    showWoNumberSuccess();
                } else {
                    showWoNumberError('Nomor WO sudah digunakan');
                }
            } else {
                showWoNumberError(response.message ||'Gagal memeriksa nomor WO');
            }
        },
        error: function(xhr) {
            console.error('Error checking WO number:', xhr);
            showWoNumberError('Terjadi kesalahan saat memeriksa nomor WO');
        }
    });
}

/**
 * Reset WO number validation state
 */
function resetWoNumberValidation() {
    const input = $('#newWoNumber');
    const indicator = $('#woStatusIndicator');
    const helpText = $('#woNumberHelp');
    const feedback = $('#woNumberFeedback');
    const validFeedback = $('#woNumberValidFeedback');

    // Remove all validation classes
    input.removeClass('is-invalid is-valid');

    // Reset indicator
    indicator.html('<i class="bi bi-clock text-muted"></i>');

    // Reset help text
    helpText.text('Masukkan nomor work order yang unik').removeClass('text-danger text-success');

    // Hide feedback messages
    feedback.hide();
    validFeedback.hide();
}

/**
 * Show WO number loading state
 */
function showWoNumberLoading() {
    const indicator = $('#woStatusIndicator');
    const helpText = $('#woNumberHelp');

    indicator.html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>');
    helpText.text('Memeriksa ketersediaan nomor WO...').removeClass('text-danger text-success').addClass('text-muted');
}

/**
 * Show WO number success state
 */
function showWoNumberSuccess() {
    const input = $('#newWoNumber');
    const indicator = $('#woStatusIndicator');
    const helpText = $('#woNumberHelp');
    const feedback = $('#woNumberFeedback');
    const validFeedback = $('#woNumberValidFeedback');

    // Add success class
    input.removeClass('is-invalid').addClass('is-valid');

    // Update indicator
    indicator.html('<i class="bi bi-check-circle text-success"></i>');

    // Update help text
    helpText.text('Nomor WO tersedia dan dapat digunakan').removeClass('text-danger text-muted').addClass('text-success');
    
    // Show/hide feedback
    feedback.hide();
    validFeedback.show();
}

/**
 * Show WO number error state
 */
function showWoNumberError(message) {
    const input = $('#newWoNumber');
    const indicator = $('#woStatusIndicator');
    const helpText = $('#woNumberHelp');
    const feedback = $('#woNumberFeedback');
    const validFeedback = $('#woNumberValidFeedback');
    
    // Add error class
    input.removeClass('is-valid').addClass('is-invalid');
    
    // Update indicator
    indicator.html('<i class="bi bi-x-circle text-danger"></i>');
    
    // Update help text
    helpText.text(message).removeClass('text-success text-muted').addClass('text-danger');
    
    // Update feedback message
    feedback.text(message).show();
    validFeedback.hide();
}
</script>
@endpush