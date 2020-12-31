<?php declare(strict_types=1);

namespace App\Domain\Builders\MCS;

use App\Enums\Rebase\MemberRoles;
use App\Domain\Builders\Rebase\ModelBuilder;

class TemplateBuilder extends ModelBuilder
{
    public function byName(string $name)
    {
        $this->where('name', $name);

        return $this;
    }

    public function activated()
    {
        $this->where('active', true);

        return $this;
    }

    public function deactivated()
    {
        $this->where('active', false);

        return $this;
    }
}
