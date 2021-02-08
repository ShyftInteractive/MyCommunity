<?php declare(strict_types=1);

namespace App\Domain\BannedSubdomains;

use Illuminate\Database\Eloquent\Model;

class BannedSubdomain extends Model
{

    protected $connection = 'shared';

    protected $fillable = [
        'id',               // required
        'sub',              // required
        'reason',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
