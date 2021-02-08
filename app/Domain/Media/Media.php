<?php

declare(strict_types=1);

namespace App\Domain\Media;

use App\Traits\ModelScopes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\DocBlock\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{

    // Traits...
    use ModelScopes;

    protected $table = 'media';

    protected $connection = 'workspace';

    public $incrementing = false;

    protected $fillable = [
        'id',                   // required
        'workspace_id',         // required
        'name',                 // required
        'path',                 // required
        'url',                  // required
        'type',                 // required
        'visibility',           // required
        'archive',              // false
        'created_at',
        'updated_at',
    ];

    // Casts...
    protected $casts = [
        'id' => 'string',
        'workspace_id' => 'string',
        'archive' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($media): void {
            $media->id = (string)Str::uuid();
        });

        static::deleting(function (Media $media) {
            Storage::disk('spaces')->delete($media->path);
        });
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
