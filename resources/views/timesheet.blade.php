@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-10 mt-2">Timesheet Activity</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-10">
                <a href="#" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <h2 class="my-3 mb-3">WP 3.1 Human Security Risk Awareness Program Planning</h2>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0">Summary</p>
                <div class="d-flex align-items-center">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6 me-2">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">February</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">March</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">April</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4">May</a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-light btn-sm border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; margin-bottom: 10px;">
                        <i class="bi bi-plus fs-2 text-dark" style="margin-left: 5px"></i>
                    </a>
                </div>
            </div>
            <div>
                <a href="#" class="btn btn-light btn-sm border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; margin-bottom: 10px;" data-bs-toggle="collapse" data-bs-target="#filterCard" aria-expanded="false" aria-controls="filterCard">
                    <i class="bi bi-filter fs-2 text-dark" style="margin-left: 5px"></i>
                </a>
                <div class="collapse mt-2" id="filterCard">
                    <div class="card card-body rounded-0 border shadow-sm mb-7">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-filter fs-2 text-dark" style="margin-bottom: 10px; margin-right: 5px;"></i>
                            <h5 class="mb-3">Filter Data</h5>
                        </div>
                        <div class="mb-2">
                            <label for="filterTask" class="form-label">Pekan</label>
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm border border-secondary rounded-0 dropdown-toggle 
                                                d-flex justify-content-between align-items-center
                                                border-0 border-bottom border-1 border-secondary" 
                                        type="button" id="dropdownPekan" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="width: 200px; text-align: left;">
                                    <span>Pilih Pekan</span>
                                </button>
                                <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownPekan">
                                    <li><a class="dropdown-item" href="#">Minggu ke-1</a></li>
                                    <li><a class="dropdown-item" href="#">Minggu ke-2</a></li>
                                    <li><a class="dropdown-item" href="#">Minggu ke-3</a></li>
                                    <li><a class="dropdown-item" href="#">Minggu ke-4</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <button class="btn btn-sm btn-light rounded-0 me-2" style="box-shadow: 2px 2px 6px rgba(0,0,0,0.25);">
                                Terapkan
                            </button>
                            <button class="btn btn-sm btn-light rounded-0 me-2" style="box-shadow: 2px 2px 6px rgba(0,0,0,0.25);">
                                Hapus Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <label class="mb-0">Tampilkan</label>
                    <div class="dropdown d-flex align-items-center">
                        <button class="btn btn-light btn-sm border border-secondary rounded-0 dropdown-toggle d-flex justify-content-between align-items-center border-0 border-bottom border-1 border-secondary" 
                                type="button" id="dropdownView" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="ms-1">10</span>
                        </button>
                        <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownView">
                            <li><a class="dropdown-item" href="#">10</a></li>
                            <li><a class="dropdown-item" href="#">25</a></li>
                            <li><a class="dropdown-item" href="#">50</a></li>
                        </ul>
                    </div>
                    <label class="mb-0">data per halaman</label>
                </div>
                <form class="d-flex justify-content-end align-items-center">
                    <label class="me-5 mt-3 mb-0" for="searchTask">Cari: </label>
                    <input class="form-control rounded-0 bg-light border-0 border-bottom border-1 border-secondary mt-3" style="width:200px" type="search" placeholder="Cari Data" aria-label="Search">                    
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3">
                    <thead>
                        <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                            <th scope="col" style="width: 20px;">No</th>
                            <th scope="col" style="width: 70px; min-width: 40px;">Tanggal</th>
                            <th scope="col" style="width: 80px;">(Project Manager) Oki</th>
                            <th scope="col" style="width: 80px;">(Senior Consultant) Restia</th>
                            <th scope="col" style="width: 80px;">(Associate Consultant) Yudis</th>
                            <th scope="col" style="width: 80px;">(Junior Consultant) Annisa</th>
                            <th scope="col" style="width: 80px;">(Technical Writer) Vanika</th>
                            <th scope="col" style="width: 50px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>14</td>
                            <td>Eu minim eiusmod eiusmod ex velit exercitation occaecat do.</td>
                            <td>Ullamco nulla occaecat incididunt nulla.</td>
                            <td>Ullamco nulla occaecat incididunt nulla.</td>
                            <td>Ullamco nulla occaecat incididunt nulla.</td>
                            <td>Ullamco nulla occaecat incididunt nulla.</td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots fs-3 text-dark"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end rounded-0">
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <i class="bi bi-pencil ms-1 me-3 text-dark"></i>Edit</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <i class="bi bi-trash ms-1 me-3 text-dark"></i>Hapus</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <i class="bi bi-plus fs-2 me-1 text-dark"></i>Tambah Baris di Atas</a>
                                        </li>
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <i class="bi bi-plus fs-2 me-1 text-dark"></i>Tambah Baris di Bawah</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>            
                    </tbody>
                </table>
            </div> 
            <ul class="pagination justify-content-end">
                <li class="page-item previous"><a href="#" class="page-link"><i class="previous"></i></a></li>
                <li class="page-item active"><a href="#" class="page-link">1</a></li>
                <li class="page-item "><a href="#" class="page-link">2</a></li>
                <li class="page-item "><a href="#" class="page-link">3</a></li>
                <li class="page-item "><a href="#" class="page-link">...</a></li>
                <li class="page-item "><a href="#" class="page-link">5</a></li>
                <li class="page-item "><a href="#" class="page-link">6</a></li>
                <li class="page-item next"><a href="#"  class="page-link"><i class="next"></i></a></li>
            </ul>
            <div class="col-md-6 border border-gray bg-light h-100 px-3">
                <span class="fw-bold mt-2 mb-2 d-flex justify-content-center">Total Mandays Sementara</span>
                <div class="row" style="height: 40px;">
                    <div class="col-md-6 border bg-light h-100 d-flex align-items-center">
                        <span class="fw-bold">Project Manager</span>
                    </div>
                    <div class="col-md-6 border bg-white h-100 d-flex align-items-center">
                        <span class="text">5</span>
                    </div>
                </div>
                <div class="row" style="height: 40px;">
                    <div class="col-md-6 border bg-light h-100 d-flex align-items-center">
                        <span class="fw-bold">Senior Consultant</span>
                    </div>
                    <div class="col-md-6 border bg-white h-100 d-flex align-items-center">
                        <span class="text">10</span>
                    </div>
                </div>
                <div class="row" style="height: 40px;">
                    <div class="col-md-6 border bg-light h-100 d-flex align-items-center">
                        <span class="fw-bold">Associate Consultant</span>
                    </div>
                    <div class="col-md-6 border bg-white h-100 d-flex align-items-center">
                        <span class="text">8</span>
                    </div>
                </div>
                <div class="row" style="height: 40px;">
                    <div class="col-md-6 border bg-light h-100 d-flex align-items-center">
                        <span class="fw-bold">Junior Consultant</span>
                    </div>
                    <div class="col-md-6 border bg-white h-100 d-flex align-items-center">
                        <span class="text">6</span>
                    </div>
                </div>
                <div class="row" style="height: 40px;">
                    <div class="col-md-6 border bg-light h-100 d-flex align-items-center">
                        <span class="fw-bold">Technical Writer</span>
                    </div>
                    <div class="col-md-6 border bg-white h-100 d-flex align-items-center">
                        <span class="text">4</span>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection

<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Deskripsi Task Personel</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="taskDescription" rows="3" placeholder="Deskripsi/sub-task"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="utilizationPercentage" class="form-label">Persentase Utilisasi</label>
                        <input type="number" step="0.01" class="form-control" id="utilizationPercentage" placeholder="% Utilisasi">
                    </div>
                    <div class="mb-3">
                        <label for="taskDate" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="taskDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light rounded-0" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-0" id="saveSuccessful">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    const button = document.getElementById('saveSuccessful');

    button.addEventListener('click', e => {
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
</script>

