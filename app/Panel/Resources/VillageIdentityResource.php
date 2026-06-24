<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\VillageIdentity;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\TextareaField;
use MyLaravelTools\Panel\Resources\Resource;

final class VillageIdentityResource extends Resource
{
    protected static string $model = VillageIdentity::class;

    protected static ?string $label = 'Profil Desa';

    protected static ?string $icon = 'book-open';

    public static function form(): array
    {
        return [
            TextField::make('key')->label('Key'),
            TextField::make('title')->label('Title'),
            TextareaField::make('content')->label('Content'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('key')->label('Key')->searchable()->sortable(),
            TextColumn::make('title')->label('Title')->searchable()->sortable(),
        ];
    }
}
