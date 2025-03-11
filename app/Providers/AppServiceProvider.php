<?php

namespace App\Providers;

use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Actions\CreateAction as TableCreateAction;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        URL::forceScheme('https');

        FilamentView::registerRenderHook(
            PanelsRenderHook::CONTENT_START,
            fn(): View => view('announcements'),
        );

        \BezhanSalleh\PanelSwitch\PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch->panels([
                'project',
                'app',
            ]);
        });

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
