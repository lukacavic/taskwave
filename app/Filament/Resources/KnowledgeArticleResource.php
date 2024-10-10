<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeArticleResource\Pages;
use App\Filament\Resources\KnowledgeArticleResource\RelationManagers;
use App\Models\KnowledgeArticle;
use App\Models\KnowledgeCategory;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class KnowledgeArticleResource extends Resource
{
    protected static ?string $model = KnowledgeArticle::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function getNavigationLabel(): string
    {
        return __('Knowledge Base');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label(__('Title')),

                Select::make('category_id')
                    ->required()
                    ->native(false)
                    ->options(KnowledgeCategory::get()->pluck('title', 'id'))
                    ->relationship('category', 'title')
                    ->label(__('Category')),

                Forms\Components\RichEditor::make('content')
                    ->label(__('Content'))
                    ->columnSpanFull()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('attachments')
                    ->collection('knowledge-article')
                    ->multiple()
                    ->downloadable()
                    ->label(__('Attachments'))
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('category.color')
                    ->label(''),

                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->description(function (KnowledgeArticle $record) {
                        return $record->category->title;
                    }),

                Tables\Columns\TextColumn::make('user.full_name')
                    ->label(__('Created by'))
                    ->description(function (KnowledgeArticle $record) {
                        return $record->created_at->diffForHumans();
                    }),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->date()
                    ->description(function (KnowledgeArticle $record) {
                        return $record->updated_at->diffForHumans();
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKnowledgeArticles::route('/'),
            //'create' => Pages\CreateKnowledgeArticle::route('/create'),
            //'edit' => Pages\EditKnowledgeArticle::route('/{record}/edit'),
        ];
    }
}
