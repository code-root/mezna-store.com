<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\VisitLog;
use Illuminate\Http\Request;

class VisitLogController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitLog::with('visitable')->orderByDesc('created_at');

        if ($request->filled('type')) {
            $type = $request->input('type') === 'category' ? Category::class : Product::class;
            $query->where('visitable_type', $type);
        }
        if ($request->filled('visitable_id')) {
            $query->where('visitable_id', $request->input('visitable_id'));
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }
        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->input('country') . '%');
        }

        $visits = $query->limit(2000)->get();

        $stats = [
            'total' => VisitLog::count(),
            'by_categories' => VisitLog::where('visitable_type', Category::class)->count(),
            'by_products' => VisitLog::where('visitable_type', Product::class)->count(),
        ];

        return view('admin.visits.index', compact('visits', 'stats'));
    }
}
