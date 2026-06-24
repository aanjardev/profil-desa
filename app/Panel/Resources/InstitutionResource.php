<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\Institution;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\TextareaField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class InstitutionResource extends Resource
{
    protected static string $model = Institution::class;

    protected static ?string $label = 'Lembaga';

    protected static ?string $icon = 'building';

    public static function form(): array
    {
        return [
            TextField::make('name')->label('Name'),
            TextField::make('type')->label('Type'),
            TextareaField::make('description')->label('Description'),
            ImageField::make('logo')->label('Logo'),
            ToggleField::make('is_active')->label('Is Active'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('type')->label('Type')->searchable()->sortable(),
            ImageColumn::make('logo')->label('Logo'),
            BooleanColumn::make('is_active')->label('Is Active')->sortable(),
        ];
    }
}
