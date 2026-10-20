<?php

namespace App\Enums;

enum DocumentType: string
{
    case CORRESPONDENCE = 'correspondence';
    case DECISION = 'decision';
    case REPORT = 'report';
    case MINUTES = 'minutes';
    case CONTRACT = 'contract';
    case INVOICE = 'invoice';
    case INSTRUCTION = 'instruction';

    public function label(): string
    {
        return match ($this) {
            self::CORRESPONDENCE => 'Correspondance',
            self::DECISION => 'Décision',
            self::REPORT => 'Rapport',
            self::MINUTES => 'Procès-verbal',
            self::CONTRACT => 'Contrat',
            self::INVOICE => 'Facture',
            self::INSTRUCTION => 'Instruction',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
