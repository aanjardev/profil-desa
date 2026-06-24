<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\PpidOfficial;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class PpidOfficialResource extends Resource
{
    protected static string $model = PpidOfficial::class;

    protected static ?string $label = 'Petugas PPID';

    protected static ?string $icon = 'user-cog';

    public static function form(): array
    {
        return [
            TextField::make('name')->label('Name'),
            TextField::make('position')->label('Position'),
            ImageField::make('photo')->label('Photo'),
            TextField::make('phone')->label('Phone'),
            TextField::make('email')->label('Email'),
            TextField::make('order_num')->label('Order Num'),
            ToggleField::make('is_active')->label('Is Active'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('position')->label('Position')->searchable()->sortable(),
            ImageColumn::make('photo')->label('Photo'),
            TextColumn::make('phone')->label('Phone')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable()->sortable(),
            TextColumn::make('order_num')->label('Order Num')->searchable()->sortable(),
            BooleanColumn::make('is_active')->label('Is Active')->sortable(),
        ];
    }
}
