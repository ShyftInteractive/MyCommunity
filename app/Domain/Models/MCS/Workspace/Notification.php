<?php

declare(strict_types=1);

namespace App\Domain\Models\MCS\Workspace;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Models\Rebase\Workspace\Workspace;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Notification extends Model
{
    // Connection...
    protected $connection = 'workspace';

    // Fillable Attributes...
    protected $fillable = [
        'id',                   // required
        'workspace_id',         // required
        'type',                 // required
        'message',              // required
        'details',
        'visibility',           // required
        'active',               // false
        'banner_display_at',
        'banner_hide_at',
        'created_at',
        'updated_at',
    ];

    // Casts...
    protected $casts = [
        'workspace_id' => 'string',
        'active' => 'boolean',
        'banner_display_at' => 'datetime',
        'banner_hide_at' => 'datetime',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships....
    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }


    public function scopeByWorkspace($query, $workspaceID)
    {
        return $query->where('workspace_id', $workspaceID);
    }

    public function scopeSearchable($query, $terms = null, $fields = [])
    {
        if ($terms || count($fields)) {
            return $query->where(function ($q) use ($terms, $fields): void {
                $count = 0;
                $q->where($fields[$count], 'LIKE', '%' . $terms . '%');
                while (++$count < count($fields)) {
                    $q->orWhere($fields[$count], 'LIKE', '%' . $terms . '%');
                }
            });
        }
    }
}
