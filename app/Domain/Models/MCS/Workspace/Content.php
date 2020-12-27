<?php declare(strict_types=1);

namespace App\Domain\Models\MCS\Workspace;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Models\MCS\Workspace\Page;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Factories\Rebase\ModelFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Content extends Model
{
    // Traits...

    // Connection...
    protected $connection = 'workspace';

    // Fillable Attributes...
    protected $fillable = [
        'id',                   // required
        'page_id',              // required
        'template_name',        // required
        'content',
        'created_at',
        'updated_at',
    ];

    // Casts...
    protected $casts = [
        'page_id' => 'string',
        'template_name' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Global Eager Loads...


    // Relationships....
    public function page(): HasOne
    {
        return $this->hasOne(Page::class);
    }

    // Collection Override....

    // Factory...
    public function scopeModelFactory(Builder $builder): ModelFactory
    {
        return new ModelFactory($builder);
    }

}

