<?php

namespace App\Filament\Resources\ClientResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClientStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Clients'), 100)
                ->description(__('Total of all clients'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make(__('Active Clients'), 20)
                ->descriptionIcon('heroicon-m-calendar')
                ->description(__('Total of all active clients'))
                ->color('success'),

            Stat::make(__('Inactive Clients'), 1)
                ->description(__('Total of all inactive clients'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('danger'),

            Stat::make(__('Active Contacts'), 4)
                ->description(__('Total of all active contacts'))
                ->descriptionIcon('heroicon-m-user-minus')
                ->color('success'),

        ];
    }
}
