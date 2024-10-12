<?php

namespace App\Providers\Filament;

use App\Filament\Contact\Resources\AnnouncementResource;
use App\Models\Organisation;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ContactPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('contact')
            ->path('contact')
            ->login()
            ->tenantMenu(false)
            ->tenant(Organisation::class)
            ->passwordReset()
            ->databaseNotifications()
            ->topNavigation()
            ->font('Inter')
            ->colors([
                'primary' => '#014786',
            ])
            ->discoverResources(in: app_path('Filament/Contact/Resources'), for: 'App\\Filament\\Contact\\Resources')
            ->discoverPages(in: app_path('Filament/Contact/Pages'), for: 'App\\Filament\\Contact\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Contact/Widgets'), for: 'App\\Filament\\Contact\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label(__('Announcements'))
                    ->icon('heroicon-o-bell')
                    ->url(function () {
                        return AnnouncementResource::getUrl('index');
                    })
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authGuard('contact')
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
