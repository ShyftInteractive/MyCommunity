<?php declare(strict_types=1);

namespace App\Domain\Templates;

use App\Domain\Base\BaseFactory;
use App\Domain\Base\BaseService;
use App\Domain\Templates\Template;
use App\Domain\Templates\TemplateRepository;

class TemplateService extends BaseService
{
    public function __construct(Template $model)
    {
        parent::__construct(
            repository:  new TemplateRepository($model),
            factory:  new BaseFactory($model)
        );
    }

    public function createTemplate(array $inputs, string $workspaceID)
    {
        return $this->factory->create([
            'workspace_id' => $workspaceID,
            'content' => [],
            'name' => $inputs['name'],
        ]);
    }

    public function updateTemplate(array $updates, string $id)
    {
        return $this->factory->updateWhere(
            col: 'id',
            value: $id,
            updates: $updates,
        );
    }

    public function findTemplates(string $workspaceID, ?string $search, ?int $count)
    {
        return $this->repository
            ->searchInWorkspace(
                workspaceID: $workspaceID,
                terms: $search,
                fields: ['name'],
                orderBy: 'created_at',
                count: $count
            );
    }

}
