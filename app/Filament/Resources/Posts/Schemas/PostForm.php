<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("title"),
                TextInput::make("slug"),
                Select::make('category_id')
                ->label('Category')
                ->options(
                \App\Models\Category::all()->pluck('name', 'id')
                )
                ->required(),

            ]);
    }
}