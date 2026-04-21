<?php

namespace App\Filament\Admin\Resources\Levels;

use App\Filament\Admin\Resources\Levels\Pages\CreateLevel;
use App\Filament\Admin\Resources\Levels\Pages\EditLevel;
use App\Filament\Admin\Resources\Levels\Pages\ListLevels;
use App\Filament\Admin\Resources\Levels\Schemas\LevelForm;
use App\Models\Level;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'level_nama';

    protected static ?string $navigationLabel = 'Level';

    protected static ?string $pluralModelLabel = 'Level';

    protected static ?string $modelLabel = 'Level';

    public static function form(Schema $schema): Schema
    {
        return LevelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('level_kode')
                    ->label('Kode Level')
                    ->searchable(),

                TextColumn::make('level_nama')
                    ->label('Nama Level')
                    ->searchable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLevels::route('/'),
            'create' => CreateLevel::route('/create'),
            'edit' => EditLevel::route('/{record}/edit'),
        ];
    }
}