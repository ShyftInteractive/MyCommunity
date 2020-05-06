<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;

class Account extends Model
{
    use Billable;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $connection = 'shared';

    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'uuid',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
