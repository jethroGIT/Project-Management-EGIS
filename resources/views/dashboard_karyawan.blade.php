@extends('layouts.app')

@section('content')
<div class="">    
    <h1 class="mt-0 mb-5">Dashboard</h1>
    <div class="row g-5 g-xl-8">
        <div class="col-md-5">
            <!-- profile -->
            <div class="card card-flush shadow-sm mb-6" style="height: 200px;">
                <div class="card-body d-flex flex-column justify-content-center py-5">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/media/svg/avatars/blank.svg') }}" alt="image" 
                            class="rounded-circle me-4" style="width: 80px; height: 80px; object-fit: cover;"/>
                        <div class="mt-3">
                            <span class="fw-bold fs-5 d-block mb-2">Selamat Datang,</span>
                            <h2 class="fw-bolder">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-gray-400 py-3 edit-profile-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-6 fw-semibold">Edit Profil</span>
                        <i class="bi bi-arrow-right-circle icon-edit-profile" onclick="window.location.href='{{route('profile')}}'" 
                        style="cursor: pointer; font-size: 1.4rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {{-- work package --}}
            <div class="card card-flush shadow-sm mb-6 wp-card position-relative" style="height: 200px;">
                <div class="card-body d-flex flex-column justify-content-center py-5">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" 
                            class="bi bi-file-earmark-check-fill text-primary me-4" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                        </svg>
                        <div class="position-relative wp-info-card" style="min-width:200px;">
                            <div class="mb-2">
                                <span class="fs-4 fw-bolder d-block">Jumlah Work Package</span>
                                <span class="fs-6 text-muted">yang dikerjakan</span>
                            </div>
                            <div style="position: relative;">
                                <h1 class="display-4 fw-bolder wp-highlight mb-0">{{$wpCount}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- date -->
            <div class="card card-flush shadow-sm mb-6" style="height: 200px;">
                <div class="card-header bg-light py-3">
                    <div class="card-title">
                        <h3 class="mb-0 text-gray-800 align-items-center d-flex">
                            <i class="bi bi-calendar-check me-2"></i>Hari Ini
                        </h3>
                    </div>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center py-2">
                    @php
                        $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $today = \Carbon\Carbon::now();
                        $tanggal = $today->day;
                        $bulan = $bulanIndo[$today->month - 1];
                        $tahun = $today->year;
                    @endphp
                    <div class="text-center">
                        <h1 class="display-4 fw-bolder mb-0">{{ $tanggal }}</h1>
                        <h5 class="fs-3 fw-bolder text-primary mb-0">{{ $bulan }}</h5>
                        <p class="text-muted fs-6">{{ $tahun }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            {{-- pie --}}
            <div class="card card-flush shadow-sm pie-card mb-8" style="height: 380px;">
                <div class="card-header py-0 border-bottom border-bottom-1 d-flex justify-content-between align-items-center">
                    <h2 class="card-title fw-bold">Status Work Package</h2>
                    <i class="bi bi-info-circle icon-detail-wp"
                    title="Lihat Detail WP"
                    onclick="togglePieChartInfo(event);"
                    style="cursor: pointer; font-size: 1.5rem;"></i>
                </div>
                <div class="card-body py-5">
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                        <div class="chart-container" style="position: relative; height:250px; width:250px;">
                            <canvas id="wo_pie_chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            {{-- timesheet --}}
            <div class="card card-flush shadow-sm mb-8" style="height: 380px;">
                <div class="card-header position-relative py-0 border-bottom border-bottom-1">
                    <h2 class="card-title fw-bold">Work Package Berjalan</h2>
                </div>
                <div class="card-body py-5">
                    <div class="wp-list" style="max-height: 270px; overflow-y: auto;">
                        @if($workPackagesActive->isEmpty())
                            <div class="text-center text-gray-600">
                                Tidak ada Work Package yang sedang dikerjakan (berjalan).
                            </div>
                        @else
                            @foreach($workPackagesActive as $wp)
                                @php
                                    $isBelumIsi = $wp->timesheetStatus === 'Belum mengisi Timesheet';
                                    $isMandaysCukup = $wp->timesheetStatus === 'Mandays mencukupi kontrak';
                                    $isSudahIsi = $wp->timesheetStatus === 'Sudah mengisi Timesheet';
                                    $isPeriodeMelewati = $wp->timesheetStatus === 'Periode melewati kontrak';
                                @endphp
                                <!--begin::Wrapper-->
                                <div class="d-flex align-items-center mb-6 rounded px-0 bg-light">
                                    <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-100px mh-100 me-4 
                                        {{ $isBelumIsi ? 'bg-danger' : 
                                        ($isMandaysCukup ? 'bg-warning' : 
                                        ($isPeriodeMelewati ? 'bg-info' : 'bg-primary')) }}"></span>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold fs-7 mb-2 mt-2 d-inline-block status-timesheet text-white rounded-pill px-2
                                            {{ $isBelumIsi ? 'bg-danger' : 
                                            ($isMandaysCukup ? 'bg-warning' : 
                                            ($isPeriodeMelewati ? 'bg-info' : 'bg-primary')) }}" id="status-timesheet-{{$wp->wp_id}}">
                                                {{$wp->timesheetStatus}}
                                        </div>
                                        <div class="text-gray-800 fw-semibold fs-6 mt-1">
                                            <span class="badge badge-light text-dark">WO {{$wp->wo_number ?? 0}}</span> WP {{$wp->wp_number}} {{$wp->name}}
                                        </div>
                                        <div class="text-gray-700 fw-semibold fs-7 mt-1 mb-2">
                                            @if($wp->activeVolume)
                                                {{ \Carbon\Carbon::parse($wp->activeVolume->start_date)->translatedFormat('d F Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($wp->activeVolume->end_date)->translatedFormat('d F Y') }}
                                            @elseif($isPeriodeMelewati)
                                                @php
                                                    // Ambil volume yang periodenya sudah lewat dengan end_date terbaru
                                                    $expiredVolume = $wp->workPackageVolumes
                                                        ->filter(function($v) use ($today) {
                                                            return $v->end_date && $v->end_date < now()->toDateString();
                                                        })
                                                        ->sortByDesc('end_date')
                                                        ->first();
                                                @endphp
                                                {{ \Carbon\Carbon::parse($expiredVolume->start_date)->translatedFormat('d F Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($expiredVolume->end_date)->translatedFormat('d F Y') }}
                                            @else
                                                <span class="text-muted">Tidak ada periode aktif</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center me-2 ms-1">
                                        @if($wp->activeVolume)
                                            <!-- Volume aktif ditemukan -->
                                            <button class="btn btn-secondary btn-sm d-flex align-items-center p-2 ms-1" 
                                                    style="width: 100px" 
                                                    onclick="window.location.href='{{route('timesheet.detail.user', ['volume_id' => $wp->activeVolume->volume_id, 'user_id' => Auth::user()->user_id])}}'" 
                                            >
                                                Timesheet
                                                <i class="bi bi-arrow-right-circle ms-2"></i>
                                            </button>
                                        @elseif($isPeriodeMelewati)
                                            <!-- Periode melewati kontrak, ambil volume terakhir -->
                                            @php
                                                $lastVolume = $wp->workPackageVolumes->sortByDesc('end_date')->first();
                                            @endphp
                                            @if($lastVolume)
                                                <button class="btn btn-secondary btn-sm d-flex align-items-center p-2 ms-1" 
                                                        style="width: 100px" 
                                                        onclick="window.location.href='{{route('timesheet.detail.user', ['volume_id' => $lastVolume->volume_id, 'user_id' => Auth::user()->user_id])}}'" 
                                                >
                                                    Timesheet
                                                    <i class="bi bi-arrow-right-circle ms-2"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-secondary btn-sm d-flex align-items-center p-2 ms-1" 
                                                        style="width: 100px" 
                                                        disabled
                                                >
                                                    Timesheet
                                                    <i class="bi bi-x-circle ms-2"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <!--end::Wrapper-->
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- timeline for project period--}}
    <div class="row">
        <div class="col-md-12 mb-10">
            <div class="card card-flush shadow-sm mb-4" style="height: 580px">
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
                        @if(!isset($woGroups) || empty($woGroups) || count($woGroups) === 0)
                            <div class="text-center py-5">
                                Tidak ada data WP pada tahun ini.
                            </div>
                        @else
                            @include('partials.diagram_timeline', [
                                'woGroups' => $woGroups,
                                'bulanIndonesia' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                                'lebarBulan' => 110,
                                'tinggiDiagram' => 330
                            ])
                        @endif
                    </div>
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal untuk detail pie chart -->
<div class="modal fade" id="userWpDetailModal" tabindex="-1" aria-labelledby="userWpDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="userWpDetailModalLabel">Detail Work Package</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded here via AJAX -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // filter tahun untuk periode project
        const tahunFilterPeriod = document.getElementById('tahunFilterPeriod');
        if (!tahunFilterPeriod) {
            console.error('Element #tahunFilterPeriod tidak ditemukan di DOM!');
            return;
        }
        
        tahunFilterPeriod.addEventListener('change', function() {
            const selectedYear = this.value;
            console.log('Tahun dipilih:', selectedYear);
            
            if (selectedYear) {
                showChartLoading();
                const url = '{{ route("dashboard-karyawan.period-data") }}?year=' + selectedYear;
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
                        window.initTooltips();
                    } else {
                        document.getElementById('diagram-timeline').innerHTML = '<div class="text-danger py-5">Gagal memuat data.</div>';
                    }
                    hideChartLoading();
                })
                .catch(function(error) {
                    console.error('AJAX error:', error);
                    document.getElementById('diagram-timeline').innerHTML = '<div class="text-danger py-5">Gagal memuat data.</div>';
                    hideChartLoading();
                });
            }
        });

        // Inisialisasi chart pie untuk status WP
        const pieChartDataWP = {!! json_encode($pieChartDataWP ?? ['labels' => ['Berjalan', 'Selesai'], 'data' => [1, 0], 'total' => 0]) !!};

        var ctxWPPie = document.getElementById('wo_pie_chart');
        
        if (ctxWPPie) {
            // Define colors
            var primaryColor = KTUtil.getCssVariableValue('--kt-primary') || '#009EF7';
            var dangerColor = KTUtil.getCssVariableValue('--kt-danger') || '#F1416C';
            var successColor = KTUtil.getCssVariableValue('--kt-success') || '#50CD89';
            var warningColor = KTUtil.getCssVariableValue('--kt-warning') || '#FFC700';
            var infoColor = KTUtil.getCssVariableValue('--kt-info') || '#7239EA';

            // Define fonts
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

            // Chart data
            const dataWPPie = {
                labels: pieChartDataWP.labels,
                datasets: [{
                    label: 'Work Package',
                    data: pieChartDataWP.data,
                    backgroundColor: [
                        warningColor,
                        successColor
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            };

            // Chart config
            const configWPPie = {
                type: 'pie',
                data: dataWPPie,
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
                }
            };

            var myWoPieChart = new Chart(ctxWPPie, configWPPie);
        }
    });
    
    function showChartLoading() {
        $('#periodChartLoadingOverlay').removeClass('d-none').addClass('d-flex');
        $('#tahunFilterPeriod').prop('disabled', true);
    }

    function hideChartLoading() {
        $('#periodChartLoadingOverlay').removeClass('d-flex').addClass('d-none');
        $('#tahunFilterPeriod').prop('disabled', false);
    }

    function togglePieChartInfo(event) {
        // Tampilkan modal detail pie chart
        var myModal = new bootstrap.Modal(document.getElementById('userWpDetailModal'));
        myModal.show();
        
        // Ambil detail via AJAX
        fetch('{{ route("dashboard-karyawan.user-wp-details", ["user_id" => Auth::user()->user_id]) }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                document.querySelector('#userWpDetailModal .modal-body').innerHTML = response.html;
            } else {
                document.querySelector('#userWpDetailModal .modal-body').innerHTML = `
                    <div class="alert alert-warning">
                        Tidak ada data work package untuk user ini.
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching work package details:', error);
            document.querySelector('#userWpDetailModal .modal-body').innerHTML = `
                <div class="alert alert-danger">
                    Terjadi kesalahan saat mengambil data. Silakan coba lagi.
                </div>
            `;
        });
    }

    // Fungsi untuk memperbarui status timesheet di UI
    function updateStatusTimesheetUI(data) {
        data.workPackagesActive.forEach(function(wp) {
            const el = document.getElementById('status-timesheet-' + wp.wp_id);
            if (el) {
                el.textContent = wp.timesheetStatus;
                const wrapper = el.closest('.d-flex.align-items-center.mb-6.rounded.px-0');
                const bullet = wrapper.querySelector('[data-kt-element="bullet"]');
                // Reset warna
                wrapper.classList.remove('bg-light-warning', 'bg-light-danger', 'bg-light-primary', 'bg-light-info');
                bullet.classList.remove('bg-warning', 'bg-danger', 'bg-primary', 'bg-info');
                
                // Set warna sesuai status
                if (wp.timesheetStatus === 'Belum mengisi Timesheet') {
                    wrapper.classList.add('bg-light-danger');
                    bullet.classList.add('bg-danger');
                } else if (wp.timesheetStatus === 'Sudah mengisi Timesheet') {
                    wrapper.classList.add('bg-light-primary');
                    bullet.classList.add('bg-primary');
                } else if (wp.timesheetStatus === 'Periode melewati kontrak') {
                    wrapper.classList.add('bg-light-info');
                    bullet.classList.add('bg-info');
                } else {
                    wrapper.classList.add('bg-light-warning');
                    bullet.classList.add('bg-warning');
                }
            }
        });
    }
</script>

<style>
    /* Style yang sudah ada tetap pertahankan */
    .edit-profile-footer .icon-edit-profile:hover{
        font-size: 1.1rem;
        color: #19191a;
        transition: transform 0.25s cubic-bezier(.4,2,.6,1), color 0.25s;
    }
    .wp-info-card .icon-detail-wp:hover{
        font-size: 1.1rem;
        color: #19191a;
        transition: transform 0.25s cubic-bezier(.4,2,.6,1), color 0.25s;
    }
    .wp-card .wp-highlight {
        display: inline-block;
        transition: transform 0.25s cubic-bezier(.4,2,.6,1), color 0.25s;
        transform-origin: center;
    }
    .wp-card:hover .wp-highlight {
        transform: scale(1.4);
    }
    
    /* Tambahkan CSS baru untuk mengatasi masalah tinggi card */
    .row {
        align-items: flex-start;
    }
    
    .card.card-flush {
        height: auto;
    }
    
    .wp-card {
        transition: height 0.3s ease;
    }
    
    .wp-card.expanded {
        height: auto;
    }
</style>