@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-10 mt-2 mb-3">Work Package Category Management</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-7">
                <h2 class="my-3 mb-0 mt-1">Manage Work Package Categories</h2>
            </div>
            <div class="table-responsive mt-5">
                @if($wpCategories->isNotEmpty())
                    <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                        <thead>
                            <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                                <th scope="col" style="width: 40px;">No</th>
                                <th scope="col">WP Categories</th>                      
                                <th scope="col" style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.92rem;">
                            @foreach($wpCategories as $wpCategory)
                            <tr>
                                <th scope="row" class="align-middle">{{$loop->index+1}}</th>
                                <td class="align-middle">{{$wpCategory->name}}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-2">
                                        edit
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        delete
                                    </button>                                    
                                </td>
                            </tr>  
                            @endforeach          
                        </tbody>
                    </table>
                @else
                    <p>Tidak ada data Timesheet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
     // Initialize the DataTable
    $(document).ready(function() {
        initTabelTimesheet();
    });

    function initTabelTimesheet() {
        const table = $('#kt_datatable_example_2').DataTable({
            // "scrollY": '500px',
            "scrollX": true,
            "fixedHeader": {
                "header": true,
                "headerOffset": 70
            },
            "ordering": false // Disable sorting
        });

        // setupActivitySearch(table);
    }
</script>
@endpush
