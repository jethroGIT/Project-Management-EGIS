@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="my-10">Task</h1>

    <div class="card card-flush shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Title</h3>
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
                    <!-- Filter Button -->
                    <div class="d-flex justify-content-start mb-4">
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                            </svg>
                            Filter Data
                        </button>
                    </div>

                    <!-- Filter Collapse -->
                    <div class="collapse" id="filterCollapse">
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
                    </div>

                    <!-- Add Task Button -->
                    <div class="d-flex justify-content-start mb-4">
                        <button type="button" class="btn btn-success">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Tambah Kategori Task
                        </button>
                    </div>

                    <!-- Search Form -->
                    <div>
                        <form class="d-flex justify-content-end mb-4">
                            <label class="me-5 mt-3" for="searchTask">Cari: </label>
                            <input class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" style="width:200px" type="search" placeholder="Cari Data" aria-label="Search">                    
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="kt_datatable_example_2" class="table table-striped border gy-5 gs-7 border rounded w-100">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                    <th>Kategori</th>
                                    <th class="align-middle border-bottom min-w-100px">No</th>
                                    <th class="align-middle border-bottom min-w-200px">Task</th>
                                    <th class="align-middle border-bottom min-w-200px">Actual Scope</th>
                                    <th class="align-middle border-bottom min-w-400px">Deliverables</th>
                                    <th class="align-middle border-bottom min-w-100px">Durations</th>
                                    <th class="align-middle border-bottom min-w-100px">% Complete</th>
                                    <th class="align-middle border-bottom min-w-200px">Resource Names</th>
                                    <th class="align-middle border-bottom">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Management of Human Security Risk Programs</td>
                                    <td>1.1</td>
                                    <td>Human Security Risk Awareness Program Planning</td>
                                    <td>"Human firewall design program (awareness) - IS competency matrix"</td>
                                    <td>
                                        Laporan perencanaan pengembangan awareness keamanan informasi, yang memuat:
                                        1. Metode pembangunan awareness
                                        2. Materi sosialisasi security awareness
                                        3. Materi pengujian berkala untuk topik security awareness
                                        4. Materi pelatihan dasar cyber hygiene, serta penggunaan tools pendukung cyber hygiene yang dimiliki PERUSAHAAN
                                        5. Dokumentasi workshop pengembangan awareness keamanan informasi (apabila dilaksanakan), termasuk di dalamnya materi workshop dan daftar hadir
                                    </td>
                                    <td>30 days</td>
                                    <td>81.6%</td>
                                    <td>
                                        Oki Jamhur (PM) 
                                        Restia (SC)
                                        Yudis (ASC) 
                                        Annisa Y (JC) 
                                        Vanika (TW)
                                    </td>
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
                                    <td>Management of Human Security Risk Programs</td>
                                    <td>1.2</td>
                                    <td>Human Security Risk Awareness Program Planning</td>
                                    <td>"Human firewall design program (awareness) - IS competency matrix"</td>
                                    <td>
                                        Laporan perencanaan pengembangan awareness keamanan informasi, yang memuat:
                                        1. Metode pembangunan awareness
                                        2. Materi sosialisasi security awareness
                                        3. Materi pengujian berkala untuk topik security awareness
                                        4. Materi pelatihan dasar cyber hygiene, serta penggunaan tools pendukung cyber hygiene yang dimiliki PERUSAHAAN
                                        5. Dokumentasi workshop pengembangan awareness keamanan informasi (apabila dilaksanakan), termasuk di dalamnya materi workshop dan daftar hadir
                                    </td>
                                    <td>30 days</td>
                                    <td>81.6%</td>
                                    <td>
                                        Oki Jamhur (PM) 
                                        Restia (SC)
                                        Yudis (ASC) 
                                        Annisa Y (JC) 
                                        Vanika (TW)
                                    </td>
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
                                    <td>Management of Information Security Compliance - Business Regulations</td>
                                    <td>2.1</td>
                                    <td>Human Security Risk Awareness Program Planning</td>
                                    <td>"Human firewall design program (awareness) - IS competency matrix"</td>
                                    <td>
                                        Laporan perencanaan pengembangan awareness keamanan informasi, yang memuat:
                                        1. Metode pembangunan awareness
                                        2. Materi sosialisasi security awareness
                                        3. Materi pengujian berkala untuk topik security awareness
                                        4. Materi pelatihan dasar cyber hygiene, serta penggunaan tools pendukung cyber hygiene yang dimiliki PERUSAHAAN
                                        5. Dokumentasi workshop pengembangan awareness keamanan informasi (apabila dilaksanakan), termasuk di dalamnya materi workshop dan daftar hadir
                                    </td>
                                    <td>30 days</td>
                                    <td>81.6%</td>
                                    <td>
                                        Oki Jamhur (PM) 
                                        Restia (SC)
                                        Yudis (ASC) 
                                        Annisa Y (JC) 
                                        Vanika (TW)
                                    </td>
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
                    
                    <!-- <ul class="pagination">
                        <li class="page-item previous disabled"><a href="#" class="page-link"><i class="previous"></i></a></li>
                        <li class="page-item "><a href="#" class="page-link">1</a></li>
                        <li class="page-item active"><a href="#" class="page-link">2</a></li>
                        <li class="page-item "><a href="#" class="page-link">3</a></li>
                        <li class="page-item "><a href="#" class="page-link">...</a></li>
                        <li class="page-item "><a href="#" class="page-link">5</a></li>
                        <li class="page-item "><a href="#" class="page-link">6</a></li>
                        <li class="page-item next"><a href="#"  class="page-link"><i class="next"></i></a></li>
                    </ul> -->
                </div>

                <!-- TAB WP KUANTITAS -->
                <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                    <!-- Filter Button -->
                    <div class="d-flex justify-content-start mb-4">
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                            </svg>
                            Filter Data
                        </button>
                    </div>

                    <!-- Filter Collapse -->
                    <div class="collapse" id="filterCollapse">
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
                    </div>

                    <!-- Add Task Button -->
                    <div class="d-flex justify-content-start mb-4">
                        <button type="button" class="btn btn-success">
                            <i class="bi bi-plus-lg fs-2 me-1"></i>
                            Tambah Kategori Task
                        </button>
                    </div>

                    <!-- Search Form -->
                    <div>
                        <form class="d-flex justify-content-end mb-4">
                            <label class="me-5 mt-3" for="searchTask">Cari: </label>
                            <input class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" style="width:200px" type="search" placeholder="Cari Data" aria-label="Search">                    
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="tabel_wp_kuantitas" class="table table-striped gy-5 gs-7 border rounded w-100">
                            <thead class="align-middle text-center">
                                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                    <th rowspan="3">Kategori</th>
                                    <th rowspan="3" class="border-bottom">No</th>
                                    <th rowspan="3" class="border-bottom min-w-200px">Task</th>
                                    <th rowspan="3" class="border-bottom">Volume (Qty)</th>
                                    <th rowspan="3" class="border-bottom min-w-100px">Durasi Kerja (Hari Kerja)</th>
                                    <th colspan="10" class="border-bottom">Kebutuhan Tenaga Kerja</th>
                                    <th rowspan="3" class="border-bottom">Finance Performance</th>
                                    <th rowspan="3" class="border-bottom">WP Performance</th>
                                    <th rowspan="3" class="border-bottom">Action</th>
                                </tr>
                                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                    <th colspan="2" class="border-bottom">Project Manager</th>
                                    <th colspan="2" class="border-bottom">Senior Consultant</th>
                                    <th colspan="2" class="border-bottom">Associate Consultant</th>
                                    <th colspan="2" class="border-bottom">Junior Consultant</th>
                                    <th colspan="2" class="border-bottom">Technical Writer</th>
                                </tr>
                                <tr class="">
                                    <th>JTK</th>
                                    <th>JHK</th>
                                    <th>JTK</th>
                                    <th>JHK</th>
                                    <th>JTK</th>
                                    <th>JHK</th>
                                    <th>JTK</th>
                                    <th>JHK</th>
                                    <th>JTK</th>
                                    <th>JHK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Management of Human Security Risk Programs</td>
                                    <td>1.1</td>
                                    <td>Merger & Acquisition (M&A) - Information Security Due Dilligence</td>
                                    <td>2</td>
                                    <td>46</td>
                                    <td>1</td>
                                    <td>6</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>2</td>
                                    <td>10</td>
                                    <td>20%</td>
                                    <td>20%</td>
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
                                    <td>Management of Human Security Risk Programs</td>
                                    <td>1.2</td>
                                    <td>Merger & Acquisition (M&A) - Information Security Due Dilligence</td>
                                    <td>2</td>
                                    <td>46</td>
                                    <td>1</td>
                                    <td>6</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>2</td>
                                    <td>10</td>
                                    <td>20%</td>
                                    <td>20%</td>
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
                                    <td>Management of Human Security Risk Programs</td>
                                    <td>1.3</td>
                                    <td>Merger & Acquisition (M&A) - Information Security Due Dilligence</td>
                                    <td>2</td>
                                    <td>46</td>
                                    <td>1</td>
                                    <td>6</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>2</td>
                                    <td>10</td>
                                    <td>20%</td>
                                    <td>20%</td>
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
                                    <td>Management of Information Security Compliance - Business Regulations</td>
                                    <td>2.1</td>
                                    <td>Merger & Acquisition (M&A) - Information Security Due Dilligence</td>
                                    <td>2</td>
                                    <td>46</td>
                                    <td>1</td>
                                    <td>6</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td>2</td>
                                    <td>10</td>
                                    <td>20%</td>
                                    <td>20%</td>
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
        </div>
        <div class="card-footer">
            Footer
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initTabelWPDetail();
    initTabelWPKuantitas();
});

function initTabelWPDetail() {
    $('#kt_datatable_example_2').DataTable({
        'scrollY': '500px',
        "scrollX": true,
        "fixedHeader": {
            "header":true,
            "headerOffset": 70
        },
        rowGroup: {
            dataSrc: 0,
            startRender: function (rows, group) {
                return $('<tr/>')
                    .append('<td colspan="9" class="fw-bold bg-light-primary text-dark px-4 py-3">' + group + '</td>');
            }
        },
        columnDefs: [
            {
                targets: 0,
                visible: false // Kolom kategori disembunyikan karena sudah ditampilkan sebagai grup
            }
        ]
    });
}

function initTabelWPKuantitas() {
    $('#tabel_wp_kuantitas').DataTable({
        'scrollY': '400px',
        "scrollX": true,
        // "fixedHeader": {
        //     "header":true,
        //     "headerOffset": 5
        // },
        rowGroup: {
            dataSrc: 0,
            startRender: function (rows, group) {
                return $('<tr/>')
                    .append('<td colspan="18" class="fw-bold bg-light-primary text-dark px-4 py-3">' + group + '</td>');
            }
        },
        columnDefs: [
            {
                targets: 0,
                visible: false // Kolom kategori disembunyikan karena sudah ditampilkan sebagai grup
            }
        ]
    });
}
</script>
@endpush
