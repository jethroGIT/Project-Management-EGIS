@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="mt-0 mb-5">
        <h1 class="mt-0 mb-5">Work Packages</h1>
        <p>Daftar Work Package yang belum dipanggil ke dalam Work Order</p>
    </div>
    
    <!-- Work Package List Associated with Work Order -->
    <div class="card card-flush shadow-sm mb-8">
        <div class="card-header py-0">
            <div class="card-title">
                <h3 class="fw-bold m-0">Daftar Work Packages</h3>
            </div>
            <div class="card-toolbar">
                <span class="badge badge-light-success badge-lg">{{$countWPs}} WPs</span>
            </div>
        </div>
        <div class="card-body py-0">
            @php
                $grouped = $workPackages->groupBy(function($wp) {
                    return $wp->category_id;
                });
            @endphp
            @foreach($grouped as $categoryId => $wps)
                @php
                    $categoryNumber = $wps->first()->wpCategory->category_number ?? '';
                    $categoryName = $wps->first()->wpCategory->name ?? 'Kategori Tidak Diketahui';
                    $loopIndex = $loop->index;
                    $collapseClass = ($loopIndex < 2) ? 'show' : '';
                @endphp
                <div class="mb-8">
                    <h5 class="fw-normal border-bottom pb-2 mb-3 d-flex justify-content-between align-items-center" style="cursor:pointer"
                        data-bs-toggle="collapse" data-bs-target="#category-{{ $categoryId }}">
                        <span>{{$categoryNumber}}. {{ $categoryName }}</span>
                        <span>
                            <!-- Panah collapse -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 5.646a.5.5 0 0 1 .708 0L8 11.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </span>
                    </h5>
                    <div class="collapse {{$collapseClass}}" id="category-{{ $categoryId }}">
                        <div class="row">
                            @foreach($wps as $wp)
                            <div class="col-md-6 mb-6">
                                <div class="card card-bordered h-100 shadow-sm hover-elevate-up wp-volume-card">
                                    <div class="card-body px-4 pt-4 pb-3">
                                        <!-- Status Badge -->
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <i class="bi bi-folder-fill text-primary fs-2 me-3"></i>
                                                <span class="text">
                                                    WP {{$wp->wp_number}}
                                                </span>
                                            </div>
                                            <span class="badge badge-secondary small">
                                                {{ $wp->workPackageVolumes->where('wo_id', null)->count() }} volume tersisa
                                            </span>
                                        </div>
                                        <!-- Work Package Info -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-gray-800 fw-bolder">
                                                {{$wp->name}}
                                            </p>
                                            <!-- Action Button -->
                                            <button class="btn btn-light-primary btn-sm" onclick="showDetailWP({{ $wp->wp_id }})" data-bs-toggle="modal" data-bs-target="#kt_modal_detail_wp">
                                                <i class="bi bi-eye ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

<div class="modal fade" tabindex="-1" id="kt_modal_detail_wp">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Work Package</h3>
            </div>
            <div class="modal-body">
                <p>ini isi modal</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Untuk setiap kategori
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(header) {
            const svg = header.querySelector('svg');
            const targetId = header.getAttribute('data-bs-target');
            const collapseEl = document.querySelector(targetId);

            // Set panah awal
            if (collapseEl.classList.contains('show')) {
                svg.style.transform = 'rotate(180deg)';
            } else {
                svg.style.transform = 'rotate(0deg)';
            }

            // Event collapse show/hide
            collapseEl.addEventListener('show.bs.collapse', function () {
                svg.style.transition = 'transform 0.2s';
                svg.style.transform = 'rotate(180deg)';
            });
            collapseEl.addEventListener('hide.bs.collapse', function () {
                svg.style.transition = 'transform 0.2s';
                svg.style.transform = 'rotate(0deg)';
            });
        });
    });

    // Kirim data WP ke JS
    const wpData = @json($workPackages);
    console.log('wpData:', wpData);

    function showDetailWP(wpId) {
        const wp = wpData.find(item => item.wp_id == wpId);
        if (!wp) return;

        // Card Informasi Work Package (tetap seperti sebelumnya)
        let infoCard = `
            <div class="card card-flush shadow-sm mb-6">
                <div class="card-header py-0" style="padding-bottom: 8px;">
                    <h3 class="card-title">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Informasi Work Package
                    </h3>
                </div>
                <div class="card-body py-0" style="padding-bottom: 8px;">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-borderless mb-6 pt-0" style="font-size: 0.97rem;">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-muted">Kategori</td>
                                        <td class="fw-bold text-muted">:</td>
                                        <td>${wp.wp_category?.name ?? 'Tidak Berkategori'}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Volume</td>
                                        <td class="fw-bold text-muted">:</td>
                                        <td>
                                            <span class="badge badge-light-info badge-lg">${wp.volume_qty} Volume</span>
                                            <span class="text-muted">(${wp.work_package_volumes ? wp.work_package_volumes.filter(v => v.wo_id === null).length : 0} volume tersisa)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Durasi</td>
                                        <td class="fw-bold text-muted">:</td>
                                        <td>
                                            <span class="badge badge-light-success badge-lg">${wp.duration} Hari</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Actual Scope</td>
                                        <td class="fw-bold text-muted">:</td>
                                        <td>${wp.actual_scope_contract ? wp.actual_scope_contract : 'Belum ada actual scope'}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Deliverable</td>
                                        <td class="fw-bold text-muted">:</td>
                                        <td>${wp.deliverable ? wp.deliverable.replace(/\n/g, '<br>') : '<span class="text-muted">Belum ada Deliverables</span>'}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Card Kebutuhan Tenaga Kerja
        let hrData = wp.human_resources || [];
        console.log('hrData:', hrData);
        let hrTableRows = '';

        if (hrData.length > 0) {
            hrData.forEach(hr => {
                let userNames = '-';
                if (hr.users && hr.users.length > 0) {
                    userNames = hr.users.map(u => u.name).join(', ');
                } else if (hr.user && hr.user.name) {
                    userNames = hr.user.name;
                }

                hrTableRows += `
                    <tr class="role-row" style="font-size: 0.97rem;">
                        <td>
                            <div class="d-flex align-items-center">
                                ${hr.role?.name ?? '-'}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                ${userNames}
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-light-primary badge-lg">${hr.jtk ?? 0} Orang</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-light-success badge-lg">${hr.jhk ?? 0} Hari</span>
                        </td>
                    </tr>
                `;
            });
        }

        let hrTable = '';
        if (hrData.length > 0) {
            hrTable = `
                <div class="table-responsive mb-6">
                    <table class="table table-row-bordered table-hover border gy-4 gs-7 rounded">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-1000 bg-light">
                                <th style="width: 170px;">Peran</th>
                                <th style="width: 170px;">SDM</th>
                                <th class="text-center">JTK (Jumlah Tenaga Kerja)</th>
                                <th class="text-center">JHK (Jumlah Hari Kerja)</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${hrTableRows}
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            hrTable = `
                <div class="text-center py-5">
                    <i class="bi bi-people fs-1 text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada data kebutuhan tenaga kerja</h6>
                    <p class="text-muted">Data akan tersedia setelah resource ditugaskan</p>
                </div>
            `;
        }

        // Isi modal-body dengan dua card
        const modalBody = document.querySelector('#kt_modal_detail_wp .modal-body');
        modalBody.innerHTML = infoCard + `
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-header py-0">
                    <h3 class="card-title">
                        <i class="bi bi-person-lines-fill text-primary me-2"></i>
                        Kebutuhan Tenaga Kerja
                    </h3>
                </div>
                <div class="card-body py-0">
                    ${hrTable}
                </div>
            </div>
        `;
    }
</script>
@endpush
