<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HollandCareerSuggestion extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'majors',
        'sort_order',
    ];
}

