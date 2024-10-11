<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum TicketStatus: int implements HasLabel
{
    case Open = 1;
    case InProgress = 2;
    case Answered = 3;
    case OnHold = 4;
    case Closed = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Open => __('Open'),
            self::InProgress => __('In Progress'),
            self::Answered => __('Answered'),
            self::OnHold => __('On Hold'),
            self::Closed => __('Closed'),
        };
    }
}
