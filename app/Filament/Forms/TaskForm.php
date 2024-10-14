<?php

namespace App\Filament\Forms;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentHelpers\Contracts\FormBuilder;

class TaskForm extends FormBuilder
{
    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                DatePicker::make('deadline_at')
                    ->label(__('Deadline at')),

                SpatieTagsInput::make('tags')
                    ->label(__('Tags'))
                    ->color(Color::Gray),

                Select::make('related_type')
                    ->label(__('Related type'))
                    ->live()
                    ->native(false),

                Select::make('related_id')
                    ->label(__('Related'))
                    ->required(function (Get $get) {
                        return $get('related_type') != null;
                    })
                    ->native(false),

                Select::make('members')
                    ->label(__('Members'))
                    ->relationship(name: 'users', modifyQueryUsing: function (Builder $query) {
                        return $query->orderBy('first_name');
                    })
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->options(User::get()->pluck('first_name', 'id'))
                    ->multiple(),

                ToggleButtons::make('priority_id')
                    ->label(__('Priority'))
                    ->grouped()
                    ->default(2)
                    ->options([
                        1 => __('Low'),
                        2 => __('Medium'),
                        3 => __('High'),
                    ])
                    ->inline(),

                RichEditor::make('description')
                    ->label(__('Description'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('attachments')
                    ->collection('task')
                    ->multiple()
                    ->label(__('Attachments'))
                    ->columnSpanFull()
            ]);
    }
}
