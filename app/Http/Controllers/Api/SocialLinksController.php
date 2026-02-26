<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageContent;

class SocialLinksController extends Controller
{
    protected static array $keys = [
        'social_facebook', 'social_instagram', 'social_twitter', 'social_snapchat',
        'social_whatsapp', 'social_tiktok', 'social_youtube',
    ];

    /**
     * GET /api/social-links
     * يرجع روابط حسابات التواصل الاجتماعي (فيسبوك، انستغرام، تويتر، إلخ).
     */
    public function index()
    {
        $items = PageContent::whereIn('key', self::$keys)->get()->keyBy('key');
        $data = [];
        foreach (self::$keys as $key) {
            $short = str_replace('social_', '', $key);
            $data[$short] = $items->get($key)?->content;
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
