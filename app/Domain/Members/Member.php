<?php declare(strict_types=1);

namespace App\Domain\Members;

use App\Domain\Roles\Role;
use App\Traits\ModelScopes;
use Illuminate\Support\Str;
use App\Domain\Workspaces\Workspace;
use Illuminate\Notifications\Notifiable;
use App\Domain\Members\MemberTransformers;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Authenticatable
{
    use Notifiable;
    use ModelScopes;
    use MemberTransformers;

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
        'created_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
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
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class);
    }

}
