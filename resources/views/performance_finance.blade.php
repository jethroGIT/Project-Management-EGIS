@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-10 mt-2"> Finance Performance</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-10">
                <a href="{{route ('work-package')}}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <h2 class="my-3 mb-3">WP 3.1 Human Security Risk Awareness Program Planning</h2>
            </div>
        </div>
    </div>
</div>
@endsection