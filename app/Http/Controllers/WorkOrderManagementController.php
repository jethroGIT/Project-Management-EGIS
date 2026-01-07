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
                $catNum = intval($wp->wpCategory->category_number ?? 9999);
                $wpNum = is_numeric($wp->wp_number) ? floatval($wp->wp_number) : $wp->wp_number;
                return sprintf('%04d-%s', $catNum, $wpNum);
            })
            ->values();
        
        $workOrders = WorkOrder::with('workPackageVolumes.workPackage')->orderBy('wo_number', 'asc')->get();

        $categories = WpCategory::with('workPackage')
            ->orderByRaw('category_number::integer ASC')
            ->get();
        
        $executionYears = WorkPackageVolume::whereNotNull('execution_year')
            ->distinct()
            ->orderBy('execution_year', 'asc')
            ->pluck('execution_year');

        // Proses data untuk table_summary_work_order
        $summaryWorkOrders = $workOrders->map(function ($wo) {
            $groupedVolumes = $wo->workPackageVolumes
                ->groupBy('wp_id')
                ->map(function ($volumes) {
                    return [
                        'wp' => $volumes->first()->workPackage,
                        'count' => $volumes->count(),
                    ];
                });

            return [
                'wo_number' => $wo->wo_number,
                'execution_year' => $wo->workPackageVolumes->first()->execution_year ?? '-',
                'grouped_volumes' => $groupedVolumes,
            ];
        });

        return view('work_order_management', compact('workPackages', 'categories', 'workOrders', 'executionYears', 'summaryWorkOrders'));
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

    public function assign(Request $request)
    {
        // assign multiple volumes to work order
        try {
            $request->validate([
                'wo_id' => 'required|exists:work_order,wo_id',
                'assignments' => 'required|array',
                'assignments.*.wp_id' => 'required|exists:work_package,wp_id',
                'assignments.*.volume_count' => 'required|integer|min:1',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $woId = $request->wo_id;
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $assignments = $request->assignments;
            
            $updated = 0;
            $skipped = 0;
            $executionYear = Carbon::parse($startDate)->year;

            foreach ($assignments as $assignment) {
                $wpId = $assignment['wp_id'];
                $volumeCount = $assignment['volume_count'];
                
                // Ambil volume teratas dari WP yang belum diassign ke WO manapun
                $volumes = WorkPackageVolume::where('wp_id', $wpId)
                    ->whereNull('wo_id')
                    ->orderBy('volume_id', 'asc')
                    ->limit($volumeCount)
                    ->get();
                
                if ($volumes->isEmpty()) {
                    $skipped++;
                    continue;
                }
                
                foreach ($volumes as $volume) {
                    $volume->update([
                        'wo_id' => $woId,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'execution_year' => $executionYear
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
