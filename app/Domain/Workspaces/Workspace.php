<?php declare(strict_types=1);

namespace App\Domain\Workspaces;

use Illuminate\Support\Str;
use App\Domain\Lookup\Lookup;
use App\Domain\Members\Member;
use Illuminate\Support\Carbon;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Workspaces\WorkspaceTransformers;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Workspace extends Model
{
    use WorkspaceTransformers;
    use ModelScopes;

    public $incrementing = false;

    protected $connection = 'workspace';

    protected $fillable = [
        'id',               // required
        'customer_id',      // required
        'name',             // required
        'sub',             // required
        'domain',
        'status',           // required
        'activation_token',
        'activation_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'activation_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($workspace): void {
            $workspace->id = (string)Str::uuid();
            $workspace->activation_token = (string)Str::uuid();
            $workspace->activation_at = Carbon::now();
        });

        static::created(function ($workspace): void {
            Lookup::create([
                'workspace_id' => $workspace->id,
                'customer_id' => $workspace->customer_id,
                'sub' => $workspace->sub,
                'domain' => $workspace->domain,
            ]);
        });

        static::updated(function ($workspace): void {
            if ($workspace->isDirty('domain', 'sub')) {
                Lookup::modelFactory()->update(
                    whereCol:'workspace_id',
                    whereValue: $workspace->id,
                    update: [
                        'sub' => $workspace->sub,
                        'domain' => $workspace->domain,
                    ]
                );
            }
        });

        static::deleted(function ($workspace): void {

            Lookup::modelFactory()->remove(ids: [$workspace->id]);
        });
    }

    // Relations...
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }

    public function scopeBySub($builder, string $sub)
    {
        return $builder->where('sub', $sub);
    }

}
