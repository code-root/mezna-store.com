<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VisitLog extends Model
{
    protected $fillable = [
        'visitable_type',
        'visitable_id',
        'ip_address',
        'city',
        'country',
        'country_name',
        'user_agent',
        'referer',
    ];

    public function visitable(): MorphTo
    {
        return $this->morphTo();
    }
}
