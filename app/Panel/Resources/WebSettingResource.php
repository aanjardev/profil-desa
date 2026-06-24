<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\WebSetting;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Resources\Resource;

final class WebSettingResource extends Resource
{
    protected static string $model = WebSetting::class;

    protected static ?string $label = 'Info Web';

    protected static ?string $icon = 'globe';

    public static function form(): array
    {
        return [
            TextField::make('village_name')->label('Village Name'),
            TextField::make('subdistrict')->label('Subdistrict'),
            TextField::make('city')->label('City'),
            TextField::make('province')->label('Province'),
            TextField::make('address')->label('Address'),
            TextField::make('phone')->label('Phone'),
            TextField::make('email')->label('Email'),
            ImageField::make('logo_path')->label('Logo Path'),
            TextField::make('favicon_path')->label('Favicon Path'),
            TextField::make('maps_embed')->label('Maps Embed'),
            TextField::make('facebook')->label('Facebook'),
            TextField::make('instagram')->label('Instagram'),
            TextField::make('youtube')->label('Youtube'),
            TextField::make('twitter')->label('Twitter'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('village_name')->label('Village Name')->searchable()->sortable(),
            TextColumn::make('subdistrict')->label('Subdistrict')->searchable()->sortable(),
            TextColumn::make('city')->label('City')->searchable()->sortable(),
            TextColumn::make('province')->label('Province')->searchable()->sortable(),
            TextColumn::make('address')->label('Address')->searchable()->sortable(),
            TextColumn::make('phone')->label('Phone')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable()->sortable(),
            ImageColumn::make('logo_path')->label('Logo Path'),
            TextColumn::make('favicon_path')->label('Favicon Path')->searchable()->sortable(),
            TextColumn::make('maps_embed')->label('Maps Embed')->searchable()->sortable(),
            TextColumn::make('facebook')->label('Facebook')->searchable()->sortable(),
            TextColumn::make('instagram')->label('Instagram')->searchable()->sortable(),
            TextColumn::make('youtube')->label('Youtube')->searchable()->sortable(),
            TextColumn::make('twitter')->label('Twitter')->searchable()->sortable(),
        ];
    }
}
