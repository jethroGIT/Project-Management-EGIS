@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Manajemen Work Package</h1>

    <!-- Card Category -->
     <div class="card card-flush shadow-sm">
        <div class="card-body row">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Add Category Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category">
                        <i class="bi bi-plus-lg fs-2 me-1"></i>
                        Tambah Kategori WP
                    </button>
                </div>

                <!-- Search Form -->
                <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
                    <label class="me-5 mt-3" for="searchCategory">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search"
                        id="searchCategory" 
                        placeholder="Cari Kategori" 
                        aria-label="Search"
                    >                    
                </form>
            </div>

            <!-- Category Table -->
            <div class="table-responsive mb-2">
                <table id="tabel_category" class="table table-striped table-hover gy-4 gs-3 border rounded w-100">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class="align-middle border-bottom text-center">No</th>
                            <th class="align-middle border-bottom" style="min-width: 110px">No. Kategori</th>
                            <th class="align-middle border-bottom">Kategori</th>
                            <th class="align-middle border-bottom" style="width: 140px">Action</th>
                        </tr>
                    </thead>
                     <tbody style="font-size: 0.92rem;">
                        @forelse($wpCategories as $wpCategory)
                        <tr>
                            <th scope="row" class="align-middle text-center">{{$loop->index+1}}</th>
                            <td class="align-middle text-center">{{$wpCategory->category_number}}</td>
                            <td class="align-middle">{{$wpCategory->name}}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-warning btn-sm btn-edit-category" title="Edit Kategori WP" 
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category"
                                            data-category-id="{{$wpCategory->category_id}}" 
                                            data-category-number="{{$wpCategory->category_number}}"
                                            data-category-name="{{$wpCategory->name}}"
                                    >
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-category" title="Hapus Kategori WP" 
                                            data-category-id="{{$wpCategory->category_id}}"
                                            data-category-name="{{$wpCategory->name}}"
                                    >
                                        <i class="bi bi-trash fs-6"></i>
                                    </button>
                                </div>                                    
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="bi bi-people fs-1 text-muted mb-2"></i>
                                    <h6 class="text-muted">Belum Ada Kategori WP</h6>
                                    <p class="text-muted">Tidak ada data kategori WP dalam sistem</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse          
                    </tbody>                
                </table>
            </div> 
        </div>
    </div>
</div>
@endsection

{{-- tambah kategori --}}
<div class="modal fade" tabindex="-1" id="kt_modal_add_category">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Kategori WP</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('wpcategory.add')}}" id="addCategoryForm">
                    @csrf
                    @method('POST')   
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label fw-bolder">No. Kategori</label>
                            <input type="number" class="form-control" id="category_number" name="category_number" min="1"></input>
                        </div>                
                        <div class="col-md-9">
                            <label class="form-label fw-bolder">Kategori WP</label>
                            <input class="form-control" id="name" name="name" placeholder="Kategori"></input>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitAddCategoryForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- edit kategori --}}
<div class="modal fade" tabindex="-1" id="kt_modal_edit_category">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Kategori WP</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('wpcategory.edit')}}" id="editCategoryForm">
                    @csrf
                    @method('PUT') 
                    <input type="hidden" name="category_id" id="form_category_id">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label fw-bolder">No. Kategori</label>
                            <input type="number" class="form-control" id="categoryNumber" name="category_number" min="1"></input>
                        </div>                
                        <div class="col-md-9">
                            <label class="form-label fw-bolder">Kategori WP</label>
                            <input class="form-control" id="categoryName" name="name" placeholder="Kategori"></input>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitEditCategoryForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
     // Initialize the DataTable
    $(document).ready(function() {
        initTabelTimesheet();
    });

    function initTabelTimesheet() {
        const table = $('#tabel_category').DataTable({
            // "scrollY": '500px',
            "scrollX": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "ordering": false // Disable sorting
        });

        setupCategorySearch(table);
    }

    function setupCategorySearch(table) {
        const searchInput = $('#searchCategory');

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
    $(document).ready(function () {
        const addCategoryModal = new bootstrap.Modal(document.getElementById('kt_modal_add_category'));
        const addCategoryForm = $('#addCategoryForm');
        const submitAddCategoryForm = $('#submitAddCategoryForm');

        submitAddCategoryForm.on('click', function (e) {
            e.preventDefault();

            // Validasi manual
            const categoryNumber = $('#category_number').val().trim();
            const categoryName = $('#name').val().trim();

            if (!categoryNumber || !categoryName) {
                Swal.fire({
                    title: "Data Belum Lengkap",
                    text: "Nomor Kategori & Kategori Work Package wajib diisi.",
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-primary" }
                });
                return;
            }
            if (parseInt(categoryNumber) <= 0) {
                Swal.fire({
                    title: "Nomor Kategori Tidak Valid",
                    text: "Nomor Kategori harus berupa angka positif.",
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: { confirmButton: "btn btn-primary" }
                });
                return;
            }

            // Siapkan FormData
            const formData = new FormData(addCategoryForm[0]);

            $.ajax({
                url: addCategoryForm.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // Disable form elements
                    addCategoryForm.find('input, button').prop('disabled', true);

                    Swal.fire({
                        title: 'Menambahkan Kategori...',
                        text: 'Sedang memproses penambahan kategori baru',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                },
                success: function (response) {
                    if (response.success || response.message) {
                        Swal.fire({
                            title: "Berhasil Ditambahkan",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        }).then(() => {
                            addCategoryModal.hide();
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal",
                            text: response.message || "Gagal menambahkan kategori",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Tutup",
                            customClass: { confirmButton: "btn btn-secondary" }
                        });
                    }
                },
                error: function (xhr) {
                    let errorMessage = "Terjadi kesalahan saat menambahkan kategori";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: "Gagal Menambahkan Kategori",
                        text: errorMessage,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: { confirmButton: "btn btn-secondary" }
                    });
                },
                complete: function () {
                    // Enable form elements
                    addCategoryForm.find('input, button').prop('disabled', false);
                }
            });
        });
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
                document.getElementById('categoryNumber').value = button.dataset.categoryNumber;
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
                            title: "Berhasil",
                            text: data.message || "Data berhasil diperbarui!",
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
        const categoryName = $(this).data('category-name');

        Swal.fire({
            title: "Konfirmasi Hapus Kategori WP",
            html: `
                <span>Apakah Anda yakin ingin menghapus kategori:</span>
                <p>${categoryName}?</p>
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
