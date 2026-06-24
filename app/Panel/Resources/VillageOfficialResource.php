<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\VillageOfficial;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Resources\Resource;

final class VillageOfficialResource extends Resource
{
    protected static string $model = VillageOfficial::class;

    protected static ?string $label = 'Perangkat Desa';

    protected static ?string $icon = 'user-check';

    public static function form(): array
    {
        return [
            TextField::make('name')->label('Name'),
            TextField::make('nip')->label('Nip'),
            TextField::make('position')->label('Position'),
            ImageField::make('photo')->label('Photo'),
            TextField::make('status')->label('Status'),
            TextField::make('order_num')->label('Order Num'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('nip')->label('Nip')->searchable()->sortable(),
            TextColumn::make('position')->label('Position')->searchable()->sortable(),
            ImageColumn::make('photo')->label('Photo'),
            TextColumn::make('status')->label('Status')->searchable()->sortable(),
            TextColumn::make('order_num')->label('Order Num')->searchable()->sortable(),
        ];
    }
}
