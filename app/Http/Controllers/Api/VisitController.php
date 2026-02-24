<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\VisitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VisitController extends Controller
{
    /**
     * Record a visit to a category or product.
     * POST /api/visits
     * Body: type=category|product, id=1, city=optional, country=optional
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:category,product',
            'id'   => 'required|integer|min:1',
        ]);

        $type = $request->input('type');
        $id   = (int) $request->input('id');

        $model = $type === 'category' ? Category::find($id) : Product::find($id);
        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => $type === 'category' ? 'القسم غير موجود' : 'المنتج غير موجود',
            ], 404);
        }

        $ip = $request->ip();
        $city = $request->input('city');
        $country = $request->input('country');
        $countryName = $request->input('country_name');

        if (!$city && !$country && $ip && $ip !== '127.0.0.1' && $ip !== '::1') {
            try {
                $geo = $this->getGeoFromIp($ip);
                if ($geo) {
                    $city = $city ?? $geo['city'] ?? null;
                    $country = $country ?? $geo['countryCode'] ?? null;
                    $countryName = $countryName ?? $geo['country'] ?? null;
                }
            } catch (\Throwable $e) {
                Log::debug('VisitController geo from IP failed: ' . $e->getMessage());
            }
        }

        VisitLog::create([
            'visitable_type' => get_class($model),
            'visitable_id'   => $model->id,
            'ip_address'     => $ip,
            'city'           => $city,
            'country'        => $country,
            'country_name'   => $countryName,
            'user_agent'     => $request->userAgent(),
            'referer'        => $request->header('Referer'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الزيارة',
        ]);
    }

    private function getGeoFromIp(string $ip): ?array
    {
        $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,city");
        $data = $response->json();
        if (($data['status'] ?? '') === 'success') {
            return [
                'country'      => $data['country'] ?? null,
                'countryCode'  => $data['countryCode'] ?? null,
                'city'         => $data['city'] ?? null,
            ];
        }
        return null;
    }
}
