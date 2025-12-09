<?php

namespace App\Filament\Resources\Subjects;

use App\Filament\Resources\Subjects\Pages;
use App\Models\Subject;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use UnitEnum;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationLabel = 'Хичээл';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string | UnitEnum | null $navigationGroup = 'Шалгалтын тохиргоо';
    protected static ?int $navigationSort = 1;


    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Хичээлийн нэр')
                ->required()
                ->maxLength(255),

            TextInput::make('code')
                ->label('Код (ж: MATH101)')
                ->maxLength(50),

            Textarea::make('description')
                ->label('Тайлбар')
                ->rows(3),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Хичээл')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Код')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('exams_count')
                    ->label('Шалгалтын тоо')
                    ->counts('exams')
                    ->sortable(),
            ])
            ->filters([
                // Хэрэв хэрэгтэй бол filter нэмэж болно.
            ])
            ->recordActions([
                // v4-д Edit/Delete нь Pages-тэй холбогддог тул table дотор заавал зарлах албагүй.
                // Хэрэв хүсвэл энд Action::make() ашиглаж өөрийн action нэмэж болно.
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Хожим Subject -> Exams relation manager хийх бол энд нэмнэ.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
