@extends('layouts.app')

@section('content')
<div class="">
    <h1 class="mt-0 mb-5">Management Kategori Work Package</h1>

    <div class="card card-flush shadow-sm mb-6">
        <div class="card-body">
            <!-- Filter Button -->
            <div class="d-flex justify-content-start mb-4">
                <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                    </svg>
                    Filter Data
                </button>
            </div>

            <!-- Filter Collapse -->
            <div class="collapse" id="filterCollapse">
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
                     <div class="card-body py-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Kategori WP</label>
                                <select class="form-select form-select-solid" id="kategoriFilter">
                                    <option value="">Pilih Work Package</option>
                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}">
                                                @if(isset($category->category_number))
                                                    {{ $category->category_number }}.
                                                @endif
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                     </div>
                     <div class="card-footer">
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

            <div class="d-flex justify-content-between align-items-center">
                <!-- Add Work Package Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_wp">
                        <i class="bi bi-plus-lg fs-2 me-1"></i>
                        Tambah Work Package
                    </button>
                </div>

                <!-- Search Form -->
                <div>
                    <form class="d-flex justify-content-end mb-4">
                        <label class="me-5 mt-3" for="searchWP">Cari: </label>
                        <input 
                            class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                            style="width:200px" 
                            type="search" 
                            id="searchWP"
                            placeholder="Cari Data" 
                            aria-label="Search"
                        >                    
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table id="workpackage_table" class="table border table-row-dashed border-gray-300 table-row-gray-300 gy-5 gs-7 rounded w-100">
                    <thead class="align-middle text-center">
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th>Kategori</th>
                            <!-- <th></th> -->
                            <th class="align-middle border-bottom">No</th>
                            <th class="align-middle border-bottom min-w-200px">Work Package</th>
                            <th class="align-middle border-bottom">Volume (Qty)</th>
                            <th class="align-middle border-bottom min-w-100px">Durasi Kerja (Hari Kerja)</th>
                            <th class="align-middle border-bottom min-w-200px">Actual Scope</th>
                            <th class="align-middle border-bottom min-w-500px">Deliverables</th>
                            <th class="align-middle border-bottom min-w-200px">Resource Names</th>
                            <th class="align-middle border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($workPackagesData) && $workPackagesData->count() > 0)
                            @foreach($workPackagesData as $wp)
                                <tr class="task-row">
                                    <td>{{ $wp['category_number'] }}. {{ $wp['category_name'] }}</td>
                                    <td>{{ $wp['wp_number'] }}</td>
                                    <td>{{ $wp['name'] }}</td>
                                    <td class="text-center">{{ $wp['volume_count'] }}</td>
                                    <td class="text-center">{{ $wp['duration'] }} hari</td>
                                    <td>{{ $wp['actual_scope_contract'] ?? 'Belum ada actual scope' }}</td>
                                    <td>
                                        @if($wp['deliverable'])
                                            <!-- {{ $wp['deliverable'] }} -->
                                            {!! nl2br(e($wp['deliverable'] ?? 'N/A')) !!}
                                        @else
                                            <span class="text-muted">Belum ada deliverable</span>
                                        @endif
                                    </td>
                                    <td>{{ $wp['resource_names'] }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                    <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="editWorkPackage({{ $wp['wp_id'] }})">
                                                        <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteWorkPackage({{ $wp['wp_id'] }})">
                                                        <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                        Hapus
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('wp-management.detail', ['wp_id' => $wp['wp_id']]) }}">
                                                        <i class="bi bi-eye me-3 fs-2 text-dark"></i>
                                                        Lihat Detail
                                                    </a>
                                                </li>
                                                <!-- <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="insertAbove(1.1)">
                                                        <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                        Masukkan di Atas
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="insertBelow(1.1)">
                                                        <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                        Masukkan di Bawah
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="insertSubRow(1.1)">
                                                        <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                        Masukkan Sub Baris
                                                    </a>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center text-muted py-4">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                        <h6 class="text-muted">Belum Ada Work Package</h6>
                                        <p class="text-muted">Tidak ada data work package dalam sistem</p>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Modal for Adding WP -->
            <div class="modal fade" tabindex="-1" id="kt_modal_add_wp" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                <span id="modal-title">Tambah Kategori Work Package</span>
                                <span class="badge badge-light-primary ms-3" id="step-indicator">Step 1 of 3</span>
                            </h3>
                        </div>

                        <div class="modal-body">
                            <!-- Progress Bar -->
                             <div class="mb-6">
                                <div class="progress" style="height: 8px">
                                    <div class="progress-bar bg-primary" role="progressbar" id="progress-bar" style="width: 0%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted">Basic Info</small>
                                    <small class="text-muted">Resources</small>
                                    <small class="text-muted">Tasks</small>
                                </div>
                            </div>

                            <form id="addWorkPackageForm" method="POST" action="{{ route('wp-management.store') }}">
                                @csrf

                                <!-- Step 0: Basic Information -->
                                <div class="step-content" id="step-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="mb-4">
                                                <i class="bi bi-info-circle text-primary me-2"></i>
                                                Informasi Dasar Work Package
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold required">Work Package</label>
                                                <select class="form-select form-select-solid" name="category_id" id="category_id" required>
                                                    <option value="">Pilih Work Package</option>
                                                    @if(isset($categories) && $categories->count() > 0)
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->category_id }}" data-number="{{ $category->category_number ?? '' }}">
                                                                @if(isset($category->category_number))
                                                                    {{ $category->category_number }}.
                                                                @endif
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold required">Nomor Sub Work Package</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="wp_number_display" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nomor work package saat ini">-</span>
                                                    <input type="number" name="wp_sequence" id="wp_sequence" class="form-control" placeholder="1" min="1" required/>
                                                </div>
                                                <div class="form-text">
                                                    Nomor urut dalam kategori (contoh: untuk kategori 3, input 2 akan menghasilkan 3.2)
                                                </div>
                                                <div class="invalid-feedback">
                                                    Nomor Work Package ini sudah digunakan
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold required">Nama Sub Work Package</label>
                                                <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Work Package" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold required">Volume Quantity</label>
                                                <input type="number" name="volume_qty" class="form-control" placeholder="0" min="1" value="1" required/>
                                                <div class="form-text">Jumlah volume untuk work package ini</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold required">Durasi (Hari Kerja)</label>
                                                <input type="number" name="duration" class="form-control" placeholder="30" min="1" required/>
                                                <div class="form-text">Estimasi durasi pengerjaan dalam hari kerja</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold">Actual Scope Contract</label>
                                        <input type="text" name="actual_scope_contract" class="form-control" placeholder="Masukkan Actual Scope"/>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold">Deliverables</label>
                                        <textarea name="deliverable" class="form-control" aria-label="With textarea" placeholder="Masukkan Deliverables"></textarea>
                                    </div>
                                </div>

                                <!-- Step 1: Resources -->
                                <div class="step-content" id="step-1" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="mb-4">
                                                <i class="bi bi-people text-primary me-2"></i>
                                                Assign Resources
                                            </h4>
                                            <p class="text-muted mb-4">Pilih jabatan beserta jumlah hari kerja, dan pilih user untuk ditugaskan pada work package ini.</p>
                                        </div>
                                    </div>

                                    <div id="roleAssignmentsContainer">
                                        <!-- Role assignments akan ditambahkan disini -->
                                    </div>

                                    <button type="button" class="btn btn-light-primary mb-4" id="addRoleAssignmentBtn">
                                        <i class="bi bi-plus-circle"></i> Tambah Resource
                                    </button>

                                    <!-- Summary Table -->
                                    <div class="card bg-light shadow">
                                        <div class="card-header py-0">
                                            <h5 class="card-title mb-0">
                                                <i class="bi bi-graph-up text-primary me-2"></i>
                                                Ringkasan Kebutuhan Tenaga Kerja
                                            </h5>
                                        </div>
                                        <div class="card-body py-0">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-borderless mb-0" id="roleAssignmentSummaryTable">
                                                    <thead>
                                                        <tr class="fw-bold text-gray-700">
                                                            <th>Jabatan</th>
                                                            <th class="text-center">JTK (Jumlah Tenaga Kerja)</th>
                                                            <th class="text-center">JHK (Jumlah Hari Kerja)</th>
                                                            <th>Users yang Di-assign</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="roleAssignmentSummaryBody">
                                                        <tr id="noRoleAssignmentSummary">
                                                            <td colspan="4" class="text-center text-muted py-3">
                                                                Belum ada resource yang di-assign
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Step 2: Tasks -->
                                 <div class="step-content" id="step-2" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="mb-4">
                                                <i class="bi bi-list-task text-primary me-2"></i>
                                                Tasks & Sub Tasks (Opsional)
                                            </h4>
                                            <p class="text-muted mb-4">Tambahkan tasks dan sub tasks untuk work package ini.</p>
                                        </div>
                                    </div>

                                    <div id="tasksContainer">
                                        <!-- Tasks akan ditambahkan dinamis -->
                                    </div>

                                    <button type="button" class="btn btn-light-primary" id="addTaskBtn">
                                        <i class="bi bi-plus-circle"></i> Tambah Task
                                    </button>

                                    <div class="alert alert-info mt-4">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Info:</strong> Tasks dan sub tasks yang ditambahkan di sini akan tersedia di halaman detail work package.
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                                <i class="bi bi-arrow-left"></i> Previous
                            </button>
                            <button type="button" class="btn btn-primary" id="nextBtn">
                                Next <i class="bi bi-arrow-right"></i>
                            </button>
                            <button type="button" class="btn btn-primary" id="submitBtn">Simpan</button>
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
$(document).ready(function () {
    initTabelWPDetail();

    initMultiStepModal();
    loadUsersAndRolesForResources();

    // Filter event listener
    $('#applyFilter').on('click', function() {
        applyFilter();
    });

    $('#resetFilter').on('click', function() {
        resetFilter();
    });

    // Event Delegation
    setupEventListeners();
});

function initTabelWPDetail() {
    const table = $('#workpackage_table').DataTable({
        'scrollY': '500px',
        "scrollX": true,
        "searching": true,
        "paging": true,
        "language": {
            "search": "",
            "searchPlaceholder": "Cari Work Package",
            "zeroRecords": "Tidak ada work package yang cocok dengan pencarian",
            "emptyTable": "Tidak ada data work package"
        },
        "fixedHeader": {
            "header":true,
            "headerOffset": 70
        },
        rowGroup: {
            dataSrc: 0,
            startRender: function (rows, group) {
                return $('<tr/>')
                    .append('<td colspan="10" class="fw-bold bg-light-primary text-dark px-4 py-3">' + group + '</td>');
            }
        },
        columnDefs: [
            {
                targets: 0,
                visible: false, // Kolom kategori disembunyikan karena sudah ditampilkan sebagai grup
                searchable: true
            }
        ],
        order: [[1, 'asc']]
    });

    // Setup search
    setupWPSearch(table);
}

/**
 * Function untuk search pada tabel
 */
function setupWPSearch(table) {
    const searchInput = $('#searchWP');
    
    searchInput.on('keyup change input', function() {
        const searchValue = this.value.trim();
        table.search(searchValue).draw();
    });

    searchInput.on('search', function() {
        if (this.value === '') {
            table.search('').draw();
        }
    });

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
 * Function untuk menerapkan filter
 */
function applyFilter() {
    const categoryId = $('#kategoriFilter').val();
    const table = $('#workpackage_table').DataTable();

    if (categoryId) {
        // Filter berdasarkan kategori
        const selectedCategory = $('#kategoriFilter option:selected').text().trim();

        // Hapus prefix nomor kategori
        let categoryName = selectedCategory;

        if (categoryName.match(/^\d+\.\s*/)) {
            categoryName = categoryName.replace(/^\d+\.\s*/, '');
        }
        
        console.log('Filtering by category:', categoryName); // Debug log
        
        // Terapkan filter ke kategori spesifik
        table.column(0).search(categoryName, false, true).draw();

    } else {
        // Hapus filter jika tidak ada kategori yang dipilih
        table.column(0).search('').draw();
    }

    $('#filterCollapse').collapse('hide');
}

/**
 * Function untuk menghapus filter
 */
function resetFilter() {
    // Reset pilihan dropdown
    $('#kategoriFilter').val('');

    const table = $('#workpackage_table').DataTable();
    table.columns().search('').draw();

    $('#filterCollapse').collapse('hide');
}


// Multi-step modal variables
let currentStep = 0;
let totalSteps = 2;
let roleAssignmentCounter = 0;
let taskCounter = 0;
let availableUsers = [];
let availableRoles = [];
let roleAssignments = [];

/**
 * Initialize multi-step modal functionality
 */
function initMultiStepModal() {
    // Reset modal when opened
    $('#kt_modal_add_wp').on('show.bs.modal', function () {
        resetMultiStepModal();
    });

    // Auto-generated WP number ketika kategori dipilih
    $('#category_id').on('change', function() {
        const categoryId = $(this).val();
        if (categoryId) {
            getNextWpNumber(categoryId);
        } else {
            $('#wp_sequence').val('');
            $('#wp_number_display').text('');
        }
    });

    // Cek availability ketika sequence diubah manual
    $('#wp_sequence').on('input', function() {
        const categoryId = $('#category_id').val();
        const sequence = $(this).val();

        if (categoryId && sequence) {
            checkWpNumberAvailability(categoryId, sequence);
        }
    });

    // Next button
    $('#nextBtn').on('click', function() {
        if (validateCurrentStep()) {
            goToStep(currentStep + 1);
        }
    });

    // Previous button
    $('#prevBtn').on('click', function() {
        goToStep(currentStep - 1);
    });

    // Submit button
    $('#submitBtn').on('click', function() {
        if (validateCurrentStep()) {
            submitMultiStepForm();
        }
    });

    // Add resource button
    $('#addRoleAssignmentBtn').on('click', function() {
        addRoleAssignment();
    });

    // Add task button
    $('#addTaskBtn').on('click', function() {
        addTask();
    });
}

/**
 * Get next available WP number for selected category
 */
function getNextWpNumber(categoryId) {
    $.ajax({
        url: `wp-management/next-wp-number`,
        method: 'GET',
        data: { category_id: categoryId },
        success: function(response) {
            if (response.success) {
                // Extract sequence number dari wp_number
                const parts = response.wp_number.split('.');
                const sequence = parts[parts.length - 1];

                $('#wp_sequence').val(sequence);
                $('#wp_number_display').text(response.wp_number);
                $('#wp_number_display').removeClass('text-danger').addClass('text-success');
            }
        },
        error: function() {
            console.error('Failed to get next WP number');
            $('#wp_number_display').text('Error').removeClass('text-success').addClass('text-danger');
        }
    });
}

/**
 * Check if WP number is available
 */
function checkWpNumberAvailability(categoryId, sequence) {
    $.ajax({
        url: `/wp-management/check-wp-number`,
        method: 'GET',
        data: {
            category_id: categoryId,
            sequence: sequence
        },
        success: function(response) {
            if (response.success) {
                $('#wp_number_display').text(response.wp_number);

                if (response.available) {
                    $('#wp_number_display').removeClass('text-danger').addClass('text-success');
                    $('#wp_sequence').removeClass('is-invalid');
                } else {
                    $('#wp_number_display').removeClass('text-success').addClass('text-danger');
                    $('#wp_sequence').addClass('is-invalid');
                }
            }
        },
        error: function() {
            $('#wp_number_display').text('Error').removeClass('text-success').addClass('text-danger');
        }
    });
}

/**
 * Reset modal to initial state
 */
function resetMultiStepModal() {
    currentStep = 0;
    // resourceCounter = 0;
    roleAssignmentCounter = 0;
    taskCounter = 0;
    
    // Reset form
    $('#addWorkPackageForm')[0].reset();
    
    // Reset containers
    $('#roleAssignmentsContainer').empty();
    $('#tasksContainer').html('');

    goToStep(0);

    $('#roleAssignmentsContainer').html(getInitialRoleAssignmentsHTML());

    // Update resource selects
    updateRoleSelects();
    updateRoleAssignmentSummary();
}

/**
 * Navigate to specific step
 */
function goToStep(step) {
    if (step < 0 || step > totalSteps) return;

    currentStep = step;
    
    // Hide all steps
    $('.step-content').hide();
    
    // Show current step
    $(`#step-${step}`).show();
    
    // Update progress bar
    const progress = (step / totalSteps) * 100;
    $('#progress-bar').css('width', progress + '%');
    
    // Update step indicator
    $('#step-indicator').text(`Step ${step + 1} of ${totalSteps + 1}`);
    
    // Update buttons
    $('#prevBtn').toggle(step > 0);
    $('#nextBtn').toggle(step < totalSteps);
    $('#submitBtn').toggle(step === totalSteps);
}

/**
 * Validate current step
 */
function validateCurrentStep() {
    let isValid = true;
    
    if (currentStep === 0) {
        // Validate basic information
        const requiredFields = ['category_id', 'wp_sequence', 'name', 'volume_qty', 'duration'];
        
        requiredFields.forEach(field => {
            const input = $(`[name="${field}"], #${field}`);
            if (!input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });

        if ($('#wp_sequence').hasClass('is-invalid')) {
            isValid = false;
        }
        
        if (!isValid) {
            Swal.fire({
                title: "Validasi Gagal",
                text: "Mohon lengkapi semua field yang wajib diisi",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
        
    } else if (currentStep === 1) {
        // Validate resources
        const roleCards = $('.role-assignment-card');
        
        if (roleCards.length === 0) {
            Swal.fire({
                title: "Resource Diperlukan",
                text: "Minimal harus ada 1 resource assignment",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }

        isValid = validateRoleAssignment();
    }
    // Step 2 is optional, so always valid
    
    return isValid;
}

/**
 * Load users and roles for resource selection
 */
function loadUsersAndRolesForResources() {
    $.ajax({
        url: `/wp-management/users-with-roles`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                availableUsers = response.users;
                availableRoles = response.roles.filter(role =>
                    role.name !== 'admin' && role.name !== 'karyawan'
                );

                // updateResourceSelects();
                updateRoleSelects();
            } else {
                showErrorAlert('Gagal memuat data user dan role untuk resource selection');
            }
        },
        error: function(xhr) {
            console.error('Failed to load users and roles for:', xhr);
            showErrorAlert('Gagal memuat data user dan role');
        }
    });
}

/**
 * Get initial resource HTML with user and role selection
 */
function getInitialRoleAssignmentsHTML() {
    return `
        <div class="role-assignment-card mb-4 p-4 border-2 border-primary rounded shadow" data-index="0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-info">
                    <i class="bi bi-person-badge me-2"></i>
                    Resource Assignment #1
                </h5>
                <button type="button" class="btn btn-light-danger btn-sm remove-role-assignment" style="display: none;">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>

            <!-- Role and JHK Selection -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold required">Pilih Jabatan</label>
                        <select class="form-select role-select" name="role_assignments[0][role_id]" required>
                            <option value="">Pilih Jabatan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold required">Jumlah Hari Kerja (JHK)</label>
                        <input type="number" name="role_assignments[0][jhk]" class="form-control jhk-input" placeholder="0" min="1" required/>
                        <div class="form-text">JHK berlaku untuk semua user dalam role ini</div>
                    </div>
                </div>
            </div>

            <!-- Users Container -->
            <div class="users-container" data-role-index="0">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label fw-bold">Users untuk Role ini:</label>
                </div>
                
                <div class="users-list" id="users-list-0">
                    <!-- User assignments akan ditambahkan disini -->
                </div>

                <button type="button" class="btn btn-light-success btn-sm add-user-to-role" data-role-index="0">
                    <i class="bi bi-person-plus"></i> Tambah User
                </button>
                
                <div class="no-users-message text-muted text-start py-3" id="no-users-0">
                    <small>Klik "Tambah User" untuk menambahkan user ke role ini</small>
                </div>
            </div>
        </div>
    `;
}

/**
 * Load users for resource selection
 */
// function loadUsersForResources() {
//     $.ajax({
//         url: `/wp-management/users-with-roles`,
//         method: 'GET',
//         success: function(response) {
//             if (response.success) {
//                 availableUsers = response.users;
//                 updateResourceSelects();

//             } else {
//                 Swal.fire({
//                     title: 'Error',
//                     text: 'Gagal memuat data user untuk resource selection',
//                     icon: 'error',
//                     buttonsStyling: false,
//                     confirmButtonText: 'OK',
//                     customClass: {
//                         confirmButton: 'btn btn-secondary'
//                     }
//                 });
//             }
//         },
//         error: function(xhr) {
//             console.error('Failed to load users:', xhr.responseJSON);
//             console.error('Status:', xhr.status);
//             console.error('Response Text:', xhr.responseText);
//         }
//     });
// }

/** RESOURCE MANAGEMENT */
/**
 * Add new resource assignment
 */
function addRoleAssignment() {
    roleAssignmentCounter++;

    const roleAssignmentHTML = `
        <div class="role-assignment-card mb-4 p-4 border border-2 rounded shadow" data-index="${roleAssignmentCounter}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-info">
                    <i class="bi bi-person-badge me-2"></i>
                    Resource Assignment #${roleAssignmentCounter + 1}
                </h5>
                <button type="button" class="btn btn-light-danger btn-sm remove-role-assignment">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>

            <!-- Role and JHK Selection -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold required">Pilih Jabatan</label>
                        <select class="form-select role-select" name="role_assignments[${roleAssignmentCounter}][role_id]" required>
                            <option value="">Pilih Jabatan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold required">Jumlah Hari Kerja (JHK)</label>
                        <input type="number" name="role_assignments[${roleAssignmentCounter}][jhk]" class="form-control jhk-input" placeholder="0" min="1" required/>
                        <div class="form-text">JHK berlaku untuk semua user dalam role ini</div>
                    </div>
                </div>
            </div>

            <!-- Users Container -->
            <div class="users-container" data-role-index="${roleAssignmentCounter}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label fw-bold">Users untuk Role ini:</label>
                </div>
                
                <div class="users-list" id="users-list-${roleAssignmentCounter}">
                    <!-- User assignments akan ditambahkan disini -->
                </div>

                <button type="button" class="btn btn-light-success btn-sm add-user-to-role" data-role-index="${roleAssignmentCounter}">
                    <i class="bi bi-person-plus"></i> Tambah User
                </button>
                
                <div class="no-users-message text-muted text-start py-3" id="no-users-${roleAssignmentCounter}">
                    <small>Klik "Tambah User" untuk menambahkan user ke role ini</small>
                </div>
            </div>
        </div>
    `;
    
    $('#roleAssignmentsContainer').append(roleAssignmentHTML);
    updateRoleSelects();
    updateRemoveRoleAssignmentButtons();
}

/**
 * Update resource select options
 */
function updateRoleSelects() {
    // Update role selects
    $('.role-assignment-card .role-select').each(function() {
        const currentValue = $(this).val();
        $(this).html('<option value="">Pilih Jabatan</option>');

        availableRoles.forEach(role => {
            if (!role.id || !role.name) return;

            const optionText = `${role.name}`;
            $(this).append(`<option value="${role.id}">${optionText}</option>`);
        });

        if (currentValue) {
            $(this).val(currentValue);
        }
    });

    // Update user selects for all roles
    $('.role-assignment-card').each(function() {
        const roleIndex = $(this).data('index');
        updateUserSelectsInRole(roleIndex);
    });
}

/**
 * Update role assignment resource summary table
 */
function updateRoleAssignmentSummary() {
    const summaryData = [];

    // Collect all role assignments
    $('.role-assignment-card').each(function() {
        const roleId = $(this).find('.role-select').val();
        const roleName = $(this).find('.role-select option:selected').text();
        // const userId = $(this).find('.user-select').val();
        const jhk = parseInt($(this).find('.jhk-input').val()) || 0;

        if (roleId && jhk > 0) {
            // Get users for this role
            const users = [];
            $(this).find('.user-select-in-role').each(function() {
                const userId = $(this).val();
                const userName = $(this).find('option:selected').text();

                if (userId && userName !== 'Pilih User') {
                    users.push({
                        userId: userId,
                        userName: userName
                    });
                }
            });

            summaryData.push({
                roleId: roleId,
                roleName: roleName,
                jhk: jhk,
                jtk: users.length,
                users: users
            });
        }
    });

    // Update summary table
    const summaryBody = $('#roleAssignmentSummaryBody');
    summaryBody.empty();
    
    if (summaryData.length === 0) {
        summaryBody.append(`
            <tr id="noRoleAssignmentSummary">
                <td colspan="4" class="text-center text-muted py-3">
                    Belum ada resource yang di-assign
                </td>
            </tr>
        `);
    } else {
        summaryData.forEach(data => {
            const usersList = data.users.map(user => user.userName).join(', ') || 'Belum ada user';
            summaryBody.append(`
                <tr>
                    <td class="fw-bold">${data.roleName}</td>
                    <td class="text-center">
                        <span class="badge badge-light-primary">${data.jtk} orang</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-light-success">${data.jhk} hari</span>
                    </td>
                    <td class="small">${usersList}</td>
                </tr>
            `);
        });
    }
}

/**
 * Enhanced validation for role assignment
 */
function validateRoleAssignment() {
    let isValid = true;
    const problems = [];
    const usedRoles = [];
    const globalUserAssignments = [];
    let totalJhk = 0;

    // Get duration value for comparison
    const duration = parseInt($('input[name="duration"]').val()) || 0;

    $('.role-assignment-card').each(function(index) {
        const roleSelect = $(this).find('.role-select');
        const jhkInput = $(this).find('.jhk-input');

        const roleId = roleSelect.val();
        const roleName = roleSelect.find('option:selected').text();
        const jhk = parseInt(jhkInput.val()) || 0;

        // Reset validation classes
        roleSelect.removeClass('is-invalid');
        jhkInput.removeClass('is-invalid');

        // Validation
        if (!roleId) {
            roleSelect.addClass('is-invalid');
            problems.push(`Assignment #${index + 1}: Role harus dipilih`);
            isValid = false;
        } else {
            // Check for duplicate assignments
            if (usedRoles.includes(roleId)) {
                roleSelect.addClass('is-invalid');
                problems.push(`Assignment #${index + 1}: Role ${roleName} sudah digunakan`);
                isValid = false;
            } else {
                usedRoles.push(roleId);
            }
        }

        if (jhk <= 0) {
            jhkInput.addClass('is-invalid');
            problems.push(`Resource Assignment #${index + 1}: JHK harus lebih dari 0`);
            isValid = false;
        } else {
            totalJhk += jhk;
        }

        // Validate users in this role
        const userSelects = $(this).find('.user-select-in-role');
        let hasUsers = false;

        userSelects.each(function(userIndex) {
            const userSelect = $(this);
            const userId = userSelect.val();
            
            userSelect.removeClass('is-invalid');

            if (userId) {
                hasUsers = true;

                // Check for duplicate user assignments accross all roles
                if (globalUserAssignments.includes(userId)) {
                    userSelect.addClass('is-invalid');
                    problems.push(`Resource Assignment #${index + 1}: User sudah di-assign di role lain`);
                    isValid = false;
                } else {
                    globalUserAssignments.push(userId);
                }
            }
        });

        // There must be at least 1 user per role
        if (roleId && !hasUsers) {
            problems.push(`Resource Assignment #${index + 1}: Minimal harus ada 1 user untuk role ini`);
            isValid = false;
        }
    });

    // Check minimal requirement
    if ($('.role-assignment-card').length === 0) {
        problems.push('Minimal harus ada 1 role assignment');
        isValid = false;
    }

    // Validate total JHK and Duration
    if (totalJhk > duration && duration > 0) {
        problems.push(`Total JHK (${totalJhk} hari) melebihi durasi kerja (${duration} hari)`);

        // Add visual indication to all JHK inputs
        $('.jhk-input').addClass('is-invalid');
        $('input[name="duration"]').addClass('is-invalid');

        isValid = false;
    } else {
        // Remove invalid classes if validation passes
        $('.jhk-input').removeClass('is-invalid');
        $('input[name="duration"]').removeClass('is-invalid');
    }

    if (!isValid) {
        Swal.fire({
            title: 'Validasi Resource Assignment Gagal',
            html: `
                <div class="text-start">
                    <p class="mb-3">Masalah yang ditemukan:</p>
                    <ul>
                        ${problems.map(problem => `<li>${problem}</li>`).join('')}
                    </ul>
                </div>
            `,
            icon: 'warning',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-warning'
            }
        });
    }

    return isValid;
}

/**
 * Enhanced validation for resource selection
 */


/**
 * Update remove buttons visibility
 */
function updateRemoveRoleAssignmentButtons() {
    const roleCards = $('.role-assignment-card');

    if (roleCards.length <= 1) {
        roleCards.find('.remove-role-assignment').hide();
    } else {
        roleCards.find('.remove-role-assignment').show();
    }
}

/**
 * Add user to specific role
 */
function addUserToRole(roleIndex) {
    console.log('Adding user to role index:', roleIndex); // Debug log

    const usersListContainer = $(`#users-list-${roleIndex}`);
    console.log('Users list container found:', usersListContainer.length); // Debug log
    
    // fallback Jika tidak ditemukan, gunakan card index
    if (usersListContainer.length === 0) {
        console.warn('Container not found by ID, using card index...');
        const targetCard = $(`.role-assignment-card`).eq(roleIndex);
        if (targetCard.length) {
            usersListContainer = targetCard.find('.users-list');
            console.log('Found container via card index');
        }
    }

    if (usersListContainer.length === 0) {
        console.error(`Users list container not found for role index: ${roleIndex}`);
        return;
    }

    const existingUserCount = usersListContainer.find('.user-assignment-item').length;

    const userItemHTML = `
        <div class="user-assignment-item d-flex align-items-center gap-2 p-2 rounded" data-user-index="${existingUserCount}">
            <div class="flex-grow-1">
                <select class="form-select user-select-in-role" name="role_assignments[${roleIndex}][users][${existingUserCount}][user_id]" required>
                    <option value="">Pilih User</option>
                </select>
            </div>
            <button type="button" class="btn btn-light-danger btn-sm remove-user-from-role" data-role-index="${roleIndex}">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;

    usersListContainer.append(userItemHTML);

    // Update user select options
    updateUserSelectsInRole(roleIndex);
    
    // Hide no users message
    $(`#no-users-${roleIndex}`).hide();
    
    updateRoleAssignmentSummary();
}

/**
 * Update user selects in specific role
 */
function updateUserSelectsInRole(roleIndex) {
    const container = $(`.users-container[data-role-index="${roleIndex}"]`);

    container.find('.user-select-in-role').each(function() {
        const currentValue = $(this).val();
        $(this).html('<option value="">Pilih User</option>');

        availableUsers.forEach(user => {
            if (!user.user_id || !user.name) return;
            
            $(this).append(`<option value="${user.user_id}">${user.name}</option>`);
        });
        
        if (currentValue) {
            $(this).val(currentValue);
        }
    });
}

/**
 * Update resource numbers after removal
 */
function updateRoleAssignmentNumbers() {
    $('.role-assignment-card').each(function(index) {
        $(this).find('h5').text(`Resource Assignment #${index + 1}`);

        // Update name attributes
        // $(this).find('.user-select').attr('name', `resources[${index}][user_id]`);
        $(this).find('.role-select').attr('name', `role_assignments[${index}][role_id]`);
        $(this).find('.jhk-input').attr('name', `role_assignments[${index}][jhk]`);

        // Update users container
        $(this).find('.users-container').attr('data-role-index', index);
        $(this).find('.add-user-to-role').attr('data-role-index', index);
        $(this).find('.users-list').attr('id', `users-list-${index}`);
        $(this).find('.no-users-message').attr('id', `no-users-${index}`);
        
        // Update user assignments
        $(this).find('.user-assignment-item').each(function(userIndex) {
            $(this).attr('data-user-index', userIndex);
            $(this).find('.user-select-in-role').attr('name', `role_assignments[${index}][users][${userIndex}][user_id]`);
            $(this).find('.remove-user-from-role').attr('data-role-index', index);
        });

        $(this).attr('data-index', index);
    });

    roleAssignmentCounter = $('.role-assignment-card').length - 1;
}

/**
 * Update user number in specific role
 */
function updateUserNumbers(roleIndex) {
    const container = $(`.users-container[data-role-index="${roleIndex}"]`);

    container.find('.user-assignment-item').each(function(index) {
        $(this).attr('data-user-index', index);
        $(this).find('.user-select-in-role').attr('name', `role_assignments[${roleIndex}][users][${index}][user_id]`);
    });
}

/**
 * Function to toggle showing No user message
 */
function toggleNoUsersMessage(roleIndex) {
    const usersList = $(`#users-list-${roleIndex}`);
    const noUsersMessage = $(`#no-users-${roleIndex}`);

    if (usersList.find('.user-assignment-item').length === 0) {
        noUsersMessage.show();
    } else {
        noUsersMessage.hide();
    }
}

/**
 * Helper function to show error alerts
 */
function showErrorAlert(message) {
    Swal.fire({
        title: 'Error',
        text: message,
        icon: 'error',
        buttonsStyling: false,
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-secondary'
        }
    });
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Hapus semua listener yang mungkin sudah ada
    $(document).off('click.roleManagement');
    
    // Event delegation pada document level
    $(document).on('click.roleManagement', '.add-user-to-role', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Mencegah event bubbling
        
        // Gunakan position card dalam container, bukan DOM index
        const roleCard = $(this).closest('.role-assignment-card');
        const roleIndex = $('.role-assignment-card').index(roleCard);
        
        console.log('Add user clicked - Card position:', roleIndex);
        
        if (roleIndex >= 0) {
            addUserToRole(roleIndex);
        }
    });

    $(document).on('click.roleManagement', '.remove-user-from-role', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        
        const roleCard = $(this).closest('.role-assignment-card');
        const roleIndex = $('.role-assignment-card').index(roleCard);
        
        console.log('Remove user clicked - Card position:', roleIndex);
        
        if (roleIndex >= 0) {
            $(this).closest('.user-assignment-item').remove();
            updateUserNumbers(roleIndex);
            updateRoleAssignmentSummary();
            toggleNoUsersMessage(roleIndex);
        }
    });

    $(document).on('click.roleManagement', '.remove-role-assignment', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        
        $(this).closest('.role-assignment-card').remove();
        updateRoleAssignmentNumbers();
        updateRemoveRoleAssignmentButtons();
        updateRoleAssignmentSummary();
    });

    // Event listeners untuk summary update
    $(document).on('change.roleManagement', '.role-select, .jhk-input, .user-select-in-role', function() {
        updateRoleAssignmentSummary();
    });

    $(document).on('input.roleManagement', '.jhk-input', function() {
        updateRoleAssignmentSummary();
    });
}

/** TASK MANAGEMENT */
/**
 * Add new task
 */
function addTask() {
    const taskHTML = `
        <div class="task-item mb-4 p-4 border border-light rounded shadow" data-index="${taskCounter}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Task #${taskCounter + 1}</h5>
                <button type="button" class="btn btn-light-danger btn-sm remove-task">
                    <i class="bi bi-trash"></i> Hapus Task
                </button>
            </div>
            
            <div class="form-group mb-3">
                <label class="form-label fw-bold required">Nama Task</label>
                <input type="text" name="tasks[${taskCounter}][name]" class="form-control" placeholder="Masukkan nama task" required/>
            </div>
            
            <div class="sub-tasks-container" data-task-index="${taskCounter}">
                <h6 class="mb-3">Sub Tasks (Opsional)</h6>
                <!-- Sub tasks will be added here -->
            </div>
            
            <button type="button" class="btn btn-light-primary btn-sm add-subtask" data-task-index="${taskCounter}">
                <i class="bi bi-plus"></i> Tambah Sub Task
            </button>
        </div>
    `;
    
    $('#tasksContainer').append(taskHTML);
    taskCounter++;
}

/**
 * Remove task event delegation
 */
$(document).on('click', '.remove-task', function() {
    $(this).closest('.task-item').remove();
    updateTaskNumbers();
});

/**
 * Add sub task event delegation
 */
$(document).on('click', '.add-subtask', function() {
    const taskIndex = $(this).data('task-index');
    const subTasksContainer = $(`.sub-tasks-container[data-task-index="${taskIndex}"]`);
    const subTaskIndex = subTasksContainer.find('.sub-task-item').length;
    
    const subTaskHTML = `
        <div class="sub-task-item mb-2 d-flex align-items-center">
            <input type="text" name="tasks[${taskIndex}][sub_tasks][${subTaskIndex}][name]" 
                   class="form-control me-2" placeholder="Nama sub task"/>
            <button type="button" class="btn btn-light-danger btn-sm remove-subtask">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    
    subTasksContainer.append(subTaskHTML);
});

/**
 * Remove sub task event delegation
 */
$(document).on('click', '.remove-subtask', function() {
    $(this).closest('.sub-task-item').remove();
});

/**
 * Update task numbers after removal
 */
function updateTaskNumbers() {
    $('.task-item').each(function(index) {
        $(this).find('h5').text(`Task #${index + 1}`);
        $(this).attr('data-index', index);
        
        // Update name attributes
        $(this).find('input[name*="[name]"]').attr('name', `tasks[${index}][name]`);
        $(this).find('.sub-tasks-container').attr('data-task-index', index);
        $(this).find('.add-subtask').attr('data-task-index', index);
        
        // Update sub task names
        $(this).find('.sub-task-item').each(function(subIndex) {
            $(this).find('input').attr('name', `tasks[${index}][sub_tasks][${subIndex}][name]`);
        });
    });
    
    taskCounter = $('.task-item').length;
}

/** SUBMIT FORM */
/**
 * Submit multi-step form
 */
function submitMultiStepForm() {
    const form = $('#addWorkPackageForm');
    const formData = new FormData(form[0]);

    formData.append('wp_sequence', $('#wp_sequence').val());

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
            $('#submitBtn').prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-2"></i>Membuat...');
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: "Berhasil Dibuat!",
                    html: `
                        <p>${response.message}</p>
                        <div class="mt-3 p-3 bg-light rounded">
                            <strong>Detail Work Package:</strong><br>
                            <strong>Nama:</strong> ${response.work_package.name}<br>
                            <strong>Nomor:</strong> ${response.work_package.wp_number}<br>
                            <strong>Kategori:</strong> ${response.work_package.wp_category.name}<br>
                            <strong>Volume:</strong> ${response.summary.volumes_created}
                        </div>
                    `,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    $('#kt_modal_add_wp').modal('hide');
                    window.location.reload();
                });
            } else {
                throw new Error(response.message || 'Unknown error');
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat membuat work package";

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                if (xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    errorMessage += ":\n" + errors.join('\n');
                }
            }

            Swal.fire({
                title: "Gagal Membuat Work Package",
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
            $('#submitBtn').prop('disabled', false).html('<i class="bi bi-check-circle"></i> Buat Work Package');
        }
    });
}

/**
 * Function untuk edit work package (placeholder)
 */
function editWorkPackage(wpId) {
    window.location.href = `{{ route('wp-management.edit', ['wp_id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', wpId);
}

/**
 * Function untuk delete work package dengan konfirmasi
 */
function deleteWorkPackage(wpId) {
    if (!wpId) {
        Swal.fire({
            title: 'Error',
            text: 'Work Package ID tidak ditemukan.',
            icon: 'error',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-secondary'
            }
        });
        return;
    }

    // Cek jika work package memiliki data asosiasi
    checkWorkPackageAssociations(wpId);
}

/**
 * Cek asosiasi work pakcage sebelum penghapusan
 */
function checkWorkPackageAssociations(wpId) {
    Swal.fire({
        title: 'Memeriksa data terkait...',
        text: 'Sedang memeriksa data yang terhubung dengan Work Package',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Pengecekan asosiasi dengan AJAX call
    $.ajax({
        url: `{{ route('wp-management.check-wp-associations', ['wp_id' => ':wp_id']) }}`.replace(':wp_id', wpId),
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.close();

            if (response.success) {
                if (response.has_associations) {
                    // Work package memiliki asosiasi
                    showWorkPackageAssociationWarning(response.associations, wpId);
                } else {
                    // Jika tidak ada asosiasi
                    confirmDeleteWorkPackage(wpId, false);
                }
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message || 'Gagal memeriksa data Work Package',
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

            let errorMessage = 'Terjadi kesalahan saat memeriksa data Work Package';
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
 * Tampilkan peringatan asosiasi pada work package dengan opsi delete 
 */
function showWorkPackageAssociationWarning(associations, wpId) {
    let associationsList = [];

    if (associations.volumes_count > 0) {
        associationsList.push(`• ${associations.volumes_count} Volume(s)`);
    }
    if (associations.tasks_count > 0) {
        associationsList.push(`• ${associations.tasks_count} Task(s)`);
    }
    if (associations.subtasks_count > 0) {
        associationsList.push(`• ${associations.subtasks_count} Sub Task(s)`);
    }
    if (associations.work_assignments_count > 0) {
        associationsList.push(`• ${associations.work_assignments_count} Work Assignment(s)`);
    }
    if (associations.timesheets_count > 0) {
        associationsList.push(`• ${associations.timesheets_count} Timesheet Record(s)`);
    }
    if (associations.human_resources_count > 0) {
        associationsList.push(`• ${associations.human_resources_count} Human Resource(s)`);
    }

    const associationsText = associationsList.join('\n');

    Swal.fire({
        title: 'Konfirmasi Hapus Work Package',
        html: `
            <div class="text-start">
                <p class="mb-3">Work Package ini memiliki data terkait yang akan ikut terhapus:</p>
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
                <p class="text-muted small mt-3">
                    <strong>Note:</strong> Relasi dengan user akan diputuskan (data user tidak akan terhapus).
                </p>
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
        },
        width: '600px'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with force delete
            confirmDeleteWorkPackage(wpId, true, associations);
        }
    });
}

/**
 * Konfirmasi penghapusan work package
 */
function confirmDeleteWorkPackage(wpId, isForceDelete = false, associations = null) {
    const title = isForceDelete ? 'Konfirmasi Hapus Paksa' : 'Konfirmasi Hapus Work Package';
    const text = isForceDelete ?
        'Anda yakin ingin menghapus Work Package ini beserta semua data terkait?' :
        'Apakah Anda yakin ingin menghapus Work Package ini?';
    
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton : 'btn btn-danger',
            cancelButton : 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            executeWorkPackageDelete(wpId, isForceDelete, associations);
        }
    });
}

/**
 * Eksekusi penghapusan work package
 */
function executeWorkPackageDelete(wpId, isForceDelete, associations) {
    // Show loading
    Swal.fire({
        title: 'Menghapus Work Package...',
        html: `
            <div class="text-center">
                <p>Sedang menghapus Work Package dan semua data terkait...</p>
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

    // Prepare AJAX data
    let ajaxData = {
        force: isForceDelete
    };

    if (associations) {
        ajaxData.associations = associations;
    }

    // AJAX call
    $.ajax({
        url: `{{ route('wp-management.force-delete-wp', ['wp_id' => ':wp_id']) }}`.replace(':wp_id', wpId),
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        data: JSON.stringify(ajaxData),
        success: function(response) {
            if (response.success) {
                const deletedData = response.deleted_data;

                Swal.fire({
                    title: 'Work Package Berhasil Dihapus',
                    text: `Work Package ${deletedData.work_package.wp_number} berhasil dihapus.`,
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
                    title: 'Gagal menghapus Work Package',
                    text: response.message || 'Terjadi kesalahan saat menghapus Work Package',
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
            let errorMessage = 'Terjadi kesalahan saat menghapus Work Package';
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
</script>
@endpush