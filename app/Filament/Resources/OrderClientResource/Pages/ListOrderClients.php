<?php

namespace App\Filament\Resources\OrderClientResource\Pages;

use App\Filament\Resources\OrderClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderClients extends ListRecords
{
    protected static string $resource = OrderClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
