<?php declare(strict_types=1);

namespace App\Domain\Pages;

use App\Traits\ModelScopes;
use Illuminate\Support\Str;
use App\Domain\Workspaces\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
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
        'slug',                 // required
        'path',
        'title',                // required
        'description',
        'content',
        'visibility',           // required
        'published',            // false
        'is_homepage',          // false
        'published_at',
        'created_at',
        'updated_at',
    ];

    // Casts...
    protected $casts = [
        'id' => 'string',
        'member_id' => 'string',
        'workspace_id' => 'string',
        'content' => 'array',
        'published' => 'boolean',
        'is_homepage' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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

}
