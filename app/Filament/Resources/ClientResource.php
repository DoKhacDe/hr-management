<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('custom.client.name'))->required(),
                Forms\Components\TextInput::make('phone')->label(__('custom.client.phone'))->required(),
                Forms\Components\TextInput::make('email')->label(__('custom.client.email'))->required()->email(),
                Forms\Components\TextInput::make('address')->label(__('custom.client.address')),
                TextArea::make('notes')->label(__('custom.client.notes'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('custom.client.name'))->searchable(),
                Tables\Columns\TextColumn::make('email')->label(__('custom.client.email'))->searchable(),
                Tables\Columns\TextColumn::make('phone')->label(__('custom.client.phone'))->searchable(),
                Tables\Columns\TextColumn::make('address')->label(__('custom.client.address')),
                Tables\Columns\TextColumn::make('notes')->label(__('custom.client.notes')),
            ])
            ->filters([
                //
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
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
