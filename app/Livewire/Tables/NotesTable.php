<?php

namespace App\Livewire\Tables;

use App\Models\Note;
use App\Models\Task;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class NotesTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public ?string $relatedType = null;

    public ?int $relatedId = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(when($this->relatedType != null, function () {
                return Note::whereHasMorph('related', $this->relatedType, function (Builder $query) {
                    return $query->whereKey($this->relatedId);
                });
            }))
            ->query(Note::query())
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->label(__('Title')),

                TextColumn::make('note')
                    ->searchable()
                    ->html()
                    ->label(__('Note')),

                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->model(Note::class)
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.tables.notes-table');
    }
}
