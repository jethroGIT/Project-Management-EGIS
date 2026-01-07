@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-10 mt-2 mb-3">Manajemen Work Order</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
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
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-primary me-2 mb-3" onclick="openAssignWO()">
                    <i class="bi bi-plus-circle"></i> Assign WP ke WO
                </button>

                <!-- Search Bar -->
                <div>
                    <form class="d-flex justify-content-end mb-4">
                        <label class="me-5 mt-3" for="searchWO">Cari: </label>
                        <input 
                            class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                            style="width:200px" 
                            type="search" 
                            id="searchWO"
                            placeholder="Cari Data" 
                            aria-label="Search"
                        >                    
                    </form>
                </div>
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
                                <label class="form-label fw-bold">Work Package</label>
                                <select class="form-select form-select-solid" id="kategoriFilter">
                                    <option value="">Pilih Work Package</option>
                                    @foreach($categories as $category)
                                        @if($category->workPackage && $category->workPackage->count() > 0)
                                            <option value="{{ $category->category_id }}">
                                                @if(isset($category->category_number))
                                                    {{ $category->category_number }}.
                                                @endif
                                                {{ $category->name }}
                                            </option>
                                        @endif
                                    @endforeach
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

            <!-- Table -->
            {{-- No WP, no WO, nama WP, volume by contract, volume realisasi, volume remaining, action lihat detail --}}
            <div class="table-responsive mb-2" style="overflow-x: auto; width: 100%;">
                <table id="table_work_order" class="table table-hover gy-4 gs-3 border rounded w-100">
                    <thead>
                        <tr class="text-center fw-bolder fs-6 text-gray-800 px-7">
                            <th scope="col" style="display: none;">WP Group Key</th> {{-- untuk grouping WP category --}}
                            <th scope="col" rowspan="2" class="align-middle border-bottom" style="min-width:50px">No.</th>
                            <th scope="col" rowspan="2" class="align-middle border-bottom">Work Package</th>
                            @php
                                $countYears = $executionYears->count();
                            @endphp
                            <th scope="col" colspan="{{$countYears}}" class="align-middle border-bottom">No. WO</th>
                            <th scope="col" colspan="3" class="align-middle border-bottom">Volume (Qty)</th>
                            <th scope="col" rowspan="2" class="align-middle border-bottom" style="min-width: 70px">Action</th>
                        </tr>
                        <tr class="text-center fw-bolder fs-6 text-gray-800 px-7">
                            <th scope="col" style="display: none;"></th> {{-- untuk grouping WP category --}}
                            @foreach($executionYears as $year)
                                <th class="align-middle border-bottom" style="min-width: 50px">{{ $year }}</th>
                            @endforeach
                            <th class="align-middle border-bottom" style="min-width: 100px">By Contract</th>
                            <th class="align-middle border-bottom" style="min-width: 70px">Realisasi</th>
                            <th class="align-middle border-bottom" style="min-width: 50px">Sisa</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @forelse($workPackages as $wp)
                            <tr>
                                @php
                                    $totalWithWO = $wp->workPackageVolumes->whereNotNull('wo_id')->count();
                                    $remaining = $wp->volume_qty - $totalWithWO;
                                @endphp

                                {{-- Kolom tersembunyi untuk grouping --}}
                                <td style="display: none;">{{$wp->wpCategory->name ?? '-'}}</td>
                                <td class="align-middle text-center">{{$wp->wp_number}}</td>
                                <td class="align-middle">{{$wp->name}}</td>
                                @foreach($executionYears as $year)
                                    <td class="align-middle text-center">
                                        @php
                                            $woNumbers = $wp->workPackageVolumes
                                                ->where('execution_year', $year)
                                                ->whereNotNull('workOrder')
                                                ->sortBy(fn($vol) => $vol->workOrder->wo_number)
                                                ->pluck('workOrder.wo_number')
                                                ->filter()
                                                ->unique()
                                                ->map(fn($num) => 'WO ' . $num)
                                                ->implode(', ');
                                        @endphp
                                        {{ $woNumbers ?: '-' }}
                                    </td>
                                @endforeach
                                <td class="align-middle text-center">{{$wp->volume_qty}}</td>
                                <td class="align-middle text-center">{{$totalWithWO}}</td>
                                <td class="align-middle text-center">{{$remaining}}</td>
                                <td class="align-middle text-center">
                                    {{-- Button Lihat Detail --}}
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat Detail" 
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_detail_wo" 
                                            data-wp-id="{{ $wp->wp_id }}"
                                    >
                                        <i class="bi bi-eye fs-2 text-center p-0"></i>
                                    </button>
                                </td>
                            </tr>  
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-people fs-1 text-muted mb-2"></i>
                                        <h6 class="text-muted">Belum Ada Kategori WP</h6>
                                        <p class="text-muted">Tidak ada data kategori WP dalam sistem</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse          
                    </tbody>                
                </table>
            </div>
            <div class="separator my-3"></div>                        
            <div class="card card-flush shadow-sm border-0 mb-5" id="mandaysCard" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);">
                <div class="card-header pb-0">
                    <h3 class="card-title fw-bold p-0">Summary by Work Orders</h3>
                </div>
                <div class="card-body py-0">
                    <table id="table_summary_work_order" class="table border bordered-gray-300 table-row-bordered table-sm table-row-gray-300 gs-3">
                        <thead style="font-size: 1.1rem;">
                            <tr>
                                <th scope="col" style="display: none;">WP Group Key</th> {{-- untuk grouping WP category --}}
                                <th scope="col" class="fw-bold align-middle">No.</th>
                                <th scope="col" class="fw-bold align-middle">Kategori WP</th>
                                <th scope="col" class="fw-bold text-center align-middle">Volume (QTY)</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.97rem;">
                            @foreach($summaryWorkOrders as $summary)
                                @foreach($summary['grouped_volumes'] as $group)
                                    <tr>
                                        <td scope="col" style="display: none;">
                                            WO {{ $summary['wo_number'] }} - ({{ $summary['execution_year'] }})
                                        </td>
                                        <td class="align-middle text-center">{{ $group['wp']->wp_number ?? '-' }}</td>
                                        <td class="align-middle">{{ $group['wp']->name ?? '-' }}</td>
                                        <td class="text-center align-middle">{{ $group['count'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach                         
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection

<div class="modal fade" tabindex="-1" id="kt_modal_detail_wo">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Work Order</h3>
            </div>
            <div class="modal-body">
                <span class="badge badge-primary" id="work_package_no">WP </span>
                <p id="work_package_name">WP </p>
                <table id="modal_work_order" class="table table-hover gy-4 gs-3 border rounded w-100">
                    <thead>
                        <tr class="text-center fw-bold fs-6 text-gray-800 px-7">
                            <th scope="col" style="display:none;">WO Group</th>
                            <th scope="col" class="align-middle border-bottom">Volume ke-</th>
                            <th scope="col" class="align-middle border-bottom">Periode</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data akan diisi melalui JavaScript --}}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Assign Work Package ke Work Order (Contoh statis) -->
<div class="modal fade" tabindex="-1" id="kt_modal_assign_wo" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Assign Kategori Work Package ke Work Order</h3>
            </div>
            <div class="modal-body">
                <form id="assignWoForm">
                    @csrf
                    <div class="mb-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-clipboard-check text-primary me-2 fs-3"></i>
                            <h6 class="mb-0">Work Order</h6>
                        </div>
                        @php
                            $latestWO = $workOrders->sortByDesc('wo_number')->first();
                        @endphp
                        @if($latestWO)
                            <div class="mb-3 px-2 py-2 rounded border border-info">
                                <div class="fw-bold text-info mb-1">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Work Order Sebelumnya: WO {{ $latestWO->wo_number }} ({{ $latestWO->workPackageVolumes->pluck('execution_year')->unique()->filter()->implode(', ') ?: '-' }})
                                </div>
                                <div class="text-dark small">
                                    WP:
                                    @php
                                        $wpNumbers = $latestWO->workPackageVolumes->pluck('workPackage.wp_number')->unique()->filter();
                                    @endphp
                                    @if($wpNumbers->isNotEmpty())
                                        @foreach($wpNumbers as $wpNum)
                                            <span class="badge badge-light-primary badge-square fw-bold me-1">{{ $wpNum }}</span>
                                        @endforeach
                                    @else
                                        <span class="fw-bold">-</span>
                                    @endif
                                    <br>
                                    Volume yang di assign: <span class="fw-bold">{{ $latestWO->workPackageVolumes->count() }}</span>
                                </div>
                            </div>
                        @else
                            <div class="mb-3 px-2 py-2 rounded bg-light border border-primary text-muted">
                                <i class="bi bi-primary-circle me-1"></i>
                                Belum ada Work Order sebelumnya.
                            </div>
                        @endif
                        <div class="input-group mb-3">
                            <span class="input-group-text">Nomor WO</span>
                            <input type="number" min="1" id="newWoNumber" name="newWoNumber"
                                class="form-control" placeholder="1" required />
                        </div>
                    </div>
                    <div class="separator separator-dashed my-6"></div>
                    <div class="mb-8">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-calendar-range text-primary me-2 fs-4"></i>
                            <h6 class="mb-0">Periode Pelaksanaan Volume WP</h6>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold required">Start Date</label>
                                <input type="date" name="start_date" id="addVolumeStartDate" 
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold required">End Date</label>
                                <input type="date" name="end_date" id="addVolumeEndDate" 
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-solid my-4"></div>
                    <div id="volumeSelectionContainer"></div>
                    <div class="d-flex justify-content-start mb-0">
                        <button type="button btn-sm" class="btn btn-primary" id="addWPVolumeBtn" onclick="addMoreVolumeSelection()">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Pilih Volume WP Lain
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="addAssignWO()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<template id="volumeSelectionTemplate">
    <div class="card card-flush shadow-sm border-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);">
        <div class="card-header py-1">
            <div class="card-title title-template fw-bolder fs-5">Assignment #</div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-danger remove-wpvolume-btn">
                    <i class="bi bi-trash fs-5"></i> Hapus
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-10">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-info-circle text-primary me-2 fs-3"></i>
                    <div class="fs-5 text-dark fw-bold mb-0">Kategori Work Package</div>
                </div>
                @php
                    function wpOptionText($wp) {
                        $maxLength = 100; // atur sesuai kebutuhan
                        $text = trim($wp->wp_number . ' ' . $wp->name);
                        return strlen($text) > $maxLength
                            ? mb_substr($text, 0, $maxLength) . '...'
                            : $text;
                    }
                @endphp
                <select name="wp_id" class="form-select wpSelect mb-2" required>
                    <option value="">Pilih Kategori Work Package</option>
                    @foreach($workPackages as $wp)
                        @php
                            $remaining = $wp->volume_qty - $wp->workPackageVolumes->whereNotNull('wo_id')->count();
                        @endphp
                        @if($remaining > 0)
                            <option value="{{ $wp->wp_id }}" data-remaining="{{ $remaining }}" data-total="{{ $wp->volume_qty }}">
                                {{ wpOptionText($wp) }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="volume-section">
                <div class="alert alert-warning py-2 px-3 mb-0 volume-warning" role="alert" style="display:block;">
                    silakan pilih kategori Work Package terlebih dahulu
                </div>
                <div class="volume-options" style="display:none;">
                    <div class="d-flex align-items-center justify-content-start mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-folder text-primary me-2 fs-3"></i>
                            <div class="fs-5 text-dark fw-bold mb-0">Volume</div>
                        </div>
                    </div>
                    <div class="mb-3 px-2 py-2 rounded border border-info">
                        <div class="fw-bold text-info mb-1">
                            <i class="bi bi-clock-history me-1"></i>
                            WP Volume yang sudah di-assign:
                        </div>
                        <div class="text-dark small wp-assigned-info">
                            <span class="assigned-volume-count"></span>
                        </div>
                        <div class="text-dark small wp-assigned-info">
                            <span class="assigned-volume-period"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group" style="max-width: 200px;">
                            <input type="number" min="1" name="volume_count"
                                class="form-control volume-count" placeholder="1" required />
                            <span class="input-group-text">volume</span>
                        </div>
                        <div class="form-text ms-2 mb-0 volume-remaining-info">
                            Tersisa <span class="remaining-count"></span> dari <span class="total-count"></span> volume
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
    window.wpData = @json($workPackages->values());
    window.workOrders = @json($workOrders->values());

    $(document).ready(function() {
        initTabelWorkOrder();
        initTableSummary();
        initTableModalWO();
        console.log(window.wpData);

        // Filter event listener
        $('#applyFilter').on('click', function() {
            applyFilter();
        });

        $('#resetFilter').on('click', function() {
            resetFilter();
        });

        $('#kt_modal_detail_wo').on('hidden.bs.modal', function () {
            // Reset konten modal
            $('#work_package_no').text('WP');
            $('#work_package_name').text('WP');
            $('#modal_work_order tbody').html('');
            // Destroy DataTable agar tidak error saat modal dibuka lagi
            const $table = $('#modal_work_order');
            if ($.fn.DataTable.isDataTable($table)) {
                $table.DataTable().destroy();
            }
        });
    });

    function formatTanggal(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr);
        if (isNaN(d)) return '-';
        const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return `${d.getDate()} ${bulan[d.getMonth()]} ${d.getFullYear()}`;
    }

    function initTabelWorkOrder() {
        const table = $('#table_work_order').DataTable({
            scrollY: '350px',
            scrollX: true,
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
        setupWorkOrderSearch(table);
    }

    function initTableSummary() {
        const table = $('#table_summary_work_order').DataTable({
            scrollY: '325px',
            scrollX: true,
            resposive: true,
            paging: true,
            ordering: false, 
            rowGroup: {
                dataSrc: 0,
                startRender: function (rows, group) {
                    return $('<tr/>')
                        .append('<td colspan="' + rows.columns()[0].length + '" class="fw-bold bg-light-primary text-dark px-4 py-2">' + group + '</td>')
                        .addClass('wo-group-header');
                }
            },
            columnDefs: [
                { targets: 0, visible: false, searchable: true }
            ]
        });
    }

    function initTableModalWO(){
        $('#table_work_order').on('click', '.btn-success[data-wp-id]', function() {
            const wpId = $(this).data('wp-id');
            const wp = window.wpData.find(w => w.wp_id == wpId);

            $('#work_package_no').text(wp ? 'WP - ' + wp.wp_number : 'WP');
            $('#work_package_name').text(wp ? wp.name : 'WP');

            let rows = '';
            if (wp && wp.work_package_volumes) {
                // Urutkan volume berdasarkan wo_number ascending
                const sortedVolumes = [...wp.work_package_volumes]
                    .filter(vol => vol.wo_id && vol.work_order)
                    .sort((a, b) => a.work_order.wo_number - b.work_order.wo_number);

                sortedVolumes.forEach(function(vol) {
                    const groupKey = `WO ${vol.work_order.wo_number} (${vol.execution_year ?? '-'})`;
                    const period = `${formatTanggal(vol.start_date)} - ${formatTanggal(vol.end_date)}`;
                    rows += `
                        <tr class="text-center px-7" style="font-size:0.95rem;">
                            <td style="display:none;">${groupKey}</td>
                            <td class="align-middle text-center">${vol.volume_number ?? '-'}</td>
                            <td class="align-middle text-center">${period}</td>
                        </tr>
                    `;
                });
            }
            if(!rows) {
                rows = `<tr><td colspan="3" class="text-center text-muted small" style="font-size:0.85em;">Belum ada volume yang di-assign pada WO</td></tr>`;
            }

            // Isi tbody
            $('#modal_work_order tbody').html(rows);

            // Inisialisasi DataTables dengan rowGroup
            setTimeout(function() {
                const $table = $('#modal_work_order');
                if ($.fn.DataTable.isDataTable($table)) {
                    $table.DataTable().destroy();
                }
                $table.DataTable({
                    paging: false,
                    searching: false,
                    info: false,
                    ordering: false,
                    rowGroup: {
                        dataSrc: 0,
                        startRender: function(rows, group) {
                            return $('<tr/>')
                                .append('<td colspan="3" class="bg-light-primary text-dark px-4 py-2">' + group + '</td>')
                                .addClass('wo-group-header');
                        }
                    },
                    columnDefs: [
                        { targets: 0, visible: false, searchable: false }
                    ]
                });
            }, 100);

            // Tampilkan modal
            $('#kt_modal_detail_wo').modal('show');
        });
    }

    function setupWorkOrderSearch(table) {
        const searchInput = $('#searchWO');

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

    function applyFilter() {
        const categoryId = $('#kategoriFilter').val();
        const table = $('#table_work_order').DataTable();

        if (categoryId) {
            // Ambil nama kategori dari dropdown
            const selectedCategory = $('#kategoriFilter option:selected').text().trim();

            // Hapus prefix nomor kategori jika ada
            let categoryName = selectedCategory.replace(/^\d+\.\s*/, '');

            // Terapkan filter ke kolom kategori (kolom ke-0)
            table.column(0).search(categoryName, false, true).draw();
        } else {
            // Hapus filter jika tidak ada kategori yang dipilih
            table.column(0).search('').draw();
        }

        $('#filterCollapse').collapse('hide');
    }

    function resetFilter() {
        $('#kategoriFilter').val('');
        const table = $('#table_work_order').DataTable();
        table.columns().search('').draw();
        $('#filterCollapse').collapse('hide');
    }

    // ketika klik tombol assign work order
    function openAssignWO() {
        // reset form and variables
        resetAssignWOForm();
        // Set rekomendasi nomor WO
        $('#newWoNumber').val(getRecommendedWoNumber());
        // Show modal
        $('#kt_modal_assign_wo').modal('show');
    }

    function resetAssignWOForm() {
        const form = document.getElementById('assignWoForm');
        // Hapus semua card volume selection yang sudah ada
        form.querySelectorAll('.card.card-flush.shadow-sm.border-0.mb-5').forEach(card => card.remove());
        // Tambahkan satu card dari template
        addMoreVolumeSelection();
        updateAddBtnState();
    }

    // clone template card untuk menambah volume selection
    function addMoreVolumeSelection() {
        const template = document.getElementById('volumeSelectionTemplate');
        const container = document.getElementById('volumeSelectionContainer');
        
        if (!template) return;
        
        // Append ke container khusus
        const clone = template.content.cloneNode(true);
        container.appendChild(clone);
        
        // Event hapus card
        const cards = container.querySelectorAll('.card.card-flush.shadow-sm.border-0.mb-5');
        cards.forEach((card, idx) => {
            const title = card.querySelector('.title-template');
            const wpSelect = card.querySelector('.wpSelect');
            const volumeWarning = card.querySelector('.volume-warning');
            const volumeOptions = card.querySelector('.volume-options');
            const removeBtn = card.querySelector('.remove-wpvolume-btn');

            if (title) {
                title.textContent = `Assignment #${idx + 1}`;
            }
            // Event hapus card
            if (removeBtn) {
                removeBtn.onclick = function() {
                    const cards = container.querySelectorAll('.card.card-flush.shadow-sm.border-0.mb-5');
                    if (cards.length <= 1) {
                        Swal.fire({
                            text: "Minimal harus ada 1 volume work package!",
                            icon: "warning",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: { confirmButton: "btn btn-warning" }
                        });
                        return;
                    }
                    card.remove();
                    // Setelah hapus, update judul lagi
                    const updatedCards = container.querySelectorAll('.card.card-flush.shadow-sm.border-0.mb-5');
                    updatedCards.forEach((c, i) => {
                        const t = c.querySelector('.title-template');
                        if (t) t.textContent = `Assignment #${i + 1}`;
                    });
                    // Enable tombol jika card kurang dari wp available
                    const addBtn = document.getElementById('addWPVolumeBtn');
                    if (updatedCards.length < window.wpData.length) {
                        addBtn.disabled = false;
                    }
                    updateWorkPackageOptions();
                    updateAddBtnState();
                };
            }

            if (wpSelect && volumeWarning && volumeOptions) {
                if (!wpSelect.value) {
                    volumeWarning.style.display = 'block';
                    volumeOptions.style.display = 'none';
                } else {
                    volumeWarning.style.display = 'none';
                    volumeOptions.style.display = 'block';
                }

                wpSelect.addEventListener('change', function() {
                if (!this.value) {
                    volumeWarning.style.display = 'block';
                    volumeOptions.style.display = 'none';
                } else {
                    volumeWarning.style.display = 'none';
                    volumeOptions.style.display = 'block';
                    
                    // Get remaining and total volume from data attributes
                    const option = this.options[this.selectedIndex];
                    const remaining = parseInt(option.dataset.remaining || 0);
                    const total = parseInt(option.dataset.total || 0);
                    const assignedCount = total - remaining;
                    
                    // Update info displays
                    const volumeCountInput = card.querySelector('.volume-count');
                    const remainingCountSpan = card.querySelector('.remaining-count');
                    const totalCountSpan = card.querySelector('.total-count');
                    const assignedVolumeCountSpan = card.querySelector('.assigned-volume-count');
                    const assignedVolumePeriodSpan = card.querySelector('.assigned-volume-period');
                    
                    if (remainingCountSpan) remainingCountSpan.textContent = remaining;
                    if (totalCountSpan) totalCountSpan.textContent = total;
                    if (assignedVolumeCountSpan) {
                        if (assignedCount > 0) {
                            // Gather information about assigned volumes
                            const wpId = this.value;
                            const wp = window.wpData.find(w => w.wp_id == wpId);
                            
                            if (wp && wp.work_package_volumes) {
                                // Get volumes that have been assigned to WOs
                                const assignedVolumes = wp.work_package_volumes.filter(vol => vol.wo_id && vol.work_order);
                                
                                // Group volumes by work order
                                const volumesByWO = {};
                                assignedVolumes.forEach(vol => {
                                    const woNumber = vol.work_order.wo_number;
                                    if (!volumesByWO[woNumber]) {
                                        volumesByWO[woNumber] = {
                                            count: 0,
                                            startDate: null,
                                            endDate: null
                                        };
                                    }
                                    volumesByWO[woNumber].count++;
                                    
                                    // Get start and end date (use the same for all volumes in a WO)
                                    if (!volumesByWO[woNumber].startDate || new Date(vol.start_date) < new Date(volumesByWO[woNumber].startDate)) {
                                        volumesByWO[woNumber].startDate = vol.start_date;
                                    }
                                    if (!volumesByWO[woNumber].endDate || new Date(vol.end_date) > new Date(volumesByWO[woNumber].endDate)) {
                                        volumesByWO[woNumber].endDate = vol.end_date;
                                    }
                                });
                                
                                // Format dates and create the list
                                const formatDate = (dateStr) => {
                                    if (!dateStr) return '';
                                    const d = new Date(dateStr);
                                    if (isNaN(d)) return '';
                                    const day = d.getDate();
                                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                                    return `${day} ${months[d.getMonth()]} ${d.getFullYear()}`;
                                };
                                
                                // Create HTML for each WO group
                                const volumeList = Object.keys(volumesByWO).map(woNumber => {
                                    const info = volumesByWO[woNumber];
                                    return `- ${info.count} volume (WO ${woNumber}): ${formatDate(info.startDate)} - ${formatDate(info.endDate)}`;
                                }).join('<br>');
                                
                                assignedVolumeCountSpan.innerHTML = volumeList;
                            } else {
                                assignedVolumeCountSpan.textContent = 'Belum ada volume WP yang diassign ke WO.';
                            }
                        } else {
                            assignedVolumeCountSpan.textContent = 'Belum ada volume WP yang diassign ke WO.';
                        }
                    }
                    
                    // Set max value for volume input
                    if (volumeCountInput) {
                        volumeCountInput.max = remaining;
                        volumeCountInput.value = Math.min(1, remaining);
                    }
                }
                
                setTimeout(updateWorkPackageOptions, 0);
                updateAddBtnState();
            });
            }
        });
        updateWorkPackageOptions();
        updateAddBtnState();
    }

    function updateAddBtnState() {
        const addBtn = document.getElementById('addWPVolumeBtn');
        const cards = document.querySelectorAll('.card.card-flush.shadow-sm.border-0.mb-5');

        // Hitung WP yang masih punya volume belum di-assign WO
        // const availableWPIds = window.wpData
        //     .filter(wp =>
        //         wp.work_package_volumes &&
        //         wp.work_package_volumes.some(vol => !vol.wo_id)
        //     )
        //     .map(wp => wp.wp_id);
        const wpSelectOptions = document.querySelectorAll('.wpSelect option');
        const availableWPOptions = Array.from(wpSelectOptions).filter(option => {
            return option.value && parseInt(option.dataset.remaining || 0) > 0;
        });

        // Tombol aktif jika jumlah card < jumlah WP yang masih available
        addBtn.disabled = cards.length > availableWPOptions.length;
    }

    function updateWorkPackageOptions(){
        const selects = document.querySelectorAll('.wpSelect');
        // Ambil semua value WP yang sudah dipilih (selain yang kosong)
        const selectedValues = Array.from(selects)
            .map(sel => sel.value)
            .filter(val => val);

        selects.forEach(select => {
            Array.from(select.options).forEach(opt => {
                // Jangan disable jika value kosong (placeholder)
                if (!opt.value) {
                    opt.disabled = false;
                    return;
                }
                // Disable jika WP sudah dipilih di card lain
                if (selectedValues.includes(opt.value) && select.value !== opt.value) {
                    opt.disabled = true;
                } else {
                    opt.disabled = false;
                }
            });
        });
    }

    function getRecommendedWoNumber() {
        // Ambil semua wo_number dari window.wpData dan workOrders
        let usedNumbers = [];
        if (window.workOrders) {
            usedNumbers = window.workOrders.map(wo => parseInt(wo.wo_number, 10)).filter(n => !isNaN(n));
        }
        // Cari nilai terbesar, lalu +1
        let recommended = 1;
        if (usedNumbers.length > 0) {
            recommended = Math.max(...usedNumbers) + 1;
        }
        return recommended;
    }

    function addAssignWO() {
        const form = $('#assignWoForm');
        const startDate = $('#addVolumeStartDate').val();
        const endDate = $('#addVolumeEndDate').val();

        if (!startDate || !endDate) {
            Swal.fire({
                title: "Tanggal tidak valid",
                text: "Silakan isi tanggal mulai dan selesai.",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-secondary" }
            });
            return;
        }

        // Validasi tanggal selesai harus setelah tanggal mulai
        if (new Date(startDate) > new Date(endDate)) {
            Swal.fire({
                title: "Tanggal tidak valid",
                text: "Tanggal selesai harus setelah tanggal mulai.",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-secondary" }
            });
            return;
        }

        // Validasi Work Package dan jumlah volume
        let assignments = [];
        let valid = true;
        
        $('#volumeSelectionContainer .card').each(function(idx) {
            const wpSelect = $(this).find('.wpSelect');
            const wpId = wpSelect.val();
            const volumeInput = $(this).find('input[name="volume_count"]');
            const volumeCount = parseInt(volumeInput.val());
            
            if (!wpId) {
                valid = false;
                Swal.fire({
                    title: "Work Package belum dipilih",
                    text: `Silakan pilih Work Package pada card Assignment #${idx + 1}`,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
                return false; // break each
            }
            
            if (!volumeCount || volumeCount < 1) {
                valid = false;
                Swal.fire({
                    title: "Jumlah volume tidak valid",
                    text: `Silakan isi jumlah volume dengan angka lebih dari 0 pada card Assignment #${idx + 1}`,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
                return false; // break each
            }
            
            // Ambil remaining dari option yang dipilih
            const selectedOption = wpSelect.find('option:selected');
            const remaining = parseInt(selectedOption.data('remaining') || 0);
            
            if (volumeCount > remaining) {
                valid = false;
                Swal.fire({
                    title: "Jumlah volume melebihi yang tersedia",
                    text: `Jumlah volume maksimal yang tersedia pada WP ${selectedOption.text().split(' ')[0]} adalah ${remaining}`,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
                return false; // break each
            }
            
            assignments.push({
                wp_id: wpId,
                volume_count: volumeCount
            });
        });
        
        if (!valid) return;

        // Jika create new WO, ambil nomor WO baru
        const newWoNumber = $('#newWoNumber').val();
        if (!newWoNumber || parseInt(newWoNumber) < 1) {
            Swal.fire({
                title: "Nomor WO tidak valid",
                text: "Isi nomor WO baru dengan nomor yang valid (minimal bernilai 1).",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: { confirmButton: "btn btn-secondary" }
            });
            return;
        }

        // Buat WO baru
        $.ajax({
            url: "{{ route('work-order.add') }}",
            method: 'POST',
            data: {
                _token: form.find('[name="_token"]').val(),
                wo_number: newWoNumber
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                form.find('input, button, select').prop('disabled', true);
                Swal.fire({
                    title: 'Membuat Work Order...',
                    text: 'Sedang membuat WO baru',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading() }
                });
            },
            success: function (response) {
                if (response.success && response.data && response.data.wo_id) {
                    // Assign volume ke WO baru
                    assignVolumesToWO(response.data.wo_id, assignments, form);
                } else {
                    Swal.fire({
                        title: "Gagal Membuat WO",
                        text: response.message || "Gagal membuat WO baru",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    });
                    form.find('input, button, select').prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMessage = "Terjadi kesalahan saat membuat WO baru";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    title: "Gagal Membuat WO",
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
                form.find('input, button, select').prop('disabled', false);
            }
        });
    }

    function assignVolumesToWO(wo_id, assignments, form) {
        $.ajax({
            url: "{{ route('work-order.assign') }}",
            method: 'PUT',
            data: {
                _token: form.find('[name="_token"]').val(),
                wo_id: wo_id,
                assignments: assignments, //isinya array {wp_id, volume_count}
                start_date: $('#addVolumeStartDate').val(),
                end_date: $('#addVolumeEndDate').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                Swal.fire({
                    title: 'Assign WP ke WO...',
                    text: 'Sedang memproses assignment WO pada volume',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading() }
                });
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: "Berhasil Assign WP ke WO",
                        text: response.message || "Work Package berhasil diassign ke Work Order",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    }).then(() => {
                        $('#kt_modal_assign_wo').modal('hide');
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Gagal",
                        text: response.message || "Gagal assign WO pada volume",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    });
                }
            },
            error: function (xhr) {
                let errorMessage = "Terjadi kesalahan saat assign";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    title: "Gagal Assign WP ke WO",
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                });
            },
            complete: function () {
                form.find('input, button, select').prop('disabled', false);
            }
        });
    }
</script>
@endpush

<style>
    /* Tambahkan di <style> atau file CSS Anda */
    .wo-group-header td {
        font-size: 0.95rem !important;
        font-weight: 400 !important;
    }
</style>