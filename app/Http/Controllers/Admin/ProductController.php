<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
  public function index(Request $request)
  {
    try {
      $search   = $request->input('search');
      $category = $request->input('category_id');
      $status   = $request->input('is_active');

      $query = Product::with('category');

      if ($category) {
        $query->where('category_id', $category);
      }

      if ($search) {
        $query->where('name', 'like', "%{$search}%");
      }

      if (!is_null($status)) {
        $query->where('is_active', $status);
      }

      $products   = $query->paginate(20);
      $categories = Category::all();

      return view('admin.products.index', compact('products', 'categories'));
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductController@index", [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض المنتجات');
    }
  }

  public function create()
  {
    try {
      $categories = Category::all();
      return view('admin.products.create', compact('categories'));
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductController@create", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء إنشاء المنتج');
    }
  }

  public function store(Request $request)
  {
    try {
      $data = $request->validate([
        'name'        => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price'       => 'required|numeric|min:0',
        'image'       => 'required|url',
        'description' => 'nullable|string|max:255',
        'is_active'   => 'required|boolean',
      ]);

      Product::create($data);

      return redirect()
        ->route('admin.products.index')
        ->with('success', 'تم إنشاء المنتج بنجاح');
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductController@store", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ المنتج');
    }
  }

  public function edit($id)
  {
    try {
      $product    = Product::findOrFail($id);
      $categories = Category::all();

      return view('admin.products.edit', compact('product', 'categories'));
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductController@edit", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض المنتج');
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $product = Product::findOrFail($id);

      $data = $request->validate([
        'name'        => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price'       => 'required|numeric|min:0',
        'image'       => 'required|url',
        'description' => 'nullable|string|max:255',
        'is_active'   => 'required|boolean',
      ]);

      $product->update($data);

      return redirect()
        ->route('admin.products.index')
        ->with('success', 'تم تحديث المنتج بنجاح');
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductController@update", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث المنتج');
    }
  }

  public function destroy($id)
  {
    try {
      $product = Product::findOrFail($id);

      // منع حذف منتج مفعل (اختياري)
      if ($product->is_active) {
        return redirect()->back()->with('error', 'لا يمكن حذف منتج مفعل');
      }

      $product->delete();

      return redirect()
        ->route('admin.products.index')
        ->with('success', 'تم حذف المنتج بنجاح');
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductController@destroy", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء حذف المنتج');
    }
  }

  public function show(Request $request,$id)
  {
    try {

      $product = Product::with(['category', 'variants'=>function($q) use ($request){
        $q->when($request->variant_name != null or !empty($request->variant_name), function($q) use ($request){
          $q->where('name', 'like', '%' . $request->variant_name . '%');
        });
      }])->findOrFail($id);
      return view('admin.products.show', compact('product'));
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductController@show", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض المنتج');
    }
  }
}
