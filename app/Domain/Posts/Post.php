<?php

declare(strict_types=1);

namespace App\Domain\Posts;

use App\Traits\ModelScopes;
use Illuminate\Support\Str;
use App\Domain\Members\Member;
use App\Domain\Workspaces\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    // Traits...
    use ModelScopes;

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
        'published',            // false
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
        'published' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($post): void {
            $post->id = (string)Str::uuid();
        });
    }

    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

}
