<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Exports\ClientExporter;
use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(ClientExporter::class)
                ->color('primary')
                ->columnMapping(false)
                ->formats([
                    ExportFormat::Xlsx,
                    ExportFormat::Csv,
                ]),
            Actions\CreateAction::make(),
        ];
    }
}
