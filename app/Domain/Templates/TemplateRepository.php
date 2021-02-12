<?php declare(strict_types=1);

namespace App\Domain\Templates;

use App\Domain\Templates\Template;
use App\Domain\Base\BaseRepository;

class TemplateRepository extends BaseRepository
{

    public function __construct(Template $model)
    {
        parent::__construct($model);
    }
}
