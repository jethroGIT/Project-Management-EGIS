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
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-file-earmark-check-fill text-primary" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                        </svg>
                        <div>
                            <h3 class="card-title fw-bold m-0">Utilisasi Work Package</h3>
                            <div class="fs-6 text-muted">WP yang telah dipanggil oleh WO</div>
                            <div class="d-flex align-items-end">
                                <div class="d-flex align-items-baseline">
                                    <span class="fs-2hx fw-bold text-primary me-2">{{ $workPackageWOAssignmentData['assigned'] }}</span>
                                    <span class="fs-4 text-muted fw-semibold">/</span>
                                    <span class="fs-3 text-muted fw-semibold ms-1">{{ $workPackageWOAssignmentData['total'] }}</span>
                                    <!-- <span class="ms-2 badge badge-light-success fs-7 fw-bold">% completed</span> -->
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
            <div class="d-flex align-items-center justify-content-start gap-2">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="text-warning" viewBox="0 0 640 640">
                        <path d="M192 160L192 144C192 99.8 278 64 384 64C490 64 576 99.8 576 144L576 160C576 190.6 534.7 217.2 474 230.7C471.6 227.9 469.1 225.2 466.6 222.7C451.1 207.4 431.1 195.8 410.2 187.2C368.3 169.7 313.7 160.1 256 160.1C234.1 160.1 212.7 161.5 192.2 164.2C192 162.9 192 161.5 192 160.1zM496 417L496 370.8C511.1 366.9 525.3 362.3 538.2 356.9C551.4 351.4 564.3 344.7 576 336.6L576 352C576 378.8 544.5 402.5 496 417zM496 321L496 288C496 283.5 495.6 279.2 495 275C510.5 271.1 525 266.4 538.2 260.8C551.4 255.2 564.3 248.6 576 240.5L576 255.9C576 282.7 544.5 306.4 496 320.9zM64 304L64 288C64 243.8 150 208 256 208C362 208 448 243.8 448 288L448 304C448 348.2 362 384 256 384C150 384 64 348.2 64 304zM448 400C448 444.2 362 480 256 480C150 480 64 444.2 64 400L64 384.6C75.6 392.7 88.5 399.3 101.8 404.9C143.7 422.4 198.3 432 256 432C313.7 432 368.3 422.3 410.2 404.9C423.4 399.4 436.3 392.7 448 384.6L448 400zM448 480.6L448 496C448 540.2 362 576 256 576C150 576 64 540.2 64 496L64 480.6C75.6 488.7 88.5 495.3 101.8 500.9C143.7 518.4 198.3 528 256 528C313.7 528 368.3 518.3 410.2 500.9C423.4 495.4 436.3 488.7 448 480.6z"/>
                    </svg>
                </div>
                <h3 class="card-title fw-bold m-0">Perbandingan Nilai Uang</h3>
            </div>

            <!-- Progress Bar -->
            <div class="mt-3">
                <div class="d-flex justify-content-between">
                    <div class="fs-6 fw-bold text-muted">WO keluar dengan total keseluruhan</div>
                    <div class="fs-6 fw-bold text-muted">10 %</div>
                </div>
                <div class="progress progress-sm mt-1" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-info" style="width: 10%"></div>
                </div>
                <!-- <div class="text-muted fs-6 mt-1">Rp10.000.000 / Rp100.000.000</div> -->
                <div class="text-muted fs-6 mt-1">Rp{{ number_format($woCompletionFinanceData['total_wo_value'], 0, ',', '.') }} / RP12.704.350.000</div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-3">
                <div class="d-flex justify-content-between">
                    <div class="fs-6 fw-bold text-muted">WO selesai dengan WO keluar</div>
                    <div class="fs-6 fw-bold text-muted">{{ $woCompletionFinanceData['completion_percentage'] }} %</div>
                </div>
                <div class="progress progress-sm mt-1" role="progressbar" aria-label="Basic example" aria-valuenow="{{ $woCompletionFinanceData['completion_percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-primary bg-success" style="width: {{ $woCompletionFinanceData['completion_percentage'] }}%"></div>
                </div>
                <div class="text-muted fs-6 mt-1">
                    Rp{{ number_format($woCompletionFinanceData['completed_wo_value'], 0, ',', '.') }} / Rp{{ number_format($woCompletionFinanceData['total_wo_value'], 0, ',', '.') }}
                </div>
            </div>

            <!-- Additional info -->
            <div class="mt-4">
                <!-- Toggle Button -->
                <div class="d-flex justify-content-between align-items-center">
                    <button 
                        type="button" 
                        class="btn btn-sm btn-light-primary" 
                        id="toggleFinanceDetails"
                        data-bs-toggle="collapse" 
                        data-bs-target="#financeDetailsCollapse" 
                        aria-expanded="false" 
                        aria-controls="financeDetailsCollapse"
                    >
                        <i class="bi bi-chevron-down transition-icon" id="toggleFinanceIcon"></i>
                        <span class="ms-1" id="toggleFinanceText">Tampilkan Detail</span>
                    </button>
                </div>
                
                <div class="collapse" id="financeDetailsCollapse">
                    <div class="fs-6 text-muted fw-bold my-2">Detail Informasi</div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Total WO Keluar:</span>
                            <span class="fw-bold">{{ $woCompletionFinanceData['total_wo_count'] }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">WO Selesai:</span>
                            <span class="fw-bold text-success">{{ $woCompletionFinanceData['completed_wo_count'] }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">WO Berjalan:</span>
                            <span class="fw-bold text-warning">{{ $woCompletionFinanceData['total_wo_count'] - $woCompletionFinanceData['completed_wo_count'] }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Nilai WO Berjalan:</span>
                            <span class="fw-bold text-warning">Rp{{ number_format($woCompletionFinanceData['ongoing_wo_value'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-6">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header py-0">
                    <h3 class="card-title fw-bold m-0">Work Package Selesai</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="fs-6 text-muted">Total WP terpanggil</div>
                        <div class="fs-1 fw-bold text-primary">{{ $pieChartDataWo['total'] ?? 0 }}</div>
                    </div>
                    <canvas id="wo_pie_chart" class="mh-400px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header py-0">
                    <h3 class="card-title fw-bold m-0">Persentase Progres Work Package</h3>
                </div>
                <div class="card-body pb-3">
                    <div class="col-md-3 mb-1">
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
                        <div class="box">
                            <div class="subbox">
                                <canvas id="wp_progres_bar_chart"></canvas>
                            </div>
                        </div>
                        <!-- class="mh-400px" -->

                        <!-- Loading Overlay -->
                        <div id="chartLoadingOverlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-light bg-opacity-75 d-none">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Memuat data...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-6">
         <!--begin::Card header-->
        <div class="card-header position-relative py-0 border-bottom border-bottom-1">
            <h2 class="card-title fw-bold">Jadwal Pelaksanaan Work Order</h2>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body">
            <div class="col-md-2 mb-5">
                <div class="input-group">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                        </svg>
                    </span>
                    <select name="execution_year"
                            id="tahunFilterPeriod"
                            class="form-select"
                    >
                        <option value="">Pilih Tahun</option>
                        @if(isset($executionYear) && !empty($executionYear))
                            @foreach ($executionYear as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <!-- Loading indicator -->
            <div id="periodChartLoadingOverlay" class="d-none position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 justify-content-center align-items-center" style="z-index: 10;">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Memuat data...</small>
                    </div>
                </div>
            </div>
            <!-- Diagram WPV Container -->
            <div id="diagram-timeline">
                @include('partials.diagram_timeline', [
                    'woGroups' => $woGroups,
                    'bulanIndonesia' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                    'lebarBulan' => 110,
                    'tinggiDiagram' => 330
                ])
            </div>
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
            <div class="table-responsive">
                <div class="chart-scroll" style="--bs-chart-items: {{ count($barChartWpSDMData['labels']) }}">
                    <canvas id="wp_sdm_bar_chart" class="w-100" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" id="pieChartDetailModal" tabindex="-1" aria-labelledby="pieChartDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Status Work Package</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded here by AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    $('#tahunFilter').on('change', function() {
        const selectedYear = this.value;

        if (selectedYear) {
            // Show loading state
            showChartLoading();
            
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
            // Reset default
            location.reload();
        }
    });

    $('#toggleFinanceDetails').on('click', function() {
        const icon = $('#toggleFinanceIcon');
        const text = $('#toggleFinanceText');
        const isExpanded = $(this).attr('aria-expanded') === 'true';

        // Update icon rotation
        if (isExpanded) {
            icon.removeClass('rotate');
            text.text('Tampilkan Detail');
        } else {
            icon.addClass('rotate');
            text.text('Sembunyikan Detail');
        }
    });

    // Event listener untuk collapse state changes
    $('#financeDetailsCollapse').on('shown.bs.collapse', function () {
        $('#toggleFinanceIcon').addClass('rotate');
        $('#toggleFinanceText').text('Sembunyikan Detail');
        $('#toggleFinanceDetails').attr('aria-expanded', 'true');
    });

    $('#financeDetailsCollapse').on('hidden.bs.collapse', function () {
        $('#toggleFinanceIcon').removeClass('rotate');
        $('#toggleFinanceText').text('Tampilkan Detail');
        $('#toggleFinanceDetails').attr('aria-expanded', 'false');
    });

    // Auto-collapse jika screen kecil
    function handleResponsiveCollapse() {
        if ($(window).width() < 768) {
            $('#financeDetailsCollapse').collapse('hide');
        }
    }

    // Check on load and resize
    handleResponsiveCollapse();
    $(window).on('resize', handleResponsiveCollapse);
});

document.addEventListener('DOMContentLoaded', function () {
    const tahunFilterPeriod = document.getElementById('tahunFilterPeriod');
    if (!tahunFilterPeriod) {
        console.error('Element #tahunFilterPeriod tidak ditemukan di DOM!');
        return;
    }
    
    tahunFilterPeriod.addEventListener('change', function() {
        const selectedYear = this.value;
        console.log('Tahun dipilih:', selectedYear);
        
        if (selectedYear) {
            showPeriodChartLoading();
            const url = '{{ route("dashboard.period-data") }}?year=' + selectedYear;
            console.log('URL AJAX:', url);

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                console.log('Status response:', response.status);
                return response.json();
            })
            .then(function(response) {
                console.log('Response JSON:', response);
                if (response.success && response.html) {
                    document.getElementById('diagram-timeline').innerHTML = response.html;
                } else {
                    document.getElementById('diagram-timeline').innerHTML = '<div class="text-danger py-5">Gagal memuat data.</div>';
                }
                hidePeriodChartLoading();
            })
            .catch(function(error) {
                console.error('AJAX error:', error);
                document.getElementById('diagram-timeline').innerHTML = '<div class="text-danger py-5">Gagal memuat data.</div>';
                hidePeriodChartLoading();
            });
        }
    });
});

function showPeriodChartLoading() {
    $('#periodChartLoadingOverlay').removeClass('d-none').addClass('d-flex');
    $('#tahunFilterPeriod').prop('disabled', true);
}

function hidePeriodChartLoading() {
    $('#periodChartLoadingOverlay').removeClass('d-flex').addClass('d-none');
    $('#tahunFilterPeriod').prop('disabled', false);
}

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
 * Perbandingan WP selesai dengan WP yang dipanggil oleh WO
 * Pie Chart
 * 
 */
const pieChartDataWo = @json($pieChartDataWo ?? ['labels' => ['No Data'], 'data' => [1], 'total' => 0]);

var ctxWoPie = document.getElementById('wo_pie_chart');

// Define colors
var primaryColor = KTUtil.getCssVariableValue('--kt-primary') || '#009EF7';
var dangerColor = KTUtil.getCssVariableValue('--kt-danger') || '#F1416C';
var successColor = KTUtil.getCssVariableValue('--kt-success') || '#50CD89';
var warningColor = KTUtil.getCssVariableValue('--kt-warning') || '#FFDE21';
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
            successColor,
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
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label;
                        const value = context.parsed;
                        const total = pieChartDataWo.total || 0;
                        const percentage = total > 0 ? Math.round((value/total) * 100) : 0;

                        return `${label}: ${value} WP (${percentage}%)`;
                    }
                }
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

    const backgroundColors = wpProgressBarChartData.data.map(completion => {
        return completion >= 100 ? successColor : warningColor;
    });

    const borderColors = wpProgressBarChartData.data.map(completion => {
        return completion >= 100 ?
        successColor.replace('89', '70') :
        warningColor.replace('700', '600');
    });

    const dataBarWpProgres = {
        labels: wpProgressBarChartData.labels,
        datasets: [{
            label: 'Completion Percentage (%)',
            data: wpProgressBarChartData.data,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
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
                    display: true,
                    text: 'Completion Percentage (%)',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
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
                            
                        //     // Volume details
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
            maintainAspectRatio: false,
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
                        align: 'end',
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

    const subbox = document.querySelector('.subbox');
    subbox.style.height = '300px';
    if (myWpBarChart.data.labels.length > 7) {
        const newHeight = 300 + ((myWpBarChart.data.labels.length - 7) * 20);
        subbox.style.height = `${newHeight}px`;
    }
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
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: false
            },
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    title: function(tooltipItems) {
                        return tooltipItems[0].label;
                    },
                    label: function(context) {
                        return `Jumlah WP: ${context.parsed.y}`;
                    },
                    footer: function() {
                        return 'Klik untuk melihat detail';
                    }
                }
            }
        },
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
                ticks: {
                    stepSize: 1
                },
                title: {
                    display: true,
                    text: 'Jumlah Work Package',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            }
        },
        onClick: function(event, elements) {
            if (elements.length > 0) {
                const index = elements[0].index;
                const username = this.data.labels[index];
                const wpCount = this.data.datasets[0].data[index];

                // Perbaiki selector untuk modal body
                $('#pieChartDetailModal').modal('show');
                $('#pieChartDetailModal .modal-body').html(`
                    <div class="d-flex justify-content-center my-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);

                // AJAX call
                $.ajax({
                    url: '{{ route("dashboard.user-wp-details") }}',
                    type: 'GET',
                    data: {
                        username: username
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#pieChartDetailModal .modal-body').html(response.html);
                        } else {
                            $('#pieChartDetailModal .modal-body').html(`
                                <div class="alert alert-warning">
                                    Tidak ada data work package untuk personel ini.
                                </div>
                            `);
                        }
                    },
                    error: function() {
                        $('#pieChartDetailModal .modal-body').html(`
                            <div class="alert alert-danger">
                                Terjadi kesalahan saat mengambil data. Silakan coba lagi.
                            </div>
                        `);
                    }
                });
            }
        }
    }
};

document.getElementById('wp_sdm_bar_chart').style.cursor = 'pointer';
var myWpSDMBarChart = new Chart(ctxBarWpSDM, configBarWpSDM);

</script>
@endpush


<style>
    .box {
        height: 520px;
        max-height: 260px;
        overflow-y: scroll;
    }

    /* CSS untuk expandable section */
    .transition-icon {
        transition: transform 0.3s ease;
    }

    .transition-icon.rotate {
        transform: rotate(180deg);
    }

    /** Helper class untuk Bar Chart SDM */
    .chart-scroll {
        min-width: calc(var(--bs-chart-items, 10) * 60px);
    }
</style>
