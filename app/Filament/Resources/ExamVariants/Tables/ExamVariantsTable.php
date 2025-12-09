<?php

namespace App\Filament\Resources\ExamVariants\Tables;

use App\Filament\Resources\Questions\QuestionResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExamVariantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exam.subject.name')
                    ->label('Хичээл')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('exam.title')
                    ->label('Шалгалт')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('label')
                    ->label('Хувилбар')
                    ->sortable(),

                TextColumn::make('questions_count')
                    ->label('Асуултын тоо')
                    ->counts('questions'),

                TextColumn::make('created_at')
                    ->label('Үүссэн')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
