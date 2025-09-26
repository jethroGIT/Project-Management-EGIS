@extends('layouts.app')

@section('content')
<div class="">
    <!-- <div class="card">
        <div class="card-header d-flex">
            <h1 class="my-10 justify-content-center">Proyek EGIS</h1>
        </div>
        <div class="card-body">
            <p>Diagram Funnel untuk melihat keuangan</p>
            <p>Summary WP melihat finance performance dan wp performance</p>
            <p>Role/pekerja yang memiliki jumlah mandays kritikal (sama dengan atau lebih dari mandays plan)</p>
            <p>Bar chart beban mandays role/pekerja untuk WP</p>
        </div>
        <div class="card-footer">

        </div>
    </div> -->

    <h1 class="mt-0 mb-5">Dashboard</h1>

    <div class="row mb-6">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body my-2">
                    <div class="d-flex align-items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-file-text-fill text-info" viewBox="0 0 16 16">
                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1"/>
                        </svg>
                        <div>
                            <h3 class="card-title fw-bold m-0">Total Work Order</h3>
                            <div class="fs-6 text-muted">Jumlah WO saat ini</div>
                            <div class="fs-2hx fw-bold text-info">{{ $totalWorkOrders }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body my-2">
                    <div class="d-flex align-items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-file-earmark-check-fill text-success" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                        </svg>
                        <div>
                            <h3 class="card-title fw-bold m-0">Work Package Selesai</h3>
                            <div class="fs-6 text-muted">Progres pengerjaan WP</div>
                            <div class="d-flex align-items-end">
                                <div class="d-flex align-items-baseline">
                                    <span class="fs-2hx fw-bold text-success me-2">{{ $workPackageCompletionData['completed'] }}</span>
                                    <span class="fs-4 text-muted fw-semibold">/</span>
                                    <span class="fs-3 text-muted fw-semibold ms-1">{{ $workPackageCompletionData['total'] }}</span>
                                    <span class="ms-2 badge badge-light-success fs-7 fw-bold">{{ $workPackageCompletionData['completion_percentage'] }}% completed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-6">
        <div class="card-body">
            <div class="row">
                <div class="col-md-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-warning" viewBox="0 0 640 640">
                        <path d="M192 160L192 144C192 99.8 278 64 384 64C490 64 576 99.8 576 144L576 160C576 190.6 534.7 217.2 474 230.7C471.6 227.9 469.1 225.2 466.6 222.7C451.1 207.4 431.1 195.8 410.2 187.2C368.3 169.7 313.7 160.1 256 160.1C234.1 160.1 212.7 161.5 192.2 164.2C192 162.9 192 161.5 192 160.1zM496 417L496 370.8C511.1 366.9 525.3 362.3 538.2 356.9C551.4 351.4 564.3 344.7 576 336.6L576 352C576 378.8 544.5 402.5 496 417zM496 321L496 288C496 283.5 495.6 279.2 495 275C510.5 271.1 525 266.4 538.2 260.8C551.4 255.2 564.3 248.6 576 240.5L576 255.9C576 282.7 544.5 306.4 496 320.9zM64 304L64 288C64 243.8 150 208 256 208C362 208 448 243.8 448 288L448 304C448 348.2 362 384 256 384C150 384 64 348.2 64 304zM448 400C448 444.2 362 480 256 480C150 480 64 444.2 64 400L64 384.6C75.6 392.7 88.5 399.3 101.8 404.9C143.7 422.4 198.3 432 256 432C313.7 432 368.3 422.3 410.2 404.9C423.4 399.4 436.3 392.7 448 384.6L448 400zM448 480.6L448 496C448 540.2 362 576 256 576C150 576 64 540.2 64 496L64 480.6C75.6 488.7 88.5 495.3 101.8 500.9C143.7 518.4 198.3 528 256 528C313.7 528 368.3 518.3 410.2 500.9C423.4 495.4 436.3 488.7 448 480.6z"/>
                    </svg>
                </div>
                <div class="col-md-11">
                    <h3 class="card-title fw-bold m-0">Perbandingan Nilai Uang</h3>
                    <!-- Progress Bar -->
                    <div class="progress progress-sm mt-3">
                        <div class="progress-bar bg-success progress-bar-animated" 
                                role="progressbar" style="width: 10%" 
                                aria-valuenow="47" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="text-muted fs-8 mt-2">Rp10.000.000 / Rp100.000.000</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-6">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header py-0">
                    <h3 class="card-title fw-bold m-0">Perbandingan WP yang dipanggil oleh WO</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="fs-6 text-muted">Total Work Package</div>
                        <div class="fs-1 fw-bold text-primary">{{ $pieChartDataWo['total'] ?? 0 }}</div>
                    </div>
                    <canvas id="wo_pie_chart" class="mh-400px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header py-0">
                    <h3 class="card-title fw-bold m-0">Persentase Progres Work Package</h3>
                </div>
                <div class="card-body">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                                </svg>
                            </span>
                            <select class="form-select" id="tahunFilter">
                                <option value="">Pilih Tahun</option>
                                @if(isset($availableYears) && !empty($availableYears))
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="position-relative">
                        <canvas id="wp_progres_bar_chart" class="mh-400px"></canvas>

                        <!-- Loading Overlay -->
                        <div id="chartLoadingOverlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-light bg-opacity-75 d-none">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Memuat data tahun...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-6">
        <div class="card-header py-0">
            <h3 class="card-title fw-bold m-0">Project Berjalan</h3>
            <div class="card-toolbar">
                <span class="badge badge-light-info badge-lg">
                    {{ $projectBerjalanData->count() }} Project
                </span>
            </div>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <div>
                <form class="d-flex justify-content-end mb-4">
                    <label class="me-5 mt-3" for="searchWOandWP">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search" 
                        id="searchWOandWP"
                        placeholder="Cari Data" 
                        aria-label="Search"
                    >                    
                </form>
            </div>

            <div class="table-responsive">
                <table id="wp_progres_table" class="table border table-row-dashed border-gray-300 table-row-gray-300 gy-5 gs-7 rounded w-100">
                    <thead class="align-middle text-center">
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th>Nomor Work Order</th>
                            <th class="align-middle border-bottom">No</th>
                            <th class="align-middle border-bottom min-w-200px">Work Package</th>
                            <th class="align-middle border-bottom">Volume (Qty)</th>
                            <th class="align-middle border-bottom min-w-100px">WP Progres</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($projectBerjalanData->count() > 0)
                            @foreach($projectBerjalanData as $index => $project)
                                <tr class="task-row">
                                    <td>WO {{ $project['wo_number'] }}</td>
                                    <td>{{ $index + 1 }}.</td>
                                    <td>
                                        <span>WP {{ $project['wp_number'] }}</span>
                                        <span>{{ $project['wp_name'] }}</span>
                                    </td>
                                    <td class="text-center">{{ $project['volume_qty'] }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            <span class="fw-bold badge badge-lg
                                                @if($project['completion'] >= 80) badge-light-success
                                                @elseif($project['completion'] >= 60) badge-light-primary
                                                @elseif($project['completion'] >= 40) badge-light-warning
                                                @else badge-light-danger
                                                @endif
                                            ">
                                                {{ number_format($project['completion'], 1) }}%
                                            </span>
                                            <div class="progress progress-sm w-100" style="height: 6px;">
                                                <div class="progress-bar
                                                    @if($project['completion'] >= 80) bg-success
                                                    @elseif($project['completion'] >= 60) bg-primary
                                                    @elseif($project['completion'] >= 40) bg-warning
                                                    @else bg-danger
                                                    @endif
                                                "
                                                    role="progressbar"
                                                    style="width: {{ $project['completion'] }}%"
                                                    aria-valuenow="{{ $project['completion'] }}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                                ></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-6">
        <!--begin::Card header-->
        <div class="card-header position-relative py-0 border-bottom border-bottom-1">
            <h2 class="card-title fw-bold">Periode Project</h2>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pb-0">
            <div class="mb-5" style="max-width: 200px;">
                <form method="GET" id="filterYearForm">
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                            </svg>
                        </span>
                        <select name="execution_year"
                                id="execution_year"
                                class="form-select"
                                {{-- onchange="document.getElementById('filterYearForm').submit()" --}}
                        >
                            <option value="" disabled>Pilih Tahun</option>
                            {{-- @foreach ($executionYear as $year) --}}
                                <option value="2025">2025
                                    {{-- {{ (request('execution_year', $selectedYear) == $year) ? 'selected' : '' }}> --}}
                                    {{-- {{ $year }} --}}
                                </option>
                            {{-- @endforeach --}}
                        </select>
                    </div>
                </form>
            </div>
            {{-- <div id="diagram-wpv"> --}}
                <div class="table-responsive pb-10" style="overflow-x: auto; max-height: 350px;">
                    @php
                        $bulanIndonesia = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        $lebarBulan = 160; // px per bulan
                        $tinggiDiagram = 340; // px tinggi diagram
                    @endphp
                    <div style="display: flex;">
                        <!-- Sumbu Y (Label) sticky di kiri, mulai dari atas -->
                        <div style="
                            position: sticky;
                            left: 0;
                            top: 0;
                            background: #fff;
                            width: 110px;
                            min-width: 110px;
                            max-width: 110px;
                            z-index: 3;
                            flex-shrink: 0;
                            box-shadow: 2px 0 4px -2px #eee;
                        ">
                            <!-- Header bulan, kosong agar sejajar dan tetap sticky -->
                            <div style="height: 40px;"></div>
                            {{-- @foreach($wpvWithPeriod as $wpv) --}}
                                <div class="d-flex align-items-center" style="height:60px;">
                                    {{-- <span class="text-dark fw-bold fs-4 me-2">WP {{ $wpv->workPackage->wp_number }}</span> --}}
                                    <span class="text-dark fw-bold fs-4 me-2">WP XX</span>
                                </div>
                            {{-- @endforeach --}}
                        </div>
                        <!-- Kolom diagram (bulan & item) -->
                        <div style="position: relative; min-width: {{ count($bulanIndonesia) * $lebarBulan }}px; height: {{ $tinggiDiagram }}px; flex: 1;">
                            <!-- Sumbu X (Bulan Indonesia) sticky di atas -->
                            <div style="position: sticky; top: 0; z-index: 1; background: #fff;">
                                <div style="display: flex;">
                                    @foreach($bulanIndonesia as $bulan)
                                        <div style="width: {{ $lebarBulan }}px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <span class="fw-bold text-gray-700" style="width:100%; text-align:center;">{{ $bulan }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Diagram WPV -->
                            <div style="position: relative;">
                                @php
                                    $colorList = [
                                        ['bg' => 'bg-light-primary', 'text' => 'text-primary'],
                                        ['bg' => 'bg-light-success', 'text' => 'text-success'],
                                        ['bg' => 'bg-light-info',    'text' => 'text-info'],
                                        ['bg' => 'bg-light-danger',  'text' => 'text-danger'],
                                    ];
                                    $colorCount = count($colorList);
                                @endphp
                                {{-- @foreach($wpvWithPeriod as $wpv) --}}
                                    {{-- @php
                                        \Carbon\Carbon::setLocale('id');
                                        $startMonth = \Carbon\Carbon::parse($wpv->start_date)->month;
                                        $endMonth = \Carbon\Carbon::parse($wpv->end_date)->month;
                                        $topPosition = ($loop->index * 60);
                                        $leftPosition = ($startMonth - 1) * $lebarBulan;
                                        $width = ($endMonth - $startMonth + 1) * $lebarBulan;
                                        $color = $colorList[$loop->index % $colorCount];
                                    @endphp --}}
                                    {{-- <div class="d-flex align-items-center"
                                        style="position: absolute; top: {{ $topPosition }}px; left: {{ $leftPosition }}px; height:60px; z-index:2;">
                                        <div class="{{ $color['bg'] }} rounded-pill d-flex align-items-center px-2" style="width: {{ $width }}px;">
                                            <span class="fw-bold {{ $color['text'] }} ms-3">
                                                {{ \Carbon\Carbon::parse($wpv->start_date)->translatedFormat('d F') }} - {{ \Carbon\Carbon::parse($wpv->end_date)->translatedFormat('d F') }}
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="d-flex align-items-center"
                                        style="position: absolute; height:60px; z-index:2;">
                                        <div class="rounded-pill d-flex align-items-center px-2">
                                            <span class="fw-bold ms-3">
                                                01 Januari - 31 Desember
                                            </span>
                                        </div>
                                    </div>
                                {{-- @endforeach --}}
                            </div>
                            <!-- Garis vertikal pembatas bulan -->
                            @for($i = 0; $i <= count($bulanIndonesia); $i++)
                                <div style="
                                    position: absolute;
                                    left: {{ $i * $lebarBulan }}px;
                                    top: 0;
                                    height: {{ $tinggiDiagram }}px;
                                    width: 0;
                                    z-index: 1;
                                ">
                                    <div style="border-right:1px solid #eee; height: 100%;"></div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
        </div>
        <!--end::Card body-->
    </div>

    <div class="card shadow-sm mb-6">
        <div class="card-header py-0">
            <h3 class="card-title fw-bold m-0">Jumlah Work Package dari Setiap SDM</h3>
            <div class="card-toolbar">
                <span class="badge badge-light-info badge-lg">
                    SDM Total: {{ $barChartWpSDMData['total_users'] ?? 0 }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <canvas id="wp_sdm_bar_chart" class="mh-400px"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initTabelWPProgres();

    $('#tahunFilter').on('change', function() {
        const selectedYear = this.value;

        if (selectedYear) {
            // Show loading state
            showChartLoading();

            // Redirect dengan parameter year
            // const currentUrl = new URL(window.location.href);
            // currentUrl.searchParams.set('year', selectedYear);
            // window.location.href = currentUrl.toString();
            
            // AJAX call to get new data
            $.ajax({
                url: '{{ route("dashboard.wp-progress-data") }}',
                type: 'GET',
                data: {
                    year: selectedYear
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        // Update chart data
                        wpProgressBarChartData = response.data;
                        initWpProgressChart(response.data);
                        
                        // Update badges and info
                        // updateFilterInfo(response.data, response.year);
                        
                        // Hide loading
                        hideChartLoading();
                        
                        // Optional: Show success message
                        // Toastr.success(`Data berhasil dimuat untuk tahun ${response.year}`, 'Berhasil');
                    } else {
                        hideChartLoading();
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memuat Data',
                            text: response.message || 'Terjadi kesalahan saat memuat data',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    hideChartLoading();
                    console.error('AJAX Error:', error);
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal memuat data. Silakan coba lagi.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        } else {
            // Remove year parameter dan redirect ke default (current year)
            // const currentUrl = new URL(window.location.href);
            // currentUrl.searchParams.delete('year');
            // window.location.href = currentUrl.toString();

            // Reset default
            location.reload();
        }
    });
});

/**
 * Generate Color
 */
function generateHSLColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        const hue = Math.round((360 / count) * i); // bagi rata hue
        colors.push(`hsl(${hue}, 70%, 50%)`); // saturasi 70%, lightness 50%
    }
    return colors;
}

/**
 * Perbandingan WP yang dipanggil oleh WO
 * Pie Chart
 * 
 */
const pieChartDataWo = @json($pieChartDataWo ?? ['labels' => ['No Data'], 'data' => [1], 'total' => 0]);

var ctxWoPie = document.getElementById('wo_pie_chart');

// Define colors
var primaryColor = KTUtil.getCssVariableValue('--kt-primary') || '#009EF7';
var dangerColor = KTUtil.getCssVariableValue('--kt-danger') || '#F1416C';
var successColor = KTUtil.getCssVariableValue('--kt-success') || '#50CD89';
var warningColor = KTUtil.getCssVariableValue('--kt-warning') || '#FFC700';
var infoColor = KTUtil.getCssVariableValue('--kt-info') || '#7239EA';

// Define fonts
var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

// Chart data
const dataWoPie = {
    labels: pieChartDataWo.labels,
    datasets: [{
        label: 'Work Package',
        data: pieChartDataWo.data,
        backgroundColor: [
            primaryColor,
            warningColor
        ],
        borderWidth: 2,
        hoverOffset: 4
    }]
};

// Chart config
const configWoPie = {
    type: 'pie',
    data: dataWoPie,
    options: {
        plugins: {
            title: {
                display: false
            },
            legend: {
                display: true,
                position: 'bottom'
            }
        },
        animation: {
            animateRotate: true,
            animateScale: true,
            duration: 1000
        },
        responsive: true
    },
    defaults:{
        global: {
            defaultFont: fontFamily
        }
    }
};

var myWoPieChart = new Chart(ctxWoPie, configWoPie);


/**
 * Persentase Progres Work Package
 * Horizontal Bar Chart
 * 
 */
let wpProgressBarChartData = @json($wpProgressBarChartData ?? ['labels' => ['No Data'], 'data' => [0], 'chart_details' => []]);
let myWpBarChart;

var ctxBarWpProgres = document.getElementById('wp_progres_bar_chart');

// Initialize chart
function initWpProgressChart(charData) {

    const dataBarWpProgres = {
        labels: wpProgressBarChartData.labels,
        datasets: [{
            label: 'Completion Percentage (%)',
            data: wpProgressBarChartData.data,
            backgroundColor: generateHSLColors(wpProgressBarChartData.labels.length),
            borderColor: generateHSLColors(wpProgressBarChartData.labels.length).map(color => 
                color.replace('50%', '40%') // Darker border
            ),
            borderWidth: 1
        }]
    };
    
    const configBarWpProgres = {
        type: 'bar',
        data: dataBarWpProgres,
        options: {
            indexAxis: 'y',
            plugins: {
                title: {
                    display: false
                },
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            const label = context.label;
                            const value = context.parsed.x;
                            const details = wpProgressBarChartData.chart_details[label];
                            
                            if (!details) {
                                return `Completion: ${value}%`;
                            }
    
                            // Format tooltip dengan informasi volume/quantity
                            let tooltipText = `Completion: ${value}%`;
                            
                            if (details.volume_count > 1) {
                                tooltipText += ` (${details.volume_count} volumes)`;
                            } else {
                                tooltipText += ` (1 volume)`;
                            }
    
                            return tooltipText;
                        }
                        // afterLabel: function(context) {
                        //     const label = context.label;
                        //     const details = wpProgressBarChartData.chart_details[label];
                            
                        //     if (!details) return [];
    
                        //     let afterLabels = [];
                            
                        //     // Work Package name
                        //     afterLabels.push(`WP Name: ${details.wp_name}`);
                            
                        //     // ✅ TAMBAHAN: Volume details
                        //     if (details.volume_count > 1) {
                        //         afterLabels.push(`Volume Numbers: ${details.volume_numbers.join(', ')}`);
                        //     } else {
                        //         afterLabels.push(`Volume Number: ${details.volume_numbers[0] || 'N/A'}`);
                        //     }
                            
                        //     // Execution year
                        //     if (details.execution_year) {
                        //         afterLabels.push(`Year: ${details.execution_year}`);
                        //     }
                            
                        //     // Period information
                        //     if (details.start_date && details.end_date) {
                        //         const startDate = new Date(details.start_date).toLocaleDateString('id-ID');
                        //         const endDate = new Date(details.end_date).toLocaleDateString('id-ID');
                        //         afterLabels.push(`Period: ${startDate} - ${endDate}`);
                        //     }
    
                        //     return afterLabels;
                        // }
                    }
                }
            },
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    title: {
                        display: true,
                        text: 'Completion Percentage (%)',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Work Package',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    },
                    ticks: {
                        font: {
                            size: 10 // Slightly smaller for better readability
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutCubic'
            }
        }
    };

    // Destroy existing chart if exists
    if (myWpBarChart) {
        myWpBarChart.destroy();
    }
    
    myWpBarChart = new Chart(ctxBarWpProgres, configBarWpProgres);
}
// Initialize chart with default data
initWpProgressChart(wpProgressBarChartData);

/**
 * Show loading state for chart
 */
function showChartLoading() {
     $('#chartLoadingOverlay').removeClass('d-none').addClass('d-flex');
    $('#tahunFilter').prop('disabled', true);
}

/**
 * Hide loading state
 */
function hideChartLoading() {
    $('#chartLoadingOverlay').removeClass('d-flex').addClass('d-none');
    $('#tahunFilter').prop('disabled', false);
}

/**
 * Initialize table WP Progress
 */
function initTabelWPProgres() {
    const table = $('#wp_progres_table').DataTable({
        'scrollY': '300px',
        "scrollX": true,
        "paging": true,
        "searching": true,
        "language": {
            "emptyTable": "Tidak ada data work package yang sedang berjalan",
            "search": "Cari Project:",
            "searchPlaceholder": "Cari berdasarkan WO atau WP"
        },
        rowGroup: {
            dataSrc: 0,
            startRender: function (rows, group) {
                return $('<tr/>')
                    .append('<td colspan="5" class="fw-bold bg-light-primary text-dark px-4 py-3">' + group + '</td>');
            }
        },
        columnDefs: [
            {
                targets: 0,
                visible: false, // Kolom kategori disembunyikan karena sudah ditampilkan sebagai grup
                searchable: true
            },
            {
                targets: 4, // Kolom progress
                orderable: true,
                type: 'num' // Enable numeric sorting for progress
            }
        ],
        order: [[4, 'asc']]
    });

    // Setup search
    setupWOandWPSearch(table);
}

/**
 * Function untuk search pada tabel
 */
function setupWOandWPSearch(table) {
    const searchInput = $('#searchWOandWP');

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
 * Jumlah Work Package dari Setiap SDM
 * Bar Chart
 * 
 */
const barChartWpSDMData = @json($barChartWpSDMData ?? ['labels' => ['No Data'], 'data' => [0]]);

var ctxBarWpSDM = document.getElementById('wp_sdm_bar_chart');

const dataBarWpSDM = {
  labels: barChartWpSDMData.labels,
  datasets: [{
    axis: 'y',
    label: 'Jumlah Work Package',
    data: barChartWpSDMData.data,
    fill: false,
    backgroundColor: generateHSLColors(barChartWpSDMData.labels.length),
    borderColor: generateHSLColors(barChartWpSDMData.labels.length).map(color => 
        color.replace('0.8', '1')
    ),
    borderWidth: 1
  }]
};

const configBarWpSDM = {
    type: 'bar',
    data: dataBarWpSDM,
    options: {
        plugins: {
            title: {
                display: false
            },
            legend: {
                display: false
            }
        },
        responsive: true,
        scales: {
            x: {
                stacked: true,
                title: {
                    display: true,
                    text: 'SDM',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    display: false
                },
                stacked: true,
                title: {
                    display: true,
                    text: 'Jumlah Work Package',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            }
        }
    }
};

var myWpSDMBarChart = new Chart(ctxBarWpSDM, configBarWpSDM);

</script>
@endpush
