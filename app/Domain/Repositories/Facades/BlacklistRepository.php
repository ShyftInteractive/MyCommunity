<?php
namespace App\Domain\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class BlacklistRepository extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'BlacklistRepository'; }
}