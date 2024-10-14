<?php

namespace App\Livewire\Tables;

use App\Filament\Forms\TaskForm;
use App\Filament\Resources\TaskResource;
use App\Models\Task;
use App\TaskStatus;
use Filament\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class TasksTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public ?string $relatedType = null;

    public ?int $relatedId = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(when($this->relatedType != null, function () {
                return Task::where('related_type', $this->relatedType)
                    ->where('related_id', $this->relatedId);
            }))
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->model(Task::class)
                    ->form(function ($form) {
                        return TaskForm::make($form);
                    }),

                Tables\Actions\EditAction::make()
                    ->model(Task::class)
                    ->form(function ($form) {
                        return TaskForm::make($form);
                    }),

                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.tables.tasks-table');
    }
}
