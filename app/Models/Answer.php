<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HashedId;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HashedId;

    protected $fillable = ['question_id','student_id','value'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
