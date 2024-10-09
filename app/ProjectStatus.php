<?php

namespace App;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProjectStatus: int implements HasLabel
{
    case NotStarted = 1;
    case InProgress = 1;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NotStarted => __('Not started'),
            self::InProgress => __('In progress'),
        };
    }

}
