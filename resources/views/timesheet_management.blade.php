@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Manajemen Timesheet</h1>

    <!-- Card Activity -->
     <div class="card card-flush shadow-sm">
        <div class="card-body row">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Add Activity Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                        <i class="bi bi-plus-lg fs-2 me-1"></i>
                        Tambah Aktivitas
                    </button>
                </div>

                <!-- Search Form -->
                <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
                    <label class="me-5 mt-3" for="searchActivity">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search"
                        id="searchActivity" 
                        placeholder="Cari Aktivitas" 
                        aria-label="Search"
                    >                    
                </form>
            </div>

            <!-- Activity Table -->
            <div class="table-responsive mb-2">
                <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="tabel_aktivitas">
                    <thead>
                        <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                            <th scope="col" style="display: none;">WP Group Key</th> {{-- Ini untuk WP Number dan WP Name --}}

                            <th scope="col" style="width: 30px;">No</th>
                            <th scope="col" style="width: 30px;">Vol</th>
                            <th scope="col" style="width: 75px; min-width: 40px;">Tanggal</th>
                            @foreach($users as $user)
                                <th scope="col" style="width: 80px;">
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{$user->role->name}}">{{$user->name}}</span>
                                </th>     
                            @endforeach
                            <th scope="col" style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @foreach($activitiesForTable as $activity)
                            @php
                                $wpNumber = optional($activity->volume->workPackage)->wp_number ?? 'N/A';
                                $wpName = optional($activity->volume->workPackage)->name ?? 'N/A';
                                $volumeNum = optional($activity->volume)->volume_number ?? 'N/A';
                                $executionDate = optional($activity)->execution_date;
                            @endphp
                            <tr>
                                {{-- Data untuk Kolom Tersembunyi (digunakan oleh RowGroup) --}}
                                <td>{{ $wpNumber }} {{$wpName}}</td>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $volumeNum }}</td> {{-- Data Volume tampil di kolom ini --}}
                                <td>{{ \Carbon\Carbon::parse($executionDate)->format('d M Y') }}</td>
                                @foreach($users as $user)
                                    @php
                                        // Untuk mendapatkan aktivitas user spesifik pada tanggal ini,
                                        // Anda perlu mencari dalam koleksi $activitiesForTable untuk tanggal dan user yang sama.
                                        // Karena $activitiesForTable adalah koleksi flat, Anda perlu logic pencarian.
                                        $userEntryForThisDateAndUser = $activitiesForTable->filter(function($entry) use ($activity, $user){
                                            return $entry->execution_date == $activity->execution_date && $entry->user_id == $user->user_id;
                                        })->first();
                                    @endphp
                                    <td>{{ $userEntryForThisDateAndUser->activity ?? '-' }}</td>
                                @endforeach
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning btn-sm btn-edit-category" title="Edit User" 
                                                {{-- data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category"
                                                data-category-id="{{$wpCategory->category_id}}" 
                                                data-category-name="{{$wpCategory->name}}" --}}
                                        >
                                            <i class="bi bi-pencil-square fs-6"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm btn-delete-category" title="Nonaktifkan User" 
                                                {{-- data-category-id="{{$wpCategory->category_id}}" --}}
                                        >
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </div>                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
</div>
@endsection

{{-- tambah aktivitas --}}
<div class="modal fade" tabindex="-1" id="addActivityModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola Aktivitas Timesheet</h3>
            </div>
            <div class="modal-body">
                <form>
                    {{-- method="POST" action="{{route('timesheet.user.add', [$volume->volume_id,1])}}" id="addActivityForm" --}}
                    @csrf
                    @method('POST')

                    <div class="form-group mb-6">
                        <label for="work_package_select" class="form-label fw-bold">Work Package</label>
                        <div class="input-group">
                            <select class="form-select form-select-solid" name="work_package_id" id="work_package_select">
                                <option value="">Pilih Work Package</option>
                                {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                @foreach($uniqueWorkPackages as $wp)
                                    <option value="{{ $wp->wp_id }}">{{ $wp->wp_number }} {{ $wp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="volume_select" class="form-label fw-bold">Volume</label>
                                <div class="input-group">
                                    <select class="form-select form-select-solid" name="work_package_id" id="work_package_select">
                                        <option value="">Pilih Volume</option>
                                        {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                        @foreach($uniqueVolumes as $vol)
                                            <option value="{{ $vol->volume_id }}">{{ $vol->volume_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" name="execution_date" id="execution_date" placeholder="Masukkan Tanggal" min="1" max="31"/>
                            </div>
                        </div>
                    </div>

                    <div id="personelActivityContainer">
                        <template id="personelActivityTemplate">
                            <div class="card card-flush shadow-sm mb-6">
                                <div class="card-body">
                                    <div class="form-group mb-6">
                                        <label for="personel_select" class="form-label fw-bold">Personel</label>
                                        <div class="input-group">
                                            <select class="form-select form-select-solid" name="work_package_id" id="work_package_select">
                                                <option value="">Pilih Personel</option>
                                                {{-- Loop melalui koleksi Work Package yang tersedia dari controller --}}
                                                @foreach($users as $user)
                                                    <option value="{{ $user->user_id }}">{{ $user->name }} - {{$user->role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="form-group mb-6">
                                        <label class="form-label fw-bold">Aktivitas</label>
                                        <textarea class="form-control" id="activity" name="activity" rows="2" placeholder="Aktivitas" required></textarea>
                                    </div>                    
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="d-flex justify-content-start mb-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Tambah Aktivitas Personel
                        </button>
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

{{-- 1. work package yg mana? dropdown
2. volume berapa? dropdown
3. mau isi aktivitas siapa?
	isi tanggal
	pilih pekerja yang kerja di wp volume yang dipilih
	isi aktivitasnya
	(bisa isi lebih dari 1 orang pekerja) --}}

{{-- edit kategori --}}
{{-- <div class="modal fade" tabindex="-1" id="kt_modal_edit_category">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola Kategori Work Package</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('wpcategory.edit')}}" id="editCategoryForm">
                    @csrf
                    @method('PUT') 
                    <input type="hidden" name="category_id" id="form_category_id">
                    <div class="mb-6">
                        <label class="form-label fw-bolder">Kategori WP</label>
                        <input class="form-control" id="categoryName" name="name" placeholder="Kategori"></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitEditCategoryForm">Simpan</button>
            </div>
        </div>
    </div>
</div> --}}

@push('scripts')
<script>
     // Initialize the DataTable
    $(document).ready(function() {
        initTabelTimesheet();
    });

    function initTabelTimesheet() {
        const table = $('#tabel_aktivitas').DataTable({
            "scrollY": '350px',
            "scrollX": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "rowGroup": {
                // dataSrc bisa berupa array indeks kolom untuk multiple grouping levels
                dataSrc: [0], // Menggunakan kolom indeks 0 (WP Group Key) dan 1 (Volume Group Key)

                // Render header untuk setiap grup
                startRender: function (rows, group, level) {
                    return $('<tr/>')
                        .append('<td colspan="' + rows.columns()[0].length + '" class="bg-light text-dark fw-bold">' + group + '</td>')
                        .addClass('wp-group-header');                    
                }
            },
            // Kolom definisi: Sembunyikan kolom yang digunakan untuk grouping
            "columnDefs": [
                { "visible": false, "targets": [0] }, // Sembunyikan kolom WP Group Key (index 0) dan Volume Group Key (index 1)
            ]
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

    // Modal and form handling for adding a new category
    const addCategoryModal = new bootstrap.Modal(document.getElementById('kt_modal_add_category'));
    const submitAddCategoryForm = document.getElementById('submitAddCategoryForm');
    const addCategoryForm = document.getElementById('addCategoryForm');

    document.addEventListener('DOMContentLoaded', function () {
        if (submitAddCategoryForm) {
            submitAddCategoryForm.addEventListener('click', function (e) {
                e.preventDefault();

                const formData = new FormData(addCategoryForm);
                const url = addCategoryForm.action;

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Terjadi kesalahan saat memproses permintaan.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            text: data.message || "Data berhasil ditambahkan!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        }).then(() => {
                            addCategoryModal.hide();
                            location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error adding category:', error);
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
    });

    // Modal and form handling for editing a new category
    const editCategoryModal = new bootstrap.Modal(document.getElementById('kt_modal_edit_category'));
    const submitEditCategoryForm = document.getElementById('submitEditCategoryForm');
    const editCategoryForm = document.getElementById('editCategoryForm');

    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            // Pastikan elemen yang diklik adalah tombol edit aktivitas
            if (event.target.closest('.btn-edit-category')) {
                const button = event.target.closest('.btn-edit-category');
                // Isi input tersembunyi timesheet_id
                document.getElementById('form_category_id').value = button.dataset.categoryId;
                document.getElementById('categoryName').value = button.dataset.categoryName;

                console.log("Button Data:", {
                id: button.dataset.categoryId,
                name: button.dataset.categoryName,
            });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        if (submitEditCategoryForm) {
            submitEditCategoryForm.addEventListener('click', function (e) {
                e.preventDefault();

                const formData = new FormData(editCategoryForm);
                const url = editCategoryForm.action;

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Terjadi kesalahan saat memproses permintaan.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            text: data.message || "Data berhasil diubah!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        }).then(() => {
                            addCategoryModal.hide();
                            location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error adding category:', error);
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
    });

    // delete category
    $(document).on('click', '.btn-delete-category', function(e) {
        e.preventDefault();
        const categoryId = $(this).data('category-id');

        Swal.fire({
            title: 'Yakin ingin menghapus kategori?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/wpcategory-management/${categoryId}/delete`, {
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
                            $(`[data-category-id="${categoryId}"]`).closest('tr').remove();
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
