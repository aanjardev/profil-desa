<?php

declare(strict_types=1);

namespace App\Panel\Resources;

use App\Models\Post;
use MyLaravelTools\Panel\Columns\BooleanColumn;
use MyLaravelTools\Panel\Columns\ImageColumn;
use MyLaravelTools\Panel\Columns\TextColumn;
use MyLaravelTools\Panel\Fields\ImageField;
use MyLaravelTools\Panel\Fields\TextField;
use MyLaravelTools\Panel\Fields\TextareaField;
use MyLaravelTools\Panel\Fields\ToggleField;
use MyLaravelTools\Panel\Resources\Resource;

final class PostResource extends Resource
{
    protected static string $model = Post::class;

    protected static ?string $label = 'Publikasi';

    protected static ?string $icon = 'newspaper';

    public static function form(): array
    {
        return [
            TextField::make('title')->label('Title'),
            TextField::make('slug')->label('Slug'),
            TextareaField::make('content')->label('Content'),
            TextField::make('excerpt')->label('Excerpt'),
            ImageField::make('image')->label('Image'),
            TextField::make('category')->label('Category'),
            TextField::make('event_date')->label('Event Date'),
            ToggleField::make('is_published')->label('Is Published'),
            ToggleField::make('is_featured')->label('Is Featured'),
            TextField::make('views')->label('Views'),
            TextField::make('user_id')->label('User Id'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('title')->label('Title')->searchable()->sortable(),
            TextColumn::make('slug')->label('Slug')->searchable()->sortable(),
            TextColumn::make('excerpt')->label('Excerpt')->searchable()->sortable(),
            ImageColumn::make('image')->label('Image'),
            TextColumn::make('category')->label('Category')->searchable()->sortable(),
            TextColumn::make('event_date')->label('Event Date')->searchable()->sortable(),
            BooleanColumn::make('is_published')->label('Is Published')->sortable(),
            BooleanColumn::make('is_featured')->label('Is Featured')->sortable(),
            TextColumn::make('views')->label('Views')->searchable()->sortable(),
            TextColumn::make('user_id')->label('User Id')->searchable()->sortable(),
        ];
    }
}
