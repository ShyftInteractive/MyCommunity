<?php

namespace App\Enums\Rebase;

use MyCLabs\Enum\Enum;

/**
 * @method static MemberRoles SUPER()
 * @method static MemberRoles ACCOUNT_OWNER()
 * @method static MemberRoles ACCOUNT_ADMIN()
 * @method static MemberRoles WORKSPACE_OWNER()
 * @method static MemberRoles WORKSPACE_ADMIN()
 * @method static MemberRoles EDITOR()
 * @method static MemberRoles ELEVATED()
 * @method static MemberRoles MEMBER()
 * @method static MemberRoles LIMITED()
 * @method static MemberRoles PUBLIC_ACCESS()
 *
 * @psalm-immutable
 */
class MemberRoles extends Enum
{
    private const SUPER = 'super';
    private const ACCOUNT_OWNER = 'Account Owner';
    private const ACCOUNT_ADMIN = 'Account Admin';
    private const WORKSPACE_OWNER = 'Website Owner';
    private const WORKSPACE_ADMIN = 'Website Admin';
    private const EDITOR = 'Editor';
    private const ELEVATED = 'Elevated Member';
    private const MEMBER = 'Member';
    private const LIMITED = 'Limited Access Member';
    private const PUBLIC_ACCESS = 'Public';
}
