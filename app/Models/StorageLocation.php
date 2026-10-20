<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StorageLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'floor',
        'room',
        'cabinet',
        'shelf',
        'box',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function archives(): HasMany
    {
        return $this->hasMany(Archive::class);
    }

    // Brief description of the physical address
    public function fullLocationAttribute(): string
    {
        return collect([
            $this->floor,
            $this->room,
            $this->cabinet,
            $this->shelf,
            $this->box,
        ])->filter()->implode(' — ');
    }
}
