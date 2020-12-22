<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['workspace.status'])->group(callback: function (): void {
    // Login redirects to global signin page...see rebase_auth for routes...
    Route::get('login', fn (Request $request) => redirect()->route(route: 'signin', parameters: ['to' => $request->get(key: 'slug')]));

    Route::middleware(['auth'])->group(callback: function (): void {
        Route::get('/dashboard', Rebase\Workspace\Dashboard\Dashboard::class)->name('dashboard');

        Route::get('/onboarding/hold',      Rebase\Workspace\Onboarding\OnboardingHold::class)->name('onboarding.hold');
        Route::get('/onboarding/start',     Rebase\Workspace\Onboarding\OnboardingStart::class)->name('onboarding.start');
        Route::post('/onboarding/complete', Rebase\Workspace\Onboarding\OnboardingComplete::class)->name('onboarding.complete');

        Route::get('/members', Rebase\Workspace\Members\WorkspaceMemberIndex::class)->name('workspace-members.index');

        Route::get('/media', MCS\Workspace\Media\MediaIndex::class)->name('media.index');

        Route::get('/events', MCS\Workspace\Events\EventIndex::class)->name('event.index');

        Route::get('/notifications', MCS\Workspace\Notifications\NotificationIndex::class)->name('notification.index');

        Route::get('/pages', MCS\Workspace\Pages\PageIndex::class)->name('page.index');

        Route::get('/posts', MCS\Workspace\Posts\PostIndex::class)->name('post.index');

        Route::get('/settings', MCS\Workspace\Settings\SettingIndex::class)->name('setting.index');

        Route::get('/settings/design', MCS\Workspace\Design\DesignIndex::class)->name('design.index');

        Route::get('/settings/design/templates', MCS\Workspace\SiteTemplates\SiteTemplateIndex::class)->name('site-template.index');

        Route::get('/settings/design/themes', MCS\Workspace\SiteThemes\SiteThemeIndex::class)->name('site-theme.index');
    });
});
