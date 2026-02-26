<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HashedId;
use App\Traits\UploadFileTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Review;

class Course extends Model
{
    use HashedId;
    use Translatable;
    use SoftDeletes;
    use UploadFileTrait;

    public $translatedAttributes = ['name', 'description', 'image'];
    protected $fillable = ['category_id', 'instructor_name', 'active', 'video'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'course_likes')->withTimestamps();
    }

    public function getImagePathAttribute()
    {
        return $this->getFileUrl($this->image);
    }

    public function getVideoPathAttribute()
    {
        return $this->getFileUrl($this->video);
    }

}
