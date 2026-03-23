<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
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
                // Menggunakan Tabs dengan mode Vertikal sesuai gambar
                Tabs::make('Product Tabs')
                    ->tabs([
                        // Tab 1: Product Details
                        Tab::make('Product Details')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),
                                
                                TextEntry::make('id')
                                    ->label('Product ID'),
                                
                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('info'),
                                
                                TextEntry::make('description')
                                    ->label('Product Description'),

                                TextEntry::make('created_at')
                                    ->label('Product Creation Date')
                                    ->date('d M Y')
                                    ->color('info'),
                            ]),

                        // Tab 2: Product Price and Stock
                        Tab::make('Product Price and Stock')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->icon('heroicon-s-currency-dollar'),
                                
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->badge()
                                    ->getStateUsing(fn ($record) => $record->stock . ' pcs')
                                    ->color(fn ($record) => $record->stock <= 5 ? 'danger' : ($record->stock <= 20 ? 'warning' : 'success')),
                            ]),

                        // Tab 3: Image and Status
                        Tab::make('Image and Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),
                                
                                IconEntry::make('is_active')
                                    ->label('Is Active?')
                                    ->boolean(),
                                
                                IconEntry::make('is_featured')
                                    ->label('Is Featured?')
                                    ->boolean(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->vertical() // Tampilan vertikal
            ]);
    }
}