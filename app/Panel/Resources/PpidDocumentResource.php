<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\PpidDocument;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\TextareaField;
use MyLaravelTools\Panel\Resources\Resource;

final class PpidDocumentResource extends Resource
{
    protected static string $model = PpidDocument::class;

    protected static ?string $label = 'Produk Hukum';

    protected static ?string $icon = 'scale';

    public static function form(): array
    {
        return [
            TextField::make('title')->label('Title'),
            TextareaField::make('description')->label('Description'),
            ImageField::make('file_path')->label('File Path'),
            TextField::make('year')->label('Year'),
            TextField::make('category')->label('Category'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('title')->label('Title')->searchable()->sortable(),
            ImageColumn::make('file_path')->label('File Path'),
            TextColumn::make('year')->label('Year')->searchable()->sortable(),
            TextColumn::make('category')->label('Category')->searchable()->sortable(),
        ];
    }
}
