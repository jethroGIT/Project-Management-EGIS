@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-0 mb-5">Manajemen Peran</h1>

    <!-- Card Roles -->
    <div class="card card-flush shadow-sm mb-6">
        <div class="card-body row">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Add Resource Button -->
                <div class="d-flex justify-content-start mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="bi bi-plus-lg fs-2 me-1"></i>
                        Tambah Peran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection