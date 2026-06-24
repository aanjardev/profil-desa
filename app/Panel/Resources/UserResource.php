<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\User;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Resources\Resource;

final class UserResource extends Resource
{
    protected static string $model = User::class;

    protected static ?string $label = 'Pengguna';

    protected static ?string $icon = 'user';

    public static function form(): array
    {
        return [
            TextField::make('name')->label('Name'),
            TextField::make('username')->label('Username'),
            TextField::make('email')->label('Email'),
            TextField::make('password')->type('password'),
            TextField::make('role')->label('Role'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('username')->label('Username')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable()->sortable(),
            TextColumn::make('role')->label('Role')->searchable()->sortable(),
        ];
    }
}
