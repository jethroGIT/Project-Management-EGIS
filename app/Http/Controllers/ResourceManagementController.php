<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
            $roles = Role::whereNotIn('name', ['karyawan'])
                            ->orderBy('name')
                            ->get();
    
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'desc' => 'nullable|string|max:1000', 
            'password' => 'nullable|string|min:6|confirmed'
        ], [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar dalam sistem',
            'email.max' => 'Email maksimal 255 karakter',
            'desc.max' => 'Deskripsi maksimal 1000 karakter',
        ]);

        try {
            DB::beginTransaction();

            $generatedPassword = $this->generatePasswordFromName($request->name);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($generatedPassword),
                'desc' => $request->desc ? trim($request->desc) : null,
            ]);

            // Assign role ke user
            if (!$user->hasRole('karyawan')) {
                $user->assignRole('karyawan');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'user' => [
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()->toArray()
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::with('roles')->findOrFail($id);
            $roles = Role::whereNotIn('name', ['karyawan'])
                            ->orderBy('name')
                            ->get();

            // Menampilkan role saat ini untuk edit form
            $userRoles = $user->getRoleNames();
            $currentRoleId = null;

            if ($userRoles->contains('admin')) {
                $currentRoleId = Role::where('name', 'admin')->first()?->role_id;
            } else {
                $karyawanRole = $userRoles->filter(function($roleName) {
                    return $roleName !== 'karyawan';
                })->first();

                if ($karyawanRole) {
                    $currentRoleId = Role::where('name', $karyawanRole)->first()?->role_id;
                }
            }

            return response()->json([
                'success' => true,
                'user' => [
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'desc' => $user->desc
                    // 'role_id' => $currentRoleId,
                    // 'role_name' => $userRoles->filter(fn($role) => $role !== 'karyawan')->first() ?? 'No Role'
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
                Rule::unique('users', 'email')->ignore($id, 'user_id')
            ],
            'password' => [
                'nullable', 
                'string', 
                'min:6', 
                'confirmed',
                // Custom rule untuk memastikan kedua password field diisi
                function ($attribute, $value, $fail) use ($request) {
                    $passwordConfirmation = $request->input('password_confirmation');

                    if (($value && !$passwordConfirmation) || (!$value && $passwordConfirmation)) {
                        $fail('Jika ingin mengubah password, kedua field password harus diisi.');
                    }
                },
            ],
            'password_confirmation' => [
                'nullable',
                'string',
                'min:6',
                // Custom rule untuk memastikan kedua password field diisi
                function ($attribute, $value, $fail) use ($request) {
                    $password = $request->input('password');

                    if (($value && !$password) || (!$value && $password)) {
                        $fail('Jika ingin mengubah password, kedua field password harus diisi.');
                    }
                },
            ],
            'desc' => 'nullable|string|max:1000'
        ], [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar dalam sistem',
            'email.max' => 'Email maksimal 255 karakter',
            'desc.max' => 'Deskripsi maksimal 1000 karakter',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password dan konfirmasi password tidak cocok',
            'password_confirmation.min' => 'Konfirmasi password minimal 6 karakter',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            // Deteksi perubahan data
            $originalName = $user->name;
            $originalEmail = $user->email;
            $originalDescription = $user->desc;
            
            $newName = trim($request->name);
            $newEmail = trim($request->email);
            $newDescription = trim($request->desc);
            $passwordChanged = $request->filled('password') && $request->filled('password_confirmation');

            // Pengecekan perubahan
            $nameChanged = $originalName !== $newName;
            $emailChanged = $originalEmail !== $newEmail;
            $descriptionChanged = $originalDescription !== $newDescription;
            
            $hasChanges = $nameChanged || $emailChanged || $descriptionChanged || $passwordChanged;

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
                        'desc' => $originalDescription,
                        'last_updated' => $user->updated_at ? $user->updated_at->format('d M Y H:i') : 'Tidak diketahui'
                    ]
                ], 200);
            }

            // Update info dasar
            $user->name = $newName;
            $user->email = $newEmail;
            $user->desc = $newDescription;

            // Update password jika diisi
            if ($passwordChanged) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui',
                'user' => [
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'desc' => $user->desc,
                    'updated_at' => $user->updated_at->format('d M Y H:i')
                ]
            ]);

        } catch(Exception $e) {
            DB::rollback();

            Log::error('Error updating user', [
                'user_id' => $id,
                'error' => $e->getMessage(),
                'request_data' => $request->except('password', 'password_confirmation')
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
