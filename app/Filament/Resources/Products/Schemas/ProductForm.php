<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Actions\Action;


class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Product Info')
                        ->description('Isi Informasi Produk')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Group::make([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('sku')
                                    ->required(),
                            ])->columns(2),
                            MarkdownEditor::make('description')
                        ]),
                        // Step::make('Product prices')
                Step::make('Product Price and Stock')
                    ->description('Isi Harga Produk')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Group::make([
                            TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->validationMessages([
                                    'min_value' => 'Harga harus lebih dari 0 ya.',
                                ]),
                            TextInput::make('stock')
                                ->required(),
                        ])->columns(2),
                        MarkdownEditor::make('description')
                    ]),
                Step::make('Media and status')
                        ->description('Isi Gambar Produk')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('products'),
                            Checkbox::make('is_active'),
                            Checkbox::make('is_featured'),
                        ]),
                ])
                ->columnSpanFull()
                ->submitAction(
                    Action::make('save')
                    ->label('Save Product')
                    ->button()
                    ->color('primary')
                    ->submit('save')
                    )
            ]);
            
    }
}