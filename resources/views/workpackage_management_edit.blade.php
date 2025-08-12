@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="mt-0 mb-2">
                Edit Work Package
            </h1>
        </div>
        <div class="text-end">
            <a href="{{ route('wp-management.detail', $workPackage->wp_id) }}" class="btn btn-light me-2">
                Batal
            </a>
            <button type="button" class="btn btn-primary" onclick="saveWorkPackage()">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <!-- Edit Form  -->
    <form id="editWorkPackageForm" method="POST" action="{{ route('wp-management.update', $workPackage->wp_id) }}">
        @csrf
        @method('PUT')

        {{-- Basic Information Card --}}
        <div class="card card-flush shadow-sm mb-6">
            <div class="card-header py-0">
                <h3 class="card-title">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Informasi Dasar Work Package
                </h3>
            </div>
            <div class="card-body py-0">
                <div class="row">
                    {{-- Category --}}
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold required">Kategori</label>
                        <select class="form-select form-select-solid" name="category_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    {{ $workPackage->category_id == $category->category_id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Nomor Work Package --}}
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Nomor Work Package</label>
                        <input type="text" class="form-control" value="{{ $workPackage->wp_number }}" readonly>
                    </div>

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold required">Nama Work Package</label>
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control" 
                            value="{{ $workPackage->name }}" 
                            placeholder="Masukkan nama work package" 
                            required
                        >
                    </div>

                    <!-- Duration -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold required">Durasi (Hari Kerja)</label>
                        <input 
                            type="number" 
                            name="duration" 
                            class="form-control" 
                            value="{{ $workPackage->duration }}" 
                            min="1" 
                            placeholder="20" 
                            required
                        >
                    </div>

                    <!-- Actual Scope -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Actual Scope Contract</label>
                        <textarea 
                            name="actual_scope_contract" 
                            class="form-control" 
                            placeholder="Masukkan actual scope contract"
                        >
                            {{ $workPackage->actual_scope_contract }}
                        </textarea>
                    </div>

                    <!-- Deliverable -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Deliverables</label>
                        <textarea 
                            name="deliverable" 
                            class="form-control" 
                            rows="3" 
                            placeholder="Masukkan deliverable"
                        >
                            {{ $workPackage->deliverable }}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Volume Management Card --}}
        <div class="card card-flush shadow-sm mb-6">
            <div class="card-header py-0">
                <h3 class="card-title">
                    <i class="bi bi-collection text-primary me-2"></i>
                    Manajemen Volume ({{ $volumesData->count() }})
                </h3>
            </div>
            <div class="card-body py-0">
                <div id="volumeContainer">
                    @foreach($volumesData as $index => $volume)
                        <div class="volume-item mb-4 p-4 border rounded" data-volume-id="{{ $volume['volume_id'] }}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="bi bi-folder-fill text-primary me-2"></i>
                                    Volume {{ $volume['volume_number'] }}
                                </h5>
                                <span class="badge badge-light-info">{{ $volume['execution_year'] }}</span>
                            </div>

                            <input type="hidden" name="volumes[{{ $index }}][volume_id]" value="{{ $volume['volume_id'] }}">

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">Tanggal Mulai</label>
                                    <input 
                                        type="date" 
                                        name="volumes[{{ $index }}][start_date]" 
                                        class="form-control" 
                                        value="{{ $volume['start_date'] }}" 
                                        required
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">Tanggal Selesai</label>
                                    <input 
                                        type="date" 
                                        name="volumes[{{ $index }}][end_date]" 
                                        class="form-control" 
                                        value="{{ $volume['end_date'] }}" 
                                        required
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">Tahun Pelaksanaan</label>
                                    <input 
                                        type="number" 
                                        name="volumes[{{ $index }}][execution_year]" 
                                        class="form-control" 
                                        value="{{ $volume['execution_year'] }}" 
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Volume Resouces Info --}}
                            <div class="mt-3">
                                <label class="form-label fw-bold">Resources</label>
                                <div class="p-3 bg-light rounded">
                                    @if($volume['resources']->count() > 0)
                                        @foreach($volume['resources'] as $resource)
                                            <span class="badge badge-light-primary me-2 mb-1">
                                                {{ $resource['user_name'] }} ({{ $resource['role_name'] }})
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Belum ada resource assigned</span>
                                    @endif
                                </div>
                                <div class="form-text">
                                    Resource assignment akan dikelola di bagian "Kebutuhan Tenaga Kerja" di bawah
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Human Resources Management Card --}}
        <div class="card card-flush shadow-sm mb-6">
            <div class="card-header py-0">
                <h3 class="card-title">
                    <i class="bi bi-person-lines-fill text-primary me-2"></i>
                    Kebutuhan Tenaga Kerja
                </h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-light-primary btn-sm" onclick="addHumanResource()">
                        <i class="bi bi-plus-circle"></i> Tambah Resource
                    </button>
                </div>
            </div>
            
            <div class="card-body py-0">
                <div id="humanResourceContainer">
                    @foreach($humanResourcesData as $index => $hr)
                        <div class="human-resource-item mb-6 p-4 border rounded shadow-sm" data-index="{{ $index }}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Resource #{{ $index + 1 }}</h6>
                                <button 
                                    type="button" class="btn btn-light-danger"
                                    onclick="removeHumanResource(this)"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">Role/Peran</label>
                                    <select name="resources[{{ $index }}][role_id]" class="form-select" required>
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $role)
                                            <option 
                                                value="{{ $role->role_id }}" 
                                                {{ $hr['role_id'] == $role->role_id ? 'selected' : '' }}
                                            >
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">JTK (Jumlah Tenaga Kerja)</label>
                                    <input 
                                        type="number" 
                                        name="resources[{{ $index }}][jtk]" 
                                        class="form-control" 
                                        value="{{ $hr['jtk'] }}" 
                                        min="1" placeholder="1" 
                                        required
                                    >
                                    <div class="form-text">Jumlah orang dengan role ini</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">JHK (Jumlah Hari Kerja)</label>
                                    <input 
                                        type="number" 
                                        name="resources[{{ $index }}][jhk]" 
                                        class="form-control" 
                                        value="{{ $hr['jhk'] }}" 
                                        min="1" placeholder="20" 
                                        required
                                    >
                                    <div class="form-text">Total hari kerja untuk role ini</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($humanResourcesData->count() == 0)
                    <div class="text-center py-4" id="noResourcesMessage">
                        <i class="bi bi-people fs-1 text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada kebutuhan tenaga kerja</h6>
                        <p class="text-muted">Klik "Tambah Resource" untuk menambahkan kebutuhan tenaga kerja</p>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection

<style>
.required::after {
    content: " *";
    color: #e63946;
}

.volume-item {
    background-color: #f8f9fa;
    border: 2px dashed #dee2e6 !important;
}

.human-resource-item {
    border: 1px solid #dee2e6 !important;
}

.human-resource-item:hover {
    border-color: #0d6efd !important;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn-light-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.btn-light-danger:hover {
    background-color: #f5c6cb;
    border-color: #f1b0b7;
    color: #721c24;
}
</style>

@push('scripts')
<script>
let humanResourceIndex = {{ $humanResourcesData->count() }};

/**
 * Save work package changes
 */
function saveWorkPackage() {
    const form = document.getElementById('editWorkPackageForm');
    const formData = new FormData(form);

    // Show loading
    Swal.fire({
        title: 'Menyimpan perubahan...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Submit form via AJAX
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();

        if (data.success) {
            Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            }).then(() => {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            });
        } else {
            let errorMessage = data.message;
            
            if (data.errors) {
                const errorList = Object.values(data.errors).flat();
                errorMessage += '\n\n' + errorList.join('\n');
            }

            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-secondary'
                }
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);

        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan saat menyimpan perubahan',
            icon: 'error',
            buttonsStyling: false,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-secondary'
            }
        });
    });
}

/**
 * Add new human resource
 */
function addHumanResource() {
    const container = document.getElementById('humanResourceContainer');
    const noResourcesMessage = document.getElementById('noResourcesMessage');
    
    if (noResourcesMessage) {
        noResourcesMessage.style.display = 'none';
    }

    const resourceHtml = `
        <div class="human-resource-item mb-4 p-4 border rounded" data-index="${humanResourceIndex}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Resource #${humanResourceIndex + 1}</h6>
                <button type="button" class="btn btn-sm btn-light-danger" onclick="removeHumanResource(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold required">Role/Peran</label>
                    <select name="resources[${humanResourceIndex}][role_id]" class="form-select" required>
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->role_id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold required">JTK (Jumlah Tenaga Kerja)</label>
                    <input type="number" name="resources[${humanResourceIndex}][jtk]" 
                           class="form-control" min="1" placeholder="1" required>
                    <div class="form-text">Jumlah orang dengan role ini</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold required">JHK (Jumlah Hari Kerja)</label>
                    <input type="number" name="resources[${humanResourceIndex}][jhk]" 
                           class="form-control" min="1" placeholder="20" required>
                    <div class="form-text">Total hari kerja untuk role ini</div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', resourceHtml);
    humanResourceIndex++;
}

/**
 * Remove human resource
 */
function removeHumanResource(button) {
    const resourceItem = button.closest('.human-resource-item');
    
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus resource ini?',
        icon: 'warning',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            resourceItem.remove();
            
            // Update resource numbering
            updateResourceNumbering();
            
            // Show no resources message if no resources left
            const container = document.getElementById('humanResourceContainer');
            const noResourcesMessage = document.getElementById('noResourcesMessage');
            
            if (container.children.length === 0 && noResourcesMessage) {
                noResourcesMessage.style.display = 'block';
            }
        }
    });
}

/**
 * Update resource numbering after removal
 */
function updateResourceNumbering() {
    const resourceItems = document.querySelectorAll('.human-resource-item');
    
    resourceItems.forEach((item, index) => {
        const header = item.querySelector('h6');
        if (header) {
            header.textContent = `Resource #${index + 1}`;
        }
    });
}

// Form validation
$(document).ready(function() {
    // Date validation
    $('input[type="date"]').on('change', function() {
        const container = $(this).closest('.volume-item');
        const startDate = container.find('input[name*="[start_date]"]').val();
        const endDate = container.find('input[name*="[end_date]"]').val();
        
        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            Swal.fire({
                title: 'Tanggal Tidak Valid',
                text: 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai',
                icon: 'warning',
                buttonsStyling: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-warning'
                }
            });
            
            $(this).val('');
        }
    });
});
</script>
@endpush