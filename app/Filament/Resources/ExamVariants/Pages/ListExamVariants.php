<?php

namespace App\Filament\Resources\ExamVariants\Pages;

use App\Filament\Resources\ExamVariants\ExamVariantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamVariants extends ListRecords
{
    protected static string $resource = ExamVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
