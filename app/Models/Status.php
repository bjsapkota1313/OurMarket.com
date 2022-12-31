<?php

enum Status : string
{
    case Available='Available';
    case Sold ='Sold';
    case Expired='Expired';

    public function label(): string {
        return static::getLabel($this);
    }
    public static function getLabel(self $value): string {
        return match ($value) {
            Status::Available => 'Available',
            Status::Sold => 'Sold',
            Status::Expired => 'Expired',
        };
    }
}
