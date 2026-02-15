<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    protected $fillable = ['title','locale','question_id'];
}
