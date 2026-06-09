<?php

namespace App\Filament\Resources\CourseMentors\Pages;

use App\Filament\Resources\CourseMentors\CourseMentorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseMentor extends EditRecord
{
    protected static string $resource = CourseMentorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
