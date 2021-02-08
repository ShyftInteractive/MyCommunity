<?php declare(strict_types=1);

namespace App\Domain\Tags;

use App\Domain\Base\BaseService;
use App\Domain\Tags\TagRepository;

class TagService extends BaseService {

    public function __construct(Tag $model) {

        parent::__construct(
            repository: new TagRepository($model)
        );
    }

}
