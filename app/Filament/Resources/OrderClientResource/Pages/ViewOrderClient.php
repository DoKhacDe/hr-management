<?php

namespace App\Filament\Resources\OrderClientResource\Pages;

use App\Filament\Resources\OrderClientResource;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewOrderClient extends ViewRecord
{
    protected static string $resource = OrderClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(4)
            ->schema([
                TextEntry::make('client.name'),
                TextEntry::make('total_price')->numeric(locale: 'nl'),
                TextEntry::make('total_order')->label('Total Order Done')->numeric(),
                TextEntry::make('total_orders')
                    ->label('Total Orders')
                    ->getStateUsing(function ($record) {
                        return $record->order()->count();
                    })
                    ->numeric(),
        ]);
    }
}
