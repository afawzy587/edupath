<?php

namespace App\Models;

use App\Traits\HashedId;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Question extends Model
{
    use SoftDeletes,
        HashedId,
        Translatable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['type','active','order'];
}
