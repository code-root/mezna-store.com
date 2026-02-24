<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
  public function index(Request $request)
  {
    try {
      $search = $request->input('search');
      $categoryId = $request->input('category_id');

      $query = Product::query()->withCount('visitLogs');

      // Filter by category if provided
      if ($categoryId) {
        $query->where('category_id', $categoryId);
      }

      // Search by name if provided
      if ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      }

      $products = $query->paginate(20);

      return response()->json([
        'success' => true,
        'data' => ProductResource::collection($products),
        'message' => 'تم جلب المنتجات بنجاح'
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/ProductController@index', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'request' => $request->all()
      ]);

      return response()->json([
        'success' => false,
        'message' => 'حدث خطأ أثناء جلب المنتجات',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show(Request $request, $id)
  {
    try {
      $search = $request->input('search', null);
      $product = Product::withCount('visitLogs')
        ->with(['category', 'variants' => function ($q) use ($search) {
        if ($search && trim($search) != "" && $search != null) {
          $q->where('name', 'like', '%' . trim($search) . '%');
        }
      }])->findOrFail($id);

      return response()->json([
        'success' => true,
        'data' => new ProductResource($product),
        'message' => 'تم جلب المنتج بنجاح'
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/ProductController@show', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'id' => $id
      ]);

      return response()->json([
        'success' => false,
        'message' => 'المنتج غير موجود',
        'error' => $e->getMessage()
      ], 404);
    }
  }
}
