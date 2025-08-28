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
                                Filter Data berdasarkan Tahun
                            </div>
                        </h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Tahun</label>
                                <select class="form-select form-select-solid" id="kategoriFilter">
                                    <option value="">Pilih Tahun</option>
                                    {{-- @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}">
                                                @if(isset($category->category_number))
                                                    {{ $category->category_number }}.
                                                @endif
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif --}}
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
                            <th scope="col" style="display: none;">WP Group Key</th> {{-- untuk grouping --}}
                            <th scope="col" rowspan="2" class="align-middle border-bottom" style="min-width:15px"></th>
                            <th scope="col" rowspan="2" class="align-middle border-bottom" style="min-width:50px">No. WP</th>
                            <th scope="col" rowspan="2" class="align-middle border-bottom">Work Package</th>
                            <th scope="col" rowspan="2" class="align-middle border-bottom"  style="min-width:90px">No. WO</th>
                            <th scope="col" colspan="3" class="align-middle border-bottom">Volume (Qty)</th>
                            <th scope="col" rowspan="2" class="align-middle border-bottom" style="min-width: 70px">Action</th>
                        </tr>
                        <tr class="text-center fw-bolder fs-6 text-gray-800 px-7">
                            <th scope="col" style="display: none;"></th> {{-- untuk grouping --}}
                            <th class="align-middle border-bottom" style="min-width: 100px">By Contract</th>
                            <th class="align-middle border-bottom" style="min-width: 70px">Realisasi</th>
                            <th class="align-middle border-bottom" style="min-width: 50px">Sisa</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @forelse($workPackages as $wp)
                            @php
                                $totalWithWO = $wp->workPackageVolumes->whereNotNull('wo_id')->count();
                                $remaining = $wp->volume_qty - $totalWithWO;
                            @endphp
                            <tr class="parent-row" data-group="{{ $wp->wpCategory->name ?? 'wpcat' }}">
                                <td style="display: none;">{{ $wp->wpCategory->name ?? 'wpcat' }}</td> {{-- untuk grouping --}}
                                <td style="cursor:pointer;">
                                    <a class="toggle-collapse" data-bs-toggle="collapse" href="#detail-{{$wp->wp_id}}" aria-expanded="false" aria-controls="detail-{{$wp->wp_id}}">
                                        <i class="bi bi-plus fs-2 me-2 text-dark" id="icon-task{{$wp->wp_id}}"></i>
                                    </a>
                                </td>
                                <td class="align-middle text-center">{{$wp->wp_number}}</td>
                                <td class="align-middle">{{$wp->name}}</td>
                                <td class="align-middle text-center"></td>
                                <td class="text-center align-middle">{{$wp->volume_qty}}</td>
                                <td class="text-center align-middle">{{$totalWithWO}}</td>
                                <td class="text-center align-middle">{{$remaining}}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat Detail">
                                        <i class="bi bi-eye fs-2 text-center"></i>
                                    </button>
                                </td>
                            </tr>
                            @if($wp->workPackageVolumes->count() > 0)
                                @php
                                    $grouped = $wp->workPackageVolumes->groupBy('wo_id');
                                @endphp
                                @foreach($wp->workPackageVolumes as $volume)
                                    <tr class="collapse child-row text-center" id="detail-{{$wp->wp_id}}">
                                        <td style="display: none"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="ps-5">
                                            {{ $volume->execution_year ?? '-' }} - WO {{ $volume->workOrder->wo_number ?? '-' }}
                                        </td>
                                        <td></td>
                                        <td>
                                            {{ $grouped[$volume->wo_id]->count() }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endif
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

@push('scripts')
<script>
    $(document).ready(function() {
        initTabelWorkOrder();

        @if(isset($workPackages) && $workPackages->count() > 0)
            @foreach($workPackages as $wp)
                $('#detail-{{ $wp->wp_id }}').on('show.bs.collapse', function () {
                    $('#icon-task{{ $wp->wp_id }}').removeClass('bi-plus text-dark').addClass('bi-dash text-primary');
                });
                $('#detail-{{ $wp->wp_id }}').on('hide.bs.collapse', function () {
                    $('#icon-task{{ $wp->wp_id }}').removeClass('bi-dash text-primary').addClass('bi-plus text-dark');
                });
            @endforeach
        @endif
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
                    // Jangan filter terlalu ketat - hapus kondisi wpcat
                    if (!group || group.trim() === '') {
                        return null;
                    }
                    
                    return $('<tr/>')
                        .append('<td colspan="9" class="fw-bold bg-light-primary text-dark px-4 py-3">' + group + '</td>')
                        .addClass('wp-group-header');
                }
            }, // <- TAMBAHKAN COMMA INI
            drawCallback: function(settings) {
                // Hide child-row dari DataTables styling
                $('.child-row').removeClass('odd even');
                
                // Remove unwanted group headers
                $('.dtrg-group').each(function() {
                    var groupText = $(this).find('td').text().trim();
                    if (!groupText || groupText === 'No group' || groupText === '' || groupText === 'wpcat') {
                        $(this).remove();
                    }
                });
            },
            columnDefs: [
                { targets: 0, visible: false, searchable: false }
            ]
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
</script>
@endpush
