<?php declare(strict_types=1);

namespace App\Domain\Members;

use App\Domain\Roles\Role;
use App\Domain\Roles\RoleCollection;
use App\Traits\ModelScopes;
use Illuminate\Support\Str;
use App\Domain\Workspaces\Workspace;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Authenticatable
{
    use Notifiable;
    use ModelScopes;

    public $incrementing = false;

    protected $connection = 'workspace';

    protected $fillable = [
        'id',                   // required
        'email',                // required
        'password',
        'name',                 // required
        'avatar',
        'profile',
        'remember_token',
        'email_token',
        'email_verified_at',
        'activated',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'id' => 'string',
        'email_token' => 'string',
        'profile' => 'array',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($member): void {
            $member->id = (string)Str::uuid();
            $member->email_token = (string)Str::uuid();
        });

        static::updating(function ($member): void {
            if ($member->isDirty('avatar')) {
                Storage::disk('spaces')->delete($member->avatar);
            }
        });
    }

    /**
     * @return HasMany
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    /**
     * @return BelongsToMany
     */
    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class);
    }

    /**
     * @return RoleCollection
     */
    public function workspaceRoles(): RoleCollection {
        return $this->roles->flatMap(function($item) {
            return [$item->workspace_id => $item];
        });
    }

    /**
     * @param string|null $workspaceID
     * @return Role
     */
    public function role(?string $workspaceID): Role
    {
        return $this->roles->filter(function($role) use ($workspaceID) {
            return $role->workspace_id == $workspaceID || $role->workspace_id == null;
        })->first();
    }
}
