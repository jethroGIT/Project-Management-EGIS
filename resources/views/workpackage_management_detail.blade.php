@extends('layouts.app')

@section('content')
<div class="">
    <div class="d-flex justify-content-between align-items-center mt-0 mb-5">
        <div>
            <h1 class="mt-0 mb-5">Detail Kategori Work Package</h1>
            <h4 class="">{{ $workPackage->wp_number }} {{ $workPackage->name }}</h4>
        </div>
        <div class="text-end">
            <a href="{{ route('wp-management') }}" class="btn btn-light me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button class="btn btn-primary" onclick="editWorkPackage({{ $workPackage->wp_id }})">
                <i class="bi bi-pencil-square"></i> Edit Data
            </button>
        </div>
    </div>

    <!-- Work Package Info Card -->
    <div class="card card-flush shadow-sm mb-8">
        <div class="card-header py-0">
            <h3 class="card-title">
                <i class="bi bi-info-circle text-primary me-2"></i>
                Informasi Kategori Work Package
            </h3>
        </div>
        <div class="card-body py-0">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-borderless mb-6">
                        <tbody>
                            <!-- <tr>
                                <td class="fw-bold text-muted" style="width: 140px;">Nomor WP:</td>
                                <td>
                                    <span class="badge badge-light-primary fs-6">{{ $workPackage->wp_number }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Nama:</td>
                                <td class="fw-bold">{{ $workPackage->name }}</td>
                            </tr> -->
                            <tr>
                                <td class="fw-bold text-muted">Work Package</td>
                                <td class="fw-bold text-muted">:</td>
                                <td>{{ $workPackage->wpCategory->name ?? 'Tidak Berkategori' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Total Volume</td>
                                <td class="fw-bold text-muted">:</td>
                                <td>
                                    <span class="badge badge-light-info badge-lg">{{ $workPackage->volume_qty }} Volume</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Durasi</td>
                                <td class="fw-bold text-muted">:</td>
                                <td>
                                    <span class="badge badge-light-success badge-lg">{{ $workPackage->duration }} Hari</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Actual Scope</td>
                                <td class="fw-bold text-muted">:</td>
                                <td>{{ $workPackage->actual_scope_contract ?: 'Belum ada actual scope' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Deliverable</td>
                                <td class="fw-bold text-muted">:</td>
                                <td>
                                    @if(isset($workPackage))
                                        {!! nl2br(e($workPackage->deliverable ?? 'N/A')) !!}
                                    @else
                                        <p class="text-muted">
                                            Belum ada Deliverables
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Volumes Card -->
    <div class="card card-flush shadow-sm mb-8">
        <div class="card-header py-0">
            <h3 class="card-title">
                <i class="bi bi-collection text-primary me-2"></i>
                Work Package Volumes ({{ $volumesWithWorkOrderCount }} dari {{ $totalVolumesCount }} volume)
            </h3>
        </div>
        <div class="card-body py-0">
            @if($volumesData->count() > 0)
                <div class="volume-scroll-container">
                    @if($volumesData->count() > 1)
                        <!-- Scrollable Volume Cards -->
                        <div class="volume-cards-wrapper" id="volumeCardsWrapper">
                            @foreach($volumesData as $volume)
                                <div class="volume-card-item col-md-6 col-lg-4 mb-2">
                                    <div class="card card-bordered h-100 shadow-sm hover-elevate-up">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h4 class="card-title mb-0">
                                                    <i class="bi bi-folder-fill text-primary me-2"></i>
                                                    Volume {{ $volume['volume_number'] }}
                                                </h4>
                                                <span class="badge badge-light-info">{{ $volume['execution_year'] ?? '-' }}</span>
                                            </div>

                                            <!-- Volume Status Badge -->
                                            <div class="mb-3">
                                                @if(!$volume['start_date'] && !$volume['end_date'] && !$volume['execution_year'])
                                                    <span class="badge badge-light-info">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        Belum Konfigurasi
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mb-4">
                                                <div class="fw-bold mb-1">
                                                    <i class="bi bi-hash me-1"></i>
                                                    Work Order
                                                </div>
                                                <div class="fs-7">
                                                    @if ($volume['wo_number'])
                                                        WO {{ $volume['wo_number'] }}
                                                    @else
                                                        <span>Belum tersedia</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <div class="fw-bold mb-1">
                                                    <i class="bi bi-calendar-range me-1"></i>
                                                    Periode Pelaksanaan
                                                </div>
                                                <div class="fs-7">
                                                    @if($volume['start_date'] && $volume['end_date'])
                                                        {{ $volume['period_formatted'] }}
                                                    @else
                                                        <span>
                                                            Belum tersedia
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
        
                                            <div class="mb-4">
                                                <div class="fw-bold mb-1">
                                                    <i class="bi bi-people me-1"></i>
                                                    Resources ({{ $volume['resource_count'] }})
                                                </div>
                                                <div class="fs-7 text-wrap">
                                                    {{ Str::limit($volume['resource_names'], 70, '...') }}
                                                </div>
                                            </div>
        
                                            <div class="mt-auto">
                                                <!-- Link ke halaman manajemen volume -->
                                                <button 
                                                    class="btn btn-light-primary btn-sm w-100 fs-6" 
                                                    onclick="manageVolume({{ $volume['volume_id'] }})" 
                                                >
                                                    <!-- <i class="bi bi-pencil-square me-1"></i> -->
                                                    <i class="bi bi-eye me-1"></i>
                                                    Lihat Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3"></div>
                    @else
                        <div class="row justify-content-center">
                            @foreach($volumesData as $volume)
                                <div class="volume-card-item-one col-md-6 col-lg-4 mb-8">
                                    <div class="card card-bordered h-100 shadow hover-elevate-up">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h4 class="card-title mb-0">
                                                    <i class="bi bi-folder-fill text-primary me-2"></i>
                                                    Volume {{ $volume['volume_number'] }}
                                                </h4>
                                                <span class="badge badge-light-info">{{ $volume['execution_year'] }}</span>
                                            </div>

                                            <div class="mb-4">
                                                <div class="fw-bold mb-1">
                                                    <i class="bi bi-hash me-1"></i>
                                                    Work Order
                                                </div>
                                                <div class="fs-7">
                                                    @if ($volume['wo_number'])
                                                        WO {{ $volume['wo_number'] }}
                                                    @else
                                                        <span>Belum tersedia</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <div class="fw-bold mb-1">
                                                    <i class="bi bi-calendar-range me-1"></i>
                                                    Periode Pelaksanaan
                                                </div>
                                                <div class="fs-6">{{ $volume['period_formatted'] }}</div>
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
                                                <button 
                                                    class="btn btn-light-primary btn-sm w-100 fs-6" 
                                                    onclick="manageVolume({{ $volume['volume_id'] }})" 
                                                >
                                                    <i class="bi bi-eye me-1"></i>
                                                    Lihat Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada volume</h6>
                    <p class="text-muted">Volume belum dipanggil ke dalam Work Order</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Human Resources Summary -->
    <div class="card card-flush shadow-sm mb-8">
        <div class="card-header py-0">
            <h3 class="card-title">
                <i class="bi bi-person-lines-fill text-primary me-2"></i>
                Kebutuhan Tenaga Kerja
            </h3>
        </div>
        <div class="card-body py-0">
            @if($humanResourcesData->count() > 0)
                <div class="table-responsive mb-6">
                    <table class="table table-row-bordered table-hover border gy-4 gs-7 rounded">
                        <thead>
                            <tr class="fw-bold fs-4 text-gray-1000 bg-light">
                                <th></th>
                                <th style="width: 170px;">Jabatan</th>
                                <th style="width: 170px;">Personel</th>
                                <th class="text-center">JTK (Jumlah Tenaga Kerja)</th>
                                <th class="text-center">JHK (Jumlah Hari Kerja)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($humanResourcesData as $index => $hr)
                                <tr class="role-row">
                                    <td style="cursor:pointer;">
                                        <a class="toggle-collapse" data-bs-toggle="collapse" data-bs-target="#role{{ $hr['hr_id'] }}-details" aria-expanded="false" aria-controls="role{{ $hr['hr_id'] }}-details">
                                            <i class="bi bi-plus fs-2 me-2 text-dark" id="icon-role{{ $hr['hr_id'] }}"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{ $hr['role_name'] }}
                                        </div>
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-light-primary badge-lg">{{ $hr['jtk'] }} Orang</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-light-success badge-lg">{{ $hr['jhk'] }} Hari</span>
                                    </td>
                                </tr>

                                @if($hr['assigned_users']->count() > 0)
                                    @foreach($hr['assigned_users'] as $user)
                                        <tr class="collapse deskripsi-row" id="role{{ $hr['hr_id'] }}-details">
                                            <td></td>
                                            <td></td>
                                            <td>
                                                {{ $user['name'] }}
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="collapse deskripsi-row" id="role{{ $hr['hr_id'] }}-details">
                                        <td></td>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="bi bi-person-x me-2"></i>
                                            Belum ada personel yang di-assign untuk jabatan ini
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people fs-1 text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada data kebutuhan tenaga kerja</h6>
                    <p class="text-muted">Data akan tersedia setelah tenaga kerja ditugaskan</p>
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

.volume-scroll-container {
    position: relative;
    width: 100%;
}

.volume-nav-buttons {
    position: absolute;
    top: -60px;
    right: 0;
    z-index: 10;
}

.volume-cards-wrapper {
    display: flex;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-behavior: smooth;
    gap: 20px;
    padding: 10px 0 20px 0;
    margin: 0;
    
    /* Custom scrollbar */
    scrollbar-width: thin;
    scrollbar-color: #dee2e6 #f8f9fa;
}

.volume-cards-wrapper::-webkit-scrollbar {
    height: 8px;
}

.volume-cards-wrapper::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 4px;
}

.volume-cards-wrapper::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 4px;
}

.volume-cards-wrapper::-webkit-scrollbar-thumb:hover {
    background: #adb5bd;
}

.volume-card-item {
    flex: 0 0 320px; /* Fixed width, no shrink, no grow */
    min-height: 320px;
    max-height: 280px;
}

.volume-card-item .card {
    width: 100%;
    height: 100%;
    min-height: 280px;
}

.volume-card-item .card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .volume-card-item {
        flex: 0 0 280px;
        max-width: 280px;
    }
    
    .volume-cards-wrapper {
        gap: 15px;
    }
}

@media (max-width: 576px) {
    .volume-card-item {
        flex: 0 0 260px;
        max-width: 260px;
    }

    .volume-cards-wrapper {
        gap: 10px;
        padding: 10px 0;
    }
}

/* CARD HOVER EFFECTS */
.volume-card-item .card:hover {
    border-color: #0d6efd;
}

.volume-card-item .card:hover .card-title {
    color: #0d6efd;
}

.volume-card-item-one .card:hover {
    border-color: #0d6efd;
}

.volume-card-item-one .card:hover .card-title {
    color: #0d6efd;
}
</style>

@push('scripts')
<script>
$(document).ready(function() {
    @if(isset($humanResourcesData) && $humanResourcesData->count() > 0)
        @foreach($humanResourcesData as $hr)
            $('#role{{ $hr['hr_id'] }}-details').on('show.bs.collapse', function () {
                $('#icon-role{{ $hr['hr_id'] }}').removeClass('bi-plus').addClass('bi-dash');
            });
            $('#role{{ $hr['hr_id'] }}-details').on('hide.bs.collapse', function () {
                $('#icon-role{{ $hr['hr_id'] }}').removeClass('bi-dash').addClass('bi-plus');
            });
        @endforeach
    @endif
});

/**
 * Function untuk edit work package (placeholder)
 */
function editWorkPackage(wpId) {
    window.location.href = `{{ route('wp-management.edit', ['wp_id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', wpId);
}

/**
 * Function untuk manage volume (placeholder for future)
 */
function manageVolume(volumeId) {
    const referrerUrl = `{{ route('work-package.detail', ['volume_id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', volumeId) + '?referrer=detail&wp_id={{ $workPackage->wp_id }}';
    window.location.href = referrerUrl;
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