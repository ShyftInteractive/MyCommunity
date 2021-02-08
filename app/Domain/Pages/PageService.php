<?php

declare(strict_types=1);

namespace App\Domain\Pages;

use App\Services\BaseService;
use App\Services\Queries\PageQueries;
use App\Services\Factories\PageFactory;
use App\Domain\Models\MCS\Workspace\Page;
use App\Domain\Collections\MCS\PageCollection;

class PageService extends BaseService
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function query()
    {
        return new PageQueries($this->model);
    }

    public function factory()
    {
        return new PageFactory($this->model);
    }

    public function updatePage(string $pageID, array $updates)
    {
        if (array_key_exists('is_homepage', $updates)) {
            return $this->toggleHomepage();
        }

        return $this->factory()->updateByID(
            id: $pageID,
            updates: $updates
        );
    }

    public function getPublishedPages(string $workspaceID)
    {
        return $this->model
            ->byWorkspace($workspaceID)
            ->where('published', true)
            ->get();
    }

    public function getActiveContent(string $slug, PageCollection $pages)
    {
        if ($slug === '') {
            return $pages->where('is_homepage', true)->first()->content;
        }

        return $pages->where('slug', $slug)->first()->content;
    }
}
