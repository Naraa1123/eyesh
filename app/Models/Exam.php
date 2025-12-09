<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'title',
        'code',
        'duration_minutes',
        'total_points',
        'is_active',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function variants()
    {
        return $this->hasMany(ExamVariant::class);
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
