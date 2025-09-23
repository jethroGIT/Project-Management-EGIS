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
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-file-earmark-fill text-info" viewBox="0 0 16 16">
                            <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z"/>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-journal-check text-success" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                        </svg>
                        <div>
                            <h3 class="card-title fw-bold m-0">Work Package Selesai</h3>
                            <div class="fs-6 text-muted">Progres pengerjaan WP</div>
                            <!-- <h2 class="fs-2hx fw-bold text-success">20 / 47 (47%)</h2> -->
                            <div class="d-flex align-items-end">
                                <div class="d-flex align-items-baseline">
                                    <span class="fs-2hx fw-bold text-success me-2">20</span>
                                    <span class="fs-4 text-muted fw-semibold">/</span>
                                    <span class="fs-3 text-muted fw-semibold ms-1">42</span>
                                    <span class="ms-2 badge badge-light-success fs-7 fw-bold">47% completed</span>
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
                    <!-- <div style="position: relative; height: 240px; width: 100%;">
                        <canvas id="pie_chart"></canvas>
                    </div> -->
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
                                <option value="">2024</option>
                                <option value="">2025</option>
                                <option value="">2026</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div style="position: relative; height: 240px; width: 100%;">
                        <canvas id="horizontal_bar_chart"></canvas>
                    </div> -->
                    <canvas id="wp_progres_bar_chart" class="mh-400px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-6">
        <div class="card-header py-0">
            <h3 class="card-title fw-bold m-0">Project Berjalan</h3>
            <div class="card-toolbar">
                <span class="badge badge-light-info badge-lg">
                    
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="wp_progres_table" class="table border table-row-dashed border-gray-300 table-row-gray-300 gy-5 gs-7 rounded w-100">
                    <thead class="align-middle text-center">
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th>Nomor Work Order</th>
                            <!-- <th></th> -->
                            <th class="align-middle border-bottom">No</th>
                            <th class="align-middle border-bottom min-w-200px">Work Package</th>
                            <th class="align-middle border-bottom">Volume (Qty)</th>
                            <th class="align-middle border-bottom min-w-100px">WP Progres</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="task-row">
                            <td>WO 1</td>
                            <td>1.</td>
                            <td>WP 1.1 Merger & Acquisition (M&A) - Information Security Due Dilligence</td>
                            <td class="text-center">2</td>
                            <td class="text-center">75 %</td>
                        </tr>
                        <tr class="task-row">
                            <td>WO 1</td>
                            <td>2.</td>
                            <td>WP 1.2 Merger & Acquisition (M&A) - In-Depth/ Combination Assessment</td>
                            <td class="text-center">2</td>
                            <td class="text-center">60 %</td>
                        </tr>
                        <tr class="task-row">
                            <td>WO 2</td>
                            <td>3.</td>
                            <td>WP 2.1 Control/Framework Assessment</td>
                            <td class="text-center">2</td>
                            <td class="text-center">45 %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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
var ctxBarWpProgres = document.getElementById('wp_progres_bar_chart');

const labelsBarWp = ['WP 1.1', 'WP 2.1', 'WP 3.1', 'WP 4.1', 'WP 5.1', 'WP 6.1', 'WP 7.1'];
const dataBarWpProgres = {
  labels: labelsBarWp,
  datasets: [{
    axis: 'y',
    label: 'Completeness (%)',
    data: [65, 59, 80, 81, 56, 55, 40],
    fill: false,
    backgroundColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(255, 159, 64, 1)',
      'rgba(255, 205, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(201, 203, 207, 1)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
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
            }
        },
        responsive: true,
        scales: {
            x: {
                beginAtZero: true,
                max: 100,
                stacked: true
            },
            y: {
                grid: {
                    display: false
                },
                stacked: true
            }
        }
    }
};

var myWpBarChart = new Chart(ctxBarWpProgres, configBarWpProgres);

$(document).ready(function () {
    initTabelWPProgres();
});

function initTabelWPProgres() {
    const table = $('#wp_progres_table').DataTable({
        'scrollY': '300px',
        "scrollX": true,
        "paging": false,
        "language": {
            "emptyTable": "Tidak ada data work package yang sedang berjalan"
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
        ]
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
