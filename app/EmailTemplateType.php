<?php

namespace App;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum EmailTemplateType: int implements HasLabel
{
    case TICKET_REPLY = 1;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TICKET_REPLY => __('Ticket reply'),
        };
    }
}
