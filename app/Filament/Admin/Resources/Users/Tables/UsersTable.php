<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;

class UsersTable
{
    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('level.level_nama')
                ->label('Level'),

            TextColumn::make('username')
                ->searchable(),

            TextColumn::make('nama')
                ->searchable(),
        ])
        ->recordActions([
            EditAction::make(),
        ])
        ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ]);
}
}
