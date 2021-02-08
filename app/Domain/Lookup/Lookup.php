<?php declare(strict_types=1);

namespace App\Domain\Lookup;

use Stripe\Customer;
use App\Domain\Workspaces\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lookup extends Model
{
    protected $table = 'lookup';
    /**
     * @var array
     */
    protected $fillable = [
        'id',               // required
        'customer_id',      // required
        'workspace_id',     // required
        'sub',             // required
        'domain',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function workspaces(): HasMany
    {
        return $this->hasMany(Workspace::class);
    }

    public function scopeBySub($builder,string $sub)
    {
        return $builder->where('sub', $sub);
    }

    public function scopeByDomain($builder, string $domain)
    {
        return $builder->where('domain',  $domain);
    }

    public function scopeByCustomerID($builder, string $id)
    {
        return $builder->where('customer_id', $id);
    }
}
