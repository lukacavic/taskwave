<?php

namespace App\Filament\Resources\ContractResource\Widgets;

use Filament\Widgets\ChartWidget;

class ContractsByType extends ChartWidget
{
    protected static ?string $heading = 'Contracts By Type';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Contracts by type',
                    'data' => [10, 5, 2, 11],
                ],
            ],
            'labels' => ['Express Contracts', 'Adhesion Contracts', 'Implied Contracts', 'Contracts under seal'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
