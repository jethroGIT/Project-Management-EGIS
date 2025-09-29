<div class="table-responsive pb-10" style="overflow-x: auto; max-height: 350px;">
    <div style="display: flex;">
        <!-- Sumbu Y (Label) sticky di kiri, mulai dari atas -->
        <div style="
            position: sticky;
            left: 0;
            top: 0;
            background: #fff;
            width: 110px;
            min-width: 110px;
            max-width: 110px;
            z-index: 3;
            flex-shrink: 0;
            box-shadow: 2px 0 4px -2px #eee;
        ">
            <!-- Header bulan, kosong agar sejajar dan tetap sticky -->
            <div style="height: 40px;"></div>
            @foreach($wpvWithPeriod as $wpv)
                <div style="
                    padding: 10px 5px;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    font-size: 0.85rem;
                    border-bottom: 1px solid #f5f5f5;
                    height: 60px;
                    display: flex;
                    align-items: center;
                ">
                    WP {{ $wpv->workPackage->wp_number }}
                </div>
            @endforeach
        </div>
        <!-- Kolom diagram (bulan & item) -->
        <div style="position: relative; min-width: {{ count($bulanIndonesia) * $lebarBulan }}px; height: {{ $tinggiDiagram }}px; flex: 1;">
            <!-- Sumbu X (Bulan Indonesia) sticky di atas -->
            <div style="position: sticky; top: 0; z-index: 1; background: #fff;">
                <div style="display: flex; border-bottom: 1px solid #ddd;">
                    @foreach($bulanIndonesia as $index => $bulan)
                        <div style="
                            width: {{ $lebarBulan }}px; 
                            text-align: center;
                            padding: 10px;
                            font-weight: 500;
                        ">{{ $bulan }}</div>
                    @endforeach
                </div>
            </div>
            <!-- Diagram WPV -->
            <div style="position: relative;">
                @php
                    $colorList = [
                        ['bg' => 'bg-primary'],
                        ['bg' => 'bg-success'],
                        ['bg' => 'bg-info'],
                        ['bg' => 'bg-danger'],
                    ];
                    $colorCount = count($colorList);
                @endphp
                @foreach($wpvWithPeriod as $wpv)
                    @php
                        \Carbon\Carbon::setLocale('id');
                        $startMonth = \Carbon\Carbon::parse($wpv->start_date)->month;
                        $endMonth = \Carbon\Carbon::parse($wpv->end_date)->month;
                        $topPosition = ($loop->index * 60);
                        $leftPosition = ($startMonth - 1) * $lebarBulan;
                        $width = ($endMonth - $startMonth + 1) * $lebarBulan;
                        $color = $colorList[$loop->index % $colorCount];
                    @endphp
                    <div class="d-flex align-items-center"
                        style="position: absolute; top: {{ $topPosition }}px; left: {{ $leftPosition }}px; height:60px; z-index:2;">
                        <div class="{{ $color['bg'] }} rounded-pill d-flex align-items-center px-2" style="width: {{ $width }}px;">
                            <span class="fw-bold text-light ms-3">
                                {{ \Carbon\Carbon::parse($wpv->start_date)->translatedFormat('d F') }} - {{ \Carbon\Carbon::parse($wpv->end_date)->translatedFormat('d F') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Garis vertikal pembatas bulan -->
            @for($i = 0; $i <= count($bulanIndonesia); $i++)
                <div style="
                    position: absolute;
                    left: {{ $i * $lebarBulan }}px;
                    top: 0;
                    height: 100%;
                    width: 1px;
                    background-color: #ddd;
                    z-index: 0;
                "></div>
            @endfor
        </div>
    </div>
</div>