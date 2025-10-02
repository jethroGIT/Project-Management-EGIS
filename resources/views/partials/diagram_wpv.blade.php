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
        
        // Tinggi container tetap menggunakan yang dikirim dari controller
        $containerHeight = $tinggiDiagram;
    @endphp
    <div style="position: relative; width: {{ count($bulanIndonesia) * $lebarBulan }}px; height: {{ $containerHeight }}px;">
        <!-- Hanya header bulan di bagian atas -->
        <div style="position: sticky; top: 0; z-index: 3; background: #fff;">
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
            @php
                $colorList = [
                    ['bg' => 'bg-primary'],
                    ['bg' => 'bg-success'],
                    ['bg' => 'bg-info'],
                    ['bg' => 'bg-danger'],
                ];
                $colorCount = count($colorList);
            @endphp

            <!-- Garis vertikal pembatas bulan -->
            {{-- @for($i = 0; $i <= count($bulanIndonesia); $i++)
                <div style="
                    position: absolute;
                    left: {{ $i * $lebarBulan }}px;
                    top: 0;
                    height: {{$contentHeight}}px;
                    width: 1px;
                    background-color: #ddd;
                    z-index: 1;
                "></div>
            @endfor --}}
            
            @foreach($wpvWithPeriod as $wpv)
                @php
                    \Carbon\Carbon::setLocale('id');
                    $startMonth = \Carbon\Carbon::parse($wpv->start_date)->month;
                    $endMonth = \Carbon\Carbon::parse($wpv->end_date)->month;
                    
                    if ($startMonth > $endMonth) {
                        $endMonth = $endMonth + 12;
                    }
                    
                    $topPosition = ($loop->index * ($rowHeight + $spacing)) + 60;
                    $leftPosition = ($startMonth - 1) * $lebarBulan;
                    $width = ($endMonth - $startMonth + 1) * $lebarBulan;
                    
                    $color = $colorList[$loop->index % $colorCount];
                    
                    // Calculate progress
                    $progress = $wpv->performance ?? 0;
                    $progressWidth = $width * ($progress / 100);
                @endphp
                
                <div class="d-flex align-items-center justify-content-between position-relative"
                    style="position: absolute; top: {{ $topPosition }}px; left: {{ $leftPosition }}px; height: {{ $rowHeight }}px; z-index: 2; width: {{ $width }}px;">
                    
                    <!-- Main rounded pill with WP info -->
                    <div class="{{ $color['bg'] }} rounded-pill" style="width: 100%; position: relative; overflow: hidden;">
                        <!-- Progress bar overlay -->
                        @if($progress > 0)
                            <div class="progress-overlay" style="position: absolute; top: 0; left: 0; height: 100%; width: {{ $progressWidth }}px;"></div>
                        @endif
                        
                        <!-- Content -->
                        <div class="d-flex align-items-center justify-content-between p-2 px-3 position-relative" style="z-index: 2;">
                            <!-- Left side: WP Number and Period -->
                            <div class="d-flex align-items-center">
                                <span class="fw-bold text-light">
                                    WP {{ $wpv->workPackage->wp_number }}
                                </span>
                                <span class="fw-bold text-light ms-3">
                                    {{ \Carbon\Carbon::parse($wpv->start_date)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($wpv->end_date)->translatedFormat('d M') }}
                                </span>
                            </div>
                            
                            <!-- Right side: Progress percentage -->
                            <div>
                                <span class="badge bg-light text-dark">{{ $progress }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    /* Hover effect for the pills */
    .rounded-pill:hover {
        /* filter: brightness(1.05); */
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease-in-out;
    }
    
    /* Handle text overflow */
    .rounded-pill span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Badge styling */
    .badge {
        font-size: 0.85rem;
        padding: 5px 8px;
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .rounded-pill {
            padding-left: 10px;
            padding-right: 10px;
        }
    }
</style>