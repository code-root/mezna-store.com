<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'key',
        'content',
        'title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
    ];

    public static function getByKey(string $key): ?string
    {
        $row = static::where('key', $key)->first();
        return $row ? $row->content : null;
    }
}
