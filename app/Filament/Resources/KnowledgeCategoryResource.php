<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeCategoryResource\Pages;
use App\Models\KnowledgeCategory;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KnowledgeCategoryResource extends Resource
{
    protected static ?string $model = KnowledgeCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->columnSpanFull(),

                ColorPicker::make('color')
                    ->label(__('Color'))
                    ->columnSpanFull(),

                Textarea::make('short_description')
                    ->label(__('Short description'))
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')
                    ->label(''),

                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->description(function (KnowledgeCategory $record) {
                        return $record->short_description;
                    })
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
            'index' => Pages\ListKnowledgeCategories::route('/'),
            //'create' => Pages\CreateKnowledgeCategory::route('/create'),
            //'edit' => Pages\EditKnowledgeCategory::route('/{record}/edit'),
        ];
    }
}
