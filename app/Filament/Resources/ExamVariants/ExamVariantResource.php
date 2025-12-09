<?php

namespace App\Filament\Resources\ExamVariants;

use App\Filament\Resources\ExamVariants\Pages\CreateExamVariant;
use App\Filament\Resources\ExamVariants\Pages\EditExamVariant;
use App\Filament\Resources\ExamVariants\Pages\ListExamVariants;
use App\Filament\Resources\ExamVariants\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\ExamVariants\Schemas\ExamVariantForm;
use App\Filament\Resources\ExamVariants\Tables\ExamVariantsTable;
use App\Models\ExamVariant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ExamVariantResource extends Resource
{
    protected static ?string $model = ExamVariant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $navigationLabel = 'Шалгалтын хувилбар';

    protected static string | UnitEnum | null $navigationGroup = 'Шалгалтын тохиргоо';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ExamVariantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamVariantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExamVariants::route('/'),
            'create' => CreateExamVariant::route('/create'),
            'edit' => EditExamVariant::route('/{record}/edit'),
        ];
    }
}
