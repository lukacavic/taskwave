<?php

namespace App\Filament\Forms;

use Filament\Forms\Form;
use Filament\Forms;
use TomatoPHP\FilamentHelpers\Contracts\FormBuilder;

class DocumentForm extends FormBuilder
{
    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\SpatieMediaLibraryFileUpload::make('attachments')
                    ->multiple()
                    ->required()
                    ->label(__('Attachments'))
                    ->downloadable()
            ]);
    }
}
