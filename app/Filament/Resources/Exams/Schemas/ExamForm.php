<?php

namespace App\Filament\Resources\Exams\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\BelongsToSelect;

class ExamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('subject_id')
                ->label('Хичээл')
                ->relationship('subject', 'name')
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('title')
                ->label('Шалгалтын нэр')
                ->required()
                ->maxLength(255),

            TextInput::make('code')
                ->label('Шалгалтын код')
                ->maxLength(255)
                ->helperText('Жишээ: MIDTERM_2025_1'),

            TextInput::make('duration_minutes')
                ->label('Үргэлжлэх хугацаа (минут)')
                ->numeric()
                ->minValue(1)
                ->maxValue(600)
                ->default(60),

            TextInput::make('total_points')
                ->label('Нийт оноо')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->helperText('Дараа нь автоматаар боддог бол readOnly болгож болно.'),


            Toggle::make('is_active')
                ->label('Идэвхтэй эсэх')
                ->default(true),
        ]);
    }
}
