<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HashedId;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Course extends Model
{
    use HashedId,
        Translatable,
        SoftDeletes;

    public $translatedAttributes = ['name', 'description', 'image'];
    protected $fillable = ['category_id', 'instructor_name', 'active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

}
