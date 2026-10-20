<?php

namespace App\Enums;

enum ArchiveStatus: string
{
    case CURRENT = 'current';
    case INTERMEDIATE = 'intermediate';
    case DELETED = 'deleted';
    case PERMANENT = 'permanent';
    case HISTORICAL = 'historical';

    /**
     * The label shown is in French.
     */
    public function label(): string
    {
        return match ($this) {
            self::CURRENT => 'Courant',
            self::INTERMEDIATE => 'Intermédiaire',
            self::DELETED => 'Détruit',
            self::PERMANENT => 'Permanent',
            self::HISTORICAL => 'Historique',
        };
    }

    /**
     * Bootstrap colors for displaying the badge.
     */
    public function badgeColor(): string
    {
        return match ($this) {
            self::CURRENT => 'primary',
            self::INTERMEDIATE => 'warning',
            self::DELETED => 'danger',
            self::PERMANENT => 'success',
            self::HISTORICAL => 'secondary',
        };
    }

    /**
     *List of values ​​as an array (for validation).
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
