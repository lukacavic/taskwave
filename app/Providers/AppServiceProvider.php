<?php

namespace App\Providers;

use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\CreateAction as TableCreateAction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->customizeFilamentActions();
    }

    private function customizeFilamentActions(): void
    {
        Select::configureUsing(function (Select $select) {
            $select->native(false);
        });

        CreateAction::configureUsing(function(CreateAction $action) {
            $action->icon('heroicon-o-plus');
        });

        TableCreateAction::configureUsing(function (TableCreateAction $action) {
            $action->icon('heroicon-o-plus');
        });
    }
}
