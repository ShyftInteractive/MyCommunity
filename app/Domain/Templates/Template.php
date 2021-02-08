<?php

declare(strict_types=1);

namespace App\Domain\Templates;

use App\Traits\ModelScopes;
use App\Domain\Workspaces\Workspace;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Builders\MCS\TemplateBuilder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Template extends Model
{
    // Traits...
    use ModelScopes;

    // Connection...
    protected $connection = 'workspace';

    // Fillable Attributes...
    protected $fillable = [
        'id',                   // required
        'workspace_id',         // required
        'name',                 // required
        'content',
        'title',                // required
        'active',
        'created_at',
        'updated_at',
    ];

    // Casts...
    protected $casts = [
        'workspace_id' => 'string',
        'content' => 'array',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships....
    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }

}
