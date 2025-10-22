@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Manajemen Timesheet</h1>

    <!-- Card Activity -->
     <div class="card card-flush shadow-sm">
        <div class="card-body row">
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
                                <label class="form-label fw-bold">Kategori Work Package</label>
                                <select class="form-select form-select-solid" id="workPackageFilter">
                                    <option value="">Pilih Kategori Work Package</option>
                                    @if(isset($workPackagesFilter) && $workPackagesFilter->count() > 0)
                                        @foreach($workPackagesFilter as $wp)
                                            <option value="{{ $wp->wp_id }}">
                                                {{ trim(preg_replace('/\s+/', ' ', $wp->wp_number . ' - ' . $wp->name)) }}
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
                <!-- Add Activity Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                        <i class="bi bi-plus-lg fs-2 me-1"></i>
                        Tambah Aktivitas
                    </button>
                </div>

                <!-- Search Form -->
                <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
                    <label class="me-5 mt-3" for="searchActivity">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search"
                        id="searchActivity" 
                        placeholder="Cari Data" 
                        aria-label="Search"
                    >                    
                </form>
            </div>

            <!-- Activity Table -->
            <div class="table-responsive mb-2">
                <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="tabel_aktivitas">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th scope="col" style="display: none;">WP Group Key</th> {{-- untuk grouping --}}
                            <th scope="col" style="width: 30px;">No</th>
                            <th scope="col">Vol Ke-</th>
                            <th scope="col" style="width: 75px; min-width: 35px;">Tanggal</th>
                            @foreach($users as $user)
                                <th scope="col">
                                    {{$user->short_name}}
                                </th>     
                            @endforeach
                            <th scope="col" style="width: 30px;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @php $rowNumber = 1; @endphp
                        @foreach($groupedActivities as $activity)
                            <tr>
                                {{-- Kolom tersembunyi untuk grouping --}}
                                <td style="display: none;">{{ $activity['wpGroupKey'] }}</td>

                                <td>{{ $rowNumber++ }}</td>
                                <td>{{ $activity['volumes'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity['execution_date'])->format('d M Y') }}</td>
                                
                                @foreach($users as $user)
                                    @php
                                        $userData = collect($activity['users'])->firstWhere('user_id', $user->user_id);
                                    @endphp
                                    @if($userData)
                                        <td style="min-width: 120px;">
                                            @if($userData['duration'] == 1.0)
                                                <span class="badge badge-light-info mb-1">{{ $userData['duration'] }} Hari</span></br>
                                            @elseif($userData['duration'] == 0.5)
                                                <span class="badge badge-light-primary mb-1">{{ $userData['duration'] }} Hari</span></br>
                                            @else
                                                <span class="badge badge-secondary mb-1">{{ $userData['duration']}} Hari</span></br>
                                            @endif
                                            {{-- <span class="badge badge-light-info mb-1">{{ $userData['duration'] }} Hari</span></br> --}}
                                            @foreach($userData['activities'] as $userActivity)
                                                <span>{{ $userActivity }}</span></br>
                                            @endforeach
                                        </td>
                                    @else
                                        <td class="text-center text-muted">-</td>
                                    @endif
                                @endforeach

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center btn-edit-activity" href="#"
                                                    title="Edit Aktivitas" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editActivityModal"
                                                    data-timesheet-ids="{{ json_encode($activity['timesheets']['timesheet_ids']) }}"
                                                    data-volume-ids="{{ json_encode($activity['timesheets']['volume_ids']) }}"
                                                    data-execution-date="{{ json_encode($activity['execution_date']) }}"
                                                    data-personel-ids="{{ json_encode(collect($activity['users'])->pluck('user_id')->toArray()) }}"
                                                >
                                                    <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center text-danger btn-delete-activity" href="#" title="Hapus Aktivitas"
                                                    data-timesheet-ids="{{ json_encode($activity['timesheets']['timesheet_ids']) }}"
                                                    data-execution-date="{{ json_encode($activity['execution_date']) }}"
                                                >
                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                    Hapus
                                                </a>
                                            </li>
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
@endsection

{{-- tambah aktivitas --}}
<div class="modal fade" tabindex="-1" id="addActivityModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-5">
                <h3 class="modal-title">Tambah Aktivitas</h3>
            </div>
            <div class="modal-body py-3">
                <form id="addActivityForm" method="POST" action="{{route('timesheet.add')}}">
                    @csrf
                    @method('POST')
                    <div class="form-group mb-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="wo_select" class="form-label fw-bold">Work Order</label>
                                <div class="input-group">
                                    <select class="form-select" name="wo_id" id="wo_select" required> 
                                        <option value="">Pilih Work Order</option>
                                        @foreach($workOrders as $wo)
                                            <option value="{{ $wo['wo_id'] }}">WO {{ $wo['wo_number'] }} - ({{ $wo['year'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" name="execution_date" id="execution_date" placeholder="Masukkan Tanggal" min="1" max="31" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-6 rounded border border-info wo-info-container" style="display: none;">
                        <div class="fw-bold text-info mt-2 mb-1 ms-3">
                            <i class="bi bi-clipboard-check me-1"></i>
                            Work Order Info
                        </div>
                        <!-- Spinner -->
                        <div class="spinner-container text-center d-flex justify-content-center align-items-center mb-2" style="display: none;">
                            <div class="spinner-border text-info" role="status" style="width: 1.5rem; height: 1.5rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="text-dark fw-bold small wo-assigned-info ms-3" style="display: flex;">
                            <span>Periode: <span class="period-info">0</span></span>
                        </div>
                        <div class="wo-assigned-info-container">
                        </div>
                    </div>
                    {{-- jika wp dalam wo lebih dari 1 --}}
                    <div class="col-md-12 mb-6" id="wpSelectContainer" style="display: none;">
                        <label for="wp_select" class="form-label fw-bold">Kategori Work Package</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid" name="wp_id" id="wp_select" required>
                                <option value="">Pilih Kategori Work Package</option>
                            </select>
                        </div>
                    </div>
                    <div id="personelActivityContainer">
                    </div>
                    <div class="d-flex justify-content-start mb-0">
                        <button type="button" class="btn btn-primary" id="addPersonelActivityBtn">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Tambah Aktivitas Lain
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitAddActivityForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

<template id="personelActivityTemplate">
    <div class="personel-activity-group card card-flush shadow-sm mb-6">
        <div class="card-header py-2">{{--  Sesuaikan padding header --}}
            <h3 class="card-title fw-bold fs-5"></h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-danger remove-personel-btn">
                    <i class="bi bi-trash fs-5"></i> Hapus
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group mb-6">
                <div class="row">
                    <div class="col-md-8">
                        <label for="personel_select_0" class="form-label fw-bold">Personel</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid personel-select" name="personel_ids[]" id="personel_select_0" required>
                                <option value="">Pilih Personel</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="duration_0" class="form-label fw-bold">Durasi</label>
                        <div class="input-group">
                            <select class="form-select duration-select" name="durations[]" id="duration_0" required>
                                <option value="0.5">0.5</option>
                                <option value="1.0">1</option>
                                <option value="1.5">1.5</option>
                                <option value="2.0">2</option>
                            </select>
                            <span class="input-group-text" style="min-width:40px; padding-left:6px; padding-right:6px;">Hari</span>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="form-group mb-6 rounded border border-info personel-info-container" style="display: block;">
                <div class="fw-bold text-info mt-2 mb-1 ms-3">
                    <i class="bi bi-calendar me-1"></i>
                    Mandays
                </div>
                <!-- Spinner -->
                <div class="spinner-container text-center mt-2" style="display: none;">
                    <div class="spinner-border text-info" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="text-dark small wp-assigned-info ms-3 mb-2 d-flex justify-content-start gap-5" style="display: flex;">
                    <span class="assigned-mandays-count">Rencana: <span class="mandays-plan">0</span></span>
                    <span class="assigned-mandays-count">Realisasi: <span class="mandays-real">0</span></span>
                </div>
            </div>
            <div class="form-group mb-6">
                <label for="activity_0" class="form-label fw-bold">Aktivitas</label>
                <textarea class="form-control activity-textarea"  name="activities[]" id="activity_0" rows="2" placeholder="Aktivitas" required></textarea>
            </div>                    
        </div>
    </div>
</template>

{{-- edit dan/atau delete --}}
<div class="modal fade" tabindex="-1" id="editActivityModal" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-5">
                <h3 class="modal-title">Edit Aktivitas</h3>
            </div>
            <div class="modal-body py-3">
                <form id="editActivityForm" method="POST" action="{{route('timesheet.edit')}}">
                    @csrf
                    @method('POST')
                    {{-- hidden input --}}
                    <div id="edit_timesheet_ids_container"></div>
                    {{-- <input type="hidden" name="timesheet_id" id="edit_timesheet_id" value=""> --}}
                    <input type="hidden" name="deleted_timesheet_ids" id="deleted_timesheet_ids" value="">
                    <div class="form-group mb-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_wo_select" class="form-label fw-bold">Work Order</label>
                                <div class="input-group">
                                    <select class="form-select" name="wo_id" id="edit_wo_select" required disabled> 
                                        <option value="">Pilih Work Order</option>
                                        @foreach($workOrders as $wo)
                                            <option value="{{ $wo['wo_id'] }}">WO {{ $wo['wo_number'] }} - ({{ $wo['year'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="tanggal" class="col-md-6">
                                <label for="edit_execution_date" class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" name="execution_date" id="edit_execution_date" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-6 rounded border border-info wo-info-container" style="display: none;">
                        <div class="fw-bold text-info mt-2 mb-1 ms-3">
                            <i class="bi bi-clipboard-check me-1"></i>
                            Work Order Info
                        </div>
                        <div class="spinner-container text-center mt-2" style="display: none;">
                            <div class="spinner-border text-info" role="status" style="width: 1.5rem; height: 1.5rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="text-dark fw-bold small wo-assigned-info ms-3" style="display: flex;">
                            <span>Periode: <span class="period-info">0</span></span>
                        </div>
                        <div class="wo-assigned-info-container">
                        </div>
                    </div>
                    <div class="col-md-12 mb-6" id="editWpSelectContainer" style="display: none;">
                        <label for="edit_wp_select" class="form-label fw-bold">Kategori Work Package</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid" name="wp_id" id="edit_wp_select" required>
                                <option value="">Pilih Kategori Work Package</option>
                            </select>
                        </div>
                    </div>
                    <div id="editPersonelActivityContainer">
                    </div>
                    <div class="d-flex justify-content-start mb-0">
                        <button type="button" class="btn btn-primary" id="editPersonelActivityBtn">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Tambah Aktivitas Lain
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitEditActivityForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

<template id="editPersonelActivityTemplate">
    <div class="personel-activity-group card card-flush shadow-sm mb-6">
        <div class="card-header py-2"> {{-- Sesuaikan padding header --}}
            <h3 class="card-title card-title-edit fw-bold fs-5"></h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-danger remove-edit-personel-btn" data-timesheet-id="">
                    <i class="bi bi-trash fs-5"></i> Hapus
                </button>
            </div>
        </div>
        <div class="card-body">
            {{-- <input type="hidden" name="timesheet_id" id="edit_timesheet_id" value=""> --}}
            <div class="form-group mb-6">
                <div class="row">
                    <div class="col-md-8">
                        <label for="personel_select_0" class="form-label fw-bold">Personel</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid edit-personel-select" name="personel_ids[]" id="personel_select_0" required>
                                <option value="">Pilih Personel</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="duration_0" class="form-label fw-bold">Durasi</label>
                        <div class="input-group">
                            <select class="form-select edit-duration-select" name="durations[]" id="duration_0" required>
                                <option value="0.5">0.5</option>
                                <option value="1">1</option>
                                <option value="1.5">1.5</option>
                                <option value="2">2</option>
                            </select>
                            <span class="input-group-text" style="min-width:40px; padding-left:6px; padding-right:6px;">Hari</span>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="form-group mb-6 rounded border border-info personel-info-container" style="display: block;">
                <div class="fw-bold text-info mt-2 mb-1 ms-3">
                    <i class="bi bi-calendar me-1"></i>
                    Mandays
                </div>
                <!-- Spinner -->
                <div class="spinner-container text-center mt-2" style="display: none;">
                    <div class="spinner-border text-info" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="text-dark small wp-assigned-info ms-3 mb-2 d-flex justify-content-start gap-5" style="display: flex;">
                    <span class="assigned-mandays-count">Rencana: <span class="mandays-plan">0</span></span>
                    <span class="assigned-mandays-count">Realisasi: <span class="mandays-real">0</span></span>
                </div>
            </div>
            <div class="form-group mb-6">
                <label class="form-label fw-bold">Aktivitas</label>
                <textarea class="form-control edit-activity-textarea"  name="activities[]" id="activity_0" rows="2" placeholder="Aktivitas" required></textarea>
            </div>                    
        </div>
    </div>
</template>

@push('scripts')
<script>
    // ===================== GLOBAL VARIABLE =====================
    let currentPersonnel = [];
    let maxPersonelGroups = 0;
    let currentPersonelGroups = 0;

    // ===================== TABLE ACTIVITIES =====================
    $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel aktivitas
        initTableTimesheet();

        $('#applyFilter').on('click', function() {
            applyFilter();
        });

        $('#resetFilter').on('click', function() {
            resetFilter();
        });
    });

    function initTableTimesheet() {
        const table = $('#tabel_aktivitas').DataTable({
            scrollY: '350px',
            scrollX: true,
            fixedHeader: {
                header: true,
                headerOffset: 70
            },
            ordering: false,
            rowGroup: {
                dataSrc: 0,
                startRender: function (rows, group) {
                    return $('<tr/>')
                        .append('<td colspan="' + rows.columns()[0].length + '" class="fw-bold bg-light-primary text-dark px-4 py-3">' + group + '</td>')
                        .addClass('wp-group-header');
                }
            },
            columnDefs: [
                { targets: 0, visible: false, searchable: true }
            ]
        });
        setupActivitySearch(table);
    }

    function setupActivitySearch(table) {
        const searchInput = $('#searchActivity');

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
                this.blur(); // Optional: remove focus
                table.search('').draw();
            }
        });
    }

    function escapeRegex(string) {
        return string.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    }

    function normalizeText(text) {
        return text.replace(/\s+/g, ' ').trim();
    }

    // ===================== FILTER DATA =====================
    function applyFilter() {
        const wpId = $('#workPackageFilter').val();
        const table = $('#tabel_aktivitas').DataTable();

        if (wpId) {
            let selectedWP = $('#workPackageFilter option:selected').text();
            selectedWP = normalizeText(selectedWP);
            const WPKey = escapeRegex(selectedWP);
            table.column(0).search('^' + WPKey + '$', true, false).draw();
        } else {
            table.column(0).search('').draw();
        }

        $('#filterCollapse').collapse('hide');
    }

    function resetFilter() {
        $('#workPackageFilter').val('');
        const table = $('#tabel_aktivitas').DataTable();
        table.columns().search('').draw();
        $('#filterCollapse').collapse('hide');
    }

    // ===================== ADD ACTIVITY =====================
    // ambil data WO
    document.addEventListener('DOMContentLoaded', function () {
        const woSelect = document.getElementById('wo_select');
        const wpSelectContainer = document.getElementById('wpSelectContainer');
        const wpSelect = document.getElementById('wp_select');
        const woInfoContainer = document.querySelector('.wo-info-container');
        const woAssignedInfoContainer = document.querySelector('.wo-assigned-info-container');
        const woAssignedInfo = document.querySelector('.wo-assigned-info');
        const periodInfoElement = document.querySelector('.period-info');
        const woInfoSpinner = woInfoContainer.querySelector('.spinner-container'); // Spinner container
        const spinner = woInfoSpinner.querySelector('.spinner-border.text-info');
        const personelActivityContainer = document.getElementById('personelActivityContainer');
        const personelActivityTemplate = document.getElementById('personelActivityTemplate');

        woSelect.addEventListener('change', function () {
            const woId = this.value;

            currentPersonnel = [];
            maxPersonelGroups = 0;
            currentPersonelGroups = 0;
            personelActivityContainer.innerHTML = ''; // Kosongkan container personel
            $('#addPersonelActivityBtn').attr('disabled', 'true');
            wpSelect.removeEventListener('change', handleWpSelectChange);

            // Sembunyikan container jika tidak ada WO yang dipilih
            if (!woId) {
                wpSelectContainer.style.display = 'none';
                wpSelect.innerHTML = '<option value="">Pilih Kategori Work Package</option>';
                woInfoContainer.style.display = 'none';
                woAssignedInfoContainer.innerHTML = '';
                periodInfoElement.textContent = '0';
                return;
            }

            // Tampilkan WO Info Container
            woInfoContainer.style.display = 'block';

            // Tampilkan spinner dan sembunyikan konten info yang lama
            woInfoSpinner.style.display = 'flex'; // Tampilkan spinner
            woAssignedInfoContainer.innerHTML = ''; // Kosongkan container konten
            woAssignedInfo.style.display = 'none';
            periodInfoElement.textContent = 'Memuat...';

            // Fetch data WP berdasarkan WO
            fetch(`/timesheet-management/${woId}/work-packages`)
                .then(response => response.json())
                .then(data => {
                    // Sembunyikan spinner setelah data berhasil dimuat
                    woInfoSpinner.style.display = 'none';
                    spinner.style.display = 'none';
                    spinner.style.visibility = 'hidden';

                    if (data.success) {
                        const workPackages = data.work_packages;
                        woAssignedInfoContainer.innerHTML = ''; // Kosongkan container lagi (jika ada sisa)
                        woAssignedInfo.style.display = 'flex'; // Tampilkan lagi flex container untuk periode

                        // Perbarui periode dengan data dari controller
                        periodInfoElement.textContent = data.period;

                        // Loop melalui WP dan tampilkan informasi
                        data.work_packages.forEach(wp => {
                            const wpInfoElement = document.createElement('div');
                            wpInfoElement.classList.add('text-dark', 'small', 'wo-assigned-info', 'ms-3', 'mb-1', 'd-flex', 'justify-content-start', 'gap-2');
                            wpInfoElement.innerHTML = `
                                <span>WP ${wp.wp_number}:</span>
                                <span>${wp.volume_count} Volume</span>
                            `;
                            woAssignedInfoContainer.appendChild(wpInfoElement);
                        });

                        // Jika ada lebih dari 1 WP, tampilkan dropdown kategori WP
                        if (workPackages.length > 1) {
                            wpSelectContainer.style.display = 'block';
                            wpSelect.innerHTML = '<option value="">Pilih Kategori Work Package</option>';

                            // Tambahkan opsi WP ke dropdown
                            workPackages.forEach(wp => {
                                const option = document.createElement('option');
                                option.value = wp.wp_id;
                                option.textContent = `${wp.wp_number} - ${wp.name}`;
                                wpSelect.appendChild(option);
                            });

                            wpSelect.addEventListener('change', handleWpSelectChange);

                            // Event listener untuk dropdown WP
                            wpSelect.addEventListener('change', function () {
                                const wpId = this.value;
                                if (wpId) {
                                    fetchPersonelAndMandays(woId, wpId);
                                } else {
                                    personelActivityContainer.innerHTML = ''; // Kosongkan personel container
                                }
                            });
                        } else {
                            // Sembunyikan dropdown jika hanya ada 1 WP
                            wpSelectContainer.style.display = 'none';
                            wpSelect.innerHTML = '<option value="">Pilih Kategori Work Package</option>';
                            fetchPersonelAndMandays(woId, null);
                        }
                    } else {
                        wpSelectContainer.style.display = 'none';
                        wpSelect.innerHTML = '<option value="">Pilih Kategori Work Package</option>';
                        woAssignedInfoContainer.innerHTML = '<span class="text-danger ms-3 mb-2">Gagal memuat data WP.</span>';
                        woAssignedInfo.style.display = 'flex'; // Tetap tampilkan header info
                        periodInfoElement.textContent = 'Tidak tersedia';
                    }
                })
                .catch(error => {
                    console.error('Error fetching work packages:', error);
                    wpSelectContainer.style.display = 'none';
                    wpSelect.innerHTML = '<option value="">Pilih Kategori Work Package</option>';
                    // Sembunyikan spinner jika terjadi error
                    woInfoSpinner.style.display = 'none';
                    woAssignedInfoContainer.innerHTML = '<span class="text-danger ms-3 mb-2">Terjadi kesalahan saat memuat data.</span>';
                    woAssignedInfo.style.display = 'flex'; // Tetap tampilkan header info
                    periodInfoElement.textContent = 'Tidak tersedia';
                });
        });
    });

    // Event handler terpisah untuk perubahan WP Select
    function handleWpSelectChange() {
        const woId = woSelect.value;
        const wpId = this.value;
        
        // Reset personel container dan state saat WP berubah
        currentPersonnel = [];
        maxPersonelGroups = 0;
        currentPersonelGroups = 0;
        personelActivityContainer.innerHTML = '';
        $('#addPersonelActivityBtn').attr('disabled', 'true');

        if (wpId) {
            fetchPersonelAndMandays(woId, wpId);
        }
    }

    function fetchPersonelAndMandays(woId, wpId = null) {
        // Kosongkan container personel
        const personelActivityContainer = document.getElementById('personelActivityContainer');
        const personelActivityTemplate = document.getElementById('personelActivityTemplate');
        // Reset container dan state
        personelActivityContainer.innerHTML = '';
        currentPersonnel = [];
        maxPersonelGroups = 0;
        currentPersonelGroups = 0;

        // Fetch data personel berdasarkan WO dan WP
        fetch(`/timesheet-management/personel?wo_id=${woId}${wpId ? `&wp_id=${wpId}` : ''}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentPersonnel = data.personnel;
                    maxPersonelGroups = currentPersonnel.length;
                    
                    if (maxPersonelGroups > 0) {
                        // Tambahkan 1 grup personel secara default dengan data
                        addPersonelActivityGroup(false, personelActivityTemplate);
                        
                        // Enable tombol add jika masih ada sisa personel
                        if (currentPersonelGroups < maxPersonelGroups) {
                            $('#addPersonelActivityBtn').removeAttr('disabled');
                        } else {
                            $('#addPersonelActivityBtn').attr('disabled', 'true');
                        }
                    } else {
                        Swal.fire({
                            title: "Tidak Ada Personel",
                            text: "Tidak ada data personel untuk work package ini.",
                            icon: "warning",
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        });
                        $('#addPersonelActivityBtn').attr('disabled', 'true');
                    }
                } else {
                    Swal.fire({
                        title: "Gagal Memuat Data",
                        text: data.message || "Tidak ada data personel untuk work package ini.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    });
                    $('#addPersonelActivityBtn').attr('disabled', 'true');
                }
            })
            .catch(error => {
                console.error('Error fetching personnel:', error);
                Swal.fire({
                    title: "Kesalahan",
                    text: "Terjadi kesalahan saat memuat data personel.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
                $('#addPersonelActivityBtn').attr('disabled', 'true');
            });
    }

    // Function to fetch and display mandays data
    function updateMandaysInfo(personelSelectElement, volumeId, personelActivityGroupDiv) {
        const selectedUserId = personelSelectElement.value;
        const mandaysInfoContainer = personelActivityGroupDiv.querySelector('.personel-info-container');
        const mandaysSpinner = mandaysInfoContainer.querySelector('.spinner-container');
        const mandaysRealElement = mandaysInfoContainer.querySelector('.mandays-real');
        const mandaysPlanElement = mandaysInfoContainer.querySelector('.mandays-plan');

        if (!selectedUserId) {
            mandaysPlanElement.textContent = '0';
            mandaysRealElement.textContent = '0';
            return;
        }

        // Tampilkan spinner mandays saat memulai fetch data mandays
        mandaysSpinner.style.display = 'flex';
        mandaysRealElement.textContent = '...';
        mandaysPlanElement.textContent = '...';

        // Fetch mandays untuk personel ini
        fetch(`/timesheet-management/personel-mandays/${selectedUserId}/${volumeId}`)
            .then(response => response.json())
            .then(mandaysData => {
                mandaysSpinner.style.display = 'none';
                if (mandaysData.success) {
                    mandaysPlanElement.textContent = mandaysData.mandays_plan || 0;
                    mandaysRealElement.textContent = mandaysData.mandays_real || 0;
                }else {
                    mandaysPlanElement.textContent = 'Error';
                    mandaysRealElement.textContent = 'Error';
                }
            }).catch(error => {
                console.error('Error fetching mandays:', error);
                // Sembunyikan spinner mandays saat error
                mandaysSpinner.style.display = 'none';
                mandaysPlanElement.textContent = 'Gagal';
                mandaysRealElement.textContent = 'Gagal';
            });
    }
    
    // Fungsi untuk memperbarui tombol tambah personel
    function updatePersonelActivityButtons() {
        const addPersonelActivityBtn = document.getElementById('addPersonelActivityBtn');
        
        // Nonaktifkan tombol tambah jika sudah mencapai batas maksimal user atau jika belum ada personel (maxPersonelGroups == 0)
        if (currentPersonelGroups >= maxPersonelGroups || maxPersonelGroups === 0) {
            addPersonelActivityBtn.setAttribute('disabled', 'true');
        } else {
            addPersonelActivityBtn.removeAttribute('disabled');
        }
    }

    // Fungsi untuk memperbarui dropdown personel dengan data baru
    function updatePersonelDropdowns() {
        const allSelects = document.querySelectorAll('.personel-select');
        
        allSelects.forEach(select => {
            const currentValue = select.value; // Simpan nilai yang dipilih
            
            // Kosongkan dan isi ulang opsi
            select.innerHTML = '<option value="">Pilih Personel</option>';
            
            if (currentPersonnel.length > 0) {
                currentPersonnel.forEach(person => {
                    const option = document.createElement('option');
                    option.value = person.user_id;
                    const roleName = person.role ? ` - ${person.role}` : '';
                    option.textContent = `${person.name}${roleName}`;
                    option.setAttribute('data-user-id', person.user_id);
                    select.appendChild(option);
                });
                
                // Restore nilai yang dipilih jika masih ada
                if (currentValue && Array.from(select.options).some(opt => opt.value === currentValue)) {
                    select.value = currentValue;
                }
            }
        });
        
        updatePersonelSelectOptions();
    }

    // Fungsi untuk memperbarui opsi select agar disable personel yang sudah dipilih
    function updatePersonelSelectOptions() {
        const allSelects = document.querySelectorAll('.personel-select');
        const selectedUserIds = Array.from(allSelects)
            .map(select => select.value)
            .filter(value => value !== '');

        allSelects.forEach(select => {
            Array.from(select.options).forEach(option => {
                if (option.value !== '') {
                    if (selectedUserIds.includes(option.value) && option.value !== select.value) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                }
            });
        });
    }

    // Fungsi untuk menambahkan grup personel baru
    function addPersonelActivityGroup(isInitial = false, personelActivityTemplate) {
        const personelActivityContainer = document.getElementById('personelActivityContainer');

        // if (!personelActivityTemplate) {
        //     console.error('Template personelActivityTemplate tidak ditemukan di DOM.');
        //     alert('Terjadi kesalahan: Template tidak ditemukan.');
        //     return;
        // }
        
        if(!isInitial){
            // Cek batas maksimal
            if (currentPersonelGroups >= maxPersonelGroups) {
                Swal.fire({
                    text: `Anda telah mencapai batas maksimal personel (${maxPersonelGroups}).`,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-warning" }
                });
                return;
            }
            
            // Jika belum memilih WO/WP, tampilkan peringatan
            if (maxPersonelGroups === 0) {
                Swal.fire({
                    text: `Pilih Work Order dan/atau Work Package terlebih dahulu.`,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-warning" }
                });
                return;
            }
        }

        const newGroup = personelActivityTemplate.content.cloneNode(true);
        const newGroupDiv = newGroup.querySelector('.personel-activity-group');
        const newGroupIndex = currentPersonelGroups; 

        newGroupDiv.id = `personel-activity-${newGroupIndex}`; 
        newGroupDiv.querySelector('.card-title').textContent = `Personel ${newGroupIndex + 1}`; 

        // Update ID dan name atribut
        const selectElement = newGroupDiv.querySelector('.personel-select');
        selectElement.id = `personel_select_${newGroupIndex}`;
        selectElement.name = `personel_ids[${newGroupIndex}]`; 

        const durationElement = newGroupDiv.querySelector('.duration-select');
        durationElement.id = `duration_${newGroupIndex}`;
        durationElement.name = `durations[${newGroupIndex}]`; 

        const textareaElement = newGroupDiv.querySelector('.activity-textarea');
        textareaElement.id = `activity_${newGroupIndex}`;
        textareaElement.name = `activities[${newGroupIndex}]`; 
        
        // Update label 'for' attributes
        const personelLabel = newGroupDiv.querySelector('label[for="personel_select_0"]');
        if (personelLabel) personelLabel.setAttribute('for', `personel_select_${newGroupIndex}`);

        const durationLabel = newGroupDiv.querySelector('label[for="duration_0"]');
        if (durationLabel) durationLabel.setAttribute('for', `duration_${newGroupIndex}`);

        const activityLabel = newGroupDiv.querySelector('label[for="activity_0"]');
        if (activityLabel) activityLabel.setAttribute('for', `activity_${newGroupIndex}`);
        
        // Kosongkan dan isi opsi personel
        selectElement.innerHTML = '<option value="">Pilih Personel</option>';
        currentPersonnel.forEach(person => {
            const option = document.createElement('option');
            option.value = person.user_id;
            const roleName = person.role ? ` - ${person.role}` : '';
            option.textContent = `${person.name}${roleName}`;
            option.setAttribute('data-user-id', person.user_id);
            selectElement.appendChild(option);
        });

        // Event listener untuk mandays saat personel dipilih
        selectElement.addEventListener('change', function (){
            const woId = document.getElementById('wo_select').value;
            const wpId = document.getElementById('wp_select').value || null;
            
            // Perlu fetch volume_id lagi untuk memastikan, atau simpan di global state saat fetchPersonelAndMandays
            // Sederhananya, kita bisa ambil volume_id dari data fetch personel
            fetch(`/timesheet-management/personel?wo_id=${woId}${wpId ? `&wp_id=${wpId}` : ''}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.volume_id) {
                         updateMandaysInfo(this, data.volume_id, newGroupDiv);
                    }
                });
            updatePersonelSelectOptions();
        });

        // Update onclick untuk tombol hapus
        const removeButton = newGroupDiv.querySelector('.remove-personel-btn');
        removeButton.onclick = function () {
            removePersonelActivityGroup(newGroupDiv.id);
        };

        personelActivityContainer.appendChild(newGroup);
        currentPersonelGroups++;

        if(!isInitial){
            updatePersonelActivityButtons(); 
            updatePersonelSelectOptions();
        }
    }

    // Fungsi untuk menghapus grup personel
    function removePersonelActivityGroup(groupId) {
        const personelActivityContainer = document.getElementById('personelActivityContainer');
        const totalGroups = personelActivityContainer.querySelectorAll('.personel-activity-group').length;

        // Cegah penghapusan jika hanya ada 1 grup personel
        if (totalGroups <= 1) {
            Swal.fire({
                text: "Minimal harus ada 1 personel!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: { confirmButton: "btn btn-warning" }
            });
            return;
        }

        // Hapus grup personel berdasarkan ID
        document.getElementById(groupId).remove();
        currentPersonelGroups--;

        // Perbarui tombol tambah personel
        updatePersonelActivityButtons();

        // Perbarui nomor dan atribut grup personel setelah penghapusan
        personelActivityContainer.querySelectorAll('.personel-activity-group').forEach((group, index) => {
            group.id = `personel-activity-${index}`;
            group.querySelector('.card-title').textContent = `Personel ${index + 1}`;
            
            // Perbarui ID dan name untuk form elements
            group.querySelector('.personel-select').id = `personel_select_${index}`;
            group.querySelector('.personel-select').name = `personel_ids[${index}]`;
            group.querySelector('.duration-select').id = `duration_${index}`;
            group.querySelector('.duration-select').name = `durations[${index}]`;
            group.querySelector('.activity-textarea').id = `activity_${index}`;
            group.querySelector('.activity-textarea').name = `activities[${index}]`;

            // Perbarui label 'for' attributes setelah renumber
            const personelLabel = group.querySelector('label[for^="personel_select_"]');
            if (personelLabel) personelLabel.setAttribute('for', `personel_select_${index}`);

            const durationLabel = group.querySelector('label[for^="duration_"]');
            if (durationLabel) durationLabel.setAttribute('for', `duration_${index}`);

            const activityLabel = group.querySelector('label[for^="activity_"]');
            if (activityLabel) activityLabel.setAttribute('for', `activity_${index}`);

            // Perbarui tombol hapus untuk grup yang baru diurutkan
            group.querySelector('.remove-personel-btn').onclick = function () {
                removePersonelActivityGroup(group.id);
            };
        });
        updatePersonelSelectOptions();
    }

    // Event listener utama
    document.addEventListener('DOMContentLoaded', function () {
        const addActivityModal = document.getElementById('addActivityModal');
        const personelActivityContainer = document.getElementById('personelActivityContainer');
        const personelActivityTemplate = document.getElementById('personelActivityTemplate');
        const addPersonelActivityBtn = document.getElementById('addPersonelActivityBtn');

        // Event listener untuk tombol tambah personel
        addPersonelActivityBtn.addEventListener('click', function () {
            addPersonelActivityGroup(false, personelActivityTemplate);
        });

        // Event listener untuk membuka modal "Tambah Aktivitas"
        addActivityModal.addEventListener('shown.bs.modal', function () {
            // Reset form dan state
            document.getElementById('addActivityForm').reset();
            document.getElementById('wo_select').value = '';
            document.getElementById('wp_select').value = '';
            document.getElementById('wpSelectContainer').style.display = 'none';
            document.querySelector('.wo-info-container').style.display = 'none';
            
            // Reset state
            currentPersonnel = [];
            maxPersonelGroups = 0;
            currentPersonelGroups = 0;
            
            // Kosongkan container
            personelActivityContainer.innerHTML = '';
            
            // Disable tombol add sampai WO dipilih
            $('#addPersonelActivityBtn').attr('disabled', 'true');

            // Tambahkan satu grup personel secara default
            addPersonelActivityGroup(true, personelActivityTemplate);
        });

        // Event listener untuk menutup modal - cleanup
        addActivityModal.addEventListener('hidden.bs.modal', function () {
            personelActivityContainer.innerHTML = '';
            currentPersonnel = [];
            maxPersonelGroups = 0;
            currentPersonelGroups = 0;
        });
    });

    function validateAddActivityForm() {
        // Cek field utama
        const wo = document.getElementById('wo_select').value.trim();
        const date = document.getElementById('execution_date').value.trim();

        if (!wo || !date) {
            Swal.fire({
                title: "Data Belum Lengkap",
                text: "Work Order, Kategori Work Package (jika diperlukan), atau Tanggal wajib diisi.",
                icon: "info",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-primary" }
            });
            return false;
        }

        // Cek setiap grup personel
        const personelSelects = document.querySelectorAll('.personel-select');
        const activityTextareas = document.querySelectorAll('.activity-textarea');
        const durationSelects = document.querySelectorAll('.duration-select');

        for (let i = 0; i < personelSelects.length; i++) {
            if (!personelSelects[i].value.trim() || !activityTextareas[i].value.trim() || !durationSelects[i].value.trim()) {
                Swal.fire({
                    title: "Data Belum Lengkap",
                    text: "Personel, Durasi, dan Aktivitas wajib diisi untuk setiap grup.",
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-primary" }
                });
                return false;
            }
        }

        return true;
    }

    // submit tambah aktivitas
    document.getElementById('submitAddActivityForm').addEventListener('click', function () {
        const woId = document.getElementById('wo_select').value;
        const wpId = document.getElementById('wp_select').value || null; // Jika tidak ada WP, kirim null

        const form = document.getElementById('addActivityForm');
        const addActivityForm = $('#addActivityForm');
        const formData = new FormData(form);

        // Validasi form sebelum submit
        if (!validateAddActivityForm()) {
            return;
        }

        formData.append('wo_id', woId);
        if (wpId) {
            formData.append('wp_id', wpId);
        }

        // Kirim data menggunakan AJAX
        $.ajax({
            url: addActivityForm.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ambil CSRF token dari meta tag
            },
            beforeSend: function () {
                // Nonaktifkan semua input dan tombol di dalam form
                addActivityForm.find('input, button, select, textarea').prop('disabled', true);

                Swal.fire({
                    title: 'Menambahkan Aktivitas...',
                    text: 'Sedang memproses penambahan aktivitas baru',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                // Tampilkan pesan sukses
                Swal.fire({
                    title: "Berhasil Ditambahkan",
                    text: response.message || "Data berhasil ditambahkan!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                }).then(() => {
                    // Tutup modal dan refresh halaman
                    $('#addActivityModal').modal('hide');
                    window.location.reload();
                });
            },
            error: function (xhr) {
                // Tangani error dan tampilkan pesan kesalahan
                let errorMessage = "Terjadi kesalahan saat menambahkan aktivitas";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    title: "Gagal Menambahkan Aktivitas",
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
            },
            complete: function () {
                // Aktifkan kembali semua input dan tombol di dalam form
                addActivityForm.find('input, button, select, textarea').prop('disabled', false);
            }
        });
    });

    // ===================== EDIT ACTIVITY =====================
    let deletedTimesheetIds = []; // Array untuk menyimpan ID timesheet yang dihapus

    
    document.addEventListener('DOMContentLoaded', function () {
        // Event listener untuk tombol edit aktivitas
        const editButtons = document.querySelectorAll('.btn-edit-activity');
        const editPersonelActivityBtn = document.getElementById('editPersonelActivityBtn');
        const editPersonelActivityContainer = document.getElementById('editPersonelActivityContainer');
        const editPersonelActivityTemplate = document.getElementById('editPersonelActivityTemplate');
        let maxPersonelGroups = 0; // Jumlah maksimal user dari WP
        let currentPersonelGroups = 0; // Jumlah grup personel yang ada saat ini
        let currentPersonnel = []; // Data user dari WP

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil atribut dari tombol yang diklik
                const volumeIds = JSON.parse(this.getAttribute('data-volume-ids')); // Ambil volume IDs
                const executionDate = this.getAttribute('data-execution-date'); // Ambil execution date
                const personelIds = JSON.parse(this.getAttribute('data-personel-ids')); // Ambil personel IDs

                if (!volumeIds || !executionDate || volumeIds.length === 0) {
                    Swal.fire({
                        title: "Kesalahan",
                        text: "Data untuk mengedit aktivitas tidak lengkap.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    });
                    return;
                }

                // Panggil fungsi populateEditModal dengan parameter
                populateEditModal(volumeIds, executionDate, personelIds);
            });
        });

        // Fungsi untuk memuat data personel dari WP
        function loadPersonnelData(woId, wpId) {
            fetch(`/timesheet-management/personel?wo_id=${woId}${wpId ? `&wp_id=${wpId}` : ''}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentPersonnel = data.personnel;
                        maxPersonelGroups = currentPersonnel.length;
                        updateEditPersonelActivityButtons();
                    } else {
                        Swal.fire({
                            title: "Gagal Memuat Data",
                            text: data.message || "Tidak ada data personel untuk work package ini.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching personnel:', error);
                    Swal.fire({
                        title: "Kesalahan",
                        text: "Terjadi kesalahan saat memuat data personel.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    });
                });
        }

        document.getElementById('editActivityModal').addEventListener('shown.bs.modal', function () {
            const woId = document.getElementById('edit_wo_select').value;
            const wpId = document.getElementById('edit_wp_select').value;

            if (woId && wpId) {
                loadPersonnelData(woId, wpId);
            }
        });
    });

    // Fungsi untuk memperbarui tombol tambah aktivitas
    function updateEditPersonelActivityButtons() {
        const editPersonelActivityBtn = document.getElementById('editPersonelActivityBtn');

        console.log('Current Personel Groups:', currentPersonelGroups);
        console.log('Max Personel Groups:', maxPersonelGroups);
        // Aktifkan tombol jika jumlah personel yang ada masih kurang dari jumlah maksimal
        if (currentPersonelGroups < maxPersonelGroups) {
            editPersonelActivityBtn.removeAttribute('disabled');
        } else {
            editPersonelActivityBtn.setAttribute('disabled', 'true');
        }
    }

    // Fungsi untuk memuat data ke dalam modal edit
    function populateEditModal(volumeIds, executionDate, personelIds) {
        const hiddenInputContainer = document.getElementById('edit_timesheet_ids_container');
        const editPersonelActivityContainer = document.getElementById('editPersonelActivityContainer');
        const editWoSelect = document.getElementById('edit_wo_select');
        const editWpSelect = document.getElementById('edit_wp_select');
        const editWpSelectContainer = document.getElementById('editWpSelectContainer');
        const editExecutionDate = document.getElementById('edit_execution_date');

        // Kosongkan container dan reset state
        hiddenInputContainer.innerHTML = '';
        editPersonelActivityContainer.innerHTML = '';
        deletedTimesheetIds = [];

        // Simpan volume_ids sebagai hidden input
        const volumeIdsInput = document.createElement('input');
        volumeIdsInput.type = 'hidden';
        volumeIdsInput.name = 'volume_ids';
        volumeIdsInput.id = 'edit_volume_ids';
        volumeIdsInput.value = JSON.stringify(volumeIds);
        hiddenInputContainer.appendChild(volumeIdsInput);

        console.log('volumeIds: ', volumeIds);
        console.log('executionDate: ', executionDate);

        // Perbaiki format tanggal jika ada karakter tambahan
        const formattedExecutionDate = executionDate.replace(/['"]+/g, ''); // Hapus tanda kutip jika ada
        editExecutionDate.value = formattedExecutionDate;

        // Fetch data dari controller editData
        fetch(`/timesheet-management/edit-data?volume_ids=${encodeURIComponent(JSON.stringify(volumeIds))}&execution_date=${encodeURIComponent(formattedExecutionDate)}`)
            .then(response => response.json())
            .then(data => {
                console.log('Edit data:', data);
                if (!data.success) {
                    Swal.fire('Error', data.message || 'Gagal memuat data untuk edit.', 'error');
                    return;
                }

                const activities = data.data;

                if (activities.length === 0) {
                    Swal.fire('Error', 'Tidak ada data aktivitas yang ditemukan.', 'error');
                    return;
                }

                // Ambil informasi dari aktivitas pertama untuk mengisi WO dan WP
                const firstActivity = activities[0];
                if (!firstActivity.work_package) {
                    Swal.fire('Error', 'Data Kategori Work Package tidak tersedia.', 'error');
                    return;
                }

                // Isi dropdown WO dan WP
                editWoSelect.value = firstActivity.wo_id;

                // Fetch work packages untuk WO yang dipilih
                fetch(`/timesheet-management/${firstActivity.wo_id}/work-packages`)
                    .then(response => response.json())
                    .then(wpData => {
                        if (wpData.success && wpData.work_packages) {
                            const workPackages = wpData.work_packages;

                            // Jika ada lebih dari 1 WP, tampilkan dropdown
                            if (workPackages.length > 1) {
                                editWpSelectContainer.style.display = 'block';
                                editWpSelect.innerHTML = '<option value="">Pilih Kategori Work Package</option>';

                                workPackages.forEach(wp => {
                                    const option = document.createElement('option');
                                    option.value = wp.wp_id;
                                    option.textContent = `${wp.wp_number} - ${wp.name}`;
                                    editWpSelect.appendChild(option);
                                });

                                editWpSelect.value = firstActivity.work_package.wp_id;
                                editWpSelect.setAttribute('disabled', 'true');
                            } else {
                                editWpSelectContainer.style.display = 'none';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching work packages:', error);
                        editWpSelectContainer.style.display = 'none';
                    });

                // Tambahkan data personel dan aktivitas ke dalam modal
                activities.forEach((activity, index) => {
                    // Simpan timesheet_ids
                    activity.timesheet_ids.forEach(timesheetId => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'timesheet_ids[]';
                        hiddenInput.value = timesheetId;
                        hiddenInputContainer.appendChild(hiddenInput);
                    });

                    // Simpan personel_ids dengan index yang sama
                    const personelInput = document.createElement('input');
                    personelInput.type = 'hidden';
                    personelInput.name = 'personel_ids[]';
                    personelInput.value = activity.user_id;
                    hiddenInputContainer.appendChild(personelInput);

                    addEditPersonelActivityGroup(activity);
                });

                updateEditGroupNumbering();

                // Pastikan modal instance sudah ada
                const editActivityModalElement = document.getElementById('editActivityModal');
                const editActivityModal = bootstrap.Modal.getInstance(editActivityModalElement) || new bootstrap.Modal(editActivityModalElement);
                editActivityModal.show();
            })
            .catch(error => {
                console.error('Error loading edit data:', error);
                Swal.fire('Error', 'Gagal memuat data untuk edit.', 'error');
            });
    }

    // Event listener untuk tombol tambah personel di modal edit
    editPersonelActivityBtn.addEventListener('click', function () {
        addEditPersonelActivityGroup();
    });

    // Fungsi untuk menambahkan grup personel di modal edit
    function addEditPersonelActivityGroup(activity = null) {  // Ubah parameter jadi activity = null (fleksibel)
        const editPersonelActivityContainer = document.getElementById('editPersonelActivityContainer');
        const editPersonelActivityTemplate = document.getElementById('editPersonelActivityTemplate');

        if (!editPersonelActivityTemplate) {
            console.error('Template editPersonelActivityTemplate tidak ditemukan');
            return;
        }

        const newGroup = editPersonelActivityTemplate.content.cloneNode(true);
        const newGroupDiv = newGroup.querySelector('.personel-activity-group');
        const newGroupIndex = editPersonelActivityContainer.querySelectorAll('.personel-activity-group').length;

        newGroupDiv.id = `edit-personel-activity-${newGroupIndex}`;
        newGroupDiv.querySelector('.card-title-edit').textContent = `Personel ${newGroupIndex + 1}`;

        // Ambil elemen form
        const personelSelect = newGroupDiv.querySelector('.edit-personel-select');
        const durationSelect = newGroupDiv.querySelector('.edit-duration-select');
        const activityTextarea = newGroupDiv.querySelector('.edit-activity-textarea');
        const mandaysPlanElement = newGroupDiv.querySelector('.mandays-plan');
        const mandaysRealElement = newGroupDiv.querySelector('.mandays-real');
        const mandaysSpinner = newGroupDiv.querySelector('.spinner-container');

        if (activity) {  // Mode initial: Isi dengan data existing
            // Validasi data activity
            if (!activity.user || !activity.user.user_id) {
                console.error('Data user tidak ditemukan pada aktivitas:', activity);
                Swal.fire({
                    title: "Kesalahan Data",
                    text: "Data user tidak ditemukan pada aktivitas ini.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
                return;
            }

            // Isi dropdown personel (hanya satu option, disabled)
            personelSelect.innerHTML = `<option value="${activity.user.user_id}">${activity.user.name} - ${activity.user.roles[1].name || 'Tidak Ada Role'}</option>`;
            personelSelect.value = activity.user.user_id;
            personelSelect.disabled = true;

            // Set nilai durasi dan aktivitas
            durationSelect.value = activity.duration;
            activityTextarea.value = activity.activity;

            // Fetch mandays untuk personel ini (gunakan volume_ids[0] seperti sebelumnya)
            mandaysSpinner.style.display = 'flex';
            fetch(`/timesheet-management/personel-mandays/${activity.user.user_id}/${activity.volume_ids[0]}`)
                .then(response => response.json())
                .then(mandaysData => {
                    mandaysSpinner.style.display = 'none';
                    if (mandaysData.success) {
                        mandaysPlanElement.textContent = mandaysData.mandays_plan || 0;
                        mandaysRealElement.textContent = mandaysData.mandays_real || 0;
                    } else {
                        mandaysPlanElement.textContent = 'Error';
                        mandaysRealElement.textContent = 'Error';
                    }
                })
                .catch(error => {
                    console.error('Error fetching mandays:', error);
                    mandaysSpinner.style.display = 'none';
                    mandaysPlanElement.textContent = 'Gagal';
                    mandaysRealElement.textContent = 'Gagal';
                });

            // Set data-timesheet-id untuk tombol hapus
            const removeButton = newGroupDiv.querySelector('.remove-edit-personel-btn');
            removeButton.setAttribute('data-timesheet-id', JSON.stringify(activity.timesheet_ids));

        } else {  // Mode add new: Isi kosong, populate dropdown dari currentPersonnel
            // Kosongkan atau populate personel select dengan list available personnel
            personelSelect.innerHTML = '<option value="">Pilih Personel</option>';
            currentPersonnel.forEach(person => {  // Gunakan currentPersonnel yang sudah diload
                const option = document.createElement('option');
                option.value = person.user_id;
                option.textContent = person.name;
                // Optional: Tambahkan logic untuk disable jika sudah digunakan (check existing groups)
                personelSelect.appendChild(option);
            });
            personelSelect.disabled = false;  // Enable untuk pilih

            // Kosongkan duration dan activity
            durationSelect.value = '';
            activityTextarea.value = '';

            // Kosongkan mandays (atau fetch setelah pilih personel, tapi butuh event listener baru)
            mandaysPlanElement.textContent = 0;
            mandaysRealElement.textContent = 0;

            // Tambahkan event listener untuk fetch mandays saat personel dipilih (opsional, tapi direkomendasikan)
            personelSelect.addEventListener('change', function() {
                const selectedUserId = this.value;
                if (selectedUserId) {
                    // Asumsikan volumeId dari konteks (misalnya dari edit_wp_select atau ambil dari data lain)
                    const volumeId = document.getElementById('edit_wp_select').value;  // Sesuaikan
                    mandaysSpinner.style.display = 'flex';
                    fetch(`/timesheet-management/personel-mandays/${selectedUserId}/${volumeId}`)
                        .then(response => response.json())
                        .then(mandaysData => {
                            mandaysSpinner.style.display = 'none';
                            if (mandaysData.success) {
                                mandaysPlanElement.textContent = mandaysData.mandays_plan || 0;
                                mandaysRealElement.textContent = mandaysData.mandays_real || 0;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            mandaysSpinner.style.display = 'none';
                        });
                }
            });

            // Untuk remove button di new group, tidak perlu data-timesheet-id (karena baru)
            const removeButton = newGroupDiv.querySelector('.remove-edit-personel-btn');
            removeButton.setAttribute('data-timesheet-id', '');  // Kosong
        }

        // Event remove (sama untuk kedua mode)
        const removeButton = newGroupDiv.querySelector('.remove-edit-personel-btn');
        removeButton.addEventListener('click', function () {
            removeEditPersonelActivityGroup(newGroupDiv);
        });

        editPersonelActivityContainer.appendChild(newGroupDiv);
        currentPersonelGroups++;  // Update count
        updateEditPersonelActivityButtons();
    }

    // Fungsi untuk menghapus grup personel di modal edit
    function removeEditPersonelActivityGroup(group) {
        const editPersonelActivityContainer = document.getElementById('editPersonelActivityContainer');
        const totalGroups = editPersonelActivityContainer.querySelectorAll('.personel-activity-group').length;

        if (totalGroups <= 1) {
            Swal.fire({
                title: "Hapus Seluruh Aktivitas?",
                text: "Apakah Anda yakin ingin menghapus seluruh aktivitas personel?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-danger me-2",
                    cancelButton: "btn btn-secondary"
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const timesheetId = group.querySelector('.remove-edit-personel-btn').getAttribute('data-timesheet-id');
                    if (timesheetId) {
                        deletedTimesheetIds.push(timesheetId);
                    }
                    group.remove();
                    updateEditGroupNumbering();
                }
            });
        } else {
            Swal.fire({
                title: "Hapus Aktivitas?",
                text: `Apakah Anda yakin ingin menghapus aktivitas personel?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-danger me-2",
                    cancelButton: "btn btn-secondary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const timesheetId = group.querySelector('.remove-edit-personel-btn').getAttribute('data-timesheet-id');
                    console.log('Menghapus aktivitas personel dengan timesheetId:', timesheetId);

                    if (timesheetId) {
                        deletedTimesheetIds.push(timesheetId);
                    }

                    // Hapus elemen grup dari DOM
                    group.remove();
                    updateEditGroupNumbering();
                }
            });
        }
        updateEditPersonelActivityButtons();
    }

    // Fungsi untuk memperbarui nomor grup personel di modal edit
    function updateEditGroupNumbering() {
        const editPersonelActivityContainer = document.getElementById('editPersonelActivityContainer');
        const groups = editPersonelActivityContainer.querySelectorAll('.personel-activity-group');

        groups.forEach((group, index) => {
            group.id = `edit-personel-activity-${index}`;
            group.querySelector('.card-title-edit').textContent = `Personel ${index + 1}`;
        });
    }

    // Fungsi untuk validasi form edit
    function validateEditActivityForm() {
        const editExecutionDate = document.getElementById('edit_execution_date').value.trim();
        const personelSelects = document.querySelectorAll('.edit-personel-select');
        const activityTextareas = document.querySelectorAll('.edit-activity-textarea');
        const durationSelects = document.querySelectorAll('.edit-duration-select');

        if (!editExecutionDate) {
            Swal.fire({
                title: "Data Belum Lengkap",
                text: "Tanggal wajib diisi.",
                icon: "info",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-primary" }
            });
            return false;
        }

        for (let i = 0; i < personelSelects.length; i++) {
            if (!personelSelects[i].value.trim() || !activityTextareas[i].value.trim() || !durationSelects[i].value.trim()) {
                Swal.fire({
                    title: "Data Belum Lengkap",
                    text: "Personel, Durasi, dan Aktivitas wajib diisi untuk setiap grup.",
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-primary" }
                });
                return false;
            }
        }
        return true;
    }

    // Fungsi untuk submit form edit
    document.getElementById('submitEditActivityForm').addEventListener('click', function (e) {
        e.preventDefault();

        if (!validateEditActivityForm()) {
            return;
        }

        const deletedTimesheetInput = document.getElementById('deleted_timesheet_ids');
        if (deletedTimesheetInput) {
            deletedTimesheetInput.value = JSON.stringify(deletedTimesheetIds);
        }

        const editActivityForm = $('#editActivityForm');
        const formData = new FormData(document.getElementById('editActivityForm'));

        // Log data yang akan dikirim
        console.log('Submitting edit form with data:', Object.fromEntries(formData.entries()));

        $.ajax({
            url: editActivityForm.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ambil CSRF token dari meta tag
            },
            beforeSend: function () {
                editActivityForm.find('input, button, select, textarea').prop('disabled', true);

                Swal.fire({
                    title: 'Memperbarui Aktivitas...',
                    text: 'Sedang memproses pembaruan aktivitas',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                console.log('Edit success response:', response);
                Swal.fire({
                    title: "Berhasil Diperbarui",
                    text: response.message || "Data berhasil diperbarui!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                }).then(() => {
                    $('#editActivityModal').modal('hide');
                    window.location.reload();
                });
            },
            error: function (xhr) {
                console.error('Edit error response:', xhr);
                let errorMessage = "Terjadi kesalahan saat memperbarui aktivitas";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    title: "Gagal Memperbarui Aktivitas",
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
            },
            complete: function () {
                editActivityForm.find('input, button, select, textarea').prop('disabled', false);
            }
        });
    });

    document.getElementById('editActivityModal').addEventListener('shown.bs.modal', function () {
        this.setAttribute('aria-hidden', 'false');
    });

    document.getElementById('editActivityModal').addEventListener('hidden.bs.modal', function () {
        this.setAttribute('aria-hidden', 'true');
    });

    // ===================== DELETE ACTIVITY =====================
    $(document).on('click', '.btn-delete-activity', function(e) {
        e.preventDefault();
        const timesheetIds = $(this).data('timesheet-ids');
        console.log('Hapus seluruh aktivitas personel dengan timesheetIds:', timesheetIds);
        const executionDate = $(this).data('execution-date');
        let formattedDate = executionDate;
        if (executionDate) {
            const dateObj = new Date(executionDate);
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            formattedDate = dateObj.toLocaleDateString('id-ID', options);
        }
        Swal.fire({
            title: "Konfirmasi Hapus Aktivitas",
            html: `
                <span>Apakah Anda yakin ingin menghapus seluruh aktivitas personel pada tanggal</span>
                <p>${formattedDate}?</p>
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
                fetch(`/timesheet-management/${timesheetIds}/delete-all`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title:'Berhasil!', 
                            text: data.message, 
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
                });
            }
        });
    });
</script>
@endpush

<style>
    select.personel-select option[disabled] {
        color: #bbb !important;
        background-color: #f5f5f5 !important;
        cursor: not-allowed;
    }
    
    select.edit-personel-select option[disabled] {
        color: #bbb !important;
        background-color: #f5f5f5 !important;
        cursor: not-allowed;
    }
</style>