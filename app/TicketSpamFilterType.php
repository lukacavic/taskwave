<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum TicketSpamFilterType: int implements HasLabel
{
    case SENDER = 1;
    case SUBJECT = 2;
    case PHRASE = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SENDER => __('Sender'),
            self::SUBJECT => __('Subject'),
            self::PHRASE => __('Phrase'),
        };
    }
}
