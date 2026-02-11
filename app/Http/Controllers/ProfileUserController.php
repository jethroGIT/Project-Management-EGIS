<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkPackage;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ambil resource cost dan hitung user terlibat di berapa work package
        $user = auth()->user();
        // Ambil semua role_id dari relasi work user
        $resourceCost = 0;
        $role = null;
        if($user->hasRole('admin')){
            $adminRole = Role::where('name', 'admin')->first();
            $roleIds = $adminRole->role_id;
            $role = $adminRole;
        }else{
            $roleIds = $user->work->pluck('role_id')->filter()->unique();
            if ($roleIds->count()) {
                $role = Role::find($roleIds->first());
                $resourceCost = $role ? $role->resourceCost : 0;
            }
        }

        $workPackagesUserCount = $user->work()
            ->with('volume')
            ->get()
            ->map(function($work) {
                return $work->volume->volume_id ?? null;
            })
            ->filter()
            ->unique()
            ->count();
        $workPackagesCount = WorkPackage::count();
        return view('profile_user', compact('resourceCost', 'workPackagesUserCount', 'workPackagesCount', 'role'));
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
    public function edit(Request $request, string $userId)
    {
        try {
            // validation
            // save
            $user = User::where('user_id', $userId)
                                ->firstOrFail();
            if($user->name === $request->name && $user->email === $request->email && !$request->filled('password')){
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada perubahan yang dilakukan.'
                ], 400);
            };

            $data = [];
            if ($request->filled('name')) {
                $data['name'] = $request->name;
            }
            if ($request->filled('email')) {
                $data['email'] = $request->email;
            }
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }
            if (!empty($data)) {
                $user->update($data);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $user // Kirim data yang diperbarui jika perlu untuk update UI
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
