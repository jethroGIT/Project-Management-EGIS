@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-10 mt-2 mb-3">Work Order</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Filter Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                        </svg>
                        Filter Data
                    </button>
                </div>

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
                                Filter Data berdasarkan Kategori
                            </div>
                        </h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Kategori WP</label>
                                <select class="form-select form-select-solid" id="kategoriFilter">
                                    <option value="">Pilih Kategori WP</option>
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

            <!-- Table -->
            {{-- No WP, no WO, nama WP, volume by contract, volume realisasi, volume remaining, action lihat detail --}}
            <div class="table-responsive mb-2">
                <table id="table_work_order" class="table table-hover gy-4 gs-3 border rounded w-100">
                    <thead>
                        <tr class="text-center fw-bolder fs-6 text-gray-800 px-7">
                            <th scope="col" style="display: none;">WP Group Key</th> {{-- untuk grouping WP category --}}
                            <th scope="col" rowspan="2" class="align-middle border-bottom" style="min-width:50px">No. WP</th>
                            <th scope="col" rowspan="2" class="align-middle border-bottom">Work Package</th>
                            <th scope="col" colspan="2" class="align-middle border-bottom"  style="min-width:100px">No. WO</th>
                            <th scope="col" colspan="3" class="align-middle border-bottom">Volume (Qty)</th>
                            <th scope="col" rowspan="2" class="align-middle border-bottom" style="min-width: 70px">Action</th>
                        </tr>
                        <tr class="text-center fw-bolder fs-6 text-gray-800 px-7">
                            <th scope="col" style="display: none;"></th> {{-- untuk grouping WP category --}}
                            <th class="align-middle border-bottom" style="min-width: 50px">2024</th>
                            <th class="align-middle border-bottom" style="min-width: 50px">2025</th>
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
                                <td class="align-middle text-center">
                                    @php
                                        $wo2024 = $wp->workPackageVolumes->firstWhere('execution_year', 2024);
                                    @endphp
                                    @if($wo2024 && $wo2024->workOrder)
                                        WO {{ $wo2024->workOrder->wo_number ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @php
                                        $wo2025 = $wp->workPackageVolumes->firstWhere('execution_year', 2025);
                                    @endphp
                                    @if($wo2025 && $wo2025->workOrder)
                                        WO {{ $wo2025->workOrder->wo_number ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
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
                            <th scope="col" class="align-middle border-bottom">Tahun</th>
                            <th scope="col" class="align-middle border-bottom">No. WO</th>
                            <th scope="col" class="align-middle border-bottom">Realisasi (Qty)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 0.92rem;">
                            <td class="align-middle text-center">2024</td>
                            <td class="align-middle text-center">WO-001</td>
                            <td class="align-middle text-center">10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.wpData = @json($workPackages);
    $(document).ready(function() {
        initTabelWorkOrder();

        // Filter event listener
        $('#applyFilter').on('click', function() {
            applyFilter();
        });

        $('#resetFilter').on('click', function() {
            resetFilter();
        });

        $('#table_work_order').on('click', '.btn-success[data-wp-id]', function() {
            const wpId = $(this).data('wp-id');
            const wp = window.wpData.find(w => w.wp_id == wpId);

            $('#work_package_no').text(wp ? 'WP - ' + wp.wp_number : 'WP');
            $('#work_package_name').text(wp ? wp.name : 'WP');

            let rows = '';
            if (wp && wp.work_package_volumes) {
                // Group by wo_id
                const woGroups = {};
                wp.work_package_volumes.forEach(function(vol) {
                    if (vol.wo_id && vol.work_order) {
                        if (!woGroups[vol.wo_id]) {
                            woGroups[vol.wo_id] = {
                                execution_year: vol.execution_year,
                                wo_number: vol.work_order.wo_number,
                                totalWithWO: 0,
                                realization_qty: 0
                            };
                        }
                        woGroups[vol.wo_id].totalWithWO += (vol.volume_qty ?? 0);
                        woGroups[vol.wo_id].realization_qty += 1; // Jumlahkan baris volume, bukan sum kolom
                    }
                });

                Object.values(woGroups).forEach(function(group) {
                    rows += `
                        <tr style="font-size: 0.92rem;">
                            <td class="align-middle text-center">${group.execution_year ?? '-'}</td>
                            <td class="align-middle text-center">WO ${group.wo_number ?? '-'}</td>
                            <td class="align-middle text-center">${group.realization_qty}</td>
                        </tr>
                    `;
                });
            }
            if(!rows) {
                rows = `<tr><td colspan="4" class="text-center text-muted">Tidak ada data WO</td></tr>`;
            }

            $('#kt_modal_detail_wo tbody').html(rows);
        });
    });

    function initTabelWorkOrder() {
        const table = $('#table_work_order').DataTable({
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
        });
        setupWorkOrderSearch(table);
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
</script>
@endpush
