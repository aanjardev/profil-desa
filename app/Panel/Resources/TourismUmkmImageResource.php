<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\TourismUmkmImage;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class TourismUmkmImageResource extends Resource
{
    protected static string $model = TourismUmkmImage::class;

    protected static ?string $label = 'Foto Wisata';

    protected static ?string $icon = 'camera';

    public static function form(): array
    {
        return [
            TextField::make('tourism_umkm_id')->label('Tourism Umkm Id'),
            ImageField::make('image_path')->label('Image Path'),
            TextField::make('caption')->label('Caption'),
            ToggleField::make('is_thumbnail')->label('Is Thumbnail'),
            TextField::make('order_num')->label('Order Num'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('tourism_umkm_id')->label('Tourism Umkm Id')->searchable()->sortable(),
            ImageColumn::make('image_path')->label('Image Path'),
            TextColumn::make('caption')->label('Caption')->searchable()->sortable(),
            BooleanColumn::make('is_thumbnail')->label('Is Thumbnail')->sortable(),
            TextColumn::make('order_num')->label('Order Num')->searchable()->sortable(),
        ];
    }
}
