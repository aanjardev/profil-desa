<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\TourismUmkm;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\TextareaField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class TourismUmkmResource extends Resource
{
    protected static string $model = TourismUmkm::class;

    protected static ?string $label = 'Wisata & UMKM';

    protected static ?string $icon = 'store';

    public static function form(): array
    {
        return [
            TextField::make('name')->label('Name'),
            TextField::make('slug')->label('Slug'),
            TextareaField::make('description')->label('Description'),
            TextField::make('type')->label('Type'),
            TextField::make('location')->label('Location'),
            TextField::make('maps_link')->label('Maps Link'),
            TextField::make('contact')->label('Contact'),
            TextField::make('website')->label('Website'),
            ImageField::make('image')->label('Image'),
            ToggleField::make('is_active')->label('Is Active'),
            TextField::make('views')->label('Views'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('slug')->label('Slug')->searchable()->sortable(),
            TextColumn::make('type')->label('Type')->searchable()->sortable(),
            TextColumn::make('location')->label('Location')->searchable()->sortable(),
            TextColumn::make('maps_link')->label('Maps Link')->searchable()->sortable(),
            TextColumn::make('contact')->label('Contact')->searchable()->sortable(),
            TextColumn::make('website')->label('Website')->searchable()->sortable(),
            ImageColumn::make('image')->label('Image'),
            BooleanColumn::make('is_active')->label('Is Active')->sortable(),
            TextColumn::make('views')->label('Views')->searchable()->sortable(),
        ];
    }
}
