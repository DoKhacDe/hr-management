<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Client;
use Filament\Actions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Model;
class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('product_name')->required()
                    ->disabled(fn ($record) => $record->status == 1),
                TextInput::make('quantity')->numeric()->required()->default(0)
                    ->disabled(fn ($record) => $record->status == 1),
                TextInput::make('price')
                    ->required()
                    ->suffix('vnđ')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->disabled(fn ($record) => $record->status == 1),
                Select::make('status')
                    ->required()
                    ->options([
                        0 => 'pending',
                        1 => 'accepted',
                        2 => 'rejected',
                        3 => 'cancelled',
                    ])
                    ->disabled(fn ($record) => $record->status == 1),
                Placeholder::make('client_name')
                    ->label('Client Name')
                    ->content(function ($record) {
                        return optional($record->orderClient->client)->name ?? 'Không có thông tin';
                    }),
                Textarea::make('note')
                    ->disabled(fn ($record) => $record->status == 1),
            ]);
    }

    public function handleRecordUpdate(Model $record, array $data): Model
    {
        $orderClient = $record->orderClient;
        if($orderClient) {
            $priceOld = $orderClient->total_price;
            $orderOld = $orderClient->total_order;
            $orderClient->update([
                'total_price' => $data['status'] == 1 ? floatval($data['price']) + $priceOld : $priceOld,
                'total_order' => $data['status'] == 1 ? $orderOld + 1 : $orderOld,
            ]);
        }
        unset($data['client_name']);

        $record->update($data);

        return $record;
    }
}
