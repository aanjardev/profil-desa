<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\InstitutionMember;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Resources\Resource;

final class InstitutionMemberResource extends Resource
{
    protected static string $model = InstitutionMember::class;

    protected static ?string $label = 'Pengurus Lembaga';

    protected static ?string $icon = 'users';

    public static function form(): array
    {
        return [
            TextField::make('institution_id')->label('Institution Id'),
            TextField::make('name')->label('Name'),
            TextField::make('position')->label('Position'),
            ImageField::make('photo')->label('Photo'),
            TextField::make('order_num')->label('Order Num'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('institution_id')->label('Institution Id')->searchable()->sortable(),
            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('position')->label('Position')->searchable()->sortable(),
            ImageColumn::make('photo')->label('Photo'),
            TextColumn::make('order_num')->label('Order Num')->searchable()->sortable(),
        ];
    }
}
