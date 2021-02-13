<?php

namespace App\Providers;

use App\Domain\Roles\Role;
use App\Domain\Members\Member;
use App\Domain\Roles\RoleService;
use App\Domain\Customers\Customer;
use App\Domain\Workspaces\Workspace;
use App\Domain\Members\MemberService;
use Illuminate\Support\ServiceProvider;
use App\Domain\Customers\CustomerService;
use App\Domain\Workspaces\WorkspaceService;
use App\Domain\BannedSubdomains\BannedSubdomain;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Domain\BannedSubdomains\BannedSubdomainService;

class DomainServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BannedSubdomainService::class, function($app) {
            return new BannedSubdomainService(new BannedSubdomain());
        });

        $this->app->singleton(CustomerService::class, function($app) {
            return new CustomerService(new Customer());
        });

        $this->app->singleton(WorkspaceService::class, function($app) {
            return new WorkspaceService(new Workspace());
        });

        $this->app->singleton(MemberService::class, function($app) {
            return new MemberService(new Member());
        });

        $this->app->singleton(RoleService::class, function($app) {
            return new RoleService(new Role());
        });

    }

    public function provides()
    {
        return [
            BannedSubdomainService::class,
            CustomerService::class,
            WorkspaceService::class,
            MemberService::class,
            RoleService::class,
        ];
    }
}
