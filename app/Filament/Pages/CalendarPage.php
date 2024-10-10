<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CalendarWidget;
use Filament\Pages\Page;

class CalendarPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.pages.calendar-page';

    protected static ?string $navigationGroup = 'Utilities';

    protected static ?string $title = 'Calendar';

    protected function getHeaderWidgets(): array
    {
        return [CalendarWidget::class];
    }

}
