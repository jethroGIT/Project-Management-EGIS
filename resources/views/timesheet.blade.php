@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-10 mt-2">Timesheet Activity</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-7">
                <a href="{{route('work-package.detail', $volume->volume_id)}}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
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
                    <a href="#" class="btn btn-light btn-sm border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; margin-bottom: 10px;">
                        <i class="bi bi-plus fs-2 text-dark" style="margin-left: 5px"></i>
                    </a>
                </div>                
            </div>
            <div class="mb-2">
                <label class="form-label">Filter Berdasarkan Tanggal</label>
                <input type="text" class="form-control form-control-solid" placeholder="Pilih rentang tanggal" id="kt_daterangepicker_1" style="width: 35%"/>
            </div>
            <form class="d-flex justify-content-end align-items-center">
                <label class="me-5 mb-0" for="searchActivity">Cari: </label>
                <div>
                    <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
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
            </form>
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <div class="table-responsive">
                        @if($monthDates->isNotEmpty())
                            <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                                <thead>
                                    <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                                        <th scope="col" style="width: 40px;">No</th>
                                        <th scope="col" style="width: 70px; min-width: 40px;">Tanggal</th>
                                        @foreach($usersInSelectedMonth as $user)
                                            <th scope="col" style="width: 80px;">
                                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{$user->role->name}}">{{$user->name}}</span>
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
                                                {{ $userEntry->activity ?? '-'}}
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
            <div class="col">
                <div class="d-flex justify-content-between mb-5">
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#mandaysSummaryTable" aria-expanded="false" aria-controls="mandaysSummaryTable">
                        <i class="bi bi-chevron-down me-2"></i>
                        Lihat Ringkasan Mandays
                    </button>
                    {{-- id user dummy terlebih dulu, nanti ambil dari session user --}}
                    <button type="button" class="btn btn-light-primary" aria-expanded="false" aria-controls="kelolaAktivitas" onclick="window.location.href='{{ route('timesheet.detail.user', [$volume->volume_id, 1]) }}'">
                        Kelola Aktivitas
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                        </svg>
                    </button>
                </div>
                <div class="collapse" id="mandaysSummaryTable">
                    <table class="table border bordered-gray-300 table-row-bordered table-sm table-row-gray-300 gs-3">
                        <thead>
                            <tr>
                                <th scope="col" colspan="3" class="text-center bg-light py-1">Total Mandays</th>
                            </tr>
                            <tr>
                                <th scope="col" rowspan="2" class="align-middle py-1">Personel</th>
                                <th scope="col" colspan="2" class="text-center align-middle py-1">Mandays</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle py-0">Rencana</th>
                                <th class="text-center align-middle py-0">Realisasi</th>                            
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.92rem;">
                            @foreach($humanResources as $hResource)
                            <tr>
                                <td class="align-middle">{{$hResource->role->name}}</td>
                                <td class="text-center align-middle" style="color:gray">{{$hResource->jhk}}</td>
                                <td class="text-center align-middle">
                                    @php
                                        // Ambil realisasi mandays untuk role ini. Jika tidak ada data, default 0.
                                        $realisasiMandays = $timesheetCountPerRole[$hResource->role_id] ?? 0;
                                    @endphp
                                    {!! mandaysLabel($hResource->jhk, $realisasiMandays) !!}
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

<!--begin::Scrollbottom-->
{{-- <div id="kt_scrollbottom_button" class="scrolltop" data-kt-scrollbottom="true" style="bottom: 120px; display:flex">
    <span class="svg-icon">
        <!-- Icon panah ke bawah (reverse dari scrolltop) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 15.5L6.5 10l1.41-1.41L12 13.67l4.09-4.08L17.5 10z" fill="black"/>
        </svg>
    </span>
    <span id="closeScrollBottom" style="position:absolute;top:-8px;right:-8px;font-size:12px;background:red;color:white;border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;cursor:pointer;">×</span>
</div> --}}
<!--end::Scrollbottom-->


<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Timesheet Work Package</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form>
                    <label class="form-label fw-bolder">February, 2025</label>
                    <div class="form-group mb-6">
                        <label class="form-label fw-bold">Tanggal</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="percentComplete" placeholder="Masukkan Tanggal" min="1" max="31"/>
                        </div>
                    </div>
                    <hr class="dropdown-divider mb-4">
                    <div class="mb-4">
                        <label class="form-label fw-bolder">Personel Activity</label>
                        <div class="resourceContainer" id="resourceContainer">
                            <div class="personel-activity-group mb-4" id="resource-0">
                                <div class="card card-flush shadow">
                                    <div class="card-header">
                                        <h3 class="card-title">Personel 1</h3>
                                    </div>
                                    <div class="card-body py-5 mb-2">
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Personel</label>
                                            <select class="form-select mb-2" name="resources[]">
                                                <option value="">Pilih Resource</option>
                                                <option value="pm">Project Manager (PM)</option>
                                                <option value="sc">Senior Consultant (SC)</option>
                                                <option value="asc">Associate Consultant (ASC)</option>
                                                <option value="jc">Junior Consultant (JC)</option>
                                                <option value="tw">Technical Writer (TW)</option>
                                                <option value="osc">On-Site Consultant (OSC)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="activity-0" class="form-label">Aktivitas</label>
                                            <textarea class="form-control" id="activity-0" name="activities[]" rows="3" placeholder="Aktivitas"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-light-primary" id="addPersonelBtn">
                            <i class="bi bi-plus-lg"></i>
                            Tambah Personel
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light rounded-0" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-0" id="saveSuccessful">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let personelCounter = 1;
    const button = document.getElementById('saveSuccessful');

    button.addEventListener('click', e => {
        e.preventDefault();

        Swal.fire({
            text: "Data berhasil disimpan!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
    });

     // Initialize the DataTable
    $(document).ready(function() {
        initTabelTimesheet();

        // Add Personel Button Click Event
        $('#addPersonelBtn').on('click', function() {
            addNewPersonel();
        });

        // Remove Personel Button Click Event
        $('#removePersonelBtn').on('click', function() {
            removeLastPersonel();
        });

        // Update remove button visibility on page load
        updateRemoveButtonVisibility();
    });

    function initTabelTimesheet() {
        const table = $('#kt_datatable_example_2').DataTable({
            "scrollY": '500px',
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
    let startDate = '';
    let endDate = '';

    moment.locale('id'); // Set locale to Indonesian
    $(document).ready(function () {
    $('#kt_daterangepicker_1').daterangepicker({
            locale: {
                format: 'D MMMM YYYY',
                applyLabel: "Terapkan",
                cancelLabel: "Batal",
                weekLabel: "Minggu",
                daysOfWeek: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                firstDay: 1 // Set hari pertama minggu ke Senin
            }
        }, function(start, end) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
        });
         $('#applyFilter').on('click', function () {
            if (!startDate || !endDate) {
                Swal.fire("Peringatan", "Mohon pilih rentang tanggal terlebih dahulu.", "warning");
                return;
            }

            const url = new URL(window.location.href);
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            window.location.href = url.toString();
        });

        $('#resetFilter').on('click', function () {
            const url = new URL(window.location.href);
            url.searchParams.delete('start_date');
            url.searchParams.delete('end_date');
            window.location.href = url.toString();
        });
    });


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

    /* ADD NEW PERSONEL */
    function addNewPersonel() {
        const personelHtml = `
            <div class="personel-activity-group mb-4" id="resource-${personelCounter}">
                <div class="card card-flush shadow">
                    <div class="card-header">
                        <h3 class="card-title">Personel ${personelCounter + 1}</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-light-danger remove-personel-btn" onclick="removePersonel(${personelCounter})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                    <div class="card-body py-5 mb-2">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Personel</label>
                            <select class="form-select" name="resources[]">
                                <option value="">Pilih Resource</option>
                                <option value="pm">Project Manager (PM)</option>
                                <option value="sc">Senior Consultant (SC)</option>
                                <option value="asc">Associate Consultant (ASC)</option>
                                <option value="jc">Junior Consultant (JC)</option>
                                <option value="tw">Technical Writer (TW)</option>
                                <option value="osc">On-Site Consultant (OSC)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="activity-${personelCounter}" class="form-label fw-bold">Aktivitas</label>
                            <textarea class="form-control" id="activity-${personelCounter}" name="activities[]" rows="3" placeholder="Masukkan aktivitas yang dilakukan..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#resourceContainer').append(personelHtml);
        personelCounter++;
        updateRemoveButtonVisibility();
    }

    function removePersonel(index) {
        const personelCount = $('#resourceContainer .personel-activity-group').length;
        
        if (personelCount > 1) {
            $(`#resource-${index}`).remove();
            updateRemoveButtonVisibility();
            updatePersonelNumbers();
        } else {
            Swal.fire({
                text: "Minimal harus ada 1 personel!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
        }

        personelCounter--;
    }

    function updateRemoveButtonVisibility() {
        const personelCount = $('#resourceContainer .personel-activity-group').length;
        
        // Show/hide remove buttons
        if (personelCount > 1) {
            $('#removePersonelBtn').show();
            $('.remove-personel-btn').show();
        } else {
            $('#removePersonelBtn').hide();
            $('.remove-personel-btn').hide();
        }
    }

    function updatePersonelNumbers() {
        $('#resourceContainer .personel-activity-group').each(function(index) {
            $(this).find('.card-title').text(`Personel ${index + 1}`);
            $(this).find('.card-footer small').text(`Personel Activity #${index + 1}`);
        });
    }

    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // document.addEventListener("DOMContentLoaded", function () {
    //     const scrollBottomBtn = document.getElementById("kt_scrollbottom_button");
    //     const closeScrollBottom = document.getElementById("closeScrollBottom");

    //     // Tombol muncul langsung
    //     scrollBottomBtn.style.display = "flex";

    //     // Klik panah scroll ke bawah
    //     scrollBottomBtn.addEventListener("click", function (e) {
    //         if (e.target.id !== "closeScrollBottom" && !closeScrollBottom.contains(e.target)) {
    //             const secondTable = document.getElementById('mandaysSummaryTable')
    //             if(secondTable){
    //                 window.scrollTo({
    //                     top: secondTable.offsetTop,
    //                     behavior:'smooth'
    //                 });
    //                 scrollBottomBtn.style.display="none";
    //             }else{
    //                 window.scrollTo({
    //                     top: document.body.scrollHeight,
    //                     behavior: 'smooth'
    //                 });
    //                 scrollBottomBtn.style.display="none";
    //             }
    //         }
    //     });

    //     // Tutup tombol
    //     closeScrollBottom.addEventListener("click", function () {
    //         scrollBottomBtn.style.display = "none";
    //     });
    // });
</script>
@endpush

@php
    function mandaysLabel($plan, $realization) {
        if ($realization == $plan) {
            $bg = '#f5b942';
            $color = 'black';
        }elseif ($realization < $plan) {
            $bg = 'transparent';
            $color = 'black';
        } else {
            $bg = '#dc3545';
            $color = 'white';
        }
        return '<span class="d-inline-block px-3 py-1 text-center" style="border-radius:8px; background:' . $bg . '; color:' . $color . '; min-width:40px; min-height:24px;">' . $realization . '</span>';
    }
@endphp
