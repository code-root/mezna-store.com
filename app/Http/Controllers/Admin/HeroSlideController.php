<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|url|max:500',
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        HeroSlide::create($data);
        return redirect()->route('admin.hero-slides.index')->with('success', 'تمت الإضافة بنجاح');
    }

    public function edit(HeroSlide $hero_slide)
    {
        return view('admin.hero-slides.edit', ['slide' => $hero_slide]);
    }

    public function update(Request $request, HeroSlide $hero_slide)
    {
        $data = $request->validate([
            'image' => 'required|url|max:500',
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $hero_slide->update($data);
        return redirect()->route('admin.hero-slides.index')->with('success', 'تم التحديث بنجاح');
    }

    public function destroy(HeroSlide $hero_slide)
    {
        $hero_slide->delete();
        return redirect()->route('admin.hero-slides.index')->with('success', 'تم الحذف بنجاح');
    }
}
