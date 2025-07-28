@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Manajemen Sumber Daya Manusia</h1>

    <!-- Card Resource -->
     <div class="card card-flush shadow-sm">
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
                        <tr class="fw-bolder fs-4 text-gray-1000 px-7">
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
                                <span class="badge badge-light badge-lg">
                                    {{ $user->role->name ?? 'No Role' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-warning btn-sm" title="Edit User">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </button>

                                    <!-- Deactivate Button -->
                                    <button type="button" class="btn btn-danger btn-sm" title="Nonaktifkan User">
                                        <i class="bi bi-power fs-6"></i>
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
                        <!-- <tr class="align-middle">
                            <td>2</td>
                            <td>Restia</td>
                            <td>restia123@gmail.com</td>
                            <td>Senior Consultant</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-warning btn-sm" title="Edit User">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" title="Nonaktifkan User">
                                        <i class="bi bi-power fs-6"></i>
                                    </button>
                                </div>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
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
</script>
@endpush