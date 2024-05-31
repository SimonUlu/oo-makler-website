<?php

namespace App\Enums;

enum NumberWord: string
{
    case One = 'einem';
    case Two = 'zwei';
    case Three = 'drei';
    case Four = 'vier';
    case Five = 'fünf';
    case Six = 'sechs';
    case Seven = 'sieben';
    case Eight = 'acht';
    case Nine = 'neun';
    case Ten = 'zehn';
    case Eleven = 'elf';
    case Twelve = 'zwölf';
    case Thirteen = 'dreizehn';
    case Fourteen = 'vierzehn';
    case Fifteen = 'fünfzehn';
    case Sixteen = 'sechzehn';

    public static function fromNumber(int $number): string
    {
        return match ($number) {
            1 => self::One->value,
            2 => self::Two->value,
            3 => self::Three->value,
            4 => self::Four->value,
            5 => self::Five->value,
            6 => self::Six->value,
            7 => self::Seven->value,
            8 => self::Eight->value,
            9 => self::Nine->value,
            10 => self::Ten->value,
            11 => self::Eleven->value,
            12 => self::Twelve->value,
            13 => self::Thirteen->value,
            14 => self::Fourteen->value,
            15 => self::Fifteen->value,
            16 => self::Sixteen->value,
            default => (string) $number,
        };
    }
}
