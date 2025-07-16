@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="my-10">Work Package</h1>

    <div class="card card-flush shadow-sm">
        <div class="card-header">
            <div class="mt-6">
                <h3 class="card-title">WP 3.1 Human Security Risk Awareness Program Planning</h3>
                <p>Periode 3 Maret 2025 - 19 November 2025</p>
            </div>
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_7">Detail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_8">Kuantitas</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body py-5">
            <div class="tab-content" id="myTabContent">
                <!-- TAB WP DETAIL -->
                <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                    <div class="d-flex justify-content-end mb-4">
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                            Edit Data
                        </button>
                    </div>

                    <div class="row">
                        <!-- Actual Scope -->
                        <div class="mb-6">
                            <label class="form-label fw-bold fs-6 text-dark mb-3">Actual Scope</label>
                            <div class="bg-secondary p-4 rounded">
                                <p class="mb-0 fs-7">"Human firewall design program (awareness) - IS competency matrix"</p>
                            </div>
                        </div>

                        <!-- Deliverables -->
                        <div class="mb-6">
                            <label class="form-label fw-bold fs-6 text-dark mb-3">Deliverables</label>
                            <div class="bg-secondary p-4 rounded">
                                <p class="mb-2 fs-7">Laporan perencanaan pengembangan awareness keamanan informasi, yang memuat: <br/>
                                    1. Metode pembangunan awareness <br/>
                                    2. Materi sosialisasi security awareness <br/>
                                    3. Materi pengujian berkala untuk topik security awareness <br/>
                                    4. Materi pelatihan dasar cyber hygiene, serta penggunaan tools pendukung cyber hygiene yang dimiliki PERUSAHAAN <br/>
                                    5. Dokumentasi workshop pengembangan awareness keamanan informasi (apabila dilaksanakan), termasuk di dalamnya materi workshop dan daftar hadir <br/>
                                </p>
                            </div>
                        </div>

                        <!-- Resource Names -->
                        <div class="mb-6">
                            <label class="form-label fw-bold fs-6 text-dark mb-3">Resource Names</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="bg-light-primary p-4 rounded">
                                        <div>
                                            <div class="fs-7 text-dark">Oki Jamhur - Project Manager</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light-primary p-4 rounded">
                                        <div>
                                            <div class="fs-7 text-dark">Restia - Senior Consultant</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light-primary p-4 rounded">
                                        <div>
                                            <div class="fs-7 text-dark">Yudis - Associate Consultant</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light-primary p-4 rounded">
                                        <div>
                                            <div class="fs-7 text-dark">Annisa Y - Junior Consultant</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light-primary p-4 rounded">
                                        <div>
                                            <div class="fs-7 text-dark">Vanika - Technical Writer</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="form-label fw-bold fs-6 text-dark mb-3">Task List</label>
                        <div class="table-responsive">
                            <table id="tabel_wp_task" class="table table-striped border gy-5 gs-7 border rounded w-100">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="align-middle border-bottom min-w-100px">No</th>
                                        <th class="align-middle border-bottom min-w-200px">Task</th>
                                        <th class="align-middle border-bottom">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Analisis kebutuhan program security awareness</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                        <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="editTask(1.1)">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteTask(1.1)">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertAbove(1.1)">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Atas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertBelow(1.1)">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Bawah
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertSubRow(1.1)">
                                                            <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                            Masukkan Sub Baris
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Identifikasi stakeholder dan kebutuhannya terhadap program security awareness</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                        <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="editTask(1.1)">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteTask(1.1)">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertAbove(1.1)">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Atas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertBelow(1.1)">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Bawah
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertSubRow(1.1)">
                                                            <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                            Masukkan Sub Baris
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Sumber daya yang dibutuhkan dalam program security awareness</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                        <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="editTask(1.1)">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteTask(1.1)">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertAbove(1.1)">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Atas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertBelow(1.1)">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Bawah
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertSubRow(1.1)">
                                                            <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                            Masukkan Sub Baris
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Penentuan cara penyampaian program security awareness</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                        <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="editTask(1.1)">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteTask(1.1)">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertAbove(1.1)">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Atas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertBelow(1.1)">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Bawah
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="insertSubRow(1.1)">
                                                            <i class="bi bi-plus-square me-3 fs-2 text-dark"></i>
                                                            Masukkan Sub Baris
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB WP KUANTITAS -->
                <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                    <!-- Filter Button -->
                    <!-- <div class="d-flex justify-content-start mb-4">
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                            </svg>
                            Filter Data
                        </button>
                    </div> -->

                    <!-- Filter Collapse -->
                    <!-- <div class="collapse" id="filterCollapse">
                        <div class="card card-flush shadow-lg mb-4">
                             <div class="card-header">
                                 <h3 class="card-title">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                         <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                                     </svg>
                                     <div class="m-2">
                                        Filter Data
                                     </div>
                                 </h3>
                             </div>
                             <div class="card-body py-5">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Kategori</label>
                                        <select class="form-select form-select-solid" id="kategoriFilter">
                                            <option value="">Pilih Kategori</option>
                                            <option value="management">Management of Human Security Risk Programs</option>
                                            <option value="awareness">Human Security Risk Awareness Program</option>
                                            <option value="training">Security Training Programs</option>
                                            <option value="assessment">Risk Assessment Programs</option>
                                        </select>
                                    </div>
                                </div>
                             </div>
                             <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger me-3" id="resetFilter">
                                        Hapus Filter
                                    </button>
                                    <button type="button" class="btn btn-primary" id="applyFilter">
                                        Terapkan
                                    </button>
                                </div>
                             </div>
                        </div>
                    </div> -->

                    <!-- Add Task Button -->
                    <!-- <div class="d-flex justify-content-start mb-4">
                        <button type="button" class="btn btn-success">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Tambah Kategori Task
                        </button>
                    </div> -->

                    <div class="row">
                        <!-- Duration Section -->
                        <div class="col-md-4">
                            <div class="card card-flush shadow-sm mb-4">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Duration</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="fs-1 fw-bold text-success">22</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                </div>
                            </div>
                        </div>

                        <!-- Finance Performance -->
                        <div class="col-md-4">
                            <div class="card card-flush shadow-sm mb-4">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Finance Performance</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="fs-1 fw-bold text-success">30 %</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                </div>
                            </div>
                        </div>

                        <!-- WP Performance -->
                        <div class="col-md-4">
                            <div class="card card-flush shadow-sm mb-4">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">WP Performance</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="fs-1 fw-bold text-primary">30 %</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                </div>
                            </div>
                        </div>

                        <!-- Timesheet Button -->
                        <div class="d-flex justify-content-end mb-4">
                            <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                Timesheet
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Kebutuhan Tenaga Kerja Section -->
                        <div class="card card-flush shadow-sm mb-6">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Kebutuhan Tenaga Kerja</h3>
                            </div>
                            <div class="card-body">
                                <!-- Search Form -->
                                <div>
                                    <form class="d-flex justify-content-end mb-4">
                                        <label class="me-5 mt-3" for="searchTask">Cari: </label>
                                        <input class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" style="width:200px" type="search" placeholder="Cari Data" aria-label="Search">                    
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <table id="tabel_wp_tenaga_kerja" class="table table-bordered border gy-5 gs-7 border rounded w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="fw-bold text-gray-800">Personel</th>
                                                <th class="fw-bold text-gray-800 text-center">JTK</th>
                                                <th class="fw-bold text-gray-800 text-center">JHK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-semibold">Project Manager</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">4</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Senior Consultant</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">10</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Associate Consultant</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">10</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Junior Consultant</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">4</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Technical Writer</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">20</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            Footer
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let resourceCounter = 2;

$(document).ready(function () {
    initTabelWPTask();
    initTabelWPTenagaKerja();

    // Resource management
    
    // Add Resource Button Click Event
    $('#addResourceBtn').on('click', function() {
        addNewResource();
    });
});

function initTabelWPTask() {
    $('#tabel_wp_task').DataTable({
        'scrollY': '300px',
        "scrollX": true,
        "fixedHeader": {
            "header":true,
            "headerOffset": 70
        }
    });
}

function initTabelWPTenagaKerja() {
    $('#tabel_wp_tenaga_kerja').DataTable({
        'scrollY': '300px',
        "scrollX": true,
        // "fixedHeader": {
        //     "header":true,
        //     "headerOffset": 70
        // }
    });
}

/* ADD RESOURCE BUTTON FORM */
function addNewResource() {
    const resourceHtml = `
        <div class="input-group mb-2" id="resource-${resourceCounter}">
            <select class="form-select" name="resources[]">
                <option value="">Pilih Resource</option>
                <option value="pm">Project Manager (PM)</option>
                <option value="sc">Senior Consultant (SC)</option>
                <option value="asc">Associate Consultant (ASC)</option>
                <option value="jc">Junior Consultant (JC)</option>
                <option value="tw">Technical Writer (TW)</option>
                <option value="osc">On-Site Consultant (OSC)</option>
            </select>
            <button type="button" class="btn btn-light-danger" onclick="removeResource(${resourceCounter})">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                </svg>
            </button>
        </div>
    `;
    
    $('#resourceContainer').append(resourceHtml);
    resourceCounter++;
}

function removeResource(index) {
    const resourceCount = $('#resourceContainer .input-group').length;
    
    // Pastikan minimal ada 1 resource yang tersisa
    if (resourceCount > 1) {
        $(`#resource-${index}`).remove();
    } else {
        alert('Minimal harus ada 1 resource!');
    }
}

// Function untuk toggle sub-rows
function toggleSubRows(rowId) {
    const icon = document.getElementById('icon-' + rowId);
    const subRows = document.getElementById('subRows-' + rowId);
    
    if (subRows.classList.contains('show')) {
        // Collapse
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-right');
    } else {
        // Expand
        icon.classList.remove('bi-chevron-right');
        icon.classList.add('bi-chevron-down');
    }
}
</script>
@endpush