<?php

namespace App\Filament\Resources\PcResource\Pages;

use App\Filament\Resources\PcResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPc extends ViewRecord
{
    protected static string $resource = PcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
