<?php declare(strict_types=1);

namespace App\Domain\Pages;

use App\Domain\Base\BaseService;
use App\Domain\Pages\PageRepository;

class PageService extends BaseService {

    public function __construct(Page $model) {

        parent::__construct(
            repository: new PageRepository($model)
        );
    }

    public function findPages(string $workspaceID, ?string $search, ?int $count)
    {
        return $this->repository
            ->searchInWorkspace(
                workspaceID: $workspaceID,
                terms: $search,
                fields: ['slug', 'title'],
                orderBy: 'start_at',
                count: $count
            );
    }
}
