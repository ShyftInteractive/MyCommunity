<?php

declare(strict_types=1);

namespace App\Domain\Models\MCS\Workspace;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Builders\Rebase\ModelBuilder;
use App\Domain\Factories\Rebase\ModelFactory;
use App\Domain\Models\Rebase\Workspace\Workspace;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
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

    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = Carbon::parse($value);
    }

    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = Carbon::parse($value);
    }

    // Relationships....
    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }

    // Collection Override....
    // public function newCollection(array $models = []): PageCollection
    // {
    //     return new PageCollection($models);
    // }

    public function newEloquentBuilder($query): ModelBuilder
    {
        return new ModelBuilder($query);
    }

    // Factory...
    public function scopeModelFactory(Builder $builder): ModelFactory
    {
        return new ModelFactory($builder);
    }
}
