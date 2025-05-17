<?php

namespace App\Filament\Resources\OrderClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'order';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_client_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_client_id')
            ->columns([
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('price'),
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
