<?php declare(strict_types=1);

namespace App\Domain\Models\MCS\Workspace;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Builders\MCS\PageBuilder;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Models\MCS\Workspace\Content;
use App\Domain\Collections\MCS\PageCollection;
use App\Domain\Factories\MCS\PageModelFactory;
use App\Domain\Models\Rebase\Workspace\Workspace;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
{
    // Traits...

    // Connection...
    protected $connection = 'workspace';

    public $incrementing = false;

    // Fillable Attributes...
    protected $fillable = [
        'id',                   // required
        'workspace_id',         // required
        'slug',                 // required
        'path',
        'title',                // required
        'description',
        'visibility',           // required
        'published_at',
        'created_at',
        'updated_at',
    ];

    // Casts...
    protected $casts = [
        'id' => 'string',
        'member_id' => 'string',
        'workspace_id' => 'string',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Global Eager Loads...

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($page): void {
            $page->id = (string)Str::uuid();
        });
    }


    // Relationships....
    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }

    public function content(): HasOne
    {
        return $this->hasOne(Content::class);
    }

    // Collection Override....
    public function newCollection(array $models = []): PageCollection
    {
        return new PageCollection($models);
    }

    public function newEloquentBuilder($query): PageBuilder
    {
        return new PageBuilder($query);
    }

    // Factory...
    public function scopeModelFactory(Builder $builder): PageModelFactory
    {
        return new PageModelFactory($builder);
    }

}

