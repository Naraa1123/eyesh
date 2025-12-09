<?php

namespace App\Filament\Resources\ExamVariants\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use App\Models\Subject;
use App\Models\Exam;

class ExamVariantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subject_id')
                    ->label('Хичээл')
                    ->options(fn () => Subject::query()
                        ->orderBy('name')
                        ->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn (Set $set) => $set('exam_id', null))
                    ->required()
                    ->dehydrated(false),

                // 2. Хичээлээсээ шүүлттэй Exam
                Select::make('exam_id')
                    ->label('Шалгалт')
                    ->options(function (Get $get) {
                        $subjectId = $get('subject_id');

                        if (! $subjectId) {
                            return [];
                        }

                        return Exam::query()
                            ->where('subject_id', $subjectId)
                            ->orderBy('title')
                            ->pluck('title', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn (Get $get) => ! $get('subject_id')), // эхлээд subject сонгохыг шахна
                 TextInput::make('label')
                     ->label('Хувилбарын тэмдэглэгээ (A, B, C...)')
                     ->maxLength(10)
                     ->required(),

                 Textarea::make('description')
                     ->label('Тайлбар')
                     ->rows(3)
                     ->maxLength(65535)
                     ->nullable(),
            ]);
    }
}
