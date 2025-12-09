<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'exam_variant_id',
        'user_id',
        'started_at',
        'finished_at',
        'score',
        'max_score',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function variant()
    {
        return $this->belongsTo(ExamVariant::class, 'exam_variant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
