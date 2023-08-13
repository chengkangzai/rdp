<?php

namespace App\Filament\Resources\PCResource\Pages;

use App\Filament\Resources\PcResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPc extends EditRecord
{
    protected static string $resource = PcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
