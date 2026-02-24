<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public const KEYS = ['shipping', 'returns', 'faq', 'meta_pixel_id', 'home'];

    public function index()
    {
        $items = [];
        foreach (self::KEYS as $key) {
            $items[$key] = PageContent::where('key', $key)->first();
        }
        return view('admin.page-contents.index', compact('items'));
    }

    public function edit(string $key)
    {
        if (!in_array($key, self::KEYS, true)) {
            abort(404);
        }
        $item = PageContent::firstOrNew(['key' => $key]);
        $labels = [
            'shipping' => 'نص الشحن (Shipping)',
            'returns' => 'نص الاسترجاع (Returns)',
            'faq' => 'الأسئلة الشائعة (FAQ)',
            'meta_pixel_id' => 'معرف بيكسل ميتا (Meta Pixel ID)',
            'home' => 'الصفحة الرئيسية / الهيرو (SEO)',
        ];
        return view('admin.page-contents.edit', compact('item', 'key', 'labels'));
    }

    public function update(Request $request, string $key)
    {
        if (!in_array($key, self::KEYS, true)) {
            abort(404);
        }
        $isPixel = $key === 'meta_pixel_id';
        $rules = [
            'content' => $isPixel ? 'nullable|string|max:100' : 'nullable|string',
            'title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:500',
        ];
        $request->validate($rules);
        PageContent::updateOrCreate(
            ['key' => $key],
            [
                'content' => $request->input('content'),
                'title' => $request->input('title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
                'og_title' => $request->input('og_title'),
                'og_description' => $request->input('og_description'),
                'og_image' => $request->input('og_image'),
            ]
        );
        return redirect()->route('admin.page-contents.index')
            ->with('success', 'تم الحفظ بنجاح');
    }
}
