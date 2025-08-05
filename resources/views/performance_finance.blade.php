@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-10 mt-2 mb-3">Finance Performance</h1>
    <div class="card bg-white shadow border-0 rounded-0 mb-5" style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-7">
                <a href="{{route('work-package.detail', $volume_id)}}" class="btn btn-light btn-sm me-3 border border-secondary rounded-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left text-dark" style="margin-left: 5px"></i>
                </a>
                <h2 class="my-3 mb-0 mt-1">WP {{ $workPackage->wp_number }} {{ $workPackage->name }}</h2>
            </div>
            <div class="row mt-4 align-items-center" style="height: 50px; padding: 0px 0px;">
                <div class="col-md-4 d-flex align-items-center" style="height: 40px">
                    <div class="border bg-light h-100 d-flex align-items-center justify-content-center w-100">
                            <span class="fw-bold">WP Value</span>
                    </div>
                    <div class="border h-100 d-flex align-items-center justify-content-center w-100"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Rencana"
                    >
                        <span class="text">{{ number_format($totalByYoy, 0, ',', '.') }}</span>
                    </div>
                </div>                    
            </div> 
            <div class="table-responsive mt-5">
                {{-- @if($activities->isNotEmpty()) --}}
                <table class="table table-hover border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-3" id="kt_datatable_example_2">
                    <thead class="border border-1 border-secondary bg-light">
                        <tr class="border-bottom border-1 border-secondary">
                            <th scope="col" rowspan="2" class="text-center align-middle border-end border-start border-secondary py-0" style="width: 160px">Personel</th>
                            <th scope="col" colspan="2" class="text-center align-middle border-end border-secondary py-1">Mandays</th>
                            <th scope="col" colspan="4" class="text-center align-middle border-start border-secondary py-1">Biaya</th>
                        </tr>
                        <tr>
                            <th class="text-center">Realisasi</th>                            
                            <th class="text-center">Rencana</th>
                            <th class="text-center">Tenaga Kerja</th>                            
                            <th class="text-center">By YoY</th>
                            <th class="text-center">Realisasi</th>
                            <th class="text-center">Sisa</th>
                        </tr>
                    </thead> 
                    <tbody class="border-bottom border-1 border-secondary">
                        @foreach($costsPerRole as $cost)
                            <tr>
                                <td class="text-start align-middle">{{ $cost['role_name'] }}</td>
                                <td class="text-center align-middle">{{ $cost['timesheet_count'] }}</td>
                                <td class="text-center align-middle">{{ $cost['jhk'] }}</td>
                                <td class="text-center align-middle">{{ number_format($cost['resource_cost'], 0, ',', '.') }}</td>
                                <td class="text-center align-middle">{{ number_format($cost['by_yoy'], 0, ',', '.') }}</td>
                                <td class="text-center align-middle">{{ number_format($cost['realization_cost'], 0, ',', '.') }}</td>
                                <td class="text-center align-middle">{{ number_format($cost['remaining_cost'], 0, ',', '.') }}</td>               
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold">
                        <tr>
                            <td colspan="5" class="text-start">Total Keuangan</td>
                            <td class="text-center">{{ number_format($totalRealization, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-start">Biaya Overtime</td>
                            <td class="text-center">{{ number_format($overtimeCost, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-start">Persentase</td>
                            <td class="text-center">{{ number_format($realizationPercentage, 2)}}%</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                {{-- @else
                    <p>Tidak ada data Timesheet</p>
                @endif --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // initTabelFinance();
    });

    // function initTabelFinance() {
    //     const table = $('#kt_datatable_example_2').DataTable({
    //         // "scrollY": '500px',
    //         "scrollX": true,
    //         "fixedHeader": {
    //             "header": true,
    //             "headerOffset": 70
    //         },
    //         "ordering": false // Disable sorting
    //     });
    // }
</script>
@endpush