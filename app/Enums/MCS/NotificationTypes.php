<?php

declare(strict_types=1);

namespace App\Enums\MCS;

use MyCLabs\Enum\Enum;

/**
 * @method static MediaTypes BANNER()
 * @method static MediaTypes MESSAGE()
 */
class NotificationTypes extends Enum
{
    private const BANNER = 'site_banner';
    private const MESSAGE = 'message';
}
