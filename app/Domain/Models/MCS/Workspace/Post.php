<?php declare(strict_types=1);

namespace App\Domain\Models\MCS\Workspace;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Builders\MCS\PageBuilder;
use App\Domain\Builders\MCS\PostBuilder;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Collections\MCS\PageCollection;
use App\Domain\Collections\MCS\PostCollection;
use App\Domain\Factories\MCS\PageModelFactory;
use App\Domain\Factories\MCS\PostModelFactory;
use App\Domain\Models\Rebase\Workspace\Member;
use App\Domain\Models\Rebase\Workspace\Workspace;

class Post extends Model
{
    // Traits...


    // Connection...
    protected $connection = 'workspace';

     public $incrementing = false;

    // Fillable Attributes...
    protected $fillable = [
        'id',                   // required
        'workspace_id',         // required
        'member_id',            // required
        'slug',                 // required
        'title',                // required
        'feature_image',
        'description',
        'content',
        'description',
        'visibility',           // required
        'featured_at',
        'published_at',
        'created_at',
        'updated_at',
    ];

    // Casts...
    protected $casts = [
        'id' => 'string',
        'member_id' => 'string',
        'workspace_id' => 'string',
        'featured_at' => 'datetime',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Global Eager Loads...

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($post): void {
            $post->id = (string)Str::uuid();
        });
    }



    // Relationships....
    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    // Collection Override....
    public function newCollection(array $models = []): PostCollection
    {
        return new PostCollection($models);
    }

    public function newEloquentBuilder($query): PostBuilder
    {
        return new PostBuilder($query);
    }

    // Factory...
    public function scopeModelFactory(Builder $builder): PostModelFactory
    {
        return new PostModelFactory($builder);
    }

}

