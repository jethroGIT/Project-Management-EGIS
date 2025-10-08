<div class="table-responsive border border-secondary border-1 rounded pb-10" style="overflow-x: auto; width: 100%;">
    @php
        // Hitung tinggi total yang dibutuhkan berdasarkan jumlah WP
        $totalItems = count($wpvWithPeriod);
        $spacing = 7; // Spacing between rows
        $rowHeight = 35; // Height of each row
        $headerHeight = 40; // Tinggi header bulan
        $extraPadding = 80; // Ruang tambahan di atas dan bawah
        
        // Hitung tinggi konten aktual
        $contentHeight = ($totalItems * ($rowHeight + $spacing)) + $extraPadding;
        $borderHeight = (($totalItems * 1.7) * ($rowHeight + $spacing)) + $extraPadding;
        
        // Tinggi container tetap menggunakan yang dikirim dari controller
        $containerHeight = $tinggiDiagram;

        // panjang border pembatas bulan
        $gridHeight = max($borderHeight, $containerHeight);
    @endphp
    <div style="position: relative; width: {{ count($bulanIndonesia) * $lebarBulan }}px; height: {{ $containerHeight }}px;">
        <!-- Hanya header bulan di bagian atas -->
        <div style="position: sticky; top: 0; z-index: 5; background: #fff;">
            <div style="display: flex;">
                @foreach($bulanIndonesia as $index => $bulan)
                    <div style="
                        width: {{ $lebarBulan }}px; 
                        min-width: {{ $lebarBulan }}px; 
                        max-width: {{ $lebarBulan }}px; 
                        flex: 0 0 {{ $lebarBulan }}px;
                        text-align: center;
                        padding: 10px;
                        font-weight: 500;
                        background-color: #f8f9fa;
                        overflow: hidden;
                        white-space: nowrap;
                        text-overflow: ellipsis;
                        border-bottom: 1px solid #ddd;
                    ">{{ $bulan }}</div>
                @endforeach
            </div>
        </div>
        
        <!-- Diagram WPV -->
        <div style="position: relative; height:{{$contentHeight}}px;">
            <div class="month-grid-lines" style="
                position: absolute;
                left: 0; 
                width: 100%;
                height: {{ $gridHeight }}px;
                z-index: 3; 
                pointer-events: none;
            ">
                @foreach($bulanIndonesia as $index => $bulan)
                    <div class="month-grid-line" style="left: {{ $index * $lebarBulan }}px;"></div>
                @endforeach
            </div>
            @php
                $colorList = [
                    ['bg' => 'bg-primary'],
                    ['bg' => 'bg-success'],
                    ['bg' => 'bg-info'],
                    ['bg' => 'bg-danger'],
                ];
                $colorCount = count($colorList);

                // Kumpulkan nomor WP unik per WO
                $wpNumbersByWo = [];
                foreach ($wpvWithPeriod as $v) {
                    $woId = $v->wo_id ?? null;
                    $wpNum = optional($v->workPackage)->wp_number;
                    if ($woId && $wpNum) {
                        $wpNumbersByWo[$woId][$wpNum] = true;
                    }
                }
                // Ubah ke array terurut
                foreach ($wpNumbersByWo as $woId => $set) {
                    $list = array_keys($set);
                    usort($list, function($a, $b) {
                        $aParts = array_map('intval', explode('.', (string) $a));
                        $bParts = array_map('intval', explode('.', (string) $b));
                        $max = max(count($aParts), count($bParts));
                        for ($i = 0; $i < $max; $i++) {
                            $ai = $aParts[$i] ?? 0;
                            $bi = $bParts[$i] ?? 0;
                            if ($ai !== $bi) return $ai <=> $bi;
                        }
                        return 0;
                    });
                    $wpNumbersByWo[$woId] = $list;
                }
            @endphp
            
            @foreach($wpvWithPeriod as $wpv)
                @php
                    \Carbon\Carbon::setLocale('id');
                    $startMonth = \Carbon\Carbon::parse($wpv->start_date)->month;
                    $endMonth = \Carbon\Carbon::parse($wpv->end_date)->month;
                    
                    if ($startMonth > $endMonth) {
                        $endMonth = $endMonth + 12;
                    }
                    
                    $topPosition = ($loop->index * ($rowHeight + $spacing)) + 40;
                    $leftPosition = ($startMonth - 1) * $lebarBulan;
                    $width = ($endMonth - $startMonth + 1) * $lebarBulan;
                    
                    $color = $colorList[$loop->index % $colorCount];
                    
                    // Calculate progress
                    $progress = $wpv->performance ?? 0;
                    $progressWidth = $width * ($progress / 100);

                    // Tooltip periode
                   $periodeTooltip = \Carbon\Carbon::parse($wpv->start_date)->translatedFormat('d M') . ' - ' . \Carbon\Carbon::parse($wpv->end_date)->translatedFormat('d M');
                @endphp
                
                <div class="position-relative"
                    style="position: absolute; top: {{ $topPosition }}px; left: {{ $leftPosition }}px; height: {{ $rowHeight }}px; z-index: 4; width: {{ $width }}px;">
                    
                    <!-- Main rounded pill with WP info -->
                    <div class="progress-bar-container" style="width: 100%; height: 100%; background-color: #e9ecef; border-radius: 10px; overflow: hidden; position: relative;">
                        <div 
                            class="progress-bar-container" 
                            style="width: 100%; height: 100%; background-color: #e9ecef; border-radius: 10px; overflow: hidden; position: relative;"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-container="body"
                            title="Periode: {{ $periodeTooltip }}"
                            aria-label="{{ $periodeTooltip }}"
                        >
                            <!-- Progress bar overlay -->
                            @if($progress > 0)
                                <div class="progress-fill {{ $color['bg'] }}" style="width: {{ $progress }}%; height: 100%; position: absolute; top: 0; left: 0;"></div>
                            @endif
                        
                            <!-- Content -->
                            <div class="d-flex align-items-center justify-content-between p-2 px-3 position-relative" style="z-index: 4; height: 100%;">
                                <!-- Left side: WP Number and Period -->
                                <div class="d-flex align-items-center">
                                    <span class="fw-bold {{ $progress > 20 ? 'text-light' : 'text-dark' }}">
                                        WO {{ $wpv->workOrder->wo_number }} - WP {{ implode(', ', $wpNumbersbyWo[$wpv->wo_id] ?? [optional($wpv->workPackage)->wp_number]) }}
                                    </span>
                                </div>
                                
                                <!-- Right side: Progress percentage -->
                                <div>
                                    <span class="badge bg-light text-dark">{{ $progress }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        if (!window.bootstrap) return;
        document.querySelectorAll('.progress-bar-container[data-bs-toggle="tooltip"]').forEach(function (el) {
            if (!bootstrap.Tooltip.getInstance(el)) {
                new bootstrap.Tooltip(el);
            }
        });
    })();
</script>
@endpush

<style>
    /* Hover effect for the pills */
    /* .rounded-pill:hover {
        /* filter: brightness(1.05);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease-in-out;
    } */
    
    /* Handle text overflow */
    /* .rounded-pill span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } */

    /* Month grid lines */
    .month-grid-line {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 0;
        border-left: 1px solid rgba(0, 0, 0, 0.15);
    }

    /* Progress bar hover effect */
    .progress-bar-container:hover {
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease-in-out;
    }
    
    /* Smooth transition for progress fill */
    .progress-fill {
        transition: width 0.5s ease-in-out;
    }
    
    /* Badge styling */
    .badge {
        font-size: 0.85rem;
        padding: 5px 8px;
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    /* Responsive adjustments */
    /* @media (max-width: 767.98px) {
        .rounded-pill {
            padding-left: 10px;
            padding-right: 10px;
        }
    } */
</style>