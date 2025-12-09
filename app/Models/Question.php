<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_variant_id',
        'text',
        'points',
        'order',
    ];

    public function variant()
    {
        return $this->belongsTo(ExamVariant::class, 'exam_variant_id');
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
