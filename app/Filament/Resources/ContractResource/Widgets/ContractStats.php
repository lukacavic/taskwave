<?php

namespace App\Filament\Resources\ContractResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContractStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Active'), 100)
                ->description(__('All active contracts'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make(__('Expired'), 20)
                ->descriptionIcon('heroicon-m-calendar')
                ->description(__('Total expired contracts'))
                ->color('danger'),

            Stat::make(__('About to expire'), 1)
                ->description(__('Check contracts about to expire'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('warning'),

            Stat::make(__('Recently added'), 4)
                ->description(__('Last added contracts'))
                ->descriptionIcon('heroicon-m-user-minus')
                ->color('success'),

        ];
    }
}
