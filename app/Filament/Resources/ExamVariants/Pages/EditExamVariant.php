<?php

namespace App\Filament\Resources\ExamVariants\Pages;

use App\Filament\Resources\ExamVariants\ExamVariantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExamVariant extends EditRecord
{
    protected static string $resource = ExamVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
