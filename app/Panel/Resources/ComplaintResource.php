<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\Complaint;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\TextareaField;
use MyLaravelTools\Panel\Resources\Resource;

final class ComplaintResource extends Resource
{
    protected static string $model = Complaint::class;

    protected static ?string $label = 'Pengaduan';

    protected static ?string $icon = 'message-square';

    public static function form(): array
    {
        return [
            TextField::make('reporter_name')->label('Reporter Name'),
            TextField::make('reporter_phone')->label('Reporter Phone'),
            TextField::make('reporter_email')->label('Reporter Email'),
            TextField::make('title')->label('Title'),
            TextareaField::make('content')->label('Content'),
            ImageField::make('attachment')->label('Attachment'),
            TextField::make('status')->label('Status'),
            TextField::make('admin_response')->label('Admin Response'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('reporter_name')->label('Reporter Name')->searchable()->sortable(),
            TextColumn::make('reporter_phone')->label('Reporter Phone')->searchable()->sortable(),
            TextColumn::make('reporter_email')->label('Reporter Email')->searchable()->sortable(),
            TextColumn::make('title')->label('Title')->searchable()->sortable(),
            ImageColumn::make('attachment')->label('Attachment'),
            TextColumn::make('status')->label('Status')->searchable()->sortable(),
            TextColumn::make('admin_response')->label('Admin Response')->searchable()->sortable(),
        ];
    }
}
