<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExploreInteraction extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'views_count',
        'watch_seconds',
    ];
}
