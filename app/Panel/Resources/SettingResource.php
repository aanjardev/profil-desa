<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\Setting;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Resources\Resource;

final class SettingResource extends Resource
{
    protected static string $model = Setting::class;

    protected static ?string $label = 'Pengaturan';

    protected static ?string $icon = 'sliders';

    public static function form(): array
    {
        return [
            TextField::make('key')->label('Key'),
            TextField::make('value')->label('Value'),
            TextField::make('group')->label('Group'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('key')->label('Key')->searchable()->sortable(),
            TextColumn::make('value')->label('Value')->searchable()->sortable(),
            TextColumn::make('group')->label('Group')->searchable()->sortable(),
        ];
    }
}
