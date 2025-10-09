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
                                    @php
                                        // Menggunakan first() untuk mendapatkan role pertama jika ada
                                        $roleName = $user->getRoleNames()->get(1) ?? $user->getRoleNames()->first();
                                    @endphp
                                    {{-- <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{$roleName}}">{{$user->short_name}}</span> --}}
                                    {{$user->short_name}}
                                </th>     
                            @endforeach
                            <th scope="col" style="width: 30px;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @php $rowNumber = 1; @endphp
                        @foreach($groupedActivities as $groupKey => $group)
                            @php
                                $firstEntry = $group->first();
                                $wpNumber = optional($firstEntry->volume->workPackage)->wp_number ?? 'N/A';
                                $wpName = optional($firstEntry->volume->workPackage)->name ?? 'N/A';
                                $wpGroupKey = $wpNumber . ' - ' . $wpName;
                                $volumeNum = optional($firstEntry->volume)->volume_number ?? 'N/A';
                                $executionDate = optional($firstEntry)->execution_date;
                            @endphp

                            <tr>
                                {{-- Kolom tersembunyi untuk grouping --}}
                                <td style="display: none;">{{ trim(preg_replace('/\s+/', ' ', $wpGroupKey)) }}</td>

                                <td>{{ $rowNumber++ }}</td>
                                <td>{{ $volumeNum }}</td>
                                <td>{{ \Carbon\Carbon::parse($executionDate)->format('d M Y') }}</td>
                                
                                @foreach($users as $user)
                                    @php
                                        $userEntry = $group->firstWhere('user_id', $user->user_id);
                                    @endphp
                                    @if($userEntry)
                                        <td style="min-width: 120px;">
                                            @if($userEntry->duration == 1.0)
                                                <span class="badge badge-light-info mb-1">{{ $userEntry->duration }} Hari</span></br>
                                            @elseif($userEntry->duration == 0.5)
                                                <span class="badge badge-light-primary mb-1">{{ $userEntry->duration }} Hari</span></br>
                                            @else
                                                <span class="badge badge-secondary mb-1">{{ $userEntry->duration}} Hari</span></br>
                                            @endif
                                            <span>{{ $userEntry->activity}}</span>
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
                                                    data-timesheet-id="{{$firstEntry->timesheet_id}}"
                                                    data-volume-id="{{$firstEntry->volume_id}}"
                                                    data-execution-date="{{$executionDate}}"
                                                >
                                                    <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center text-danger btn-delete-activity" href="#" title="Hapus Aktivitas"
                                                    data-execution-date="{{$executionDate}}" 
                                                    data-timesheet-id="{{$firstEntry->timesheet_id}}"
                                                >
                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                    Hapus
                                                </a>
                                            </li>
                                            {{-- <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('wp-management.detail', ['wp_id' => $wp['wp_id']]) }}">
                                                    <i class="bi bi-eye me-3 fs-2 text-dark"></i>
                                                    Lihat Detail
                                                </a>
                                            </li> --}}
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
                                {{-- <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-warning btn-sm btn-edit-activity" 
                                                title="Edit Aktivitas" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editActivityModal"
                                                data-timesheet-id="{{$firstEntry->timesheet_id}}"
                                                data-volume-id="{{$firstEntry->volume_id}}"
                                                data-execution-date="{{$executionDate}}"
                                        >
                                            <i class="bi bi-pencil-square fs-6"></i>
                                        </button>
                                        <button type="button" data-execution-date="{{$executionDate}}" class="btn btn-danger btn-sm btn-delete-activity" title="Hapus Aktivitas" data-timesheet-id="{{$firstEntry->timesheet_id}}">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </div>                                  
                                </td> --}}
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
                        <label for="work_package_select" class="form-label fw-bold">Kategori Work Package</label>
                        <div class="input-group">
                            @php
                                function wpOptionText($wp) {
                                    $maxLength = 100; // atur sesuai kebutuhan
                                    $text = trim($wp->wp_number . ' ' . $wp->name);
                                    return strlen($text) > $maxLength
                                        ? mb_substr($text, 0, $maxLength) . '...'
                                        : $text;
                                }
                            @endphp
                            <select class="form-select form-select-solid" name="wp_id" id="work_package_select" required>
                                <option value="">Pilih Kategori Work Package</option>
                                {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                @foreach($workPackages as $wp)
                                    <option value="{{ $wp->wp_id }}">{{ wpOptionText($wp) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="volume_select" class="form-label fw-bold">Volume Ke-</label>
                                <div class="input-group">
                                    <select class="form-select form-select-solid" name="volume_id" id="volume_select" required>
                                        <option value="">Pilih Volume</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" name="execution_date" id="execution_date" placeholder="Masukkan Tanggal" min="1" max="31" required/>
                            </div>
                        </div>
                    </div>
                    <div id="personelActivityContainer">
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
                                                        <option value="1.0">1.0</option>
                                                        <option value="1.5">1.5</option>
                                                        <option value="2.0">2.0</option>
                                                    </select>
                                                    <span class="input-group-text" style="min-width:40px; padding-left:6px; padding-right:6px;">Hari</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group mb-6">
                                        <label for="activity_0" class="form-label fw-bold">Aktivitas</label>
                                        <textarea class="form-control activity-textarea"  name="activities[]" id="activity_0" rows="2" placeholder="Aktivitas" required></textarea>
                                    </div>                    
                                </div>
                            </div>
                        </template>
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
                    <input type="hidden" name="timesheet_id" id="edit_timesheet_id" value="">
                    <div class="form-group mb-6">
                        <label for="edit_work_package_select" class="form-label fw-bold">Kategori Work Package</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid" name="wp_id" id="edit_work_package_select" required>
                                <option value="">Pilih Kategori Work Package</option>
                                {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                @foreach($workPackages as $wp)
                                    <option value="{{ $wp->wp_id }}">{{ $wp->wp_number }} {{ $wp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_volume_select" class="form-label fw-bold">Volume Ke-</label>
                                <div class="input-group">
                                    <select class="form-select form-select-solid" name="volume_id" id="edit_volume_select" required>
                                        <option value="">Pilih Volume</option>
                                    </select>
                                </div>
                            </div>
                            <div id="tanggal" class="col-md-6">
                                <label for="edit_execution_date" class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" name="execution_date" id="edit_execution_date" required/>
                            </div>
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
                <button type="button" class="btn btn-sm btn-light-danger remove-edit-personel-btn">
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
                                <option value="1.0">1.0</option>
                                <option value="1.5">1.5</option>
                                <option value="2.0">2.0</option>
                            </select>
                            <span class="input-group-text" style="min-width:40px; padding-left:6px; padding-right:6px;">Hari</span>
                        </div>
                    </div>
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
            table.column(4).search(searchValue, false, true).draw();
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

    function escapeRegex(string) {
        return string.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    }

    function normalizeText(text) {
        return text.replace(/\s+/g, ' ').trim();
    }

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

    // menampilkan volume berdasarkan work package yang dipilih
    const volumeData = @json(
        $workPackages->mapWithKeys(function ($wp) {
            return [$wp->wp_id => $wp->workPackageVolumes
                ->sortBy('volume_number')
                ->map(function ($vol) {
                    return [
                        'volume_id' => $vol->volume_id,
                        'volume_number' => $vol->volume_number
                    ];
            })->values()];
        })->toArray()
    );
    const volumeSelect = document.getElementById('volume_select');
    const editVolumeSelect = document.getElementById('edit_volume_select');

    document.addEventListener('DOMContentLoaded', function () {
        const wpSelect = document.getElementById('work_package_select');
        const editWpSelect = document.getElementById('edit_work_package_select');

        wpSelect.addEventListener('change', function () {
            updateVolumeOptions(this.value, volumeSelect);
            updateAllPersonelSelects('');
        });

        volumeSelect.addEventListener('change', function () {
            updateAllPersonelSelects(this.value);
        });

        editWpSelect.addEventListener('change', function () {
            updateVolumeOptions(this.value, editVolumeSelect);
            updateAllPersonelSelects('');
        });

        editVolumeSelect.addEventListener('change', function () {
            updateAllPersonelSelects(this.value);
        });
    });

    // menampilkan personel berdasarkan volume yang dipilih
    const personnelData = @json($personnelByVolume);

    function updateAllPersonelSelects(volumeId) {
        const selects = document.querySelectorAll('.personel-select, .edit-personel-select');
        const personnelList = personnelData[volumeId] || [];

        selects.forEach((select) => {
            // Simpan nilai terpilih sebelumnya (jika ada)
            const selectedValue = select.value;

            // Kosongkan dulu semua opsi
            select.innerHTML = '<option value="">Pilih Personel</option>';

            // Tambahkan opsi personel baru
            personnelList.forEach(person => {
                const option = document.createElement('option');
                option.value = person.user_id;
                option.textContent = `${person.name} - ${person.role_name}`;
                select.appendChild(option);
            });

            // Coba kembalikan nilai terpilih jika masih ada di list baru
            if (personnelList.find(p => p.user_id == selectedValue)) {
                select.value = selectedValue;
            }
        });
    }

    function updateVolumeOptions(wpId, volumeSelectElement) {
        const volumes = volumeData[wpId] || [];
        volumeSelectElement.innerHTML = '<option value="">Pilih Volume</option>';

        volumes.forEach(vol => {
            const option = document.createElement('option');
            option.value = vol.volume_id;
            option.textContent = vol.volume_number;
            volumeSelectElement.appendChild(option);
        });
    }

    // Add Personel Activity Button
    const addActivityModal = new bootstrap.Modal(document.getElementById('addActivityModal'));
    const addActivityForm = document.getElementById('addActivityForm');
    const submitAddActivityForm = document.getElementById('submitAddActivityForm');
    const personelActivityContainer = document.getElementById('personelActivityContainer');
    const personelActivityTemplate = document.getElementById('personelActivityTemplate');
    const addPersonelActivityBtn = document.getElementById('addPersonelActivityBtn');

    let currentPersonelGroups = 0;
    const maxPersonelGroups = {{ $users->count() }};

    function updatePersonelActivityButtons() {
        const totalGroups = personelActivityContainer.querySelectorAll('.personel-activity-group').length;
        currentPersonelGroups = totalGroups;

        // Nonaktifkan tombol tambah jika sudah mencapai batas maksimal user
        if (totalGroups >= maxPersonelGroups) {
            addPersonelActivityBtn.setAttribute('disabled', 'true');
        } else {
            addPersonelActivityBtn.removeAttribute('disabled');
        }
    }

    function updatePersonelSelectOptions() {
        // Ambil semua select personel di form tambah aktivitas
        const selects = personelActivityContainer.querySelectorAll('.personel-select');
        // Ambil semua user_id yang sudah dipilih
        const selectedIds = Array.from(selects).map(select => select.value).filter(val => val);

        selects.forEach(select => {
            const currentValue = select.value;
            // Simpan value yang sudah dipilih di select lain
            select.querySelectorAll('option').forEach(option => {
                // Jika option bukan yang sedang dipilih di select ini, dan sudah dipilih di select lain, disable
                if (option.value && option.value !== currentValue && selectedIds.includes(option.value)) {
                    option.disabled = true;
                    option.setAttribute('data-disabled', 'true');
                } else {
                    option.disabled = false;
                    option.removeAttribute('data-disabled');
                }
            });
        });
    }

    // Event listener agar update otomatis saat ada perubahan
    personelActivityContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('personel-select')) {
            updatePersonelSelectOptions();
        }
    });

    // menambah personel activity
    function addPersonelActivityGroup() {
        if (currentPersonelGroups >= maxPersonelGroups) {
            Swal.fire({
                text: "Anda telah mencapai batas maksimal personel (" + maxPersonelGroups + ").",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: { confirmButton: "btn btn-warning" }
            });
            return;
        }

        const newGroup = personelActivityTemplate.content.cloneNode(true);
        const newGroupDiv = newGroup.querySelector('.personel-activity-group');
        const newGroupIndex = currentPersonelGroups; // Menggunakan counter sebagai indeks

        newGroupDiv.id = `personel-activity-${newGroupIndex}`; // Berikan ID unik ke grup div
        newGroupDiv.querySelector('.card-title').textContent = `Personel ${newGroupIndex + 1}`; // Update judul

        // Update ID dan name atribut untuk input select dan textarea
        const selectElement = newGroupDiv.querySelector('.personel-select');
        selectElement.id = `personel_select_${newGroupIndex}`;
        selectElement.name = `personel_ids[${newGroupIndex}]`; // Gunakan indeks untuk array name

        const durationElement = newGroupDiv.querySelector('.duration-select');
        durationElement.id = `duration_${newGroupIndex}`;
        durationElement.name = `durations[${newGroupIndex}]`; // Gunakan indeks untuk array name

        const textareaElement = newGroupDiv.querySelector('.activity-textarea');
        textareaElement.id = `activity_${newGroupIndex}`;
        textareaElement.name = `activities[${newGroupIndex}]`; // Gunakan indeks untuk array name

        // Update onclick untuk tombol hapus jika Anda menggunakan onclick
        const removeButton = newGroupDiv.querySelector('.remove-personel-btn');
        removeButton.onclick = function() {
            removePersonelActivityGroup(newGroupDiv.id);
        };

        personelActivityContainer.appendChild(newGroup);
        updatePersonelActivityButtons(); // Perbarui status tombol

        updateAllPersonelSelects(volumeSelect.value);
        updatePersonelSelectOptions(); // Tambahkan ini
    }

    // menghapus personel activity
    function removePersonelActivityGroup(groupId) {
        const totalGroups = personelActivityContainer.querySelectorAll('.personel-activity-group').length;
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
        
        document.getElementById(groupId).remove();
        updatePersonelActivityButtons();
        updatePersonelSelectOptions(); // Tambahkan ini
        // Update nomor personel setelah penghapusan (Personel 1, Personel 2, dst)
        personelActivityContainer.querySelectorAll('.personel-activity-group').forEach((group, index) => {
            group.id = `personel-activity-${index}`;
            group.querySelector('.card-title').textContent = `Personel ${index + 1}`;
            group.querySelector('.personel-select').id = `personel_select_${index}`;
            group.querySelector('.personel-select').name = `personel_ids[${index}]`;
            group.querySelector('.duration-select').id = `duration_${index}`;
            group.querySelector('.duration-select').name = `durations[${index}]`;
            group.querySelector('.activity-textarea').id = `activity_${index}`;
            group.querySelector('.activity-textarea').name = `activities[${index}]`;
            group.querySelector('.remove-personel-btn').onclick = function() {
                removePersonelActivityGroup(group.id);
            };
        });
    }

    // event listener untuk tombol tambah dan hapus personel activity
    if (addPersonelActivityBtn) {
        addPersonelActivityBtn.addEventListener('click', addPersonelActivityGroup);
    }

    // inisiasi awal dengan satu grup personel
    addActivityModal._element.addEventListener('show.bs.modal', function() {
        currentPersonelGroups = 0;
        // Hapus semua grup yang mungkin ada dari sesi sebelumnya
        personelActivityContainer.innerHTML = '';
        // Tambahkan satu grup personel secara default
        addPersonelActivityGroup();
        updateAllPersonelSelects(volumeSelect.value);
    });

    // Ketika modal ditutup, reset seluruh isian form
    $('#addActivityModal').on('hidden.bs.modal', function () {
        // Reset form
        document.getElementById('addActivityForm').reset();

        // Hapus semua personel card kecuali yang pertama
        const container = document.getElementById('personelActivityContainer');
        const groups = container.querySelectorAll('.personel-activity-group');
        groups.forEach((group, index) => {
            if (index > 0) group.remove();
        });

        // Reset ID dan name personel & aktivitas pertama
        const firstSelect = container.querySelector('.personel-select');
        const firstDuration = container.querySelector('.duration-select');
        const firstTextarea = container.querySelector('.activity-textarea');
        if (firstSelect) {
            firstSelect.id = 'personel_select_0';
            firstSelect.name = 'personel_ids[0]';
            firstSelect.innerHTML = '<option value="">Pilih Personel</option>';
        }
        if (firstDuration) {
            firstDuration.id = 'duration_0';
            firstDuration.name = 'durations[0]';
            firstDuration.value = '0.5';
        }
        if (firstTextarea) {
            firstTextarea.id = 'activity_0';
            firstTextarea.name = 'activities[0]';
            firstTextarea.value = '';
        }

        // Reset judul
        const title = container.querySelector('.card-title');
        if (title) title.textContent = 'Personel 1';

        // Reset dropdown volume
        const volumeSelect = document.getElementById('volume_select');
        if (volumeSelect) {
            volumeSelect.innerHTML = '<option value="">Pilih Volume</option>';
        }

        // Pastikan counter personel direset
        currentPersonelGroups = 1;
    });

    function validateAddActivityForm() {
        // Cek field utama
        const wp = document.getElementById('work_package_select').value.trim();
        const vol = document.getElementById('volume_select').value.trim();
        const date = document.getElementById('execution_date').value.trim();

        if (!wp || !vol || !date) {
            Swal.fire({
                title: "Data Belum Lengkap",
                text: "Kategori Work Package, Volume, Tanggal, Personel, Durasi, dan aktivitas wajib diisi.",
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
        for (let i = 0; i < personelSelects.length; i++) {
            if (!personelSelects[i].value.trim() || !activityTextareas[i].value.trim()) {
                Swal.fire({
                    title: "Data Belum Lengkap",
                    text: "Personel, durasi, dan aktivitas wajib diisi untuk setiap grup.",
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

    // Submit form untuk tambah aktivitas
    if (submitAddActivityForm) {
        submitAddActivityForm.addEventListener('click', function(e) {
            e.preventDefault();
            if (!validateAddActivityForm()) return;

            const addActivityForm = $('#addActivityForm');
            const formData = new FormData(addActivityForm[0]);

            $.ajax({
                url: addActivityForm.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    addActivityForm.find('input, button, select, textarea').prop('disabled', true);
                    Swal.fire({
                        title: 'Menambahkan Aktivitas...',
                        text: 'Sedang memproses penambahan aktivitas baru',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                },
                success: function (response) {
                    Swal.fire({
                        title: "Berhasil Ditambahkan",
                        text: response.message || "Data berhasil ditambahkan!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    }).then(() => {
                        addActivityModal.hide();
                        window.location.reload();
                    });
                },
                error: function (xhr) {
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
                    addActivityForm.find('input, button, select, textarea').prop('disabled', false);
                }
            });
        });
    }

    // edit and or delete activity
    const editActivityModal = new bootstrap.Modal(document.getElementById('editActivityModal'));
    const editActivityForm = document.getElementById('editActivityForm');
    const submitEditActivityForm = document.getElementById('submitEditActivityForm');
    const editPersonelActivityContainer = document.getElementById('editPersonelActivityContainer');
    const editPersonelActivityBtn = document.getElementById('editPersonelActivityBtn');
    
    let editCurrentPersonelGroups = 0;
    let editMaxPersonelGroups = {{ $users->count() }};
    console.log('Max personel groups:', editMaxPersonelGroups);

    document.getElementById('editActivityModal').addEventListener('hidden.bs.modal', function () {
        // Reset seluruh isi container personel activity di modal edit
        editPersonelActivityContainer.innerHTML = '';
        editCurrentPersonelGroups = 0;
    });

    function populateEditModal(timesheetId, volumeId, executionDate) {        
        // Set hidden input value for timesheet id
        const hiddenInputContainer = document.getElementById('edit_timesheet_ids_container');
        hiddenInputContainer.innerHTML = '';

        // Fetch existing data
        fetch(`/timesheet-management/${volumeId}/${executionDate}/edit-data`)
            .then(response => response.json())
            .then(data => {
                const activities = data.data;
                console.log('Edit data:', activities);
                if (!activities.length || !activities[0].volume || !activities[0].volume.work_package) {
                    Swal.fire('Error', 'Data Kategori work package tidak tersedia.', 'error');
                    return;
                }
                const wpId = activities[0].volume.work_package.wp_id;

                document.getElementById('edit_work_package_select').value = wpId;
                document.getElementById('edit_timesheet_id').value = activities[0].timesheet_id;

                const volumes = volumeData[wpId] || [];
                const volumeSelect = document.getElementById('edit_volume_select');
                volumeSelect.innerHTML = '<option value="">Pilih Volume</option>';
                volumes.forEach(vol => {
                    const option = document.createElement('option');
                    option.value = vol.volume_id;
                    option.textContent = vol.volume_number;
                    volumeSelect.appendChild(option);
                });

                volumeSelect.value = volumeId;
                document.getElementById('edit_execution_date').value = executionDate;

                // Kosongkan dulu container-nya
                const hiddenInputContainer = document.getElementById('edit_timesheet_ids_container');
                hiddenInputContainer.innerHTML = '';

                // Tambahkan personel dan aktivitas yang sudah ada (dari database)
                activities.forEach((item) => {
                    if (item.timesheet_id) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'timesheet_ids[]';
                        hiddenInput.value = item.timesheet_id;
                        hiddenInputContainer.appendChild(hiddenInput);
                    }

                    // Tetap panggil function untuk render field-nya
                    editPersonelActivityGroup(item);
                });

                editCurrentPersonelGroups = 0;

                // menggantikan updateEditPersonelSelects(volumeId);
                updateAllPersonelSelects(volumeId);
                updateEditPersonelSelectOptions();

                editActivityModal.show();
            })
            .catch(error => {
                console.error('Error loading edit data:', error);
                Swal.fire('Error', 'Gagal memuat data untuk edit', 'error');
            });
    }

    const allUsers = @json($users);
    console.log('All users:', allUsers);
    function editPersonelActivityGroup(activity) {
        const template = document.getElementById('editPersonelActivityTemplate');
        if (!template) {
            console.error('Template editPersonelActivityTemplate not found');
            return;
        }
        // Langsung clone node utama (bukan dibungkus lagi)
        const group = template.content.cloneNode(true).querySelector('.personel-activity-group');

        const personelSelect = group.querySelector('.edit-personel-select');
        const durationSelect = group.querySelector('.edit-duration-select');
        const textarea = group.querySelector('.edit-activity-textarea');

        // Populate select
        allUsers.forEach(user => {
            const userOption = document.createElement('option');
            userOption.value = user.user_id;
            let roleName = (user.roles && user.roles.length > 1)
                ? user.roles[1].name
                : (user.roles && user.roles.length ? user.roles[0].name : '');
            userOption.textContent = `${user.name} - ${roleName}`;
            personelSelect.appendChild(userOption);
        });

        durationSelect.value = activity.duration ? String(activity.duration) : '1.0';
        textarea.value = activity.activity || '';
        personelSelect.value = activity.user_id ? String(activity.user_id) : '';

        // Event listener tombol hapus
        const removeBtn = group.querySelector('.remove-edit-personel-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', function () {
                removeEditPersonelActivityGroup(group);
            });
        }

        editPersonelActivityContainer.appendChild(group);
        updateEditGroupNumbering();
    }

    function removeEditPersonelActivityGroup(group) {
        if (typeof group === 'string') {
            group = document.getElementById(group);
        }
        const totalGroups = editPersonelActivityContainer.querySelectorAll('.personel-activity-group').length;
        if (totalGroups <= 1) {
            Swal.fire({
                title: "Hapus Seluruh Aktivitas?",
                text: `Apakah Anda yakin ingin menghapus seluruh aktivitas personel?`,
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
                    const timesheetId = document.getElementById('edit_timesheet_id').value; // atau ambil dari global variable

                    fetch(`/timesheet-management/${timesheetId}/delete-all`, {
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
                                // Tutup modal dan update UI
                                $('#editActivityModal').modal('hide');
                                // location.reload();
                                $(`[data-timesheet-id="${timesheetId}"]`).closest('tr').remove();
                                // console.log('Menghapus seluruh aktivitas personel');
                                // document.getElementById(groupId).remove();
                                editCurrentPersonelGroups--;
                                // Tetap update numbering (meskipun 0, jaga konsistensi DOM)
                                // wrapper.remove();
                                group.remove();
                                updateEditGroupNumbering();
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
        }else {
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
                    const timesheetId = document.getElementById('edit_timesheet_id').value; // atau ambil dari global variable

                    fetch(`/timesheet-management/${timesheetId}/delete`, {
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
                                // Tutup modal dan update UI
                                $('#editActivityModal').modal('hide');
                                // location.reload();
                                $(`[data-timesheet-id="${timesheetId}"]`).closest('tr').remove();
                                // console.log('Menghapus seluruh aktivitas personel');
                                // document.getElementById(groupId).remove();
                                editCurrentPersonelGroups--;
                                // Tetap update numbering (meskipun 0, jaga konsistensi DOM)
                                // wrapper.remove();
                                group.remove();
                                updateEditGroupNumbering();
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
        }
    }

    // ...existing code...
    function updateEditGroupNumbering() {
        // Selalu urutkan berdasarkan urutan DOM
        const groups = editPersonelActivityContainer.querySelectorAll('.personel-activity-group');
        groups.forEach((group, index) => {
            group.id = `edit-personel-activity-${index}`;
            const title = group.querySelector('.card-title, .card-title-edit');
            if (title) title.textContent = `Personel ${index + 1}`;
            const select = group.querySelector('.edit-personel-select');
            if (select) {
                select.id = `edit_personel_select_${index}`;
                select.name = `personel_ids[${index}]`;
            }
            const duration = group.querySelector('.edit-duration-select');
            if (duration) {
                duration.id = `edit_duration_${index}`;
                duration.name = `durations[${index}]`;
            }
            const textarea = group.querySelector('.edit-activity-textarea');
            if (textarea) {
                textarea.id = `edit_activity_${index}`;
                textarea.name = `activities[${index}]`;
            }
            // Pastikan tombol hapus tetap berfungsi
            const removeBtn = group.querySelector('.remove-edit-personel-btn');
            if (removeBtn) {
                removeBtn.onclick = function () {
                    removeEditPersonelActivityGroup(group);
                };
            }
        });
    }
    
    // Event listener for edit buttons
    $(document).on('click', '.btn-edit-activity', function(e) {
        e.preventDefault();
        const timesheetId = $(this).data('timesheet-id');
        const volumeId = $(this).data('volume-id');
        const executionDate = $(this).data('execution-date');
        populateEditModal(timesheetId, volumeId, executionDate);
    });

    function updateEditPersonelSelectOptions() {
        // Ambil semua select personel di modal edit
        const selects = editPersonelActivityContainer.querySelectorAll('.edit-personel-select');
        // Ambil semua user_id yang sudah dipilih
        const selectedIds = Array.from(selects).map(select => select.value).filter(val => val);

        selects.forEach(select => {
            const currentValue = select.value;
            select.querySelectorAll('option').forEach(option => {
                // Disable jika sudah dipilih di select lain dan bukan yang sedang aktif
                if (option.value && option.value !== currentValue && selectedIds.includes(option.value)) {
                    option.disabled = true;
                    option.setAttribute('data-disabled', 'true');
                } else {
                    option.disabled = false;
                    option.removeAttribute('data-disabled');
                }
            });
        });
    }

    // Event listener agar update otomatis saat ada perubahan di modal edit
    editPersonelActivityContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('edit-personel-select')) {
            updateEditPersonelSelectOptions();
        }
    });

    if (editPersonelActivityBtn) {
        editPersonelActivityBtn.addEventListener('click', function() {
            // Hitung jumlah group saat ini
            const totalGroups = editPersonelActivityContainer.querySelectorAll('.personel-activity-group').length;
            if (totalGroups >= editMaxPersonelGroups) {
                Swal.fire({
                    text: "Anda telah mencapai batas maksimal personel (" + editMaxPersonelGroups + ").",
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-warning" }
                });
                return;
            }
            // Tambahkan group kosong baru
            editPersonelActivityGroup({ activity: '', user_id: '' });
            updateAllPersonelSelects(editVolumeSelect.value);
            updateEditGroupNumbering();
            updateEditPersonelSelectOptions();
        });
    }

    if (submitEditActivityForm) {
        submitEditActivityForm.addEventListener('click', function(e) {
            e.preventDefault();
            
            const formData = new FormData(editActivityForm);
            const url = editActivityForm.action;
            
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
                    title: "Berhasil",
                    text: "Data berhasil diperbarui!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                }).then(() => {
                    editActivityModal.hide();
                    location.reload();
                });
            })
            .catch(error => {
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

    // delete
    $(document).on('click', '.btn-delete-activity', function(e) {
        e.preventDefault();
        const timesheetId = $(this).data('timesheet-id');
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
                fetch(`/timesheet-management/${timesheetId}/delete`, {
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
                            // location.reload(); // atau remove baris dari DOM langsung
                            $(`[data-timesheet-id="${timesheetId}"]`).closest('tr').remove();
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