<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\ExamVariant;
use App\Models\ExamAttempt;
use App\Models\Answer;
use App\Models\Choice;
use Illuminate\Support\Facades\Auth;

class TakeExam extends Component
{

    public ExamVariant $variant;
    public ExamAttempt $attempt;
    public $questions;

    // Хэрэглэгчийн сонгосон хариултуудыг хадгалах array
    // Ж нь: [question_id => choice_id]
    public array $selectedAnswers = [];

    public $attemptTimeLeft = 0; // seconds

    public function mount(ExamVariant $variant)
    {
        $this->variant = $variant;

        // 1. Шалгалтын асуултуудыг хариулттай нь дуудах
        $this->questions = $variant->questions()
            ->with('choices')
            ->orderBy('order')
            ->get();

        // 2. Шалгалтын оролдлого (Attempt) олох эсвэл үүсгэх
        $user = Auth::user(); // User model-тэй байх ёстой
        $userId = $user ? $user->id : 1; // Default 1 for testing if not auth

        // Өмнөх дуусаагүй оролдлогыг хайх
        $existingAttempt = ExamAttempt::where('user_id', $userId)
            ->where('exam_variant_id', $variant->id)
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            $this->attempt = $existingAttempt;

            // Сонгосон хариултуудыг сэргээх (хэрэв хүсвэл)
            // Одоогоор Answer модель ашиглан сэргээж болно, эсвэл зүгээр орхиж болно
            // Хэрэв Answer table-д хадгалж байгаа бол:
             $previousAnswers = Answer::where('exam_attempt_id', $this->attempt->id)->get();
             foreach ($previousAnswers as $ans) {
                 $this->selectedAnswers[$ans->question_id] = $ans->choice_id;
             }

        } else {
            // Шинэ оролдлого үүсгэх
            $this->attempt = ExamAttempt::create([
                'exam_id' => $variant->exam_id,
                'exam_variant_id' => $variant->id,
                'user_id' => $userId,
                'started_at' => now(),
                'status' => 'in_progress',
                'max_score' => $this->questions->sum('points'),
            ]);
        }

        // 3. Үлдсэн хугацааг тооцох
        $durationMinutes = $variant->exam->duration_minutes;

        if ($durationMinutes) {
            // Эхэлсэн цаг + үргэлжлэх хугацаа = Дуусах цаг
            $startTime = \Carbon\Carbon::parse($this->attempt->started_at);
            $endTime = $startTime->copy()->addMinutes($durationMinutes);

            // Одоогийн цаг ба дуусах цагийн зөрүү (секундээр)
            $diffInSeconds = (int) now()->diffInSeconds($endTime, false); // false = return negative if past

            // Хэрэв хугацаа аль хэдийн дууссан бол 0 гэж тооцно
            $this->attemptTimeLeft = $diffInSeconds > 0 ? $diffInSeconds : 0;
            
            // Хэрэв хугацаа дууссан байвал шууд submit хийх эсэхээ шийднэ
            // Энд шууд redirect хийхгүй, front-end дээр timer 0 болоход submit хийнэ
        } else {
            // Хугацаагүй шалгалт гэж үзвэл null эсвэл маш их тоо
            $this->attemptTimeLeft = null; 
        }
    }

    public function submit()
    {
        // 1. Хариултуудыг шалгаж оноо бодох
        $totalScore = 0;

        foreach ($this->questions as $question) {
            // Хэрэглэгч энэ асуултад хариулсан уу?
            if (isset($this->selectedAnswers[$question->id])) {

                $choiceId = $this->selectedAnswers[$question->id];
                $choice = Choice::find($choiceId);

                $isCorrect = $choice->is_correct;
                $pointsAwarded = $isCorrect ? $question->points : 0;

                if ($isCorrect) {
                    $totalScore += $pointsAwarded;
                }

                // 2. Хариултыг бааз руу хадгалах
                Answer::create([
                    'exam_attempt_id' => $this->attempt->id,
                    'question_id' => $question->id,
                    'choice_id' => $choiceId,
                    'is_correct' => $isCorrect,
                    'points_awarded' => $pointsAwarded,
                ]);
            }
        }

        // 3. Оролдлогыг дуусгавар болгож шинэчлэх
        $this->attempt->update([
            'finished_at' => now(),
            'score' => $totalScore,
            'status' => 'finished',
        ]);

        // 4. Үр дүнгийн хуудас руу үсрэх (эсвэл alert өгөх)
        // Одоогоор redirect хийхгүйгээр flash message өгье (эсвэл result page руу явуулж болно)
        session()->flash('message', 'Шалгалт амжилттай дууслаа! Таны оноо: ' . $totalScore);

        return redirect()->route('exam.result', ['attempt' => $this->attempt->id]);
    }

    public function render()
    {
        return view('livewire.student.take-exam');
    }
}
