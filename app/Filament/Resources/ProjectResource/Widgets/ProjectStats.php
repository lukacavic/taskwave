<?php

namespace App\Filament\Resources\ProjectResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Not Started'), 2)
                ->description(__('Waiting to start'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make(__('In Progress'), 1)
                ->descriptionIcon('heroicon-m-user-plus')
                ->description(__('Currently in progress'))
                ->color('success'),

            Stat::make(__('On Hold'), 1)
                ->description(__('Projects on hold'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('danger'),

            Stat::make(__('Completed'), 4)
                ->description(__('Total of all completed projects'))
                ->descriptionIcon('heroicon-m-user-minus')
                ->color('success'),

        ];
    }
}
