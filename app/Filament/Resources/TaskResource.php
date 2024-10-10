<?php

namespace App\Filament\Resources;

use App\Filament\Project\Resources\ProjectMilestoneResource;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Filament\Resources\TaskResource\Widgets\TasksStats;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Task;
use App\Models\User;
use App\TaskPriority;
use App\TaskStatus;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
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

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('title')
                    ->description(function (Task $record) {
                        return strip_tags(Str::limit($record->description, 40));
                    })
                    ->tooltip(function (Task $record) {
                        return strip_tags($record->description);
                    })
                    ->label(__('Title'))
                    ->searchable(),

                TextColumn::make('users.first_name')
                    ->label(__('Users')),

                SelectColumn::make('status_id')
                    ->label('Status')
                    ->selectablePlaceholder(false)
                    ->options(TaskStatus::class)
                    ->sortable(),

                SpatieTagsColumn::make('tags')
                    ->label(__('Tags')),

                TextColumn::make('deadline_at')
                    ->label(__('Deadline'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label(__('Created By'))
                    ->native(false)
                    ->multiple()
                    ->options(User::get()->pluck('full_name', 'id')),

                Filter::make('has_media')
                    ->label(__('Has attachment'))
                    ->baseQuery(function ($query) {
                        return $query->whereHas('media');
                    })
                    ->toggle()
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            TasksStats::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => TaskResource\Pages\ListTasks::route('/'),
            //'create' =>CreateTask::route('/create'),
            //'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }

}
