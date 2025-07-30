@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Manajemen Peran</h1>

    <!-- Card Roles -->
    <div class="card card-flush shadow-sm mb-6">
        <div class="card-body row">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Add Resource Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                        <i class="bi bi-plus-lg fs-2 me-1"></i>
                        Tambah Peran
                    </button>
                </div>

                <!-- Search Form -->
                <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
                    <label class="me-5 mt-3" for="searchRoleInput">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search"
                        id="searchRoleInput" 
                        placeholder="Cari Peran" 
                        aria-label="Search"
                    >                    
                </form>
            </div>

            <!-- Role Table -->
            <div class="table-responsive mb-2">
                <table id="tabel_role" class="table table-striped gy-4 gs-3 border rounded w-100">
                    <thead>
                        <tr class="fw-bolder fs-4 text-gray-1000 px-7">
                            <th class="align-middle border-bottom">No</th>
                            <th class="align-middle border-bottom min-w-200px">Nama Peran</th>
                            <th class="align-middle border-bottom">Singkatan</th>
                            <th class="align-middle border-bottom min-w-200px">Biaya Tenaga Kerja</th>
                            <th class="align-middle border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $index => $role)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->desc ?? 'N/A' }}</td>
                            <td>Rp{{ number_format($role->resource_cost, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Edit Button -->
                                    <button 
                                        type="button" 
                                        class="btn btn-warning btn-sm" 
                                        title="Edit Peran"
                                        onClick="editRole({{ $role->role_id }})"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button 
                                        type="button" 
                                        class="btn btn-danger btn-sm" 
                                        title="Hapus Peran"
                                        onClick="deleteRoleConfirmation({{ $role->role_id }}, '{{ addslashes($role->name) }}')"
                                    >
                                        <!-- <i class="bi bi-power fs-6"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-fill-check text-muted mb-2" viewBox="0 0 16 16">
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                        <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                                    </svg>
                                    <h6 class="text-muted">Belum Ada Data Peran</h6>
                                    <p class="text-muted">Tidak ada data peran dalam sistem</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modal Add Role -->
            <div class="modal fade" tabindex="-1" id="kt_modal_add_role">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Tambah Peran</h3>
                            
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>

                        <div class="modal-body">
                            <form id="addRoleForm" method="POST" action="{{ route('roles.store') }}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Nama Peran</label>
                                    <input type="text" name="name" id="addRoleName" class="form-control" placeholder="Masukkan nama peran" required maxlength="30"/>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Nama Alternatif (Opsional)</label>
                                    <input type="text" name="alt_name" id="addRoleAltName" class="form-control" placeholder="Contoh: Manajer Proyek" maxlength="30"/>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Singkatan (Opsional)</label>
                                    <input type="text" name="desc" id="addRoleDesc" class="form-control" placeholder="Contoh: PM" maxlength="10"/>
                                    <div class="form-text text-muted">Singkatan atau kode peran (maksimal 10 karakter)</div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Biaya Tenaga Kerja</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" name="resource_cost" id="addRoleCost" class="form-control" placeholder="0" required/>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="submitAddRole()">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Role -->
            <div class="modal fade" tabindex="-1" id="kt_modal_edit_role">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Edit Peran</h3>
                            
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>

                        <div class="modal-body">
                            <form id="editRoleForm" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role_id" id="editRoleId" value="">
                                
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Nama Peran</label>
                                    <input type="text" name="name" id="editRoleName" class="form-control" placeholder="Masukkan nama peran" required maxlength="30"/>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Nama Alternatif (Opsional)</label>
                                    <input type="text" name="alt_name" id="editRoleAltName" class="form-control" placeholder="Contoh: Manajer Proyek" maxlength="30"/>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Singkatan (Opsional)</label>
                                    <input type="text" name="desc" id="editRoleDesc" class="form-control" placeholder="Contoh: PM" maxlength="10"/>
                                    <div class="form-text text-muted">Singkatan atau kode peran (maksimal 10 karakter)</div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Biaya Tenaga Kerja</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" name="resource_cost" id="editRoleCost" class="form-control" placeholder="0" required/>
                                    </div>
                                </div>

                                <!-- Warning untuk perubahan resource cost -->
                                <div class="alert alert-light-warning d-flex align-items-center mb-4">
                                    <i class="bi bi-exclamation-triangle me-2 text-warning fs-4"></i>
                                    <div>
                                        <strong>Perhatian</strong><br>
                                        <span class="text-muted">Perubahan biaya tenaga kerja akan mempengaruhi perhitungan finansial proyek yang sedang berjalan</span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-warning" onclick="submitEditRole()">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initTabelRole();
})

/**
 * Inisiasi Tabel Role
 */
function initTabelRole() {
    const table = $('#tabel_role').DataTable({
        "ordering": true,
        "searching": true,
        "language": {
            "search": "",
            "searchPlaceholder": "Cari Peran",
            "zeroRecords": "Tidak ada data peran yang cocok dengan pencarian",
            "emptyTable": "Tidak ada data peran"
        },
        "fixedHeader": {
            "header":true,
            "headerOffset": 70
        },
    });

    // Search input to DataTables
    setupRoleSearch(table);
}

/**
 * Function untuk search pada tabel
 */
function setupRoleSearch(table) {
    const searchInput = $('#searchRoleInput');

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

/* MANAJEMEN PERAN (ROLE) */
/**
 * Function untuk submit add role form
 */
function submitAddRole() {
    const form = $('#addRoleForm');

    // Basic validation
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return;
    }

    // Additional validation
    const name = $('#addRoleName').val().trim();
    const resourceCost = $('#addRoleCost').val().trim();

    if (!name) {
        Swal.fire({
            title: "Validasi Error",
            text: "Field wajib harus diisi",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    const formData = new FormData(form[0]);

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Disable form elements
            form.find('input, button').prop('disabled', true);

            Swal.fire({
                title: 'Menambahkan Peran...',
                text: 'Sedang memproses penambahan peran baru',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: "Berhasil Ditambahkan",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    $('#kt_modal_add_role').modal('hide');
                    window.location.reload();
                });

            } else {
                Swal.fire({
                    title: "Gagal",
                    text: response.message || "Gagal menambahkan peran",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat menambahkan peran";

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                if (xhr.responseJSON.errors) {
                    const errors = Object.entries(xhr.responseJSON.errors)
                        .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                        .join('\n');
                    // errorMessage += '\n\nValidation Errors:\n' + errors;
                }
            }

            Swal.fire({
                title: "Gagal Menambahkan Peran",
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        },
        complete: function() {
            // Re-enable form elements
            form.find('input, button').prop('disabled', false);
        }
    });
}

/**
 * Function untuk edit role
 */
function editRole(roleId) {
    // Validasi parameter
    if (!roleId) {
        Swal.fire({
            title: "Error",
            text: "ID peran tidak valid",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Get role data via AJAX
    $.ajax({
        url: `/roles-management/${roleId}/edit`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Memuat Data...',
                text: 'Sedang mengambil data peran',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            Swal.close();
            
            if (response.success) {
                // Populate modal dengan data role
                $('#editRoleId').val(response.role.role_id);
                $('#editRoleName').val(response.role.name);
                $('#editRoleAltName').val(response.role.alt_name || '');
                $('#editRoleDesc').val(response.role.desc || '');
                $('#editRoleCost').val(response.role.resource_cost);
                
                // Set form action
                $('#editRoleForm').attr('action', `/roles-management/${roleId}`);
                
                // Show modal
                $('#kt_modal_edit_role').modal('show');

            } else {
                Swal.fire({
                    title: "Gagal",
                    text: response.message || "Gagal mengambil data peran",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            Swal.close();

            let errorMessage = "Terjadi kesalahan saat mengambil data peran";

            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }

            Swal.fire({
                title: "Error",
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        }
    });
}

/**
 * Function untuk submit edit role form
 */
function submitEditRole() {
    const form = $('#editRoleForm');
    const roleId = $('#editRoleId').val();

    // Validasi form
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return;
    }

    // Validasi roleId
    if (!roleId) {
        Swal.fire({
            title: "Error",
            text: "ID peran tidak ditemukan",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Additional validation
    const name = $('#editRoleName').val().trim();
    const resourceCost = $('#editRoleCost').val().trim();

    if (!name || !resourceCost) {
        Swal.fire({
            title: "Validasi Error",
            text: "Semua field wajib harus diisi",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Create Form Data
    const formData = new FormData(form[0]);

    $.ajax({
        url: `/roles-management/${roleId}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Disable form elements
            form.find('input, button').prop('disabled', true);
            
            Swal.fire({
                title: 'Memperbarui Peran...',
                text: 'Sedang memproses pembaruan data peran',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            if (response.success) {
                let successMessage = response.message || "Peran berhasil diperbarui!";

                Swal.fire({
                    title: "Berhasil",
                    text: successMessage,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    $('#kt_modal_edit_role').modal('hide');
                    window.location.reload();
                });

            } else if (response.no_changes) {
                Swal.fire({
                    title: "Tidak Ada Perubahan",
                    text: "Tidak ada data yang diubah. Silakan lakukan perubahan terlebih dahulu atau klik Batal.",
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    }
                });

            } else {
                Swal.fire({
                    title: "Gagal",
                    text: response.message || "Gagal memperbarui peran",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan saat memperbarui peran";

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                if (xhr.responseJSON.errors) {
                    const errors = Object.entries(xhr.responseJSON.errors)
                        .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                        .join('\n');
                    // errorMessage += '\n\nValidation Errors:\n' + errors;
                }
            }

            Swal.fire({
                title: "Gagal Memperbarui Peran",
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        },
        complete: function() {
            // Re-enable form elements
            form.find('input, button').prop('disabled', false);
        }
    });
}

/**
 * Function konfirmasi delete role
 */
function deleteRoleConfirmation(roleId, roleName) {
    // Validasi parameter
    if (!roleId || !roleName) {
        Swal.fire({
            title: "Error",
            text: "Data peran tidak valid",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Konfirmasi delete
    Swal.fire({
        title: "Konfirmasi Hapus Peran",
        html: `
            <p>Apakah Anda yakin ingin menghapus peran:</p>
            <div class="my-3">
                <strong>${roleName}</strong>
            </div>
            <p class="text-muted"><small>Tindakan ini tidak dapat dibatalkan</small></p>
        `,
        icon: "warning",
        buttonsStyling: false,
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: "Ya, Hapus Peran",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            deleteRole(roleId, roleName);
        }
    });
}

/**
 * Function untuk melakukan delete role
 */
function deleteRole(roleId, roleName) {
    $.ajax({
        url: `/roles-management/${roleId}`,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        beforeSend: function() {
            // Menampilkan loading
            Swal.fire({
                title: 'Menghapus Peran...',
                html: `Sedang memproses penghapusan peran <strong>${roleName}</strong>`,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            console.log('Delete Success Response: ', response);

            if (response.success) {
                Swal.fire({
                    title: 'Berhasil Dihapus',
                    html: `
                        <p>Peran <strong>${roleName}</strong> berhasil dihapus.</p>
                    `,
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'Tutup',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                }).then(() => {
                    window.location.reload();
                });
            } else {
                // Handle business logic errors
                let errorIcon = "error";
                let errorTitle = "Gagal Menghapus Peran";
                
                if (response.has_users) {
                    errorIcon = "warning";
                    errorTitle = "Peran Masih Digunakan";
                }

                Swal.fire({
                    title: errorTitle,
                    text: response.message || "Terjadi kesalahan saat menghapus peran",
                    icon: errorIcon,
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        },
        error: function(xhr) {
            console.log('Delete Error Response:', xhr);
            
            let errorTitle = "Gagal Menghapus Peran";
            let errorMessage = "Terjadi kesalahan saat menghapus peran";
            let iconType = "error";

            if (xhr.status === 404) {
                errorTitle = "Peran Tidak Ditemukan";
                errorMessage = "Peran yang ingin dihapus tidak ditemukan dalam sistem";
            } else if (xhr.status === 400 && xhr.responseJSON) {
                // Business logic error (role still in use)
                errorTitle = "Peran Masih Digunakan";
                errorMessage = xhr.responseJSON.message || errorMessage;
                iconType = "warning";
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }

            Swal.fire({
                title: errorTitle,
                text: errorMessage,
                icon: iconType,
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
        }
    });
}
</script>
@endpush