<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TasksStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Not Started'), 100)
                ->description(__('Tasks assigned to me: 34'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('gray'),

            Stat::make(__('In Progress'), 20)
                ->descriptionIcon('heroicon-m-calendar')
                ->description(__('Tasks assigned to me: 4'))
                ->color('success'),

            Stat::make(__('Testing'), 1)
                ->description(__('Tasks assigned to me: 1'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('danger'),

            Stat::make(__('Completed'), 4)
                ->description(__('Tasks assigned to me: 2'))
                ->descriptionIcon('heroicon-m-user-minus')
                ->color('success'),

        ];
    }
}
