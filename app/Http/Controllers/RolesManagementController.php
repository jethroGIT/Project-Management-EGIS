<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class RolesManagementController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Role::whereNotIn('name', ['karyawan', 'admin'])
                            ->get();
    
            return view('resource_management', compact('roles'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data peran.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30|unique:roles,name',
            'alt_name' => 'nullable|string|max:30',
            'desc' => 'nullable|string|max:10',
            'resource_cost' => 'numeric|min:0'
        ], [
            'name.required' => 'Nama peran harus diisi',
            'name.unique' => 'Nama peran sudah ada dalam sistem',
            'name.max' => 'Nama peran maksimal 30 karakter',
            'desc.max' => 'Singkatan maksimal 10 karakter',
            'resource_cost.numeric' => 'Biaya tenaga kerja harus diisi dengan nominal uang',
            'resource_cost.min' => 'Biaya tenaga kerja tidak boleh negatif'
        ]);

        try {
            DB::beginTransaction();

            // Parse resource cost
            $costString = str_replace(['.', ',', 'Rp', ' '], '', $request->resource_cost);
            $cost = (float) $costString;

            $role = Role::create([
                'name' => trim($request->name),
                'alt_name' => $request->alt_name ? trim($request->alt_name) : null,
                'desc' => $request->desc ? trim($request->desc) : null,
                'resource_cost' => $cost,
                'guard_name' => 'web'
            ]);

            DB::commit();

            // Log success
            Log::info('Role created successfully', [
                'role_id' => $role->id,
                'name' => $role->name,
                'description' => $role->desc,
                'resource_cost' => $role->resource_cost
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Peran berhasil ditambahkan',
                'role' => [
                    'role_id' => $role->id,
                    'name' => $role->name,
                    'alt_name' => $role->alt_name,
                    'desc' => $role->desc,
                    'resource_cost' => $role->resource_cost,
                    'resource_cost_formatted' => 'Rp' . number_format($role->resource_cost, 0, ',', '.')
                ]
            ]);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error creating role', [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['_token']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan peran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(string $id)
    {
        try {
            $role = Role::findOrFail($id);

            return response()->json([
                'success' => true,
                'role' => [
                    'role_id' => $role->id,
                    'name' => $role->name,
                    'alt_name' => $role->alt_name,
                    'desc' => $role->desc,
                    'resource_cost' => $role->resource_cost,
                    'resource_cost_formatted' => $role->resource_cost == intval($role->resource_cost)
                        ? intval($role->resource_cost)
                        : $role->resource_cost
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Peran tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            Log::error('Error getting role for edit', [
                'role_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data peran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:30|unique:roles,name,' . $id . ',id',
            'alt_name' => 'nullable|string|max:30',
            'desc' => 'nullable|string|max:10',
            'resource_cost' => 'numeric|min:0'
        ], [
            'name.required' => 'Nama peran harus diisi',
            'name.unique' => 'Nama peran sudah ada dalam sistem',
            'name.max' => 'Nama peran maksimal 30 karakter',
            'desc.max' => 'Singkatan maksimal 10 karakter',
            // 'resource_cost.required' => 'Biaya tenaga kerja harus diisi',
            'resource_cost.numeric' => 'Biaya tenaga kerja harus diisi dengan nominal uang',
            'resource_cost.min' => 'Biaya tenaga kerja tidak boleh negatif'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::findOrFail($id);

            // Deteksi perubahan data
            $originalName = $role->name;
            $originalAltName = $role->alt_name;
            $originalDesc = $role->desc;
            $originalResourceCost = $role->resource_cost;

            $newName = trim($request->name);
            $newAltName = $request->alt_name ? trim($request->alt_name) : null;
            $newDesc = $request->desc ? trim($request->desc) : null;

            // Parse resource cost
            $resourceCostInput = $request->resource_cost;

            if (is_string($resourceCostInput)) {
                $costString = str_replace(['.', ',', 'Rp', ' '], '', $resourceCostInput);
                $newResourceCost = (float) $costString;
            } else {
                $newResourceCost = (float) $resourceCostInput;
            }
            
            // Pengecekan perubahan
            $nameChanged = $originalName !== $newName;
            $altNameChanged = $originalAltName !== $newAltName;
            $descChanged = $originalDesc !== $newDesc;
            $resourceCostChanged = $originalResourceCost != $newResourceCost;
            
            $hasChanges = $nameChanged || $altNameChanged || $descChanged || $resourceCostChanged;

            // Jika tidak ada perubahan
            if (!$hasChanges) {
                DB::rollback();

                return response()->json([
                    'success' => false,
                    'no_changes' => true,
                    'message' => 'Tidak ada perubahan data yang terdeteksi.',
                    'current_data' => [
                        'name' => $originalName,
                        'alt_name' => $originalAltName,
                        'desc' => $originalDesc,
                        'resource_cost' => $originalResourceCost,
                        'resource_cost_display' => 'Rp' . number_format($originalResourceCost, 0, ',', '.')
                    ]
                ], 200);
            }

            // Update role
            $role->name = $newName;
            $role->alt_name = $newAltName;
            $role->desc = $newDesc;
            $role->resource_cost = $newResourceCost;
            $role->save();

            DB::commit();

            // Log success
            Log::info('Role updated successfully', [
                'role_id' => $role->id,
                'old_data' => [
                    'name' => $originalName,
                    'alt_name' => $originalAltName,
                    'desc' => $originalDesc,
                    'resource_cost' => $originalResourceCost
                ],
                'new_data' => [
                    'name' => $role->name,
                    'alt_name' => $role->alt_name,
                    'desc' => $role->desc,
                    'resource_cost' => $role->resource_cost
                ],
                'updated_by' => auth()->id() ?? 'system'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Peran berhasil diperbarui',
                'role' => [
                    'role_id' => $role->id,
                    'name' => $role->name,
                    'alt_name' => $role->alt_name,
                    'desc' => $role->desc,
                    'resource_cost' => $role->resource_cost,
                    'resource_cost_formatted' => 'Rp' . number_format($role->resource_cost, 0, ',', '.'),
                    'last_updated' => $role->updated_at ? $role->updated_at->format('d M Y H:i') : 'Tidak diketahui'
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Peran tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error updating role', [
                'role_id' => $id,
                'error' => $e->getMessage(),
                'request_data' => $request->except(['_token', '_method']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui peran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method untuk membersihkan input currency
     * 
     * Digunakan pada function store() dan update()
     */
    private function cleanCurrencyInput($input)
    {
        if (is_null($input) || $input === '') {
            return 0;
        }

        // Hapus semua karakter non-numeric kecuali titik desimal
        $cleaned = preg_replace('/[^\d.]/', '', $input);

        // Convert ke float
        return (float) $cleaned;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $role = Role::findOrFail($id);

            // Cek apakah role masih digunakan oleh user
            $usersCount = User::role($role->name)->count();

            if ($usersCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Peran tidak dapat dihapus karena masih digunakan oleh {$usersCount} user. Hapus assignment user terlebih dahulu.",
                    'has_users' => true,
                    'users_count' => $usersCount,
                    'role_name' => $role->name
                ], 400);
            }

            // Simpan data untuk log
            $roleData = [
                'role_id' => $role->id,
                'name' => $role->name,
                'alt_name' => $role->alt_name,
                'desc' => $role->desc,
                'resource_cost' => $role->resource_cost
            ];

            // Hapus role
            $role->delete();

            DB::commit();

            // Log success
            Log::info('Role deleted successfully', [
                'deleted_role' => $roleData,
                'deleted_by' => auth()->id() ?? 'system',
                'deleted_at' => now()->toDateTimeString()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Peran berhasil dihapus',
                'deleted_role' => $roleData
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Peran tidak ditemukan'
            ], 404);
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error deleting role', [
                'role_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus peran: ' . $e->getMessage()
            ], 500);
        }
    }
}
