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
        Route::post('/media/upload', MCS\Workspace\Media\MediaUpload::class)->name('media.upload');
        Route::delete('/media/{mediaID}',    MCS\Workspace\Media\MediaDelete::class)->name('media.delete');

        Route::get('/checklists', MCS\Workspace\Checklists\ChecklistIndex::class)->name('checklist.index');
        Route::get('/checklists/create', MCS\Workspace\Checklists\ChecklistCreate::class)->name('checklist.create');
        Route::post('/checklists', MCS\Workspace\Checklists\ChecklistStore::class)->name('checklist.store');
        Route::get('/checklists/{checklistID}', MCS\Workspace\Checklists\ChecklistEdit::class)->name('checklist.edit');
        Route::get('/checklists/{checklistID}', MCS\Workspace\Checklists\ChecklistUpdate::class)->name('checklist.update');
        Route::delete('/checklists/{checklistID}', MCS\Workspace\Checklists\ChecklistDelete::class)->name('checklist.delete');

        // Events...
        Route::get('/events',                        MCS\Workspace\Events\EventIndex::class)->name('event.index');
        Route::get('/events/create',                 MCS\Workspace\Events\EventCreate::class)->name('event.create');
        Route::post('/events',                       MCS\Workspace\Events\EventStore::class)->name('event.store');
        Route::get('/events/{eventID}/edit',         MCS\Workspace\Events\EventEdit::class)->name('event.edit');
        Route::get('/events/{eventID}',              MCS\Workspace\Events\EventShow::class)->name('event.show');
        Route::put('/events/{eventID}',              MCS\Workspace\Events\EventUpdate::class)->name('event.update');
        Route::delete('/events/{eventID}',           MCS\Workspace\Events\EventDelete::class)->name('event.delete');
        Route::post('/events/selected/{action}',     MCS\Workspace\Events\EventSelected::class)->name('event.selected');

        // Notices...
        Route::get('/notifications', MCS\Workspace\Notifications\NotificationIndex::class)->name('notification.index');

        // Pages...
        Route::get('/pages',                        MCS\Workspace\Pages\PageIndex::class)->name('page.index');
        Route::get('/pages/create',                 MCS\Workspace\Pages\PageCreate::class)->name('page.create');
        Route::post('/pages',                       MCS\Workspace\Pages\PageStore::class)->name('page.store');
        Route::get('/pages/{pageID}/edit',          MCS\Workspace\Pages\PageEdit::class)->name('page.edit');
        Route::put('/pages/{pageID}',               MCS\Workspace\Pages\PageUpdate::class)->name('page.update');
        Route::delete('/pages/{pageID}',            MCS\Workspace\Pages\PageDelete::class)->name('page.delete');
        Route::post('/pages/delete/selected',       MCS\Workspace\Pages\PageSelectedDelete::class)->name('page.delete.selected');

        // Posts...
        Route::get('/posts',                MCS\Workspace\Posts\PostIndex::class)->name('post.index');
        Route::get('/posts/create',         MCS\Workspace\Posts\PostCreate::class)->name('post.create');
        Route::post('/posts',               MCS\Workspace\Posts\PostStore::class)->name('post.store');
        Route::get('/posts/{postID}/edit',  MCS\Workspace\Posts\PostEdit::class)->name('post.edit');
        Route::put('/posts/{postID}',       MCS\Workspace\Posts\PostUpdate::class)->name('post.update');
        Route::delete('/posts/{postID}',    MCS\Workspace\Posts\PostDelete::class)->name('post.delete');

        // Settings...
        Route::get('/settings', MCS\Workspace\Settings\SettingIndex::class)->name('setting.index');

        Route::get('/settings/design', MCS\Workspace\Design\DesignIndex::class)->name('design.index');

        // Settings/Templates...
        Route::get('/settings/design/templates',                    MCS\Workspace\SiteTemplates\SiteTemplateIndex::class)->name('site-template.index');
        Route::get('/settings/design/templates/create',             MCS\Workspace\SiteTemplates\SiteTemplateCreate::class)->name('site-template.create');
        Route::post('/settings/design/templates',                   MCS\Workspace\SiteTemplates\SiteTemplateStore::class)->name('site-template.store');
        Route::get('/settings/design/templates/{templateID}/edit',  MCS\Workspace\SiteTemplates\SiteTemplateEdit::class)->name('site-template.edit');
        Route::post('/settings/design/templates/{templateID}',      MCS\Workspace\SiteTemplates\SiteTemplateUpdate::class)->name('site-template.update');
        Route::delete('/settings/design/templates/{templateID}',    MCS\Workspace\SiteTemplates\SiteTemplateDelete::class)->name('site-template.delete');

        // Component...
        // Route::get('/templates/{templateID}/components/{id}', MCS\Workspace\Components\ComponentShow::class)->name('component.show');
        Route::post('/templates/{templateID}/insert/component/{id}', MCS\Workspace\Components\ComponentInsert::class)->name('component.insert');

        // Settings/Themes...
        Route::get('/settings/design/themes', MCS\Workspace\SiteThemes\SiteThemeIndex::class)->name('site-theme.index');
    });

    // This *MUST* be last as it's a catch-all route
    Route::get('/{page}', MCS\Workspace\Front\Index::class)
        ->where('page', '.*')
        ->name('front.index');
});
