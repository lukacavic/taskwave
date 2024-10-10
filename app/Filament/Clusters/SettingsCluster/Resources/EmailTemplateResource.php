<?php

namespace App\Filament\Clusters\SettingsCluster\Resources;

use App\EmailTemplateType;
use App\Filament\Clusters\SettingsCluster;
use App\Filament\Clusters\SettingsCluster\Resources\EmailTemplateResource\Pages\ManageEmailTemplates;
use App\Models\EmailTemplate;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('Name'))
                        ->required(),

                    Forms\Components\Select::make('type_id')
                        ->required()
                        ->native(false)
                        ->label(__('Type'))
                        ->options(EmailTemplateType::class)
                        ->native(false),
                ]),

                TextInput::make('subject')
                    ->label(__('Subject'))
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('content')
                    ->label(__('Content'))
                    ->required(),

                KeyValue::make('meta')
                    ->hintColor('warning')
                    ->hintIcon('heroicon-o-information-circle', __('Use merge fields defined bellow'))
                    ->keyLabel(__('Field'))
                    ->valueLabel(__('Description'))
                    ->label(__('Merge Fields'))
                    ->addable(false)
                    ->deletable(false)
                    ->reorderable(false),

                Forms\Components\SpatieMediaLibraryFileUpload::make('attachments')
                    ->label(__('Attachments'))
                    ->multiple()
                    ->collection('email-template-attachments')
                    ->downloadable()
                    ->columnSpanFull()
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->icon(function (EmailTemplate $record) {
                        return $record->media()->exists() ? 'heroicon-o-paper-clip' : null;
                    })
                    ->label(__('Name')),

                Tables\Columns\TextColumn::make('type_id')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(function (EmailTemplate $record) {
                        return EmailTemplateType::from($record->type_id)->getLabel();
                    })
                    ->label(__('Type')),

                Tables\Columns\TextColumn::make('user.full_name')
                    ->searchable()
                    ->sortable()
                    ->label(__('Created by')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->since()
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
            'index' => ManageEmailTemplates::route('/'),
            //'create' => Pages\CreateEmailTemplate::route('/create'),
            //'edit' => Pages\EditEmailTemplate::route('/{record}/edit'),
        ];
    }
}
