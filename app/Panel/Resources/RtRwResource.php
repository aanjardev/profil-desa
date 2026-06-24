<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\RtRw;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class RtRwResource extends Resource
{
    protected static string $model = RtRw::class;

    protected static ?string $label = 'Data RT/RW';

    protected static ?string $icon = 'map';

    public static function form(): array
    {
        return [
            TextField::make('rw_number')->label('Rw Number'),
            TextField::make('rt_number')->label('Rt Number'),
            TextField::make('head_name')->label('Head Name'),
            TextField::make('head_phone')->label('Head Phone'),
            TextField::make('total_kk')->label('Total Kk'),
            TextField::make('total_male')->label('Total Male'),
            TextField::make('total_female')->label('Total Female'),
            TextField::make('area_name')->label('Area Name'),
            ToggleField::make('is_active')->label('Is Active'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('rw_number')->label('Rw Number')->searchable()->sortable(),
            TextColumn::make('rt_number')->label('Rt Number')->searchable()->sortable(),
            TextColumn::make('head_name')->label('Head Name')->searchable()->sortable(),
            TextColumn::make('head_phone')->label('Head Phone')->searchable()->sortable(),
            TextColumn::make('total_kk')->label('Total Kk')->searchable()->sortable(),
            TextColumn::make('total_male')->label('Total Male')->searchable()->sortable(),
            TextColumn::make('total_female')->label('Total Female')->searchable()->sortable(),
            TextColumn::make('area_name')->label('Area Name')->searchable()->sortable(),
            BooleanColumn::make('is_active')->label('Is Active')->sortable(),
        ];
    }
}
