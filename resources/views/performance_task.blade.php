@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-10 mt-2">Performance Task</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-10">
                <a href="{{ route('work-package.detail', ['volume_id' => $volume_id ?? 1]) }}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <h2 class="my-3 mb-3">
                    @if(isset($workPackage))
                        WP {{ $workPackage->wp_number }} {{ $workPackage->name }}
                    @else
                        WP tidak diketahui
                    @endif
                </h2>
            </div>
            <div class="justify-content-between row mb-3">
                <div class="row mb-3 align-items-center" style="height: 50px; padding: 0px 10px;">
                    <div class="col-md-4 d-flex align-items-center" style="height: 40px">
                        <div class="border bg-light h-100 d-flex align-items-center justify-content-center w-100">
                            <span class="fw-bold">Total % Complete</span>
                        </div>
                        <div class="border h-100 d-flex align-items-center justify-content-center w-100">
                            <span class="text">{{ $totalCompletion ?? 0 }}%</span>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <form class="d-flex align-items-center mb-0">
                            <label class="me-3" for="searchTask">Cari: </label>
                            <input 
                                id="searchInput"
                                class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" 
                                style="width:200px" 
                                type="search" 
                                placeholder="Cari Data" 
                                aria-label="Search"
                            >
                        </form>
                    </div>
                </div> 
            </div>
            <div class="table-responsive">
                <table class="table border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="table_performance_task">
                    <thead>
                        <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                            <th scope="col" style="width: 20px;"></th>
                            <th scope="col" style="width: 70px;">Status</th>
                            <th scope="col" style="width: 170px;">Task</th>
                            <th scope="col" style="width: 170px;">Sub Task</th>
                            <th scope="col" style="width: 90px;">% Utilisasi</th>
                            <th scope="col" style="width: 50px;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.92rem;">
                        @php
                            function statusLabel($status) {
                                $status = strtolower($status);
                                if ($status === 'open') {
                                    return '<span class="d-inline-block text-white px-3 py-1" style="border-radius:8px; background:#48c837; min-width:60px; min-height:24px; text-align:center;">Open</span>';
                                } elseif ($status === 'closed') {
                                    return '<span class="d-inline-block text-white px-3 py-1" style="border-radius:8px; background:#6c757d; min-width:60px; min-height:24px; text-align:center;">Closed</span>';
                                } else {
                                    return '<span class="d-inline-block px-3 py-1" style="border-radius:8px; background:#adb5bd; min-width:60px; min-height:24px; text-align:center;">' . ucfirst($status) . '</span>';
                                }
                            }
                        @endphp

                        @if(isset($tasksWithUtilization) && $tasksWithUtilization->count() > 0)
                            @foreach($tasksWithUtilization as $index => $task)
                                <tr class="task-row">
                                    <td style="cursor:pointer;">
                                        <a class="toggle-collapse" data-bs-toggle="collapse" data-bs-target="#task{{ $task->task_id }}-details" aria-expanded="false" aria-controls="task{{ $task->task_id }}-details">
                                            <i class="bi bi-plus fs-2 me-2 text-dark" id="icon-task{{ $task->task_id }}"></i>
                                        </a>
                                    </td>
                                    <th scope="row" style="width: 70px;">{!! statusLabel($task->status) !!}</th>
                                    <td>{{ $task->name }}</td>
                                    <td></td>
                                    <td>{{ $task->utilization }}%</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots fs-3 text-dark"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end rounded-0">                                        
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onClick="addSubTask({{ $task->task_id }}, '{{ addslashes($task->name) }}')">
                                                        <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                        <span>Tambah Sub Baris</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Sub Tasks -->
                                @if($task->subTask->count() > 0)
                                    @foreach($task->subTask as $subTask)
                                        <tr class="collapse deskripsi-row" id="task{{ $task->task_id }}-details" data-sub-task-id="{{ $subTask->sub_task_id }}">
                                            <td></td>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td>{{ $subTask->name }}</td>
                                            <td>{{ $subTask->completeness }}%</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots fs-3 text-dark"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center" href="#" onClick="editSubTask({{ $subTask->sub_task_id }})">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center text-danger" onClick="deleteSubTaskConfirmation({{ $subTask->sub_task_id }}, '{{ addslashes($subTask->name) }}')">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>Hapus</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>                                              
                                    @endforeach
                                @else
                                    <tr class="collapse deskripsi-row" id="task{{ $task->task_id }}-details">
                                        <td></td>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td class="text-muted">Tidak ada sub task</td>
                                        <td>0%</td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots fs-3 text-dark"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="addSubTask({{ $task->task_id }}, '{{ addslashes($task->name) }}')">
                                                            <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>Tambah Sub Task
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <!-- Fallback jika tidak ada data -->
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Tidak ada data task untuk work package ini.<br>
                                    Silahkan tambahkan task pada tabel task list
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>                       
        </div>
    </div>
</div>
@endsection

<!-- Add Sub Task Modal -->
<div class="modal fade" tabindex="-1" id="addSubTaskModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola Sub Task Personel</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form id="addSubTaskForm" method="POST" action="{{ route('performance-task.sub-task.store') }}">
                    @csrf
                    <input type="hidden" name="task_id" id="subTaskTaskId" value="">

                    <div class="form-group mb-3">
                        <label for="subTaskName" class="form-label">Sub Task</label>
                        <textarea name="sub_task_name" class="form-control" id="subTaskName" rows="3" placeholder="Deskripsi/sub-task" required maxlength="500"></textarea>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="utilizationPercentage" class="form-label">Persentase Utilisasi</label>
                        <input type="number" step="0.01" class="form-control" id="utilizationPercentage" placeholder="% Utilisasi">
                    </div> -->
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onClick="submitAddSubTask()">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Sub Task -->
<div class="modal fade" tabindex="-1" id="editSubTaskModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Sub Task</h3>
                
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body">
                <form id="editSubTaskForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="sub_task_id" id="editSubTaskId" value="">
                    
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold">Task</label>
                        <input type="text" id="editSubTaskTaskName" class="form-control bg-light" readonly>
                        <div class="form-text text-muted">Task induk untuk sub task ini</div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold">Nama Sub Task</label>
                        <textarea name="sub_task_name" id="editSubTaskName" class="form-control" rows="3" placeholder="Masukkan nama atau deskripsi sub task..." required maxlength="500"></textarea>
                        <div class="form-text text-muted">Deskripsi detail dari sub task (maksimal 255 karakter)</div>
                    </div>

                    <!-- <div class="form-group mb-4">
                        <label class="form-label fw-bold">Persentase Completeness</label>
                        <div class="input-group">
                            <input type="number" name="completeness" id="editSubTaskCompleteness" class="form-control" min="0" max="100" step="0.01" placeholder="0" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text text-muted">Persentase penyelesaian sub task (0% - 100%)</div>
                    </div> -->

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitEditSubTask()">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize the DataTable
    $(document).ready(function() {
        initTabelPerformanceTask();

        // Dynamic toggle icon on collapse for all task details
        @if(isset($tasksWithUtilization) && $tasksWithUtilization->count() > 0)
            @foreach($tasksWithUtilization as $task)
                $('#task{{ $task->task_id }}-details').on('show.bs.collapse', function () {
                    $('#icon-task{{ $task->task_id }}').removeClass('bi-plus').addClass('bi-dash');
                });
                $('#task{{ $task->task_id }}-details').on('hide.bs.collapse', function () {
                    $('#icon-task{{ $task->task_id }}').removeClass('bi-dash').addClass('bi-plus');
                });
            @endforeach
        @endif
    });

    function initTabelPerformanceTask() {
        const table = $('#table_performance_task').DataTable({
            "scrollY": '400px',
            "scrollX": true,
            "searching": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "ordering": false, // Disable sorting
            "paging": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Cari Data",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "emptyTable": "Tidak ada data yang tersedia"
            }
        });

        // Search input to DataTables
        setupSearch(table);
    }

    function setupSearch(table) {
        const searchInput = $('#searchInput');
        
        // Custom search functionality
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

        // ESC key to clear search
        searchInput.on('keydown', function(e) {
            if (e.which === 27) { // ESC key
                e.preventDefault();
                this.value = '';
                $(this).trigger('input'); // Trigger input event to clear search
                this.focus();
            }
        });
    }

    /* MANAJEMEN SUB TASK */
    /**
     * Function untuk mempermudah sub task
     */
    function addSubTask(taskId, taskName) {
        // Validasi parameter
        if (!taskId || !taskName) {
            Swal.fire({
                title: "Error",
                text: "Data task tidak valid",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
            return;
        }

        // Set data di modal
        $('#subTaskTaskId').val(taskId);
        // $('#subTaskTaskName').val(taskName);
        $('#subTaskName').val('');

        // Show modal
        $('#addSubTaskModal').modal('show');
    }

    /**
     * Function untuk submit add sub task
     */
    function submitAddSubTask() {
        const form = $('#addSubTaskForm');

        // Basic validation
        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            return;
        }

        // Additional validation
        const taskId = $('#subTaskTaskId').val();
        const subTaskName = $('#subTaskName').val().trim();

        if (!taskId || !subTaskName) {
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
                form.find('input, textarea, button').prop('disabled', true);

                Swal.fire({
                    title: 'Menambahkan Sub Task...',
                    text: 'Sedang memproses penambahan sub task baru',
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
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Tutup",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(() => {
                        $('#addSubTaskModal').modal('hide');
                        window.location.reload();
                    });

                } else {
                    Swal.fire({
                        title: "Gagal",
                        text: response.message || "Gagal menambahkan sub task",
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
                let errorMessage = "Terjadi kesalahan saat menambahkan sub task";

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
                    title: "Gagal Menambahkan Sub Task",
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
                form.find('input, textarea, button').prop('disabled', false);
            }
        });
    }

    /**
     * Function untuk edit sub task
     */
    function editSubTask(subTaskId) {
        // Validasi parameter
        if (!subTaskId) {
            Swal.fire({
                title: "Error",
                text: "ID sub task tidak valid",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
            return;
        }

        // Get sub task data via AJAX
        $.ajax({
            url: `/performance-task/sub-task/${subTaskId}/edit`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Memuat Data...',
                    text: 'Sedang mengambil data sub task',
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
                    // Populate modal dengan data sub task
                    $('#editSubTaskId').val(response.sub_task.sub_task_id);
                    $('#editSubTaskTaskName').val(response.sub_task.task_name);
                    $('#editSubTaskName').val(response.sub_task.name);
                    
                    // Set form action
                    $('#editSubTaskForm').attr('action', `/performance-task/sub-task/${subTaskId}`);
                    
                    // Show modal
                    $('#editSubTaskModal').modal('show');

                } else {
                    Swal.fire({
                        title: "Gagal",
                        text: response.message || "Gagal mengambil data sub task",
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

                let errorMessage = "Terjadi kesalahan saat mengambil data sub task";

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
     * Function untuk submit edit sub task form
     */
    function submitEditSubTask() {
        const form = $('#editSubTaskForm');
        const subTaskId = $('#editSubTaskId').val();

        // Validasi form
        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            return;
        }

        // Validasi subTaskId
        if (!subTaskId) {
            Swal.fire({
                title: "Error",
                text: "ID sub task tidak ditemukan",
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
        const subTaskName = $('#editSubTaskName').val().trim();

        if (!subTaskName) {
            Swal.fire({
                title: "Validasi Error",
                text: "Nama sub task harus diisi",
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
        
        console.log('Updating sub task with ID:', subTaskId);

        $.ajax({
            url: `/performance-task/sub-task/${subTaskId}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // Disable form elements
                form.find('input, textarea, button').prop('disabled', true);
                
                Swal.fire({
                    title: 'Memperbarui Sub Task...',
                    text: 'Sedang memproses pembaruan data sub task',
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
                    let successMessage = response.message || "Sub task berhasil diperbarui!";

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
                        $('#editSubTaskModal').modal('hide');
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
                        text: response.message || "Gagal memperbarui sub task",
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
                let errorMessage = "Terjadi kesalahan saat memperbarui sub task";

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
                    title: "Gagal Memperbarui Sub Task",
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
                form.find('input, textarea, button').prop('disabled', false);
            }
        });
    }

    /**
     * Function konfirmasi delete sub task
     */
    function deleteSubTaskConfirmation(subTaskId, subTaskName) {
        // Validasi parameter
        if (!subTaskId || !subTaskName) {
            Swal.fire({
                title: "Error",
                text: "Data sub task tidak valid",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tutup",
                customClass: {
                    confirmButton: "btn btn-secondary"
                }
            });
            return;
        }

        // Show confirmation dialog
        Swal.fire({
            title: "Konfirmasi Hapus",
            // html: `
            //     <p>Apakah Anda yakin ingin menghapus sub task ini?</p>
            //     <div class="mt-3 p-3 bg-light rounded">
            //         <strong>Sub Task:</strong> ${subTaskName}
            //     </div>
            //     <div class="mt-2">
            //         <small class="text-danger">
            //             <i class="bi bi-exclamation-triangle me-1"></i>
            //             Tindakan ini tidak dapat dibatalkan
            //         </small>
            //     </div>
            // `,
            text: "Apakah yakin ingin menghapus sub task ini?",
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: "Hapus",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                deleteSubTask(subTaskId, subTaskName);
            }
        });
    }

    /**
     * Function untuk melakukan delete sub task
     * 
     */
    function deleteSubTask(subTaskId, subTaskName) {
        $.ajax({
            url: `/performance-task/sub-task/${subTaskId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Menghapus Sub Task...',
                    text: 'Sedang menghapus penghapusan sub task',
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
                        title: "Berhasil Dihapus",
                        html: `
                            <p>${response.message}</p>
                            <div class="mt-3 p-3 bg-light rounded">
                                <strong>Sub Task yang Dihapus</strong><br>
                                <strong>Nama:</strong> ${response.deleted_sub_task.name}<br>
                                <strong>Task:</strong> ${response.deleted_sub_task.task_name}<br>
                            </div>
                        `,
                        icon: "success",
                        buttonStyling: false,
                        confirmButton: "Tutup",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        } 
                    }).then(() => {
                        window.location.reload();
                    });

                } else {
                    Swal.fire({
                        title: "Gagal",
                        text: response.message || "Gagal menghapus sub task",
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
                let errorMessage = "Terjadi kesalahan saat menghapus sub task";

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                } else if (xhr.status === 404) {
                    errorMessage = "Sub task tidak ditemukan";
                } else if (xhr.status === 403) {
                    errorMessage = "Anda tidak memiliki izin untuk menghapus sub task ini";
                }

                Swal.fire({
                    title: "Gagal Menghapus Sub Task",
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tutup",
                    customClass: {
                        confirmButton: "btn btn-secondary"
                    }
                });
            }
        })
    }
</script>
@endpush
