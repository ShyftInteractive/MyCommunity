<?php declare(strict_types=1);

namespace App\Enums\MCS;

use MyCLabs\Enum\Enum;

/**
 * @method static MediaTypes DOCUMENT()
 * @method static MediaTypes IMAGE()
 * @method static MediaTypes VIDEO()
 * @method static MediaTypes AUDIO()
 * * @method static MediaTypes OTHER()
 */
class MediaTypes extends Enum
{
    private const DOCUMENT = 'document';
    private const IMAGE = 'image';
    private const VIDEO = 'video';
    private const AUDIO = 'audio';
    private const OTHER = 'unknown';
}
