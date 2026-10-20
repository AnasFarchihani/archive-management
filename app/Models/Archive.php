<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ArchiveStatus;
use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Archive extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_number',
        'title',
        'subject',
        'sender',
        'submission_date',
        'expiry_date',
        'archive_status',
        'document_type',
        'notes',
        'department_id',
        'storage_location_id',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'submission_date' => 'date',
            'expiry_date' => 'date',
            'archive_status' => ArchiveStatus::class,
            'document_type' => DocumentType::class,
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function storageLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ArchiveFile::class);
    }
}
