@extends('layouts.app')

@section('content')
<div class="container-fluid">    
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
                        <i class="bi bi-arrow-right-circle icon-edit-profile" onclick="window.location.href='{{route('profile')}}'" style="cursor: pointer"></i>
                    </div>
                </div>
            </div>
            {{-- work package --}}
            <div class="card card-flush shadow-sm mb-8 wp-card">
                <div class="card-body ms-7">
                    <div class="d-flex align-items-center">
                        <span>
                            <i class="bi bi-journal-bookmark-fill" style="font-size: 4.5rem;"></i>
                        </span>
                        <div class="ms-10">
                            <span class="fw-bold m-0 mt-3">Jumlah Work Package</span></br>
                            <span class="text-normal m-0 mt-3">yang dikerjakan</span></br>
                            <h1 class="text-bolder mt-3 wp-highlight">{{$wpCount}}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            {{-- timesheet --}}
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-body py-5" style="min-height: 345px;">
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
                    <div class="mb-5" style="max-width: 200px;">
                        <form method="GET" id="filterYearForm">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-funnel-fill text-dark"></i>
                                </span>
                                <select name="execution_year"
                                        id="execution_year"
                                        class="form-control"
                                        required
                                        style="appearance: none; -webkit-appearance: none; background: transparent; padding-right: 2rem;"
                                        onchange="document.getElementById('filterYearForm').submit()"
                                >
                                    <option value="" disabled>Pilih Tahun</option>
                                    @foreach ($executionYear as $year)
                                        <option value="{{ $year }}"
                                            {{ (request('execution_year', $selectedYear) == $year) ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                <span style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 1.5rem; color: #444; line-height: 1;">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" style="display: block;">
                                        <path d="M5 8L10 13L15 8" stroke="#444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
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
                                    @foreach($wpvWithPeriod as $wpv)
                                        <div class="d-flex align-items-center" style="height:60px;">
                                            <span class="text-dark fw-bold fs-4 me-2">WP {{ $wpv->workPackage->wp_number }}</span>
                                        </div>
                                    @endforeach
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
                                        @foreach($wpvWithPeriod as $wpv)
                                            @php
                                                \Carbon\Carbon::setLocale('id');
                                                $startMonth = \Carbon\Carbon::parse($wpv->start_date)->month; // 1-12
                                                $endMonth = \Carbon\Carbon::parse($wpv->end_date)->month; // 1-12
                                                $topPosition = ($loop->index * 60); // 60px per baris, mulai dari top 0px (karena header sudah di atas)
                                                $leftPosition = ($startMonth - 1) * $lebarBulan; // posisi kiri berdasarkan bulan mulai
                                                $width = ($endMonth - $startMonth + 1) * $lebarBulan; // lebar berdasarkan durasi bulan
                                            @endphp
                                            <div class="d-flex align-items-center" style="position: absolute; top: {{ $topPosition }}px; left: {{ $leftPosition }}px; height:60px; z-index:2;">
                                                <div class="bg-light-primary rounded-pill d-flex align-items-center px-2" style="width: {{ $width }}px;">
                                                    <span class="fw-bold text-primary ms-3">
                                                        {{ \Carbon\Carbon::parse($wpv->start_date)->translatedFormat('d F') }} - {{ \Carbon\Carbon::parse($wpv->end_date)->translatedFormat('d F') }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
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
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // console.log('workPackagesActive', @json($workPackagesActive));
    // document.getElementById('execution_year').addEventListener('change', function() {
    //     const year = this.value;
    //     fetch(`{{ url()->current() }}?execution_year=${year}`, {
    //         headers: { 'X-Requested-With': 'XMLHttpRequest' }
    //     })
    //     .then(res => res.text())
    //     .then(html => {
    //         document.getElementById('diagram-wpv').innerHTML = html;
    //     });
    // });

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

    function fetchStatusTimesheet() {
        fetch('/dashboard-karyawan/{{ Auth::user()->user_id }}')
            .then(response => response.json())
            .then(data => updateStatusTimesheetUI(data));
    }

    // Saat halaman dibuka, langsung fetch data terbaru
    document.addEventListener('DOMContentLoaded', function () {
        fetchStatusTimesheet();
        // Optionally, refresh setiap 30 detik
        // setInterval(fetchStatusTimesheet, 30000);
    });
</script>

<style>
    .edit-profile-footer .icon-edit-profile:hover{
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