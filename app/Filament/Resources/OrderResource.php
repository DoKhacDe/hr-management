<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Client;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('orderClient.client.name'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        0 => 'pending',
                        1 => 'accepted',
                        2 => 'rejected',
                        3 => 'cancelled',
                        default => 'unknown',
                    })
                    ->color(fn ($state) => match ($state) {
                        0 => 'info',
                        1 => 'success',
                        2 => 'danger',
                        3 => 'gray',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('created_at'),
            ])
            ->filters([
                SelectFilter::make('client_id')
                    ->label('Khách hàng')
                    ->relationship('orderClient.client', 'name')
                    ->preload()
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
