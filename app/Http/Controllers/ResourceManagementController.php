<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;

class ResourceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Fetch users dengan role
            $users = User::with('roles')->get();
    
            // Fetch all roles
            $roles = Role::orderBy('name')->get();
    
            return view('resource_management', compact('users', 'roles'));
        } catch(Exception $e) {
            // Kembalikan dengan data kosong jika error
            $users = collect();
            $roles = collect();

            return view('resource_management', compact('users', 'roles'))
                ->with('error', 'Terjadi kesalahan saat memuat data user: ' . $e->getMessage());
        }
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        try {
            DB::beginTransaction();

            $generatedPassword = $this->generatePasswordFromName($request->name);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                // 'role_id' => $request->role_id,
                'password' => Hash::make($generatedPassword)
            ]);

            // Assign role ke user
            $role = Role::find($request->role_id);
            if ($role) {
                $user->assignRole($role->name);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'user' => [
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_name' => $user->getRoleNames()->first() ?? 'Belum ada peran'
                ],
                'password_info' => $generatedPassword
            ]);

        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bagian dari function store()
     * 
     * Generate password from user name
     * Format: 3 first letter (lowercase) + "123"
     */
    private function generatePasswordFromName(String $name)
    {
        // Clean name: remve spaces, special characters, keep only letters
        $cleanName = preg_replace('/[^a-zA-Z]/', '', $name);

        // Take 3 first characters, convert to lowercase
        $prefix = strtolower(substr($cleanName, 0, 3));

        // Ensure minimum 3 characters (pad with 'x' if needed)
        if (strlen($prefix) < 3) {
            $prefix = str_pad($prefix, 3, 'x');
        }

        // Combine with "123"
        $password = $prefix . '123';

        return $password;
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
        try {
            $user = User::with('roles')->findOrFail($id);
            $roles = Role::orderBy('name')->get();

            return response()->json([
                'success' => true,
                'user' => [
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_id' => $user->roles->first()?->id,
                    'role_name' => $user->getRoleNames()->first() ?? 'No Role'
                ],
                'roles' => $roles
            ]);

        } catch(Exception $e) {
            Log::error('Error getting user for edit', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user', 'email')->ignore($id, 'user_id')
            ],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            // Deteksi perubahan data
            $originalName = $user->name;
            $originalEmail = $user->email;
            $originalRoleId = $user->roles->first()?->id;
            
            $newName = trim($request->name);
            $newEmail = trim($request->email);
            $newRoleId = (int) $request->role_id;
            $passwordChanged = $request->filled('password');

            // Pengecekan perubahan
            $nameChanged = $originalName !== $newName;
            $emailChanged = $originalEmail !== $newEmail;
            $roleChanged = $originalRoleId !== $newRoleId;
            
            $hasChanges = $nameChanged || $emailChanged || $roleChanged || $passwordChanged;

            // Jika tidak ada perubahan
            if (!$hasChanges) {
                DB::rollback();

                return response()->json([
                    'success' => false,
                    'no_changes' => true,
                    'message' => 'Tidak ada perubahan data.',
                    'current_data' => [
                        'name' => $originalName,
                        'email' => $originalEmail,
                        'role_name' => $user->getRoleNames()->first() ?? 'No Role',
                        'last_updated' => $user->updated_at ? $user->updated_at->format('d M Y H:i') : 'Tidak diketahui'
                    ]
                ], 200);
            }

            // Update info dasar
            $user->name = $newName;
            $user->email = $newEmail;

            // Update password jika diisi
            if ($passwordChanged) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Update role jika berubah
            if ($roleChanged) {
                $role = Role::find($newRoleId);
                if ($role) {
                    $user->syncRoles([$role->name]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui',
                'user' => [
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_name' => $user->getRoleNames()->first() ?? 'No Role',
                    'updated_at' => $user->updated_at->format('d M Y H:i')
                ]
            ]);

        } catch(Exception $e) {
            DB::rollback();

            Log::error('Error updating user', [
                'user_id' => $id,
                'error' => $e->getMessage(),
                'request_data' => $request->except('password')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
