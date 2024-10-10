<?php

namespace App;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProjectStatus: int implements HasLabel
{
    case NotStarted = 1;
    case InProgress = 2;
    case OnHold = 3;
    case Cancelled = 4;
    case Completed = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NotStarted => __('Not started'),
            self::InProgress => __('In progress'),
            self::OnHold => __('On hold'),
            self::Cancelled => __('Cancelled'),
            self::Completed => __('Completed'),
        };
    }

}
