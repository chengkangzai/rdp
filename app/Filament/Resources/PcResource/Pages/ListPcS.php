<?php

namespace App\Filament\Resources\PCResource\Pages;

use App\Filament\Resources\PcResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPcS extends ListRecords
{
    protected static string $resource = PcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
