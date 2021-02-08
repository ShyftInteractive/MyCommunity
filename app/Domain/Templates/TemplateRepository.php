<?php

declare(strict_types=1);

namespace App\Domain\Templates;

use App\Domain\Models\MCS\Workspace\Template;

class TemplateRepository extends BaseRepository
{

    public function __construct(Template $model)
    {
        parent::__construct($model);
    }
}
