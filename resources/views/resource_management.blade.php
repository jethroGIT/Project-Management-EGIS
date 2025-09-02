@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Manajemen Sumber Daya Manusia</h1>

    <!-- Card Resource -->
    <div class="card card-flush shadow-sm mb-6">
        <div class="card-body row">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Add Resource Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="bi bi-plus-lg fs-2 me-1"></i>
                        Tambah User
                    </button>
                </div>

                <!-- Search Form -->
                <form class="d-flex justify-content-end mb-4" onsubmit="return false;">
                    <label class="me-5 mt-3" for="searchResourceInput">Cari: </label>
                    <input 
                        class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                        style="width:200px" 
                        type="search"
                        id="searchResourceInput" 
                        placeholder="Cari User" 
                        aria-label="Search"
                    >                    
                </form>
            </div>

            <!-- Resource Table -->
            <div class="table-responsive mb-2">
                <table id="tabel_resource" class="table table-striped gy-4 gs-3 border rounded w-100">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class="align-middle border-bottom">No</th>
                            <th class="align-middle border-bottom min-w-200px">Nama</th>
                            <th class="align-middle border-bottom">Email</th>
                            <th class="align-middle border-bottom">Peran</th>
                            <th class="align-middle border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    // Menggunakan first() untuk mendapatkan role pertama jika ada
                                    $userRoles = $user->getRoleNames();

                                    if ($userRoles->contains('admin')) {
                                        $displayRole = 'admin';
                                    } else {
                                        $displayRole = $userRoles->filter(function($roleName) {
                                            return $roleName !== 'karyawan';
                                        })->first();
                                    }
                                @endphp
                                @if($displayRole)
                                    <span class="badge badge-light badge-lg">
                                        {{$displayRole}}
                                    </span>
                                @else
                                    Belum memiliki peran
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Edit Button -->
                                    <button 
                                        type="button" 
                                        class="btn btn-warning btn-sm" 
                                        title="Edit User"
                                        onClick="editUser({{ $user->user_id }})"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </button>

                                    <!-- Deactivate Button -->
                                    <button type="button" class="btn btn-danger btn-sm" title="Nonaktifkan User">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                            <path d="M7.5 1v7h1V1z"/>
                                            <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="bi bi-people fs-1 text-muted mb-2"></i>
                                    <h6 class="text-muted">Belum Ada User</h6>
                                    <p class="text-muted">Tidak ada data user dalam sistem</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> 

            <!-- Modal Add User -->
            <div class="modal fade" tabindex="-1" id="kt_modal_add_user">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Tambah User</h3>
                            
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>

                        <div class="modal-body">
                            <form id="addUserForm" method="POST" action="{{ route('resource.store') }}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Nama User</label>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required/>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Masukkan email" required/>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Role</label>
                                    <select name="role_id" class="form-select" required>
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="submitAddUser()">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit User -->
            <div class="modal fade" tabindex="-1" id="kt_modal_edit_user">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Edit User</h3>

                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>

                        <div class="modal-body">
                            <form id="editUserForm" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" id="editUserId">

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Nama User</label>
                                    <input type="text" name="name" id="editUserName" class="form-control" placeholder="Masukkan nama lengkap" required/>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" id="editUserEmail" class="form-control" placeholder="Masukkan email" required/>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Peran</label>
                                    <select name="role_id" id="editUserRole" class="form-select" required>
                                        <option value="">Pilih Role</option>
                                        <!-- Akan diisi via JavaScript -->
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Password Baru</label>
                                    <input type="password" name="password" id="editUserPassword" class="form-control" placeholder="Masukkan password baru" minlength="6"/>
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" id="editUserPasswordConfirmation" class="form-control" placeholder="Konfirmasi password baru" minlength="6"/>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="submitEditUser()">
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
    initTabelResource();
})

/**
 * Inisiasi Tabel Resource (User)
 */
function initTabelResource() {
    const table = $('#tabel_resource').DataTable({
        "ordering": true,
        "searching": true,
        "language": {
            "search": "",
            "searchPlaceholder": "Cari User",
            "zeroRecords": "Tidak ada user yang cocok dengan pencarian",
            "emptyTable": "Tidak ada data user"
        },
        "fixedHeader": {
            "header":true,
            "headerOffset": 70
        },
    });

    // Search input to DataTables
    setupResourceSearch(table);
}

/**
 * Function untuk search pada tabel
 */
function setupResourceSearch(table) {
    const searchInput = $('#searchResourceInput');

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

/* MANAJEMEN RESOURCE (USER) */
/**
 * Function untuk edit user
 */
function editUser(userId) {
    console.log('Edit user with ID: ', userId);

    // Get user data via AJAX
    $.ajax({
        url: `/resource-management/${userId}/edit`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Memuat Data...',
                text: 'Sedang mengambil data user',
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
                // Populate modal dengan data user
                $('#editUserId').val(response.user.user_id);
                $('#editUserName').val(response.user.name);
                $('#editUserEmail').val(response.user.email);
                
                // Clear dan populate role dropdown
                const roleSelect = $('#editUserRole');
                roleSelect.empty();
                roleSelect.append('<option value="">Pilih Role</option>');
                
                response.roles.forEach(function(role) {
                    const selected = role.id == response.user.role_id ? 'selected' : '';
                    roleSelect.append(`<option value="${role.id}" ${selected}>${role.name}</option>`);
                });
                
                // Clear password fields
                $('#editUserPassword').val('');
                $('#editUserPasswordConfirmation').val('');
                
                // Set form action
                $('#editUserForm').attr('action', `/resource-management/${userId}`);
                
                // Show modal
                $('#kt_modal_edit_user').modal('show');

            } else {
                Swal.fire({
                    title: "Gagal",
                    text: response.message || "Gagal mengambil data user",
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

            let errorMessage = "Terjadi kesalahan saat mengambil data user";

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
 * Function untuk submit edit user form
 */
function submitEditUser() {
    const form = $('#editUserForm');
    const userId = $('#editUserId').val();

    // Validasi form
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return;
    }

    // Validasi password confirmation
    const password = $('#editUserPassword').val();
    const passwordConfirmation = $('#editUserPasswordConfirmation').val();

    if (password && password !== passwordConfirmation) {
        Swal.fire({
            title: "Validasi Error",
            text: "Password dan konfirmasi password tidak cocok",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
                confirmButton: "btn btn-secondary"
            }
        });
        return;
    }

    // Create FormData
    const formData = new FormData(form[0]);
    
    console.log('Updating user with ID:', userId);

    // Get original data untuk debugging
    const originalData = {
        name: $('#editUserName').data('original') || $('#editUserName').val(),
        email: $('#editUserEmail').data('original') || $('#editUserEmail').val(),
        role_id: $('#editUserRole').data('original') || $('#editUserRole').val()
    };

    console.log('Original data:', originalData);
    console.log('New data:', {
        name: $('#editUserName').val(),
        email: $('#editUserEmail').val(),
        role_id: $('#editUserRole').val(),
        password_filled: password ? 'Yes' : 'No'
    });

    $.ajax({
        url: `/resource-management/${userId}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Disable form elements
            form.find('input, select, button').prop('disabled', true);
            
            Swal.fire({
                title: 'Memperbarui User...',
                text: 'Sedang memproses pembaruan data user',
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
                let successMessage = response.message || "Data berhasil diperbarui!";

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
                    $('#kt_modal_edit_user').modal('hide');
                    window.location.reload();
                });
                
            } else if (response.no_changes) {
                let noChangeMessage = "Tidak ada data yang diubah. Silakan lakukan perubahan terlebih dahulu atau klik Batal.";

                Swal.fire({
                    title: "Tidak Ada Perubahan",
                    text: noChangeMessage,
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
                    text: response.message || "Gagal memperbarui user",
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
            let errorMessage = "Terjadi kesalahan saat memperbarui user";
            
            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // Handle validation errors
                if (xhr.responseJSON.errors) {
                    const errors = Object.entries(xhr.responseJSON.errors)
                        .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                        .join('\n');
                    errorMessage += '\n\nValidation Errors:\n' + errors;
                }
            }

            Swal.fire({
                title: "Gagal Memperbarui User",
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
            form.find('input, select, button').prop('disabled', false);
        }
    });
}

/**
 * Function untuk submit add user form
 */
function submitAddUser() {
    const form = $('#addUserForm');

    // Basic validation
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
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
        beforedSend: function() {
            form.find('input, select, button').prop('disabled', true);

            Swal.fire({
                title: 'Menambahkan User...',
                text: 'Sedang memproses penambahan user baru',
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
                    title: "Berhasil ditambahkan",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    window.location.reload();
                });
                
                $('#kt_modal_add_user').modal('hide');

            } else {
                Swal.fire({
                    title: "Gagal",
                    text: response.message || "Gagal menambahkan user",
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
            let errorMessage = "Terjadi kesalahan saat menambahkan user";

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                if (xhr.responseJSON.errors) {
                    const errors = Object.entries(xhr.responseJSON.errors)
                        .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                        .join('\n');
                    errorMessage += '\n\nValidation Errors:\n' + errors;
                }
            }

            Swal.fire({
                title: "Gagal Menambahkan User",
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
            form.find('input, select, button').prop('disabled', false);
        }
    });
}
</script>
@endpush