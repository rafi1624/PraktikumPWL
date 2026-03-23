<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Scalar\MagicConst\File;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    //->label('Category')
                    ->sortable()
                    ->searchable(),
                ColorColumn::make('color')
                    ->sortable(),
                IconColumn::make('published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                ImageColumn::make('image')
                    ->disk('public')
                    ->height(50)
                    ->circular()
                    ->getStateUsing(fn($record) => $record->image ? asset('storage/' . $record->image) : null),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])->defaultSort('created_at', 'asc')
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload(),
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_at')
                        ->label('Sekect Date : '),
                    ])
                    ->query(function ($query,$data) {
                return $query
                ->when(
                    $data['created_at'],
                    fn($query, $date) => $query->whereDate('created_at', $date),
                );
            }),
            ])
            
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
