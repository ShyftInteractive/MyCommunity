<?php declare(strict_types=1);

namespace App\Domain\Builders\MCS;

use App\Enums\Rebase\MemberRoles;
use App\Domain\Builders\Rebase\ModelBuilder;

class TemplateBuilder extends ModelBuilder
{
    public function byName(string $name)
    {
        return $this->where('name', $name);
    }
}
