<?php

declare(strict_types=1);

namespace App\Domain\Notifications;

use App\Traits\ModelScopes;
use App\Domain\Workspaces\Workspace;
use App\Enums\MCS\NotificationTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Notification extends Model
{
    // Traits...
    use ModelScopes;

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

    public function scopeByBanner($query)
    {
        return $query->where('type', NotificationTypes::BANNER());
    }

    public function scopeByMessage($query)
    {
        return $query->where('type', NotificationTypes::MESSAGE());
    }
}
