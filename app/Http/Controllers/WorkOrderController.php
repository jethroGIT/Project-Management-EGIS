<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\WpCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index(){
        $workPackages = WorkPackage::with(['workPackageVolumes.workOrder', 'workPackageVolumes', 'wpCategory'])
            ->get()
            ->sortBy(function($wp) {
                // Urutkan dulu berdasarkan nomor kategori, lalu nomor WP
                $catNum = $wp->wpCategory->category_number ?? 9999;
                $wpNum = is_numeric($wp->wp_number) ? floatval($wp->wp_number) : $wp->wp_number;
                return sprintf('%04d-%s', $catNum, $wpNum);
            })
            ->values();

        // $workPackages = $workPackages->sortBy(function($wp) {
        //     return $wp->wpCategory->name ?? '-';
        // });
        
        $workOrders = WorkOrder::with('workPackageVolumes')->orderBy('wo_number', 'asc')->get();

        // $workOrders = $workOrders->sortBy(function($wo) {
        //     return $wo->wo_number . '-' . ($wo->workPackageVolumes->first()->execution_year ?? '');
        // });
        
        $categories = WpCategory::with('workPackage')->orderBy('category_number', 'asc')->get();

        foreach ($workOrders as $wo) {
            // Hitung jumlah volume yang menggunakan WO ini
            $wo->realization_qty = $wo->workPackageVolumes()->count();
        }

        foreach ($workPackages as $wp) {
            // Hitung jumlah volume yang belum menggunakan WO
            $wp->remaining = $wp->volume_qty - $wp->workPackageVolumes->whereNotNull('wo_id')->count();
            $remainingWPCount = collect($workPackages)->filter(function($wp) {
                // $wp->remaining sudah dihitung sebelumnya (misal: $wp->remaining = $wp->volume_qty - $totalWithWO)
                return $wp->remaining != 0;
            })->count();
            // format periode
            foreach ($wp->workPackageVolumes as $volume) {
                $periodFormatted = "Belum tersedia";
                if ($volume->start_date && $volume->end_date) {
                    $periodFormatted = Carbon::parse($volume->start_date)->format('d M Y') . 
                        ' - ' .
                        Carbon::parse($volume->end_date)->format('d M Y');
                }
                $volume->period_formatted = $periodFormatted;
            }
        }

        return view('work_order', compact('workPackages', 'categories', 'workOrders', 'remainingWPCount'));
    }

    public function add(Request $request){
        // add new work order
        try {
            $request->validate([
                'wo_number' => 'required|string|unique:work_order,wo_number',
            ]);

            $wo = WorkOrder::create([
                'wo_number' => $request->wo_number,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Order berhasil ditambahkan.',
                'data' => $wo
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function assign(Request $request){
        // assign multiple volumes to work order
        try {
            $volumeIds = (array) $request->volume_id;
            $updated = 0;
            $skipped = 0;

            foreach ($volumeIds as $vid) {
                $volume = WorkPackageVolume::where('volume_id', $vid)->first();
                if (!$volume) continue;

                if ($request->wo_id == $volume->wo_id) {
                    $skipped++;
                    continue;
                }

                $volume->update([
                    'wo_id' => $request->wo_id
                ]);
                $updated++;
            }

            if ($updated === 0) {
                return response()->json([
                    'success' => false,
                    'message' => $skipped > 0 ? 'Tidak ada perubahan yang dilakukan.' : 'Volume tidak ditemukan.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => "Data berhasil diperbarui.",
                'updated_count' => $updated,
                'skipped_count' => $skipped
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateWO(){
        // update & delete assigned WO of WPV
    }
}
