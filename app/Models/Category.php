<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'image',
        'is_active',
        'hide_price',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hide_price' => 'boolean',
    ];

    public function banners()
    {
        return $this->hasMany(Banners::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function visitLogs()
    {
        return $this->morphMany(VisitLog::class, 'visitable');
    }
}
