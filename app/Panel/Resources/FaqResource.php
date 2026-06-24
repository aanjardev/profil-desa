<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\Faq;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\TextareaField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class FaqResource extends Resource
{
    protected static string $model = Faq::class;

    protected static ?string $label = 'Tanya Jawab';

    protected static ?string $icon = 'help-circle';

    public static function form(): array
    {
        return [
            TextField::make('question')->label('Question'),
            TextareaField::make('answer')->label('Answer'),
            TextField::make('category')->label('Category'),
            TextField::make('order_num')->label('Order Num'),
            ToggleField::make('is_active')->label('Is Active'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('question')->label('Question')->searchable()->sortable(),
            TextColumn::make('category')->label('Category')->searchable()->sortable(),
            TextColumn::make('order_num')->label('Order Num')->searchable()->sortable(),
            BooleanColumn::make('is_active')->label('Is Active')->sortable(),
        ];
    }
}
