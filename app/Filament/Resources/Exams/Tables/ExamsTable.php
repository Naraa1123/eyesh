<?php

namespace App\Filament\Resources\Exams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject.name')
                    ->label('Хичээл')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Гарчиг')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Код')
                    ->searchable(),

                TextColumn::make('duration_minutes')
                    ->label('Хугацаа (мин)')
                    ->sortable(),

                TextColumn::make('total_points')
                    ->label('Нийт оноо')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Идэвхтэй')
                    ->boolean(),

                TextColumn::make('variants_count')
                    ->label('Хувилбарын тоо')
                    ->counts('variants'),
            ])
            ->filters([
                // Жишээ нь идэвхтэй / идэвхгүй filter хийж болно
            ])
            ->recordActions([
                // ListExams, CreateExam, EditExam pages-тэй ажиллана
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
