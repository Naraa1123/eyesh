<?php

namespace App\Filament\Resources\ExamVariants\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';
    protected static ?string $title = 'Асуултууд';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('text')
                    ->label('Асуултын агуулга')
                    ->rows(4)
                    ->columnSpanFull()
                    ->required(),

                TextInput::make('points')
                    ->label('Оноо')
                    ->numeric()
                    ->columnSpanFull()
                    ->minValue(0)
                    ->default(1)
                    ->required(),

                TextInput::make('order')
                    ->label('Дараалал')
                    ->numeric()
                    ->columnSpanFull()
                    ->default(0),

                Repeater::make('choices')
                    ->label('Сонгох хариунууд')
                    ->relationship('choices') // Question::choices()
                    ->schema([
                        TextInput::make('text')
                            ->label('Хариултын текст')
                            ->columnSpanFull()
                            ->required(),

                        Toggle::make('is_correct')
                            ->label('Зөв хариулт уу?')
                            ->inline(false),
                    ])
                    ->columnSpanFull()
                    ->minItems(2)
                    ->maxItems(6)
                    ->addActionLabel('Хариулт нэмэх')
                    ->reorderable()
                    ->helperText('Нэг асуултад дор хаяж 2 хариулт, нэг нь заавал зөв байх ёстой.'),
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('text')
                    ->label('Асуулт')
                    ->limit(80)
                    ->wrap()
                    ->searchable(),

                TextColumn::make('points')
                    ->label('Оноо')
                    ->sortable(),

                TextColumn::make('choices_count')
                    ->label('Хариултын тоо')
                    ->counts('choices'),

                TextColumn::make('created_at')
                    ->label('Үүссэн')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([

            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Асуулт нэмэх')
                    ->modalHeading('Шинэ асуулт нэмэх'),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Асуулт засах'),
                DeleteAction::make()
                    ->label('Устгах'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);

    }
}
