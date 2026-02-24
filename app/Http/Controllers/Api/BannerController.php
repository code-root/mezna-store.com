<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BannerResource;
use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
  public function index(Request $request)
  {
    try {
      $categoryId = $request->input('category_id');

      $query = Banners::query();

      // Filter by category if provided
      if ($categoryId) {
        $query->where('category_id', $categoryId);
      }

      $banners = $query->paginate(20);

      return response()->json([
        'success' => true,
        'data' => BannerResource::collection($banners),
        'message' => 'تم جلب البنرات بنجاح'
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/BannerController@index', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'request' => $request->all()
      ]);

      return response()->json([
        'success' => false,
        'message' => 'حدث خطأ أثناء جلب البنرات',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show($id)
  {
    try {
      $banner = Banners::with(['category'])->findOrFail($id);

      return response()->json([
        'success' => true,
        'data' => new BannerResource($banner),
        'message' => 'تم جلب البنر بنجاح'
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/BannerController@show', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'id' => $id
      ]);

      return response()->json([
        'success' => false,
        'message' => 'البنر غير موجود',
        'error' => $e->getMessage()
      ], 404);
    }
  }

  // Get all banners for main page
  public function mainPageBanners()
  {
    try {
      $banners = Banners::whereNull('category_id')->get();

      return response()->json([
        'success' => true,
        'data' => BannerResource::collection($banners),
        'message' => 'تم جلب البنرات للصفحة الرئيسية بنجاح'
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/BannerController@mainPageBanners', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile()
      ]);

      return response()->json([
        'success' => false,
        'message' => 'حدث خطأ أثناء جلب البنرات للصفحة الرئيسية',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
