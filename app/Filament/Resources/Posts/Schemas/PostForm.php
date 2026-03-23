<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Support\Icons\Heroicon;

class PostForm
{
public static function configure(Schema $schema): Schema
{
    return $schema
        ->schema([
            // Section 1: Post Details
            Section::make("Post Details")
                ->description("Fill in the details of the post")
                ->icon('heroicon-o-document-text')
                ->schema([
                    // Grouping title, slug, category, and color into 2 columns
                    Group::make([
                        TextInput::make("title")
                        ->rules(["required","min:5","max:255"])
                        ->validationMessages([
                            'required' => 'Title wajib diisi ya.',
                            'min' => 'Title minimal 5 karakter.',
                        ]),
                        TextInput::make("slug")
                        ->rules(["required","min:3","unique"])
                        ->validationMessages([
                            'required' => 'Slug wajib diisi.',
                            'min' => 'Slug minimal 3 karakter.',
                            'unique' => 'Slug sudah digunakan, coba yang lain ya.',
                        ]),
                        Select::make("category_id")
                            ->relationship("category", "name")
                            ->preload()
                            ->searchable()
                            ->rules(["required"])
                            ->validationMessages([
                                'required' => 'Category wajib dipilih ya.',
                            ]),
                        ColorPicker::make("color"),
                    ])->columns(2),

                    MarkdownEditor::make("content"),
                ]),

            // Sidebar / Second Column Group
            Group::make([
                // Section 2: Image Upload
                Section::make("Image Upload")
                    ->schema([
                        FileUpload::make("image")
                            ->required()
                            ->disk("public")
                            ->directory("posts")
                            ->validationMessages([
                                'required' => 'Image wajib diupload ya.',
                            ]),
                    ]),

                // Section 3: Meta Information
                Section::make("Meta Information")
                    ->schema([
                        TagsInput::make("tags"),
                        Checkbox::make("published"),
                    ])->columns(2),

                DateTimePicker::make("published_at"),
            ]),
        ])->columns(2);
}
}