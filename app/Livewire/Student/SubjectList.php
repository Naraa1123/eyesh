<?php

namespace App\Livewire\Student;

use App\Models\Subject;
use Livewire\Component;

class SubjectList extends Component
{
    public $search = '';

    public function render()
    {
        // Хайлт болон идэвхтэй шалгалтын тоог тоолох query
        $subjects = Subject::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            })
            ->withCount(['exams' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        return view('livewire.student.subject-list', [
            'subjects' => $subjects
        ]);
    }
}
