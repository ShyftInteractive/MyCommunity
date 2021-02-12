<?php

declare(strict_types=1);

namespace App\Domain\Groups;

use App\Domain\Tags\Tag;
use Laravel\Horizon\Tags;
use App\Domain\Media\Media;
use App\Traits\ModelScopes;
use Illuminate\Support\Str;
use App\Domain\Workspaces\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Builders\Rebase\ModelBuilder;
use App\Domain\Factories\Rebase\ModelFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    // Traits...
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

        static::creating(function ($group): void {
            $group->id = (string)Str::uuid();
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

}
