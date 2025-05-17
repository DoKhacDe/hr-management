<?php

namespace App\Filament\Resources\OrderClientResource\Pages;

use App\Filament\Resources\OrderClientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderClient extends EditRecord
{
    protected static string $resource = OrderClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
