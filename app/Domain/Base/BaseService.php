<?php declare(strict_types=1);

namespace App\Domain\Base;

class BaseService
{

    public function __construct(protected BaseRepository $repository) { }

    public function getItems()
    {
        return $this->repository->all();
    }

    public function getItem(string $id)
    {
        return $this->repository->getByID(id: $id);
    }

    public function getWorkspaceItem(string $id, string $workspaceID)
    {
        return $this->repository->getByIDScopedToWorkspace(
            workspaceID: $workspaceID,
            id: $id,
        );
    }

    public function updateItem(string $id, array $updates)
    {
        return $this->repository->updateWhere(
            col: 'id',
            value: $id,
            updates: $updates,
        );
    }

    public function removeItem(string $id)
    {
        return $this->repository->delete(col: 'id', value: $id);
    }

    public function removeWorkspaceItem(string $workspaceID, string $id)
    {
        return $this->repository->deleteScopedToWorkspace(
            col: 'id',
            value: $id,
            workspaceID: $workspaceID,
        );
    }

    public function removeItems(array $ids)
    {
        return $this->repository->deleteAll(col: 'id', values: $ids);
    }
}
