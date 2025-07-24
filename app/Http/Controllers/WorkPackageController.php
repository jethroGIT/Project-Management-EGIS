<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Role;
use App\Models\Timesheet;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class WorkPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika ada parameter volume_id di query string
        if ($request->has('volume_id')) {
            return $this->detail($request->get('volume_id'));
        }
        
        // Ambil work package volume pertama atau redirect
        $firstVolume = WorkPackageVolume::with('workPackage')->first();
        if ($firstVolume) {
            return redirect()->route('work-package.detail', ['volume_id' => $firstVolume->volume_id]);
        }

        return view('workpackage');

    }

    public function detail($volume_id)
    {
        $volume = WorkPackageVolume::with([
            'workPackage', 
            'task',
            'work.user'
        ])->findOrFail($volume_id);

        $workPackage = $volume->workPackage;

        $humanResources = HumanResource::with('role')
            ->where('wp_id', $workPackage->wp_id)
            ->orderBy('hresource_id')
            ->get();

        // Ambil users yang terlibat di work package ini berdasarkan tabel work
        $assignedUsers = User::whereHas('work', function($query) use ($volume_id) {
            $query->where('volume_id', $volume_id);
        })->with('role')->get();

        // Hitung total completion dari task performance
        $tasks = $volume->task;
        $totalCompletion = 0;

        if ($tasks->count() > 0) {
            $taskCompletions = $tasks->map(function ($task) {
                if ($task->subTask->count() > 0) {
                    return $task->subTask->avg('completeness');
                }
                return 0;
            });
            $totalCompletion = round($taskCompletions->avg(), 2);
        }

        // hitung persentase finance performance
        // Ambil semua work dan timesheet berdasarkan volume
        $works = Work::with('user.role')->where('volume_id', $volume_id)->get();
        $timesheets = Timesheet::with('user.role')->where('volume_id', $volume_id)->get();

        // Group dan jumlahkan resource cost per role
        $resourceCostPerRole = $works->groupBy(fn($w) => optional($w->user->role)->role_id)
            ->map(fn($group) => $group->sum('resource_cost'));

        // Hitung aktivitas per role dari timesheet
        $timesheetCountPerRole = $timesheets->groupBy(fn($t) => optional($t->user->role)->role_id)
            ->map(fn($group) => $group->count());
        
        $totalByYoy = 0;
        $totalRealization = 0;

        foreach ($humanResources as $hr) {
            $roleId = $hr->role_id;
            $jhk = $hr->jhk ?? 0;
            $resourceCost = $resourceCostPerRole[$roleId] ?? 0;
            $timesheetCount = $timesheetCountPerRole[$roleId] ?? 0;

            $totalByYoy += $jhk * $resourceCost;
            $totalRealization += $timesheetCount * $resourceCost;
        }

        // Hitung persentase realisasi
        $realizationPercentage = $totalByYoy > 0 ? ($totalRealization / $totalByYoy) * 100 : 0;
        if($realizationPercentage > 100){
            $realizationPercentage = 100;
        }
        
        return view('workpackage', compact(
            'humanResources',
            'workPackage', 
            'volume', 
            'volume_id',
            'assignedUsers',
            'totalCompletion',
            'realizationPercentage'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editHResource(Request $request, $volume_id)
    {
        $volume = WorkPackageVolume::with([
            'workPackage', 
            'task',
            'work.user'
        ])->findOrFail($volume_id);

        $workPackage = $volume->workPackage;
        try {
            $request->validate([
                'hresource_id' => 'required|exists:human_resource,hresource_id', 
                'role_id' => 'required|exists:role,role_id', 
                'jhk' => 'integer|min:0', 
            ]);

            $resource = HumanResource::where('hresource_id', $request->hresource_id)
                                ->where('wp_id', $workPackage->wp_id)
                                ->where('role_id', $request->role_id)
                                ->firstOrFail();
            $resource->jhk = $request->jhk;
            $resource->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $resource // Kirim data yang diperbarui jika perlu untuk update UI
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
