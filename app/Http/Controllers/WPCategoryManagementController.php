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

    public function add(Request $request){

        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category = new WpCategory();
            $category->name = $request->input('name');
            $category->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
        
    }

    public function edit(Request $request){
        try {
            // validation
            // save
            $category = WpCategory::where('category_id', $request->category_id)
                                ->firstOrFail();
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $category // Kirim data yang diperbarui jika perlu untuk update UI
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id){
        try {
            $activity = WpCategory::findorfail($id);
            $activity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
