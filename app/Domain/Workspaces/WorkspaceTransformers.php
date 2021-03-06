<?php
namespace App\Domain\Workspaces;

use App\Enums\Rebase\WorkspaceStatus;

trait WorkspaceTransformers {

        public function isActive(): bool
        {
            return $this->status === WorkspaceStatus::ACTIVE();
        }

        public function isPending(): bool
        {
            return $this->status === WorkspaceStatus::PENDING();
        }

        public function isArchived(): bool
        {
            return $this->status === WorkspaceStatus::ARCHIVED();
        }
}
