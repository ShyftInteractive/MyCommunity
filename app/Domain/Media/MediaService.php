<?php declare(strict_types=1);

namespace App\Domain\Media;

use App\Domain\Tags\Tag;
use App\Domain\Media\Media;
use App\Enums\MCS\MediaTypes;
use App\Domain\Base\BaseService;
use App\Enums\Rebase\MemberRoles;
use App\Http\Requests\MediaRequest;
use App\Domain\Media\MediaRepository;
use Illuminate\Support\Facades\Storage;

class MediaService extends BaseService
{

    public function __construct(Media $model)
    {
        parent::__construct(
            repository: new MediaRepository($model),
        );
    }

    public function resource(array $items, string $relativePath, string $workspaceID)
    {
        $name = $items['name'];
        $fullPath = "{$relativePath}/{$name}";

        return [
            'name' => $name,
            'type' => $this->getMediaType($items['extension']),
            'path' => $fullPath,
            'url' => Storage::disk('spaces')->url($fullPath),
            'visiblity' => MemberRoles::MEMBER(),
            'workspace_id' => $workspaceID,
        ];
    }

    public function updateMediaTags(string $workspaceID, string $mediaID, array $media)
    {
        return $this->repository->workspaceMediaAndTagUpdate(
            workspaceID: $workspaceID,
            mediaID: $mediaID,
            tags: $media['tags'],
        );
    }

    public function createTagForMedia(string $workspaceID, string $mediaID, Tag $tag)
    {
        $media = $this->repository->getWithTags(
            workspaceID: $workspaceID,
            mediaID: $mediaID,
        );

        $this->repository->syncTags(
            model: $media,
            tags: array_merge($media->tags->toArray(), [$tag])
        );
    }

    public function allMediaForWorkspace(string $workspaceID)
    {
        return $this->repository->allAndTags(
            workspaceID: $workspaceID,
        );
    }

    public function findMediaAndTags(string $workspaceID, ?string $search, ?int $count)
    {
        return $this->repository
                    ->searchable(
                        workspaceID: $workspaceID,
                        terms: $search,
                        fields: ['name'],
                        count: $count
                    );
    }

    public function uploadAndSaveFile(string $customerID, string $workspaceID, MediaRequest $request)
    {

        $relativePath = "{$customerID}/{$workspaceID}";
        Storage::disk('spaces')->putFileAs($relativePath, $request->file, $request->name, 'public');

        return $this->repository->create(item: $this->resource(
            items: $request->input(),
            relativePath:$relativePath,
            workspaceID: $workspaceID,
        ));
    }

    public function getMediaType(string $extension)
    {
        return  match ($extension) {
            'pdf' => MediaTypes::DOCUMENT()->getValue(),
            'doc' => MediaTypes::DOCUMENT()->getValue(),
            'docx' => MediaTypes::DOCUMENT()->getValue(),
            'xls' => MediaTypes::DOCUMENT()->getValue(),
            'xlsx' => MediaTypes::DOCUMENT()->getValue(),
            'xlx' => MediaTypes::DOCUMENT()->getValue(),
            'txt' => MediaTypes::DOCUMENT()->getValue(),
            'pages' => MediaTypes::DOCUMENT()->getValue(),
            'numbers' => MediaTypes::DOCUMENT()->getValue(),
            'cvs' => MediaTypes::DOCUMENT()->getValue(),
            'png' => MediaTypes::IMAGE()->getValue(),
            'jpg' => MediaTypes::IMAGE()->getValue(),
            'svg' => MediaTypes::IMAGE()->getValue(),
            'jpeg' => MediaTypes::IMAGE()->getValue(),
            'gif' => MediaTypes::IMAGE()->getValue(),
            'webp' => MediaTypes::IMAGE()->getValue(),
            'mp3' => MediaTypes::AUDIO()->getValue(),
            'mp4' => MediaTypes::VIDEO()->getValue(),
            'mov' => MediaTypes::VIDEO()->getValue(),
            default => MediaTypes::OTHER()->getValue(),
        };
    }
}
