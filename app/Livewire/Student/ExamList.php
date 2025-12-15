<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Exam;
use App\Models\Subject;

class ExamList extends Component
{

    public Subject $subject;
    public function render()
    {
        $exams = $this->subject->exams()
            ->with('variants')
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('livewire.student.exam-list', [
            'exams' => $exams
        ]);
    }
}
