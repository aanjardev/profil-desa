<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\EmergencyContact;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class EmergencyContactResource extends Resource
{
    protected static string $model = EmergencyContact::class;

    protected static ?string $label = 'Darurat';

    protected static ?string $icon = 'alert-triangle';

    public static function form(): array
    {
        return [
            TextField::make('name')->label('Name'),
            TextField::make('phone')->label('Phone'),
            TextField::make('category')->label('Category'),
            TextField::make('address')->label('Address'),
            TextField::make('order_num')->label('Order Num'),
            ToggleField::make('is_active')->label('Is Active'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('phone')->label('Phone')->searchable()->sortable(),
            TextColumn::make('category')->label('Category')->searchable()->sortable(),
            TextColumn::make('address')->label('Address')->searchable()->sortable(),
            TextColumn::make('order_num')->label('Order Num')->searchable()->sortable(),
            BooleanColumn::make('is_active')->label('Is Active')->sortable(),
        ];
    }
}
