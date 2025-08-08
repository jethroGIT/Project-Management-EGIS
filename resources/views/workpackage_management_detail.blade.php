@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="mt-0 mb-2">Detail Work Package</h1>
        </div>
        <div>
            <a href="{{ route('wp-management') }}" class="btn btn-light me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button class="btn btn-primary" onclick="editWorkPackage({{ $workPackage->wp_id }})">
                <i class="bi bi-pencil-square"></i> Edit Work Package
            </button>
        </div>
    </div>

    <!-- Work Package Info Card -->
    <div class="card card-flush shadow-sm mb-6">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-info-circle text-primary me-2"></i>
                Informasi Work Package
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-muted" style="width: 140px;">Nomor WP:</td>
                                <td>
                                    <span class="badge badge-light-primary fs-6">{{ $workPackage->wp_number }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Nama:</td>
                                <td class="fw-bold">{{ $workPackage->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Kategori:</td>
                                <td>{{ $workPackage->wpCategory->name ?? 'Tidak Berkategori' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Total Volume:</td>
                                <td>
                                    <span class="badge badge-light-info">{{ $workPackage->volume_qty }} Volume</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-muted" style="width: 140px;">Durasi:</td>
                                <td>
                                    <span class="badge badge-light-success">{{ $workPackage->duration }} Hari</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Actual Scope:</td>
                                <td>{{ $workPackage->actual_scope_contract ?: 'Belum ada actual scope' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Deliverable:</td>
                                <td>{{ $workPackage->deliverable ?: 'Belum ada deliverable' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Volumes Card -->
    <div class="card card-flush shadow-sm mb-6">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-collection text-primary me-2"></i>
                Work Package Volumes ({{ $volumesData->count() }})
            </h3>
        </div>
        <div class="card-body">
            @if($volumesData->count() > 0)
                <div class="row">
                    @foreach($volumesData as $volume)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card card-bordered h-100 shadow-sm hover-elevate-up">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-folder-fill text-primary me-2"></i>
                                            Volume {{ $volume['volume_number'] }}
                                        </h5>
                                        <span class="badge badge-light-warning">{{ $volume['execution_year'] }}</span>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="fw-bold mb-1">
                                            <i class="bi bi-calendar-range me-1"></i>
                                            Periode Pelaksanaan
                                        </div>
                                        <div class="fs-6">{{ $volume['period_formatted'] }}</div>
                                        <!-- <small class="text-muted">({{ $volume['duration_days'] }} hari)</small> -->
                                    </div>

                                    <div class="mb-4">
                                        <div class="fw-bold mb-1">
                                            <i class="bi bi-people me-1"></i>
                                            Resources ({{ $volume['resource_count'] }})
                                        </div>
                                        <div class="fs-7 text-wrap">
                                            {{ $volume['resource_names'] }}
                                        </div>
                                    </div>

                                    <div class="mt-auto">
                                        <!-- Link ke halaman manajemen volume -->
                                        <button class="btn btn-light-primary btn-sm w-100" 
                                                onclick="manageVolume({{ $volume['volume_id'] }})" 
                                                disabled>
                                            <i class="bi bi-gear me-1"></i>
                                            Kelola Volume
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada volume</h6>
                    <p class="text-muted">Volume akan dibuat secara otomatis saat work package dibuat</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Human Resources Summary -->
    <div class="card card-flush shadow-sm mb-6">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-person-lines-fill text-primary me-2"></i>
                Kebutuhan Tenaga Kerja
            </h3>
        </div>
        <div class="card-body">
            @if($humanResourcesData->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Role</th>
                                <th class="text-center">JTK (Jumlah Tenaga Kerja)</th>
                                <th class="text-center">JHK (Jumlah Hari Kerja)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($humanResourcesData as $hr)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-badge text-primary me-2"></i>
                                            {{ $hr['role_name'] }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-light-primary">{{ $hr['jtk'] }} Orang</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-light-success">{{ $hr['jhk'] }} Hari</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people fs-1 text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada data kebutuhan tenaga kerja</h6>
                    <p class="text-muted">Data akan tersedia setelah resource ditugaskan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
.hover-elevate-up {
    transition: all 0.3s ease;
}

.hover-elevate-up:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
}

.card-bordered {
    border: 1px solid #e4e6ef;
}

.card-bordered:hover {
    border-color: #3f4254;
}
</style>

@push('scripts')
<script>
/**
 * Function untuk edit work package (placeholder)
 */
function editWorkPackage(wpId) {
    // TODO: Implement edit functionality
    Swal.fire({
        title: "Edit Work Package",
        text: "Fitur edit work package akan segera tersedia",
        icon: "info",
        buttonsStyling: false,
        confirmButtonText: "OK",
        customClass: {
            confirmButton: "btn btn-primary"
        }
    });
}

/**
 * Function untuk manage volume (placeholder for future)
 */
function manageVolume(volumeId) {
    // TODO: Implement volume management
    Swal.fire({
        title: "Kelola Volume",
        text: "Fitur kelola volume akan segera tersedia",
        icon: "info",
        buttonsStyling: false,
        confirmButtonText: "OK",
        customClass: {
            confirmButton: "btn btn-primary"
        }
    });
}

// Toast notification if redirected with success/error message
@if(session('success'))
    Swal.fire({
        title: "Berhasil!",
        text: "{{ session('success') }}",
        icon: "success",
        timer: 3000,
        timerProgressBar: true,
        buttonsStyling: false,
        confirmButtonText: "OK",
        customClass: {
            confirmButton: "btn btn-primary"
        }
    });
@endif

@if(session('error'))
    Swal.fire({
        title: "Error!",
        text: "{{ session('error') }}",
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "OK",
        customClass: {
            confirmButton: "btn btn-secondary"
        }
    });
@endif
</script>
@endpush