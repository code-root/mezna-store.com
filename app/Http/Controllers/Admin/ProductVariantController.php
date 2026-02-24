<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductVariantController extends Controller
{
  public function create(Product $product)
  {
    return view('admin.products.variants.create', compact('product'));
  }

  public function store(Request $request, Product $product)
  {
    try {
      $data = $request->validate([
        'name'      => 'required|string|max:255',
        'image'     => 'required|url',
        'google_photo_link' => 'required|url',
        'is_active' => 'required|boolean',
      ]);

      $product->variants()->create($data);

      return redirect()
        ->route('admin.products.show', $product)
        ->with('success', 'تم إضافة المتغير بنجاح');
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductVariantController@store", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ المتغير');
    }
  }

  public function edit(Product $product, ProductVariant $variant)
  {
    return view('admin.products.variants.edit', compact('product', 'variant'));
  }

  public function update(Request $request, Product $product, ProductVariant $variant)
  {
    try {
      $data = $request->validate([
        'name'      => 'required|string|max:255',
        'image'     => 'required|url',
        'google_photo_link' => 'required|url',

        'is_active' => 'required|boolean',
      ]);

      $variant->update($data);

      return redirect()
        ->route('admin.products.show', $product)
        ->with('success', 'تم تحديث المتغير بنجاح');
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductVariantController@update", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث المتغير');
    }
  }

  public function destroy(Product $product, ProductVariant $variant)
  {
    try {
      $variant->delete();

      return redirect()
        ->route('admin.products.show', $product)
        ->with('success', 'تم حذف المتغير بنجاح');
    } catch (\Exception $e) {
      Log::error("error in Admin/ProductVariantController@destroy", [
        'error' => $e->getMessage(),
      ]);

      return redirect()->back()->with('error', 'حدث خطأ أثناء حذف المتغير');
    }
  }
}
