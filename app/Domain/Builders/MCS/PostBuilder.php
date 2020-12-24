<?php declare(strict_types=1);

namespace App\Domain\Builders\MCS;

use App\Enums\Rebase\MemberRoles;
use App\Domain\Builders\Rebase\ModelBuilder;

class PostBuilder extends ModelBuilder
{
    public function notPublished() {
        return $this->where('published_at', null);
    }

    public function published() {
        return $this->where('published_at', '<>', null);
    }
}
