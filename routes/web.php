<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Student\SubjectList;
use App\Livewire\Student\ExamList;
use App\Livewire\Student\TakeExam;

Route::get('/', function () {
    return redirect()->route('subjects');
});


Route::get('/subjects', SubjectList::class)->name('subjects');
Route::get('/subjects/{subject}/exams', ExamList::class)->name('exams');

Route::middleware(['auth'])->group(function () {
    Route::get('/exam/take/{variant}', TakeExam::class)->name('exam.take');
    Route::get('/exam/result/{attempt}', App\Livewire\Student\ShowResult::class)->name('exam.result');
    Route::get('/exam/history', App\Livewire\Student\ExamHistory::class)->name('exam.history');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
