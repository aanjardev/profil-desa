<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\VillageStatistic;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Resources\Resource;

final class VillageStatisticResource extends Resource
{
    protected static string $model = VillageStatistic::class;

    protected static ?string $label = 'Data Statistik';

    protected static ?string $icon = 'bar-chart';

    public static function form(): array
    {
        return [
            TextField::make('key')->label('Key'),
            TextField::make('value')->label('Value'),
            TextField::make('label')->label('Label'),
            TextField::make('icon')->label('Icon'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('key')->label('Key')->searchable()->sortable(),
            TextColumn::make('value')->label('Value')->searchable()->sortable(),
            TextColumn::make('label')->label('Label')->searchable()->sortable(),
            TextColumn::make('icon')->label('Icon')->searchable()->sortable(),
        ];
    }
}
