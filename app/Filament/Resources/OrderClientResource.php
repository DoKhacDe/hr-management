<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderClientResource\Pages;
use App\Filament\Resources\OrderClientResource\RelationManagers;
use App\Models\OrderClient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderClientResource extends Resource
{
    protected static ?string $model = OrderClient::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $label = 'Rank';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('total_price','desc')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->getStateUsing(function ($rowLoop) {
                        return $rowLoop->index + 1;
                    })
                    ->sortable(false),
                Tables\Columns\TextColumn::make('client.name')->searchable(),
                Tables\Columns\TextColumn::make('total_price'),
                Tables\Columns\TextColumn::make('total_order'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrdersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderClients::route('/'),
//            'create' => Pages\CreateOrderClient::route('/create'),
            'view' => Pages\ViewOrderClient::route('/{record}'),
//            'edit' => Pages\EditOrderClient::route('/{record}/edit'),
        ];
    }
}
