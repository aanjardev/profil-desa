<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\ServiceLetter;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class ServiceLetterResource extends Resource
{
    protected static string $model = ServiceLetter::class;

    protected static ?string $label = 'Layanan Surat';

    protected static ?string $icon = 'mail';

    public static function form(): array
    {
        return [
            TextField::make('letter_name')->label('Letter Name'),
            TextField::make('requirements')->label('Requirements'),
            TextField::make('estimated_time')->label('Estimated Time'),
            TextField::make('fee')->label('Fee'),
            ToggleField::make('is_active')->label('Is Active'),
            TextField::make('order_num')->label('Order Num'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('letter_name')->label('Letter Name')->searchable()->sortable(),
            TextColumn::make('requirements')->label('Requirements')->searchable()->sortable(),
            TextColumn::make('estimated_time')->label('Estimated Time')->searchable()->sortable(),
            TextColumn::make('fee')->label('Fee')->searchable()->sortable(),
            BooleanColumn::make('is_active')->label('Is Active')->sortable(),
            TextColumn::make('order_num')->label('Order Num')->searchable()->sortable(),
        ];
    }
}
