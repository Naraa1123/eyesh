<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamAttempt;

class ExamHistory extends Component
{
    use WithPagination;

    public function render()
    {
        $attempts = ExamAttempt::where('user_id', Auth::id())
            ->with(['exam', 'variant'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.student.exam-history', [
            'attempts' => $attempts
        ]);
    }
}
