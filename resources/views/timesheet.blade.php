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
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6 me-2">
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
            <div class="d-flex justify-content-start">
                <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCard" aria-expanded="false" aria-controls="filterCard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                    </svg>
                    Filter Data
                </button>
            </div>
            <div class="collapse" id="filterCard">
                <div class="card card-flush shadow-lg mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                            </svg>
                            <div class="m-2">
                            Filter Data
                            </div>
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 25px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label fw-bold">Pekan</label>
                                <select class="form-select form-select-solid" id="kategoriFilter" style="cursor: pointer;   ">
                                    <option value="">Pilih Pekan</option>
                                    <option value="management">Pekan ke-1</option>
                                    <option value="awareness">Pekan ke-2</option>
                                    <option value="training">Pekan ke-3</option>
                                    <option value="assessment">Pekan ke-4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="padding: 15px;">
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
            <form class="d-flex justify-content-end align-items-center">
                <label class="me-5 mt-3 mb-0" for="searchTask">Cari: </label>
                <input class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary mt-3" style="width:200px" type="search" placeholder="Cari Data" aria-label="Search">                    
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
                                        <th scope="col" style="width: 30px;">Action</th>
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
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots fs-3 text-dark"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                                    <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                                        <i class="bi bi-pencil ms-1 me-3 text-dark"></i>Edit</a>
                                                    </li>
                                                    <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                                        <i class="bi bi-trash ms-1 me-3 text-dark"></i>Hapus</a>
                                                    </li>
                                                    <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                                        <i class="bi bi-plus fs-2 me-1 text-dark"></i>Tambah Baris di Atas</a>
                                                    </li>
                                                    <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                                        <i class="bi bi-plus fs-2 me-1 text-dark"></i>Tambah Baris di Bawah</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
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
            <div class="col-md-6" style="width: 50%; min-width: 350px;">
                <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#mandaysSummaryTable" aria-expanded="false" aria-controls="mandaysSummaryTable">
                    <i class="bi bi-chevron-down me-2"></i>
                    Lihat Ringkasan Mandays
                </button>
                <div class="collapse" id="mandaysSummaryTable">
                    <table class="table border bordered-gray-300 table-row-bordered table-sm table-row-gray-300 gs-3">
                        <thead>
                            <tr>
                                <th scope="col" colspan="3" class="text-center bg-light">Total Mandays Sementara</th>
                            </tr>
                            <tr>
                                <th scope="col" rowspan="2" class="align-middle">Personel</th>
                                <th scope="col" colspan="2" class="text-center align-middle">Mandays</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Rencana</th>
                                <th class="text-center align-middle">Realisasi</th>                            
                            </tr>
                        </thead>
                        <tbody>
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
        $('#kt_datatable_example_2').DataTable({
            "scrollY": '500px',
            "scrollX": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "ordering": false // Disable sorting
        });
    }

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
