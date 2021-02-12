<?php

declare(strict_types=1);

namespace App\Domain\Tags;

use App\Domain\Media\Media;
use App\Traits\ModelScopes;
use Illuminate\Support\Str;
use App\Domain\Groups\Group;
use App\Domain\Workspaces\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{

    use ModelScopes;

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

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }
}
