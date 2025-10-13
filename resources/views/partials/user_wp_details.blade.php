<div class="d-flex justify-content-between align-items-center pb-3 w-90">
    <h5 class="mb-0">{{ $username }}</h5>
    <div>
        <span class="badge bg-warning">Berjalan: {{ $berjalan }}</span>
        <span class="badge bg-success me-1">Selesai: {{ $selesai }}</span>
        <span class="badge bg-primary me-1">Total: {{ $totalWp }}</span>
    </div>
</div>
<div class="card shadow-sm mb-3">
    <div class="card-body p-5">
        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr style="font-size: 0.99rem;">
                        <th rowspan="2" class="fw-bold">No.</th>
                        <th rowspan="2" class="fw-bold">Work Package</th>
                        <th colspan="2" class="text-center fw-bold p-0">Mandays</th>
                        <th rowspan="2" class="text-center fw-bold px-3">Volume</th>
                        <th rowspan="2" class="text-center fw-bold">Tahun</th>
                        <th rowspan="2" class="text-center fw-bold">Progress</th>
                        {{-- <th rowspan="2" class="text-center fw-bold">Status</th> --}}
                    </tr>
                    <tr style="font-size: 0.98rem;">
                        <th>Rencana</th>
                        <th>Realisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($workPackages as $wp)
                        <tr style="font-size: 0.93rem;">
                            <td>{{ $wp->wp_number }}</td>
                            <td>{{ $wp->name }}</td>
                            <td class="text-center">{{$wp->planned_mandays}}</td>
                            <td class="text-center">{{$wp->actual_mandays}}</td>
                            <td class="text-center">{{ $wp->volumes_count }}</td>
                            <td class="text-center">{{ $wp->execution_year }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center">
                                    <div class="progress w-100" style="height: 8px;">
                                        <div class="progress-bar {{ $wp->performance >= 100 ? 'bg-success' : 'bg-warning' }}" 
                                             role="progressbar" 
                                             style="width: {{ min($wp->performance, 100) }}%"
                                             aria-valuenow="{{ $wp->performance }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="ms-2">{{ round($wp->performance) }}%</span>
                                </div>
                            </td>
                            {{-- <td class="text-center">
                                @if($wp->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning">Berjalan</span>
                                @endif
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3">Tidak ada data work package</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>