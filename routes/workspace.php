<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['workspace.status'])->group(callback: function (): void {
    // Login redirects to global signin page...see rebase_auth for routes...
    Route::get('login', fn (Request $request) => redirect()->route(route: 'signin', parameters: ['to' => $request->get(key: 'sub')]));

    Route::middleware(['auth'])->group(callback: function (): void {
        Route::get('/dashboard', Rebase\Workspace\Dashboard\Dashboard::class)->name('dashboard');

        // Onboarding...
        Route::get('/onboarding/hold',      Rebase\Workspace\Onboarding\OnboardingHold::class)->name('onboarding.hold');
        Route::get('/onboarding/start',     Rebase\Workspace\Onboarding\OnboardingStart::class)->name('onboarding.start');
        Route::post('/onboarding/complete', Rebase\Workspace\Onboarding\OnboardingComplete::class)->name('onboarding.complete');

        // Members....
        Route::get('/members', Rebase\Workspace\Members\WorkspaceMemberIndex::class)->name('workspace-members.index');

        // Media...
        Route::get('/media', MCS\Workspace\Media\MediaIndex::class)->name('media.index');
        Route::get('/media/checklists/{state}', MCS\Workspace\Checklists\ChecklistIndex::class)->name('checklist.index');

        // Events...
        Route::get('/events', MCS\Workspace\Events\EventIndex::class)->name('event.index');

        // Notices...
        Route::get('/notifications', MCS\Workspace\Notifications\NotificationIndex::class)->name('notification.index');

        // Pages...
        Route::get('/pages',        MCS\Workspace\Pages\PageIndex::class)->name('page.index');
        Route::get('/pages/create', MCS\Workspace\Pages\PageCreate::class)->name('page.create');
        Route::post('/pages',       MCS\Workspace\Pages\PageStore::class)->name('page.store');

        // Posts...
        Route::get('/posts', MCS\Workspace\Posts\PostIndex::class)->name('post.index');

        // Settings...
        Route::get('/settings', MCS\Workspace\Settings\SettingIndex::class)->name('setting.index');

        Route::get('/settings/design', MCS\Workspace\Design\DesignIndex::class)->name('design.index');

        Route::get('/settings/design/templates', MCS\Workspace\SiteTemplates\SiteTemplateIndex::class)->name('site-template.index');

        Route::get('/settings/design/themes', MCS\Workspace\SiteThemes\SiteThemeIndex::class)->name('site-theme.index');
    });
});
