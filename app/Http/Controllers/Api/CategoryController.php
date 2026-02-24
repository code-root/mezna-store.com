<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
  public function index(Request $request)
  {
    try {
      $search = $request->input('search');

      $query = Category::query()->withCount('visitLogs');

      // Search by name if provided
      if ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      }

      $categories = $query->paginate(20);

      return response()->json([
        'success' => true,
        'data' => CategoryResource::collection($categories),
        'message' => 'تم جلب الفئات بنجاح'
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/CategoryController@index', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'request' => $request->all()
      ]);

      return response()->json([
        'success' => false,
        'message' => 'حدث خطأ أثناء جلب الفئات',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show($id)
  {
    try {
      $category = Category::withCount('visitLogs')
        ->with(['products' => fn ($q) => $q->withCount('visitLogs'), 'banners'])
        ->findOrFail($id);

      return response()->json([
        'success' => true,
        'data' => new CategoryResource($category),
        'message' => 'تم جلب الفئة بنجاح'
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/CategoryController@show', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'id' => $id
      ]);

      return response()->json([
        'success' => false,
        'message' => 'الفئة غير موجودة',
        'error' => $e->getMessage()
      ], 404);
    }
  }
}
