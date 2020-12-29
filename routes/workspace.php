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
        Route::get('/pages',                MCS\Workspace\Pages\PageIndex::class)->name('page.index');
        Route::get('/pages/create',         MCS\Workspace\Pages\PageCreate::class)->name('page.create');
        Route::post('/pages',               MCS\Workspace\Pages\PageStore::class)->name('page.store');
        Route::get('/pages/{pageID}/edit',  MCS\Workspace\Pages\PageEdit::class)->name('page.edit');
        Route::put('/pages/{pageID}',       MCS\Workspace\Pages\PageUpdate::class)->name('page.update');
        Route::delete('/pages/{pageID}',    MCS\Workspace\Pages\PageDelete::class)->name('page.delete');

        // Component...
        Route::get('/pages/{pageID}/components/{id}', MCS\Workspace\Components\ComponentShow::class)->name('component.show');

        // Posts...
        Route::get('/posts', MCS\Workspace\Posts\PostIndex::class)->name('post.index');

        // Settings...
        Route::get('/settings', MCS\Workspace\Settings\SettingIndex::class)->name('setting.index');

        Route::get('/settings/design', MCS\Workspace\Design\DesignIndex::class)->name('design.index');

        // Settings/Templates...
        Route::get('/settings/design/templates',                    MCS\Workspace\SiteTemplates\SiteTemplateIndex::class)->name('site-template.index');
        Route::get('/settings/design/templates/create',             MCS\Workspace\SiteTemplates\SiteTemplateCreate::class)->name('site-template.create');
        Route::post('/settings/design/templates',                   MCS\Workspace\SiteTemplates\SiteTemplateStore::class)->name('site-template.store');
        Route::get('/settings/design/templates/{templateID}/edit',  MCS\Workspace\SiteTemplates\SiteTemplateEdit::class)->name('site-template.edit');
        Route::put('/settings/design/templates/{templateID}',       MCS\Workspace\SiteTemplates\SiteTemplateUpdate::class)->name('site-template.update');
        Route::delete('/settings/design/templates/{templateID}',    MCS\Workspace\SiteTemplates\SiteTemplateDelete::class)->name('site-template.delete');

        // Settings/Themes...
        Route::get('/settings/design/themes', MCS\Workspace\SiteThemes\SiteThemeIndex::class)->name('site-theme.index');
    });

    // This *MUST* be last as it's a catch-all route
    Route::get('/{page}', MCS\Workspace\Front\Index::class)
        ->where('page', '.*')
        ->name('front.index');
});
