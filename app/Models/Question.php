<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HashedId;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    use HashedId;
    use Translatable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['category_id', 'type', 'active', 'order'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
