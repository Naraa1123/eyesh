<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;

class ShowResult extends Component
{
    public ExamAttempt $attempt;
    public $totalScore;
    public $maxScore;
    public $questions;

    public function mount(ExamAttempt $attempt)
    {
        $this->attempt = $attempt;

        // Security check: ensure the user owns this attempt
        if ($this->attempt->user_id !== Auth::id()) {
            abort(403);
        }

        $this->totalScore = $this->attempt->score;
        $this->maxScore = $this->attempt->max_score;

        // Load questions with answers and choices
        $this->questions = $this->attempt->variant->questions()
            ->with(['choices'])
            ->orderBy('order')
            ->get();

        // Load user's answers
        $this->attempt->load('answers');
    }

    public function render()
    {
        return view('livewire.student.show-result');
    }
}
