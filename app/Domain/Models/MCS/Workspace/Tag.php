<?php

declare(strict_types=1);

namespace App\Domain\Models\MCS\Workspace;

use Laravel\Horizon\Tags;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Models\MCS\Workspace\Media;
use App\Domain\Builders\Rebase\ModelBuilder;
use App\Domain\Factories\Rebase\ModelFactory;
use App\Domain\Models\Rebase\Workspace\Workspace;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $connection = 'workspace';

    public $incrementing = false;

    protected $fillable = [
        'id',                   // required
        'workspace_id',         // required
        'name',                 // required
        'created_at',
        'updated_at',
    ];

    // Casts...
    protected $casts = [
        'id' => 'string',
        'workspace_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($tag): void {
            $tag->id = (string)Str::uuid();
        });

        // static::deleting(function (Media $media) {
        //     Storage::disk('spaces')->delete($media->path);
        // });
    }

    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }
}
