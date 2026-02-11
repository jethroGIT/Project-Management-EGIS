<?php

namespace App\Http\Controllers;

use App\Models\WpCategory;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class WPCategoryManagementController extends Controller
{
    public function index(){
        $wpCategories = WpCategory::orderBy('category_id')->get();
        return view('wp_category_management', compact('wpCategories'));
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:trs_category,name',
                'categoryNumber' => 'required|integer|min:1|unique:trs_category,categoryNumber'
            ]);

            $category = WpCategory::create([
                'name' => $request->name,
                'categoryNumber' => (string) $request->categoryNumber
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => $category
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi khusus untuk duplikasi
            $errors = $e->validator->errors();
            $duplicateMessage = '';

            if ($errors->has('categoryNumber') || $errors->has('name')) {
                $duplicateMessage = 'Nomor atau Nama WP tidak valid atau sudah terdaftar. Periksa kembali data yang dimasukkan.';
            }

            return response()->json([
                'success' => false,
                'message' => $duplicateMessage ?: 'Terjadi kesalahan validasi.'
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani error duplikasi dari database
            if ($e->getCode() === '23505') { // Kode error PostgreSQL untuk unique constraint violation
                $errorMessage = 'Nomor atau Nama WP tidak valid atau sudah terdaftar. Periksa kembali data yang dimasukkan.';
            } else {
                $errorMessage = 'Terjadi kesalahan pada database. Silakan coba lagi.';
            }

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.'
            ], 500);
        }
    }

    public function edit(Request $request){
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255|unique:trs_category,name,' . $request->category_id . ',category_id',
                'categoryNumber' => 'required|integer|min:1|unique:trs_category,categoryNumber,' . $request->category_id . ',category_id'
            ]);
            // save
            $category = WpCategory::where('category_id', $request->category_id)
                                ->firstOrFail();
            if($category->name === $request->name && $category->categoryNumber === $request->categoryNumber){
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada perubahan yang dilakukan.'
                ], 400);
            }

            $category->update([
                'name' => $request->name,
                'categoryNumber' => (string) $request->categoryNumber
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $category // Kirim data yang diperbarui jika perlu untuk update UI
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi khusus untuk duplikasi
            $errors = $e->validator->errors();
            $duplicateMessage = '';

            if ($errors->has('categoryNumber') || $errors->has('name')) {
                $duplicateMessage = 'Nomor atau Nama WP tidak valid atau sudah terdaftar. Periksa kembali data yang dimasukkan.';
            }

            return response()->json([
                'success' => false,
                'message' => $duplicateMessage ?: 'Terjadi kesalahan validasi.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.'
            ], 500);
        }
    }
    
    public function getRelatedData($id)
    {
        try {
            // Cari kategori berdasarkan ID
            $category = WpCategory::findOrFail($id);

            // Ambil semua Work Package terkait dengan workPack_number dan name
            $workPackages = $category->workPackage()->get(['workPack_number', 'name']);

            // Format data untuk dikembalikan
            $workPackageDetails = $workPackages->map(function ($wp) {
                return [
                    'workPack_number' => $wp->workPack_number,
                    'name' => $wp->name
                ];
            });

            return response()->json([
                'success' => true,
                'deleted_trs_workPackages' => $workPackageDetails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            // Cari kategori berdasarkan ID
            $category = WpCategory::findOrFail($id);

            // Ambil semua Work Package terkait
            $workPackages = $category->workPackage()->with('workPackageVolumes')->get();

            // Periksa apakah ada volume Work Package yang memiliki workOrder_id
            $hasAssignedWorkOrder = $workPackages->flatMap(function ($wp) {
                return $wp->workPackageVolumes;
            })->contains(function ($volume) {
                return !is_null($volume->workOrder_id);
            });

            if ($hasAssignedWorkOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori Work Package tidak dapat dihapus karena terdapat volume Work Package yang sudah dikerjakan/dicall WO.'
                ], 400);
            }

            // Ambil nama Work Package untuk ditampilkan
            $workPackageDetails = $workPackages->map(function ($wp) {
                return [
                    'workPack_number' => $wp->workPack_number,
                    'name' => $wp->name
                ];
            });

            // Hapus kategori beserta semua data terkait
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori Work Package berhasil dihapus.',
                'deleted_trs_workPackages' => $workPackageDetails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
