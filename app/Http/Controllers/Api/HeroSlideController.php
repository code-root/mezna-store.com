<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;

class HeroSlideController extends Controller
{
    /**
     * Get hero slides in random order (for carousel at top of site).
     * GET /api/hero-slides
     */
    public function index()
    {
        $slides = HeroSlide::where('is_active', true)
            ->inRandomOrder()
            ->get(['id', 'image', 'alt_text', 'caption', 'sort_order']);
        return response()->json([
            'success' => true,
            'data' => $slides,
        ]);
    }
}
