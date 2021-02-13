<?php

namespace App\Rules\Rebase;

use App\Domain\BannedSubdomains\BannedSubdomainService;
use Illuminate\Contracts\Validation\Rule;

class SubdomainIsNotBanned implements Rule
{
    /**
     * Create a new rule instance.
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $service = app()->make(BannedSubdomainService::class);
        return is_string($value) && ! $service->subdomainBanned($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'That :attribute is not allowed';
    }
}
