@extends('layouts.app')

@section('content')
<div class="container-fluid">    
    <!-- profile -->
    <div class="row">
        <div class="col-md-5">
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Profile</h3>
                    </div>
                </div>
            </div>
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Work Package</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-flush shadow-sm mb-8">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Timesheet</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
