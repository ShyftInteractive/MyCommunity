<?php

declare(strict_types=1);

namespace App\Domain\Models\MCS\Workspace;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Domain\Models\MCS\Workspace\Tag;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Builders\Rebase\ModelBuilder;
use App\Domain\Factories\Rebase\ModelFactory;
use App\Domain\Models\Rebase\Workspace\Workspace;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Media extends Model
{
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

    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // public function newCollection(array $models = []): MediaCollection
    // {
    //     return new MediaCollection($models);
    // }

    public function newEloquentBuilder($query): ModelBuilder
    {
        return new ModelBuilder($query);
    }

    public function scopeModelFactory(Builder $builder): ModelFactory
    {
        return new ModelFactory($builder);
    }
}
