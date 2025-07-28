@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-10 mt-2 mb-3">Timesheet Management</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-7">
                <h2 class="my-3 mb-0 mt-1">Manage Timesheet Activities</h2>
            </div>
            {{-- <div class="table-responsive">
                @if($monthDates->isNotEmpty())
                    <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                        <thead>
                            <tr class="fw-semibold fs-4 text-gray-1000 bg-light">
                                <th scope="col" style="width: 40px;">No</th>
                                <th scope="col" style="width: 70px; min-width: 40px;">Tanggal</th>
                                @foreach($usersInSelectedMonth as $user)
                                    <th scope="col" style="width: 80px;">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{$user->role->name}}">{{$user->name}}</span>
                                    </th>     
                                @endforeach                       
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.92rem;">
                            @foreach($monthDates as $date => $entries)
                            <tr>
                                <th scope="row">{{$loop->index+1}}</th>
                                <td>{{\Carbon\Carbon::parse($date)->format('d')}}</td>
                                @foreach($usersInSelectedMonth as $user)
                                    <td>
                                        @php
                                            $userEntry = $entries->where('user_id', $user->user_id)->first();
                                        @endphp
                                        {{ $userEntry->activity ?? '-'}}
                                    </td>
                                @endforeach                                        
                            </tr>  
                            @endforeach          
                        </tbody>
                    </table>
                @else
                    <p>Tidak ada data Timesheet</p>
                @endif
            </div> --}}
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
