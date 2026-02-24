<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
  Category,
  Product,
  Banners,
  User,
};
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
  public function index()
  {
    try {

      $statistics = [
        'total_categories' => Category::count(),
        'total_products' => Product::count(),
        'total_banners' => Banners::count(),
        'total_users' => User::count(),
      ];

      $latest_users = User::latest()->take(10)->get();

      return view('admin.dashboard', compact('statistics', 'latest_users'));
    } catch (\Exception $e) {
      Log::error('error in Admin/DashboardController@index', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);
      return redirect()->back()->with('error', 'حدث خطأ أثناء عرض لوحة التحكم');
    }
  }
}
