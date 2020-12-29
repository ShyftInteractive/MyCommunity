<?php declare(strict_types=1);

namespace App\Domain\Models\MCS\Workspace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Builders\MCS\TemplateBuilder;
use App\Domain\Factories\Rebase\ModelFactory;
use App\Domain\Models\Rebase\Workspace\Workspace;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Template extends Model
{
    // Traits...

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

    public function newEloquentBuilder($query): TemplateBuilder
    {
        return new TemplateBuilder($query);
    }

    // Factory...
    public function scopeModelFactory(Builder $builder): ModelFactory
    {
        return new ModelFactory($builder);
    }

}

