@extends('layouts.app')

@section('content')
<div class="">    
    <h1 class="mt-0 mb-5">Dashboard</h1>
    <div class="row">
        <div class="col-md-5">
            <!-- profile -->
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/media/svg/avatars/blank.svg') }}" alt="image" class="rounded-circle me-4" style="width: 100px; height: 100px; object-fit: cover;"/>
                        <div>
                            <span class="fw-bold m-0 mt-3">Selamat Datang,</span>
                            <h2 class="text-bolder">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-gray-400 py-2 edit-profile-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Edit Profil</span>
                        <i class="bi bi-arrow-right-circle icon-edit-profile" onclick="window.location.href='{{route('profile')}}'" style="cursor: pointer; font-size: 1.3rem;"></i>
                    </div>
                </div>
            </div>
            {{-- work package --}}
            <div class="card card-flush shadow-sm mb-8 wp-card position-relative">
                <div class="card-body ms-7">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-file-earmark-check-fill text-success" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                        </svg>
                        <div class="ms-10 position-relative wp-info-card" style="min-width:180px;">
                            <span class="fw-bold m-0 mt-3">Jumlah Work Package</span></br>
                            <span class="text-normal m-0 mt-3">yang dikerjakan</span></br>
                            <div style="position: relative;">
                                <h1 class="text-bolder mt-3 wp-highlight mb-0">{{$wpCount}}</h1>
                                <i class="bi bi-info-circle icon-detail-wp"
                                title="Lihat Detail WP"
                                onclick="toggleWpInfoSummary(event);"
                                style="cursor: pointer; position: absolute; top: 0; right: 0; font-size: 1.3rem;"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ringkasan WP, awalnya hidden -->
                <div id="wp-info-summary" class="card-body border-top pt-3" style="display: none;">
                    <div class="fw-bold mb-2">Ringkasan WP Anda:</div>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr style="font-size: 0.93rem;">
                                    <th class="fw-bold">No. WP</th>
                                    <th class="text-center fw-bold">Jumlah Volume</th>
                                    <th class="text-center fw-bold">Tahun Eksekusi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workPackages as $wp)
                                    <tr style="font-size: 0.93rem;">
                                        <td>WP {{ $wp->wp_number }}</td>
                                        <td class="text-center">{{ $wp->volumes_count ?? ($wp->volumes->count() ?? '-') }}</td>
                                        <td class="text-center">
                                            {{$wp->execution_year ?: '-'}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            {{-- timesheet --}}
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-body py-5" style="min-height: 340px;">
                    <div class="card-title mb-4 border-bottom">
                        <h3 class="fw-bold py-1">Work Package yang sedang dikerjakan</h3>
                    </div>
                    <div class="wp-list" style="max-height: 260px; overflow-y: auto;">
                        @if($workPackagesActive->isEmpty())
                            <div class="text-center text-gray-600">
                                Tidak ada Work Package yang sedang dikerjakan.
                            </div>
                        @else
                            @foreach($workPackagesActive as $wp)
                                @php
                                    $isBelumIsi = $wp->timesheetStatus === 'Belum mengisi Timesheet';
                                    $isMandaysCukup = $wp->timesheetStatus === 'Mandays mencukupi kontrak';
                                    $isSudahIsi = $wp->timesheetStatus === 'Sudah mengisi Timesheet';
                                @endphp
                                <!--begin::Wrapper-->
                                <div class="d-flex align-items-center mb-6 rounded px-0 {{ $isBelumIsi ? 'bg-light-danger' : ($isMandaysCukup ? 'bg-light-warning' : 'bg-light-primary') }}">
                                    <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-100px mh-100 me-4 {{ $isBelumIsi ? 'bg-danger' : ($isMandaysCukup ? 'bg-warning' : 'bg-primary') }}"></span>
                                    <div class="flex-grow-1">
                                        <div class="text-gray-800 fw-semibold fs-6 mt-1">
                                            WP {{$wp->wp_number}} {{$wp->name}}
                                        </div>
                                        <div class="text-gray-700 fw-semibold fs-7 mt-1">
                                            {{ \Carbon\Carbon::parse($wp->activeVolume->start_date)->translatedFormat('d F Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($wp->activeVolume->end_date)->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="fw-semibold fs-7 mt-4 mb-1 status-timesheet" id="status-timesheet-{{$wp->wp_id}}">
                                            {{$wp->timesheetStatus}}
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center me-2">
                                        <button class="btn btn-secondary btn-sm d-flex align-items-center p-2 ms-1" 
                                                style="width: 100px" 
                                                onclick="window.location.href='{{route('timesheet.detail.user', ['volume_id' => $wp->activeVolume->volume_id, 'user_id' => Auth::user()->user_id])}}'" 
                                        >
                                            Timesheet
                                            <i class="bi bi-arrow-right-circle ms-2"></i>
                                        </button>
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
    {{-- timeline fro project period--}}
    <div class="row">
        <div class="col-md-12 mb-10">
            <div class="card h-md-100 card-flush shadow-sm mb-8">
                <!--begin::Card header-->
                <div class="card-header position-relative py-0 border-bottom border-bottom-1">
                    <h2 class="card-title fw-bold">Periode Project</h2>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pb-0">
                    <div class="col-md-2 mb-5">
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                                </svg>
                            </span>
                            <select name="execution_year"
                                    id="tahunFilter"
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
                    <div id="chartLoadingOverlay" class="d-none position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 justify-content-center align-items-center" style="z-index: 10;">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <!-- Diagram WPV Container -->
                    <div id="diagram-wpv">
                        @include('partials.diagram_wpv', [
                            'wpvWithPeriod' => $wpvWithPeriod,
                            'bulanIndonesia' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                            'lebarBulan' => 160,
                            'tinggiDiagram' => 340
                        ])
                    </div>
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tahunFilter = document.getElementById('tahunFilter');
        if (!tahunFilter) {
            console.error('Element #tahunFilter tidak ditemukan di DOM!');
            return;
        }
        
        tahunFilter.addEventListener('change', function() {
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
                        document.getElementById('diagram-wpv').innerHTML = response.html;
                    } else {
                        document.getElementById('diagram-wpv').innerHTML = '<div class="text-danger py-5">Gagal memuat data.</div>';
                    }
                    hideChartLoading();
                })
                .catch(function(error) {
                    console.error('AJAX error:', error);
                    document.getElementById('diagram-wpv').innerHTML = '<div class="text-danger py-5">Gagal memuat data.</div>';
                    hideChartLoading();
                });
            }
        });
    });
    
    function showChartLoading() {
        $('#chartLoadingOverlay').removeClass('d-none').addClass('d-flex');
        $('#tahunFilter').prop('disabled', true);
    }

    function hideChartLoading() {
        $('#chartLoadingOverlay').removeClass('d-flex').addClass('d-none');
        $('#tahunFilter').prop('disabled', false);
    }

    function toggleWpInfoSummary(event) {
        const card = event.target.closest('.wp-card');
        const info = card.querySelector('#wp-info-summary');
        if (info) {
            info.style.display = (info.style.display === 'none' || info.style.display === '') ? 'block' : 'none';
        }
    }

    function updateStatusTimesheetUI(data) {
        data.workPackagesActive.forEach(function(wp) {
            const el = document.getElementById('status-timesheet-' + wp.wp_id);
            if (el) {
                el.textContent = wp.timesheetStatus;
                const wrapper = el.closest('.d-flex.align-items-center.mb-6.rounded.px-0');
                const bullet = wrapper.querySelector('[data-kt-element="bullet"]');
                // Reset warna
                wrapper.classList.remove('bg-light-warning', 'bg-light-danger', 'bg-light-primary');
                bullet.classList.remove('bg-warning', 'bg-danger', 'bg-primary');
                // Set warna sesuai status
                if (wp.timesheetStatus === 'Belum mengisi Timesheet') {
                    wrapper.classList.add('bg-light-danger');
                    bullet.classList.add('bg-danger');
                } else if (wp.timesheetStatus === 'Sudah mengisi Timesheet') {
                    wrapper.classList.add('bg-light-primary');
                    bullet.classList.add('bg-primary');
                } else {
                    wrapper.classList.add('bg-light-warning');
                    bullet.classList.add('bg-warning');
                }
            }
        });
    }
</script>

<style>
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
</style>