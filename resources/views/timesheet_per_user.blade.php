@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-5 mt-2">Timesheet Activity</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-7">
                <a href="{{route('work-package.detail', $volume->volume_id)}}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <div>
                    <h2 class="my-3 mb-0 mt-1">WP {{ $workPackage->wp_number }} {{ $workPackage->name }}</h2>
                    <div class="mb-2 px-2 rounded-1"  style="background-color: #d7e7f5; color: #1c1f21; width: fit-content;">
                        {{$user->name}}
                        @php
                            // Menggunakan first() untuk mendapatkan role pertama jika ada
                            $roleName = $user->getRoleNames()->get(1) ?? $user->getRoleNames()->first();
                        @endphp
                        <i class="bi bi-info-circle text-primary ms-1"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            title="{{$roleName}}">
                        </i>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-10">
                {{-- <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCard" aria-expanded="false" aria-controls="filterCard" style="padding: 8px 12px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                    </svg>
                    Filter Data
                </button> --}}
                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#addActivityModal" aria-expanded="false" aria-controls="filterCard" style="padding: 8px 12px">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus mb-1 me-2" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5V7.5H11.5a.5.5 0 0 1 0 1H8.5V11.5a.5.5 0 0 1-1 0V8.5H4.5a.5.5 0 0 1 0-1H7.5V4.5A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Tambah Aktivitas
                </button>
                <button type="button" class="btn btn-light-primary" aria-expanded="false" aria-controls="lihatAktivitas" onclick="window.location.href='{{ route('timesheet.detail', [$volume->volume_id]) }}'">
                    Lihat Timesheet Summary
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                    </svg>
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
                                <label class="form-label fw-bold">Bulan</label>
                                <select class="form-select form-select-solid" id="kategoriFilter" style="cursor: pointer;   ">
                                    <option value="">Pilih Bulan</option>
                                    <option value="management">Bulan ke-1</option>
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
            <div class="row mt-4 align-items-center" style="height: 50px; padding: 0px 0px;">
                <div class="col-md-6 d-flex align-items-center" style="height: 40px">
                    <div class="border bg-light h-100 d-flex align-items-center justify-content-center w-100">
                        <span class="fw-bold">Total Mandays</span>
                    </div>
                    <div class="border h-100 d-flex align-items-center justify-content-center w-100"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Rencana"
                    >
                        <span class="text">{{$humanResources->jhk ?? '-'}}</span>
                    </div>
                    <div class="border h-100 d-flex align-items-center justify-content-center w-100"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Realisasi"
                    >
                        <span class="text">{{$activitiesCount}}</span>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end mt-3">
                    <form class="d-flex justify-content-end align-items-center">
                        <label class="me-5 mb-0" for="searchActivityUser">Cari: </label>
                        <div>
                            <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
                                <input 
                                    class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                                    style="width:200px" 
                                    type="search"
                                    id="searchActivityUser" 
                                    placeholder="Cari aktivitas" 
                                    aria-label="Search"
                                >                    
                            </form>
                        </div>                  
                    </form>
                </div>
            </div> 
            <div class="table-responsive mt-5">
                @if($activities->isNotEmpty())
                    <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                        <thead>
                            <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                                <th scope="col" style="width: 40px;">No</th>
                                <th scope="col" style="width: 70px; min-width: 40px;">Tanggal</th>
                                <th scope="col">Aktivitas</th>                       
                                <th scope="col" style="width: 40px;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.92rem;">
                            @foreach($activities as $activity)
                            <tr>
                                <th scope="row">{{$loop->index+1}}</th>
                                <td>{{\Carbon\Carbon::parse($activity->execution_date)->format('d M')}}</td>
                                <td>{{$activity->activity}}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots fs-3 text-dark"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                            <li><a class="dropdown-item d-flex align-items-center edit-activity-btn" href="#" data-bs-toggle="modal" data-bs-target="#editActivityModal" 
                                                data-timesheet-id="{{ $activity->timesheet_id }}"
                                                data-execution-date="{{ $activity->execution_date }}"
                                                data-activity="{{ $activity->activity }}"
                                                >
                                                <i class="bi bi-pencil ms-1 me-3 text-dark"></i>Edit</a>
                                            </li>
                                            <li><a class="dropdown-item d-flex align-items-center text-danger btn-delete-activity" href="#" 
                                                    data-timesheet-id="{{$activity->timesheet_id}}"
                                                    data-activity="{{$activity->activity}}"
                                                >
                                                    <i class="bi bi-trash ms-1 me-3 text-dark"></i>Hapus
                                                </a>
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
</div>
@endsection

{{-- tambah aktivitas --}}
<div class="modal fade" tabindex="-1" id="addActivityModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Aktivitas Timesheet</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('timesheet.user.add', [$volume->volume_id,1])}}" id="addActivityForm">
                    @csrf
                    @method('POST')

                    <div class="form-group mb-6">
                        <label class="form-label fw-bold">Tanggal</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="execution_date" id="execution_date" placeholder="Masukkan Tanggal" min="1" max="31"/>
                        </div>
                    </div>                    
                    <div class="mb-6">
                        <label class="form-label fw-bolder">Aktivitas</label>
                        <textarea class="form-control" id="activity" name="activity" rows="3" placeholder="Aktivitas"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitAddActivitykForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- edit aktivitas --}}
<div class="modal fade" tabindex="-1" id="editActivityModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Aktivitas Timesheet</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('timesheet.user.edit', [$volume->volume_id,1])}}" id="editActivityForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="timesheet_id" id="form_timesheet_id">
                    
                    <div class="form-group mb-6">
                        <label class="form-label fw-bold">Tanggal</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="execution_date" id="executionDate" placeholder="Masukkan Tanggal" min="1" max="31"/>
                        </div>
                    </div>                    
                    <div class="mb-6">
                        <label class="form-label fw-bolder">Aktivitas</label>
                        <textarea class="form-control" id="activityTimesheet" name="activity" rows="3" placeholder="Aktivitas"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitEditActivitykForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let personelCounter = 1;

     // Initialize the DataTable
    $(document).ready(function() {
        initTabelTimesheet();
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
        const searchInput = $('#searchActivityUser');

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

    // add activity
    const addActivityModal = new bootstrap.Modal(document.getElementById('addActivityModal'));
    const submitAddActivitykForm = document.getElementById('submitAddActivitykForm'); // tombol submit
    const addActivityForm = document.getElementById('addActivityForm'); // form

    if (submitAddActivitykForm) {
        submitAddActivitykForm.addEventListener('click', function(e) {
            e.preventDefault();

            const formData = new FormData(addActivityForm);
            const url = addActivityForm.action;

            // Kirim permintaan AJAX
            fetch(url, {
                method: 'POST',
                body: formData, // FormData akan otomatis mengatur Content-Type: multipart/form-data
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Menandai ini adalah permintaan AJAX
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ambil CSRF token
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Jika respons bukan 2xx (misal 422 untuk validasi, 500 untuk error server)
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Terjadi kesalahan saat memproses permintaan.');
                    });
                }
                return response.json(); // Parse respons JSON
            })
            .then(data => {
                // Logika jika permintaan sukses
                Swal.fire({
                    text: data.message || "Data berhasil ditambahkan!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                }).then(() => {
                    addActivityModal.hide(); // Sembunyikan modal
                    location.reload(); // Reload halaman untuk melihat perubahan
                    // ATAU update UI tanpa reload:
                    // updateTableRow(data.data); // Panggil fungsi untuk update baris di tabel utama
                });
            })
            .catch(error => {
                // Logika jika ada error (jaringan, validasi, server error)
                console.error('Error updating resource:', error);
                Swal.fire({
                    text: error.message || "Terjadi kesalahan yang tidak terduga.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-danger" }
                });
            });
        });
    }

    // edit activity
    const editActivityModal = new bootstrap.Modal(document.getElementById('editActivityModal'));
    const submitEditActivitykForm = document.getElementById('submitEditActivitykForm'); // tombol submit
    const editActivityForm = document.getElementById('editActivityForm'); // form

    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            // Pastikan elemen yang diklik adalah tombol edit aktivitas
            if (event.target.closest('.edit-activity-btn')) {
                const button = event.target.closest('.edit-activity-btn');
                // Isi input tersembunyi timesheet_id
                document.getElementById('form_timesheet_id').value = button.dataset.timesheetId;
                document.getElementById('executionDate').value = button.dataset.executionDate;
                document.getElementById('activityTimesheet').value = button.dataset.activity;
            }
        });
    });

    if (submitEditActivitykForm) {
        submitEditActivitykForm.addEventListener('click', function(e) {
            e.preventDefault();

            const formData = new FormData(editActivityForm);
            const url = editActivityForm.action;

            // Kirim permintaan AJAX
            fetch(url, {
                method: 'POST',
                body: formData, // FormData akan otomatis mengatur Content-Type: multipart/form-data
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Menandai ini adalah permintaan AJAX
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ambil CSRF token
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Jika respons bukan 2xx (misal 422 untuk validasi, 500 untuk error server)
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Terjadi kesalahan saat memproses permintaan.');
                    });
                }
                return response.json(); // Parse respons JSON
            })
            .then(data => {
                // Logika jika permintaan sukses
                Swal.fire({
                    text: data.message || "Data berhasil ditambahkan!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-secondary" }
                }).then(() => {
                    editActivityModal.hide(); // Sembunyikan modal
                    location.reload(); // Reload halaman untuk melihat perubahan
                    // ATAU update UI tanpa reload:
                    // updateTableRow(data.data); // Panggil fungsi untuk update baris di tabel utama
                });
            })
            .catch(error => {
                // Logika jika ada error (jaringan, validasi, server error)
                console.error('Error updating resource:', error);
                Swal.fire({
                    text: error.message || "Terjadi kesalahan yang tidak terduga.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-danger" }
                });
            });
        });
    }

    // delete
    $(document).on('click', '.btn-delete-activity', function(e) {
        e.preventDefault();
        const timesheetId = $(this).data('timesheet-id');
        const activity = $(this).data('activity');

        Swal.fire({
            title: "Konfirmasi Hapus Aktivitas",
            html: `
                <span>Apakah Anda yakin ingin menghapus aktivitas:</span>
                <p>${activity}?</p>
                <p class="text-muted"><small>Tindakan ini tidak dapat dibatalkan</small></p>
            `,
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: "Ya, Hapus",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/timesheet-user/${timesheetId}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title:'Berhasil!', 
                            text: data.message, 
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        }).then(() => {
                            // location.reload(); // atau remove baris dari DOM langsung
                            $(`[data-timesheet-id="${timesheetId}"]`).closest('tr').remove();
                        });
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
                });
            }
        });
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
