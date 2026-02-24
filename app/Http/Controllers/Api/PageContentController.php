<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public function show(string $key)
    {
        $allowed = ['shipping', 'returns', 'faq', 'meta_pixel_id', 'home'];
        if (!in_array($key, $allowed, true)) {
            return response()->json(['success' => false, 'message' => 'غير موجود'], 404);
        }
        $content = PageContent::where('key', $key)->first();
        $data = [
            'key' => $key,
            'content' => $content ? $content->content : null,
            'seo' => null,
        ];
        if ($content) {
            $data['seo'] = [
                'title' => $content->title,
                'meta_description' => $content->meta_description,
                'meta_keywords' => $content->meta_keywords,
                'og_title' => $content->og_title,
                'og_description' => $content->og_description,
                'og_image' => $content->og_image,
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function index(Request $request)
    {
        $keys = $request->input('keys', 'shipping,returns,faq,meta_pixel_id,home');
        $keys = array_map('trim', explode(',', $keys));
        $allowed = ['shipping', 'returns', 'faq', 'meta_pixel_id', 'home'];
        $keys = array_intersect($keys, $allowed);
        $items = PageContent::whereIn('key', $keys)->get()->keyBy('key');
        $data = [];
        foreach ($keys as $k) {
            $row = $items->get($k);
            $data[$k] = [
                'content' => $row?->content,
                'seo' => $row ? [
                    'title' => $row->title,
                    'meta_description' => $row->meta_description,
                    'meta_keywords' => $row->meta_keywords,
                    'og_title' => $row->og_title,
                    'og_description' => $row->og_description,
                    'og_image' => $row->og_image,
                ] : null,
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
