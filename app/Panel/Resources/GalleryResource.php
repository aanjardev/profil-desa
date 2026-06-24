<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\Gallery;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\TextareaField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class GalleryResource extends Resource
{
    protected static string $model = Gallery::class;

    protected static ?string $label = 'Galeri Foto';

    protected static ?string $icon = 'image';

    public static function form(): array
    {
        return [
            TextField::make('title')->label('Title'),
            TextareaField::make('description')->label('Description'),
            ImageField::make('image_path')->label('Image Path'),
            ToggleField::make('is_hero_banner')->label('Is Hero Banner'),
            TextField::make('category')->label('Category'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('title')->label('Title')->searchable()->sortable(),
            ImageColumn::make('image_path')->label('Image Path'),
            BooleanColumn::make('is_hero_banner')->label('Is Hero Banner')->sortable(),
            TextColumn::make('category')->label('Category')->searchable()->sortable(),
        ];
    }
}
