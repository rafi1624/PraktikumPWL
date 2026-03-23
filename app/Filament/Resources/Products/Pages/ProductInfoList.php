<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Section: Product Info (Disesuaikan dengan penambahan Created At)
                Section::make('Product Info')
                    ->description('') 
                    ->schema([
                        TextEntry::make('name')
                            ->label('Product Name')
                            ->color('#F97316'), 
                        
                        TextEntry::make('id')
                            ->label('Product ID'),
                        
                        TextEntry::make('sku')
                            ->label('Product SKU')
                            ->badge()
                            ->color('warning')
                            ->fontFamily('mono'),
                        
                        TextEntry::make('description')
                            ->label('Product Description')
                            ->columnSpanFull(),

                        // Penambahan Product Creation Date sesuai gambar
                        TextEntry::make('created_at')
                            ->label('Product Creation Date')
                            ->date('d M Y')
                            ->color('info'),
                    ]),

                // 2. Section: Product Price and Stock
                Section::make('Product Price and Stock')
                    ->description('')
                    ->schema([
                        TextEntry::make('price')
                            ->label('Product Price')
                            ->weight('bold')
                            ->color('primary')
                            ->icon('heroicon-s-currency-dollar')
                            ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                        
                        TextEntry::make('stock')
                            ->label('Product Stock')
                            ->suffix(' pcs')
                            ->icon('heroicon-o-cube'),
                    ])
                    ->columns(2),

                // 3. Section: Product Image & Status
                Section::make('Product Image')
                    ->description('')
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Product Image')
                            ->disk('public')
                            ->height(180)
                            ->columnSpanFull(),

                        IconEntry::make('is_active')
                            ->label('Is Active?')
                            ->boolean(),
                        
                        IconEntry::make('is_featured')
                            ->label('Is Featured?')
                            ->boolean(),
                    ])
                    ->columns(2),
            ]);
    }
}