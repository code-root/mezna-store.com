<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
  public function index(Request $request)
  {
    try {
      $category = $request->input('category_id');
      $status   = $request->input('is_active');

      $query = Banners::with('category');

      if ($category) {
        $query->where('category_id', $category);
      }

      if (!is_null($status)) {
        $query->where('is_active', $status);
      }

      $banners = $query->paginate(20);
      $categories = Category::all();

      return view('admin.banners.index', compact('banners', 'categories'));
    } catch (\Exception $e) {
      Log::error('error in Admin/BannerController@index', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض البانرات');
    }
  }

  public function create()
  {
    try {
      $categories = Category::all();

      return view('admin.banners.create', compact('categories'));
    } catch (\Exception $e) {
      Log::error('error in Admin/BannerController@create', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء إنشاء البانر');
    }
  }

  public function store(Request $request)
  {
    try {
      $data = $request->validate([
        'image'       => 'required|url',
        'category_id' => 'nullable|exists:categories,id',
        'is_active'   => 'required|boolean',
      ]);

      Banners::create($data);

      return redirect()
        ->route('admin.banners.index')
        ->with('success', 'تم إنشاء البانر بنجاح');
    } catch (\Exception $e) {
      Log::error('error in Admin/BannerController@store', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ البانر');
    }
  }

  public function edit($id)
  {
    try {
      $banner = Banners::findOrFail($id);
      $categories = Category::all();

      return view('admin.banners.edit', compact('banner', 'categories'));
    } catch (\Exception $e) {
      Log::error('error in Admin/BannerController@edit', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البانر');
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $banner = Banners::findOrFail($id);

      $data = $request->validate([
        'image'       => 'required|url',
        'category_id' => 'nullable|exists:categories,id',
        'is_active'   => 'required|boolean',
      ]);

      $banner->update($data);

      return redirect()
        ->route('admin.banners.index')
        ->with('success', 'تم تحديث البانر بنجاح');
    } catch (\Exception $e) {
      Log::error('error in Admin/BannerController@update', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث البانر');
    }
  }

  public function destroy($id)
  {
    try {
      $banner = Banners::findOrFail($id);
      $banner->delete();

      return redirect()
        ->route('admin.banners.index')
        ->with('success', 'تم حذف البانر بنجاح');
    } catch (\Exception $e) {
      Log::error('error in Admin/BannerController@destroy', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البانر');
    }
  }

  public function show($id)
  {
    try {
      $banner = Banners::with('category')->findOrFail($id);

      return view('admin.banners.show', compact('banner'));
    } catch (\Exception $e) {
      Log::error('error in Admin/BannerController@show', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض البانر');
    }
  }
}
