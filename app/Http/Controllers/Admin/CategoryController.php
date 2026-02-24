<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
  public function index(Request $request)
  {
    try {
      $search = $request->input('search');
      $status = $request->input('is_active');

      $query = Category::query();

      if ($search) {
        $query->where('name', 'like', "%{$search}%");
      }

      if (!is_null($status)) {
        $query->where('is_active', $status);
      }

      $categories = $query->paginate(20);

      return view('admin.categories.index', compact('categories'));
    } catch (\Exception $e) {
      Log::error('error in Admin/CategoryController@index', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض الأقسام');
    }
  }

  public function create()
  {
    try {
      return view('admin.categories.create');
    } catch (\Exception $e) {
      Log::error('error in Admin/CategoryController@create', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء إنشاء القسم');
    }
  }

  public function store(Request $request)
  {
    try {
      $data = $request->validate([
        'name'       => 'required|string|max:255|unique:categories,name',
        'is_active'  => 'required|boolean',
        'image'      => 'nullable|url|max:500',
        'hide_price' => 'nullable|boolean',
      ]);

      $data['hide_price'] = $request->boolean('hide_price');
      Category::create($data);

      return redirect()
        ->route('admin.categories.index')
        ->with('success', 'تم إنشاء القسم بنجاح');
    } catch (\Exception $e) {
      Log::error('error in Admin/CategoryController@store', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ القسم');
    }
  }

  public function edit($id)
  {
    try {
      $category = Category::findOrFail($id);

      return view('admin.categories.edit', compact('category'));
    } catch (\Exception $e) {
      Log::error('error in Admin/CategoryController@edit', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض القسم');
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $category = Category::findOrFail($id);

      $data = $request->validate([
        'name'       => 'required|string|max:255|unique:categories,name,' . $category->id,
        'is_active'  => 'required|boolean',
        'image'      => 'nullable|url|max:500',
        'hide_price' => 'nullable|boolean',
      ]);

      $data['hide_price'] = $request->boolean('hide_price');
      $category->update($data);

      return redirect()
        ->route('admin.categories.index')
        ->with('success', 'تم تحديث القسم بنجاح');
    } catch (\Exception $e) {
      Log::error('error in Admin/CategoryController@update', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث القسم');
    }
  }

  public function destroy($id)
  {
    try {
      $category = Category::findOrFail($id);
      $category->delete();
      return redirect()
        ->route('admin.categories.index')
        ->with('success', 'تم حذف القسم بنجاح');
    } catch (\Exception $e) {
      Log::error('error in Admin/CategoryController@destroy', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء حذف القسم');
    }
  }

  public function show($id)
  {
    try {
      $category = Category::with([
        'products' => function ($q) {
          $q->where('is_active', true);
        },
        'banners'
      ])->findOrFail($id);

      return view('admin.categories.show', compact('category'));
    } catch (\Exception $e) {
      Log::error('error in Admin/CategoryController@show', [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض القسم');
    }
  }
}
