<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\ContactService;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class ContactServiceResource extends Resource
{
    protected static string $model = ContactService::class;

    protected static ?string $label = 'Kontak Layanan';

    protected static ?string $icon = 'phone-call';

    public static function form(): array
    {
        return [
            TextField::make('service_name')->label('Service Name'),
            TextField::make('officer_name')->label('Officer Name'),
            TextField::make('phone')->label('Phone'),
            TextField::make('email')->label('Email'),
            TextField::make('office_hours')->label('Office Hours'),
            TextField::make('location')->label('Location'),
            TextField::make('order_num')->label('Order Num'),
            ToggleField::make('is_active')->label('Is Active'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('service_name')->label('Service Name')->searchable()->sortable(),
            TextColumn::make('officer_name')->label('Officer Name')->searchable()->sortable(),
            TextColumn::make('phone')->label('Phone')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable()->sortable(),
            TextColumn::make('office_hours')->label('Office Hours')->searchable()->sortable(),
            TextColumn::make('location')->label('Location')->searchable()->sortable(),
            TextColumn::make('order_num')->label('Order Num')->searchable()->sortable(),
            BooleanColumn::make('is_active')->label('Is Active')->sortable(),
        ];
    }
}
