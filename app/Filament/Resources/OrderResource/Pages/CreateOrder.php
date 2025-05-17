<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderClient;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Model;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('product_name')->required(),
                TextInput::make('quantity')->numeric()->required()->default(0),
                TextInput::make('price')
                    ->required()
                    ->suffix('vnđ')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Select::make('status')
                    ->required()
                    ->options([
                        0 => 'pending',
                        1 => 'accepted',
                        2 => 'rejected',
                        3 => 'cancelled',
                    ]),
                Select::make('client_id')
                    ->label('Client')
                    ->options(Client::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required()
                    ->preload(),
                Textarea::make('note')
            ]);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $orderClient = OrderClient::find($data['client_id']);
        $payload = null;
        if (!$orderClient) {
            $orderClientNew = OrderClient::create([
                'client_id' => $data['client_id'],
                'total_price' => $data['status'] == 1 ? (float) $data['price'] : 0,
                'total_order' => $data['status'] == 1 ? 1 : 0,
            ]);
            $payload = [
                'order_client_id' => $orderClientNew->id,
                'product_name' => $data['product_name'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'status' => $data['status'],
                'note' => $data['note'] ?? null,
            ];
        } else {
            $priceOld = $orderClient->total_price;
            $orderOld = $orderClient->total_order;
            $orderClient->update([
                'total_price' => $data['status'] == 1 ? floatval($data['price']) + $priceOld : $priceOld,
                'total_order' => $data['status'] == 1 ? $orderOld + 1 : $orderOld,
            ]);
            $payload = [
                'order_client_id' => $orderClient->id,
                'product_name' => $data['product_name'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'status' => $data['status'],
                'note' => $data['note'] ?? null,
            ];
        }
        $order = Order::create($payload);
        return $order;
    }
}
