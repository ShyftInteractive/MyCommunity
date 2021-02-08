<?php declare(strict_types=1);

namespace App\Domain\BannedSubdomains;

use App\Domain\Base\BaseRepository;

class BannedSubdomainRepository extends BaseRepository
{

    public function __construct(BannedSubdomain $model)
    {
        parent::__construct(model: $model);
    }

    public function subdomainExists(string $sub)
    {
        return $this->model->where('sub', $sub)->exists();
    }
}
