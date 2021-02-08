<?php declare(strict_types=1);

namespace App\Domain\Events;

use App\Traits\ModelScopes;
use Illuminate\Support\Str;
use App\Domain\Workspaces\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
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
        'title',                // required
        'feature_image',
        'description',
        'start_at',             // required
        'end_at',
        'visibility',           // required
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
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'published' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($event): void {
            $event->id = (string)Str::uuid();
        });
    }

    // Relationships....
    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }
}
