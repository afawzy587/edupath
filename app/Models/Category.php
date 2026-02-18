<?php

declare(strict_types=1);

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['active'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
