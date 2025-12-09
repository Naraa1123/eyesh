<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'label',
        'description',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
