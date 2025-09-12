@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-5 mt-2">Timesheet Summary</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center">
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{route('work-package.detail', $volume->volume_id)}}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                    </a>
                @else
                    <a href="{{route('timesheet.detail.user', [$volume->volume_id, auth()->user()->user_id])}}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                    </a>
                @endif
                <h2 class="my-3 mb-3">WP {{ $workPackage->wp_number }} {{ $workPackage->name }}</h2>
            </div>            
            <div class="d-flex align-items-center justify-content-end">                
                <div class="d-flex align-items-center">
                    <ul class="nav nav-tabs nav-line-tabs mb-7 fs-6 me-2">
                        @foreach($months as $month)
                        <li class="nav-item">
                            <a class="nav-link {{$month === $selectedMonth? 'active' : ''}}" href="{{route('timesheet.detail', ['volume_id' => $volume->volume_id, 'month' => $month])}}">{{$month}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>                
            </div>
            {{-- <div class="mb-2">
                <label class="form-label">Filter Berdasarkan Tanggal</label>
                <input type="text" class="form-control form-control-solid" placeholder="Pilih rentang tanggal" id="kt_daterangepicker_1" style="width: 35%"/>
            </div> --}}
            <div class="d-flex justify-content-between align-items-center mb-5">
                <button class="btn btn-light-primary mb-3" id="scrollToMandays">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-down mb-1 me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 1 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                    </svg>
                    Lihat Total Mandays
                </button>
                <form class="d-flex justify-content-end" onsubmit="return false;">
                    <label class="me-5 mt-3" for="searchActivity">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search"
                        id="searchActivity" 
                        placeholder="Cari aktivitas" 
                        aria-label="Search"
                    >                    
                </form> 
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <div class="table-responsive">
                        @if($monthDates->isNotEmpty())
                            <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                                <thead>
                                    <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                                        <th scope="col" style="width: 20px;">No</th>
                                        <th scope="col" style="width: 40px; min-width: 20px;">Tanggal</th>
                                        @foreach($usersInSelectedMonth as $user)
                                            <th scope="col" style="width: 100px;">
                                                {{$user->name}}
                                                @php
                                                    // Menggunakan first() untuk mendapatkan role pertama jika ada
                                                    $roleName = $user->getRoleNames()->get(1) ?? $user->getRoleNames()->first();
                                                @endphp
                                                <i class="bi bi-info-circle text-primary"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{$roleName}}">
                                                </i>
                                            </th>     
                                        @endforeach                       
                                    </tr>
                                </thead>
                                <tbody style="font-size: 0.92rem;">
                                    @foreach($monthDates as $date => $entries)
                                    <tr>
                                        <th scope="row">{{$loop->index+1}}</th>
                                        <td>{{\Carbon\Carbon::parse($date)->format('d')}}</td>
                                        @foreach($usersInSelectedMonth as $user)
                                            <td>
                                                @php
                                                    $userEntry = $entries->where('user_id', $user->user_id)->first();
                                                @endphp
                                                @if($userEntry)
                                                     @if($userEntry->duration == 1.0)
                                                        <span class="badge badge-light-info badge-square mb-1">{{ $userEntry->duration }} Hari</span></br>
                                                    @elseif($userEntry->duration == 0.5)
                                                        <span class="badge badge-light-primary badge-square mb-1">{{ $userEntry->duration }} Hari</span></br>
                                                    @else
                                                        <span class="badge badge-secondary badge-square mb-1">{{ $userEntry->duration}} Hari</span></br>
                                                    @endif
                                                    <span>{{ $userEntry->activity}}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach                                        
                                    </tr>  
                                    @endforeach          
                                </tbody>
                            </table>
                        @else
                            <p>Tidak ada data Timesheet</p>
                        @endif
                    </div>
                </div>           
            </div>
            <div class="separator my-3"></div>                        
            <div class="card card-flush shadow-sm border-0 mb-5" id="mandaysCard" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);">
                <div class="card-header pb-0">
                    <h3 class="card-title fw-bold p-0">Total Mandays</h3>
                </div>
                <div class="card-body py-0">
                    <table class="table border bordered-gray-300 table-row-bordered table-sm table-row-gray-300 gs-3">
                        <thead style="font-size: 1.1rem;">
                            <tr>
                                <th scope="col" rowspan="2" class="fw-bold align-middle bg-light py-1">Personel</th>
                                <th scope="col" colspan="2" class="fw-bold text-center align-middle bg-light py-2">Mandays</th>
                            </tr>
                            <tr>
                                <th class="fw-bold text-center align-middle bg-light py-1">Rencana</th>
                                <th class="fw-bold text-center align-middle bg-light py-1">Realisasi</th>                            
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.97rem;">
                            @foreach($assignedUsers as $personil)
                            <tr>
                                <td class="align-middle">{{$personil['role_name']}}</td>
                                <td class="text-center align-middle" style="color:gray">{{$personil['jhk']}}</td>
                                <td class="text-center align-middle">
                                    {!! mandaysLabel($personil['jhk'], $personil['realisasiMandays']) !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let personelCounter = 1;
    $(document).ready(function() {
        initTabelTimesheet();

        $('#scrollToMandays').on('click', function() {
            $('html, body').animate({
                scrollTop: $('#mandaysCard').offset().top - 60 // offset untuk header
            }, 600);
        });
    });

    function initTabelTimesheet() {
        const table = $('#kt_datatable_example_2').DataTable({
            "scrollY": '300px',
            "scrollX": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "ordering": false // Disable sorting
        });

        setupActivitySearch(table);
    }

    function setupActivitySearch(table) {
        const searchInput = $('#searchActivity');

        // Search input handler
        searchInput.on('keyup change input', function() {
            const searchValue = this.value.trim();
            console.log('Search value:', searchValue);
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

    // datepicker
    // let startDate = '';
    // let endDate = '';

    // moment.locale('id'); // Set locale to Indonesian
    // $(document).ready(function () {
    // $('#kt_daterangepicker_1').daterangepicker({
    //         locale: {
    //             format: 'D MMMM YYYY',
    //             applyLabel: "Terapkan",
    //             cancelLabel: "Batal",
    //             weekLabel: "Minggu",
    //             daysOfWeek: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
    //             monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
    //             firstDay: 1 // Set hari pertama minggu ke Senin
    //         }
    //     }, function(start, end) {
    //         startDate = start.format('YYYY-MM-DD');
    //         endDate = end.format('YYYY-MM-DD');
    //     });
    //      $('#applyFilter').on('click', function () {
    //         if (!startDate || !endDate) {
    //             Swal.fire("Peringatan", "Mohon pilih rentang tanggal terlebih dahulu.", "warning");
    //             return;
    //         }

    //         const url = new URL(window.location.href);
    //         url.searchParams.set('start_date', startDate);
    //         url.searchParams.set('end_date', endDate);
    //         window.location.href = url.toString();
    //     });

    //     $('#resetFilter').on('click', function () {
    //         const url = new URL(window.location.href);
    //         url.searchParams.delete('start_date');
    //         url.searchParams.delete('end_date');
    //         window.location.href = url.toString();
    //     });
    // });


    // Saat tombol Terapkan diklik
    // document.getElementById('applyFilter').addEventListener('click', function () {
    //     if (!startDate || !endDate) {
    //         Swal.fire("Peringatan", "Mohon pilih rentang tanggal terlebih dahulu.", "warning");
    //         return;
    //     }

    //     const url = new URL(window.location.href);
    //     url.searchParams.set('start_date', startDate);
    //     url.searchParams.set('end_date', endDate);
    //     window.location.href = url.toString(); // reload dengan query string
    // });

    // Reset filter
    // document.getElementById('resetFilter').addEventListener('click', function () {
    //     const url = new URL(window.location.href);
    //     url.searchParams.delete('start_date');
    //     url.searchParams.delete('end_date');
    //     window.location.href = url.toString();
    // });
</script>
@endpush

@php
    function mandaysLabel($plan, $realization) {
        if ($realization == $plan) {
            $badge = 'badge badge-warning';
        }elseif ($realization < $plan) {
            $badge = '';
        } else {
            $badge = 'badge badge-danger';
        }
        return '<span class="'.$badge.'">'. $realization . '</span>';
    }
@endphp
