@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mt-0 mb-5">
        <h1 class="mt-0 mb-5">Work Order</h1>
        <h4>WO {{ $workOrder->wo_number }}</h4>
    </div>
    
    <!-- Work Package List Associated with Work Order -->
    <div class="card card-flush shadow-sm mb-8">
        <div class="card-header py-0">
            <div class="card-title">
                <h3 class="fw-bold m-0">Daftar Work Package</h3>
            </div>
            <div class="card-toolbar">
                <span class="badge badge-light-success badge-lg">{{ $volumesData->count() }} Volume</span>
            </div>
        </div>
        <div class="card-body py-0">
            @if($volumesData->count() > 0)
                <div class="row">
                    @foreach($volumesData as $volume)
                        @php
                            // Tentukan badge color berdasarkan completion
                            $badgeClass = 'badge-light-dark';
                            if ($volume['completion'] >= 80) {
                                $badgeClass = 'badge-light-success';
                            } elseif ($volume['completion'] >= 50) {
                                $badgeClass = 'badge-light-primary';
                            } elseif ($volume['completion'] >= 25) {
                                $badgeClass = 'badge-light-info';
                            } elseif ($volume['completion'] > 0) {
                                $badgeClass = 'badge-light-warning';
                            }
                        @endphp

                        <!-- Volume Card -->
                        <div class="col-md-6 col-lg-4 mb-6">
                            <div class="card card-bordered h-100 shadow-sm hover-elevate-up wp-volume-card">
                                <div class="card-body p-6">
                                    <!-- Status Badge -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <i class="bi bi-folder-fill text-primary fs-2"></i>
                                        <span class="badge {{ $badgeClass }} badge-lg">
                                            {{ number_format($volume['completion'], 2) }} %
                                        </span>
                                    </div>
                                    
                                    <!-- Work Package Info -->
                                    <h5 class="card-title fw-bold mb-2">
                                        WP {{ $volume['wp_number'] }} {{ $volume['wp_name'] }}
                                    </h5>
                                    <p class="badge badge-light-info badge-lg mb-3">Volume {{ $volume['volume_number'] }}</p>
                                    
                                    <!-- Period -->
                                    <div class="mb-3">
                                        <div class="mb-1">Periode Pelaksanaan</div>
                                        <div class="fw-bold">{{ $volume['period_formatted'] }}</div>
                                    </div>
                                    
                                    <!-- Duration -->
                                    <div class="mb-4">
                                        <div class="mb-1">Durasi</div>
                                        <div class="fw-bold">{{ $volume['duration'] }} Hari</div>
                                    </div>
                                    
                                    <!-- Action Button -->
                                    <button class="btn btn-light-primary w-100" onClick="viewVolumeDetail({{ $volume['volume_id'] }})">
                                        <i class="bi bi-eye me-1"></i>
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State (if no volumes) -->
                <div class="text-center py-8" style="display: none;">
                    <i class="bi bi-folder-x fs-1 text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada work package</h6>
                    <p class="text-muted">Work Order ini belum memiliki work package yang terkait</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
.wp-volume-card {
    transition: all 0.3s ease;
    border: 1px solid #e4e6ef;
}

.wp-volume-card.card-bordered {
    border: 1px solid #e4e6ef !important;
    transition: all 0.3s ease !important;
}

.wp-volume-card.card-bordered:hover {
    border-color: #009ef7 !important;
    transform: translateY(-5px) !important;
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
}

/* Alternatif class yang lebih spesifik */
.hover-elevate-up.wp-volume-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    border-color: #009ef7 !important;
}

.wp-volume-card .card-title {
    line-height: 1.4;
    color: #181c32;
    transition: color 0.3s ease;
}

.wp-volume-card:hover .card-title {
    color: #6610f2 !important;
}

.wp-volume-card .badge {
    font-size: 0.75rem;
    font-weight: 600;
}

.wp-volume-card .btn {
    font-size: 0.875rem;
    font-weight: 600;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .wp-volume-card .card-title {
        font-size: 0.9rem;
    }
}
</style>

@push('scripts')
<script>
function viewVolumeDetail(volumeId) {
    // Redirect ke halaman detail volume
    window.location.href = `{{ route('work-package.detail', ['volume_id' => ':volume_id']) }}`.replace(':volume_id', volumeId);
}

$(document).ready(function() {
    // Add tooltip for cards
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endpush