@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="my-10">Work Package</h1>

    <div class="card card-flush shadow-sm mb-8">
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
                    <div class="mb-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label fw-bold fs-6 text-dark mb-3">Task List</label>
                            
                            <!-- Search Form -->
                            <div>
                                <form class="d-flex justify-content-end mb-4">
                                    <label class="me-5 mt-3" for="searchTask">Cari: </label>
                                    <input class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary" style="width:200px" type="search" placeholder="Cari Data" aria-label="Search">                    
                                </form>
                            </div>
                        </div>
    
                        <!-- Task List Section -->
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
                                                <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                        <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="editTask(1.1)">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Atas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Bawah
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
                                                <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                        <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="editTask(1.1)">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Atas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Bawah
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
                                                <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                        <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="editTask(1.1)">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Atas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Bawah
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
                                                <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                        <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="editTask(1.1)">
                                                            <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                            <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Atas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_insert_task">
                                                            <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                            Masukkan di Bawah
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal for Adding Task -->
                        <div class="modal fade" tabindex="-1" id="kt_modal_insert_task">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Tambah Task</h3>

                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Nama Task</label>
                                            <input type="text" class="form-control" placeholder="Masukkan Nama Task"/>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-flush shadow mb-6">
                        <div class="card-body py-5">
                            <div class="d-flex justify-content-end mb-4">
                                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_data">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                    </svg>
                                    Edit Data
                                </button>

                                <div class="modal fade" tabindex="-1" id="kt_modal_edit_data">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">Edit Data</h3>

                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                                </div>
                                                <!--end::Close-->
                                            </div>

                                            <div class="modal-body">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Actual Scope</label>
                                                    <input type="text" class="form-control" placeholder="Masukkan Actual Scope"/>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Deliverables</label>
                                                    <textarea class="form-control" aria-label="With textarea" placeholder="Masukkan Deliverables"></textarea>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Start Date</label>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" id="startDate" placeholder="Pilih Tanggal Mulai"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">End Date</label>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" id="endDate" placeholder="Pilih Tanggal Selesai"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Resource Names</label>
                                                    <div id="resourceContainer">
                                                        <div class="input-group mb-2" id="resource-0">
                                                            <select class="form-select" name="resources[]">
                                                                <option value="">Pilih Resource</option>
                                                                <option value="pm">Project Manager (PM)</option>
                                                                <option value="sc">Senior Consultant (SC)</option>
                                                                <option value="asc">Associate Consultant (ASC)</option>
                                                                <option value="jc">Junior Consultant (JC)</option>
                                                                <option value="tw">Technical Writer (TW)</option>
                                                                <option value="osc">On-Site Consultant (OSC)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-light-primary" id="addResourceBtn">
                                                        <i class="bi bi-plus-lg"></i>
                                                        Tambah Resource
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="row">
                                <!-- Actual Scope -->
                                <div class="col-md-6 mb-4">
                                    <div class="card card-flush shadow-sm h-100">
                                        <div class="card-body">
                                            <h3 class="card-title fw-bold">Actual Scope</h3>
                                            <p class="mb-0 fs-6 text-dark fw-semibold">"Human firewall design program (awareness) - IS competency matrix"</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card card-flush shadow-sm h-100">
                                        <div class="card-body">
                                            <h3 class="card-title fw-bold">Total % Complete</h3>
                                            <div class="d-flex justify-content-center h-100">
                                                <span class="fs-1">30 %</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <!-- Deliverables -->
                                <div class="col-md-12 mb-4">
                                    <div class="card card-flush shadow-sm">
                                        <div class="card-body">
                                            <h3 class="card-title fw-bold">Deliverables</h3>
                                            <p class="mb-2 fs-7">
                                                Laporan perencanaan pengembangan awareness keamanan informasi, yang memuat: <br/>
                                                1. Metode pembangunan awareness <br/>
                                                2. Materi sosialisasi security awareness <br/>
                                                3. Materi pengujian berkala untuk topik security awareness <br/>
                                                4. Materi pelatihan dasar cyber hygiene, serta penggunaan tools pendukung cyber hygiene yang dimiliki PERUSAHAAN <br/>
                                                5. Dokumentasi workshop pengembangan awareness keamanan informasi (apabila dilaksanakan), termasuk di dalamnya materi workshop dan daftar hadir <br/>
                                            </p>
                                        </div>
                                    </div>
                                </div>
        
                                <!-- Resource Names -->
                                <div class="col-md-12">
                                    <div class="card card-flush shadow-sm">
                                        <div class="card-header">
                                            <h3 class="card-title fw-bold">Resource Names</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3 justify-content-center">
                                                <div class="col-md-4">
                                                    <div class="card card-bordered h-100">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title fs-6 fw-bold">Oki Jamhur</h5>
                                                            <span>Project Manager</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card card-bordered h-100">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title fs-6 fw-bold">Restia</h5>
                                                            <span>Senior Consultant</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card card-bordered h-100">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title fs-6 fw-bold">Yudis</h5>
                                                            <span>Associate Consultant</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card card-bordered h-100">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title fs-6 fw-bold">Annisa Y</h5>
                                                            <span>Junior Consultant</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card card-bordered h-100">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title fs-6 fw-bold">Vanika</h5>
                                                            <span>Technical Writer</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB WP KUANTITAS -->
                <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                    <div class="row">
                        <!-- Duration Section -->
                        <div class="col-md-4">
                            <div class="card card-flush shadow-sm mb-4 duration-card">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Duration</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center h-100 gap-2">
                                        <span class="fs-1 fw-bold text-primary duration-highlight">22</span>
                                        <span class="fs-1 text-primary duration-highlight">Hari</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                </div>
                            </div>
                        </div>

                        <!-- Finance Performance -->
                        <div class="col-md-4">
                            <div class="card card-flush shadow-sm mb-4 performance-card position-relative overlay-performance-card" onclick="window.location.href='{{ route('performance-finance') }}'" style="transition: box-shadow 0.2s, border-color 0.2s, background 0.2s; cursor:pointer;">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Finance Performance</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="fs-1 fw-bold text-success">30 %</span>
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                                <!-- Overlay -->
                                <div class="performance-overlay d-flex align-items-center justify-content-center">
                                    <span class="text-white fs-4 fw-bold">lihat detail &rarr;</span>
                                </div>
                            </div>
                        </div>

                        <!-- WP Performance -->
                        <div class="col-md-4">
                            <div class="card card-flush shadow-sm mb-4 performance-card position-relative overlay-performance-card" onclick="window.location.href='{{ route('performance-task') }}'" style="transition: box-shadow 0.2s, border-color 0.2s, background 0.2s; cursor:pointer;">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">WP Performance</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="fs-1 fw-bold text-info">30 %</span>
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                                <!-- Overlay -->
                                <div class="performance-overlay d-flex align-items-center justify-content-center">
                                    <span class="text-white fs-4 fw-bold">lihat detail &rarr;</span>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                        </div> --}}

                        <!-- Timesheet Button -->
                        <div class="d-flex justify-content-end mb-4">
                            <button type="button" class="btn btn-light-primary" onclick="window.location.href='{{ route('timesheet') }}'">
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
                                    <table id="tabel_wp_tenaga_kerja" class="table table-striped border gy-4 gs-7 border rounded w-100">
                                        <thead>
                                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                                <th class="align-middle border-bottom min-w-200px  mb-3">Personel</th>
                                                <th class="align-middle border-bottom  mb-3">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah Tenaga Kerja">JTK</span>                                                    
                                                </th>                                                
                                                <th class="align-middle border-bottom  mb-3">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah Hari Kerja">JHK</span>                                                    
                                                </th>
                                                <th class="align-middle border-bottom  mb-3 ">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Project Manager</td>
                                                <td>1</td>
                                                <td>4</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            {{-- <li>
                                                                <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                                    Hapus
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Atas
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Bawah
                                                                </a>
                                                            </li> --}}
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Senior Consultant</td>
                                                <td>1</td>
                                                <td>10</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            {{-- <li>
                                                                <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                                    Hapus
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Atas
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Bawah
                                                                </a>
                                                            </li> --}}
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Associate Consultant</td>
                                                <td>1</td>
                                                <td>10</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            {{-- <li>
                                                                <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                                    Hapus
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Atas
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Bawah
                                                                </a>
                                                            </li> --}}
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Junior Consultant</td>
                                                <td>1</td>
                                                <td>4</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            {{-- <li>
                                                                <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                                    Hapus
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Atas
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Bawah
                                                                </a>
                                                            </li> --}}
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Technical Writer</td>
                                                <td>1</td>
                                                <td>20</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-body btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                                                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-pencil-square me-3 fs-2 text-dark"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            {{-- <li>
                                                                <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(1.1)">
                                                                    <i class="bi bi-trash me-3 fs-2 text-dark"></i>
                                                                    Hapus
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Atas
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#jtkandjhkModal">
                                                                    <i class="bi bi-plus-circle me-3 fs-2 text-dark"></i>
                                                                    Masukkan di Bawah
                                                                </a>
                                                            </li> --}}
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" tabindex="-1" id="jtkandjhkModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola JTK dan JHK Personel</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jumlahTenagaKerja" class="form-label">Jumlah Tenaga Kerja</label>
                            <input type="number" class="form-control" id="jumlahTenagaKerja" placeholder="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jumlahHariKerja" class="form-label">Jumlah Hari Kerja</label>                        
                            <input type="number" class="form-control" id="jumlahHariKerja" placeholder="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveSuccessful">Simpan</button>
            </div>
        </div>
    </div>
</div>

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
    $('#tabel_wp_tenaga_kerja').DataTable();
}

const saveButton = document.getElementById('saveSuccessful');

saveButton.addEventListener('click', e => {
    e.preventDefault();

    Swal.fire({
        text: "Data berhasil disimpan!",
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Tutup",
        customClass: {
            confirmButton: "btn btn-secondary"
        }
    });
});

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

<style>
.performance-card {
    box-shadow: 0 0.5rem 1.5rem rgba(33, 37, 41, 0.25), 0 0.25rem 0.5rem rgba(33, 37, 41, 0.18);
    background: #f8fafc;
}
.performance-card:hover {
    box-shadow: 0 1.5rem 3rem rgba(0,0,0, 0.9), 0 0.5rem 1rem rgba(0,0,0, 0.9);
    background: #ffffff;
    transform: translateY(-2px) scale(0.985);
}

/* Custom style for Kebutuhan Tenaga Kerja table */
#tabel_wp_tenaga_kerja tbody tr {
    height: 32px;
}
#tabel_wp_tenaga_kerja td {
    padding-bottom: 0rem !important;
}
#tabel_wp_tenaga_kerja th {
    padding-bottom: 1.1rem !important;
}

/* Highlight Duration card number and text on hover */
.duration-card .duration-highlight {
    transition: transform 0.25s cubic-bezier(.4,2,.6,1), color 0.25s;
}
.duration-card:hover .duration-highlight {
    transform: scale(1.18);
}

/* HOVER EFFECT UNTUK RESOURCE NAMES CARDS */
.card-bordered {
    transition: all 0.3s ease;
    cursor: pointer;
}

.card-bordered:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.15);
    border-color: #007bff;
}

.card-bordered:hover .card-title {
    color: #007bff;
    transition: color 0.3s ease;
}

.card-bordered:hover span {
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Smooth transition untuk semua elemen dalam card */
.card-bordered .card-body {
    transition: all 0.3s ease;
}

.card-bordered .card-title {
    transition: color 0.3s ease;
}

.card-bordered span {
    transition: all 0.3s ease;
}

.card-bordered:hover .card-body {
    background-color: #f8f9fa;
}

/* for overlay card */
.overlay-performance-card {
    position: relative;
    overflow: hidden;
}

.performance-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(30, 30, 30, 0.7);
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    z-index: 2;
    pointer-events: none;
}

.overlay-performance-card:hover .performance-overlay {
    opacity: 1.2;
    pointer-events: auto;
}
</style>