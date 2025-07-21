<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Role;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use Illuminate\Http\Request;

class WorkPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
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
        $volume = WorkPackageVolume::with(['workPackage', 'task'])->findOrFail($volume_id);
        $workPackage = $volume->workPackage;
        $humanResources = HumanResource::with('role')
            ->where('wp_id', $workPackage->wp_id)
            ->orderBy('hresource_id')
            ->get();
        
        return view('workpackage', compact('workPackage', 'volume', 'humanResources'));
    }

    public function editHResource(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|integer',
            'jumlahTenagaKerja' => 'integer|min:0',
            'jumlahHariKerja' => 'integer|min:0',
        ]);

        // Update jumlah tenaga kerja
        HumanResource::where('role_id', $validated['role_id'])
            ->update([
                'jtk' => $validated['jumlahTenagaKerja'],
                'jhk' => $validated['jumlahHariKerja'],
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
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
    public function edit(string $id)
    {
        //
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
