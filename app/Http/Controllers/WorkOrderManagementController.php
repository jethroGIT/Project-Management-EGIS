<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\WpCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkOrderManagementController extends Controller
{
    public function index(){
        $workPackages = WorkPackage::with(['workPackageVolumes.workOrder', 'workPackageVolumes', 'wpCategory'])
            ->get()
            ->sortBy(function($wp) {
                // Urutkan dulu berdasarkan nomor kategori, lalu nomor WP
                $catNum = intval($wp->wpCategory->categoryNumber ?? 9999);
                $wpNum = is_numeric($wp->workPack_number) ? floatval($wp->workPack_number) : $wp->workPack_number;
                return sprintf('%04d-%s', $catNum, $wpNum);
            })
            ->values();
        
        $workOrders = WorkOrder::with('workPackageVolumes.workPackage')->orderBy('workNumber_id', 'asc')->get();

        $categories = WpCategory::with('workPackage')
            ->orderByRaw('CAST(categoryNumber AS UNSIGNED) ASC')
            ->get();
        
        $executionYears = WorkPackageVolume::whereNotNull('executionYear')
            ->distinct()
            ->orderBy('executionYear', 'asc')
            ->pluck('executionYear');

        // Proses data untuk table_summary_mst_workOrder
        $summaryWorkOrders = $workOrders->map(function ($wo) {
            $groupedVolumes = $wo->workPackageVolumes
                ->groupBy('workPackage_id')
                ->map(function ($volumes) {
                    return [
                        'wp' => $volumes->first()->workPackage,
                        'count' => $volumes->count(),
                    ];
                });

            return [
                'workNumber_id' => $wo->workNumber_id,
                'executionYear' => $wo->workPackageVolumes->first()->executionYear ?? '-',
                'grouped_volumes' => $groupedVolumes,
            ];
        });

        return view('work_order_management', compact('workPackages', 'categories', 'workOrders', 'executionYears', 'summaryWorkOrders'));
    }

    public function add(Request $request){
        // add new work order
        try {
            $request->validate([
                'workNumber_id' => 'required|string|unique:mst_workOrder,workNumber_id',
            ]);

            $wo = WorkOrder::create([
                'workNumber_id' => $request->workNumber_id,
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

    public function assign(Request $request)
    {
        // assign multiple volumes to work order
        try {
            $request->validate([
                'workOrder_id' => 'required|exists:mst_workOrder,workOrder_id',
                'assignments' => 'required|array',
                'assignments.*.workPackage_id' => 'required|exists:trs_workPackage,workPackage_id',
                'assignments.*.volume_count' => 'required|integer|min:1',
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
            ]);

            $woId = $request->workOrder_id;
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $assignments = $request->assignments;
            
            $updated = 0;
            $skipped = 0;
            $executionYear = Carbon::parse($startDate)->year;

            foreach ($assignments as $assignment) {
                $wpId = $assignment['workPackage_id'];
                $volumeCount = $assignment['volume_count'];
                
                // Ambil volume teratas dari WP yang belum diassign ke WO manapun
                $volumes = WorkPackageVolume::where('workPackage_id', $wpId)
                    ->whereNull('workOrder_id')
                    ->orderBy('volume_id', 'asc')
                    ->limit($volumeCount)
                    ->get();
                
                if ($volumes->isEmpty()) {
                    $skipped++;
                    continue;
                }
                
                foreach ($volumes as $volume) {
                    $volume->update([
                        'workOrder_id' => $woId,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'executionYear' => $executionYear
                    ]);
                    $updated++;
                }
            }

            if ($updated === 0) {
                return response()->json([
                    'success' => false,
                    'message' => $skipped > 0 ? 'Tidak ada volume yang tersedia untuk diassign.' : 'Volume tidak ditemukan.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                // 'message' => "{$updated} volume berhasil diassign ke Work Order.",
                'updated_count' => $updated,
                'skipped_count' => $skipped
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Input tidak valid: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
