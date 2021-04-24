<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MemberController;

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
        Route::get('/members',                              [MemberController::class, 'index'])->name('member.index');
        Route::get('/members/create',                       [MemberController::class, 'create'])->name('member.create');
        Route::get('/members/{memberID}/edit',              [MemberController::class, 'edit'])->name('member.edit');
        Route::post('/members',                             [MemberController::class, 'store'])->name('member.store');
        Route::post('/members/{memberID}/upload',           [MemberController::class, 'upload'])->name('member.upload');
        Route::post('/members/selected/{action}',           [MemberController::class, 'selected'])->name('member.selected');
        Route::put('/members/{memberID}',                   [MemberController::class, 'update'])->name('member.update');
        Route::delete('/members/{memberID}/upload/delete',  [MemberController::class, 'uploadDelete'])->name('member.upload.delete');
        Route::delete('/members/{memberID}',                [MemberController::class, 'destroy'])->name('member.delete');

        // Media...
        Route::get('/media',                MCS\Workspace\Media\MediaIndex::class)->name('media.index');
        Route::post('/media',               MCS\Workspace\Media\MediaStore::class)->name('media.store');
        Route::post('/media/{mediaID}',     MCS\Workspace\Media\MediaUpdate::class)->name('media.update');
        Route::delete('/media/{mediaID}',   MCS\Workspace\Media\MediaDelete::class)->name('media.delete');
        Route::post('/media/{mediaID}/tag', MCS\Workspace\Media\MediaTagCreate::class)->name('media.tag.create');

        // Tags...
        Route::post('/tags',  MCS\Workspace\Tags\TagStore::class)->name('tag.store');
        // Route::get('/tags',                     MCS\Workspace\Tags\TagIndex::class)->name('tag.index');
        // Route::get('/tags/create',              MCS\Workspace\Tags\TagCreate::class)->name('tag.create');

        // Route::post('/tags/attach/{mediaID}',   MCS\Workspace\Tags\TagAttach::class)->name('tag.attach');
        // Route::get('/tags/{groupID}',           MCS\Workspace\Tags\TagEdit::class)->name('tag.edit');
        // Route::get('/tags/{groupID}',           MCS\Workspace\Tags\TagUpdate::class)->name('tag.update');
        // Route::delete('/tags/{groupID}',        MCS\Workspace\Tags\TagDelete::class)->name('tag.delete');

        // Groups...
        Route::get('/groups',                   MCS\Workspace\Groups\GroupIndex::class)->name('group.index');
        Route::get('/groups/create',            MCS\Workspace\Groups\GroupCreate::class)->name('group.create');
        Route::post('/groups',                  MCS\Workspace\Groups\GroupStore::class)->name('group.store');
        Route::get('/groups/{groupID}/edit',    MCS\Workspace\Groups\GroupEdit::class)->name('group.edit');
        Route::put('/groups/{groupID}',         MCS\Workspace\Groups\GroupUpdate::class)->name('group.update');
        Route::delete('/groups/{groupID}',      MCS\Workspace\Groups\GroupDelete::class)->name('group.delete');
        Route::post('/groups/selected/{action}',MCS\Workspace\Groups\GroupSelected::class)->name('group.selected');
        Route::post('/groups/{groupID}/tag',    MCS\Workspace\Groups\GroupTagCreate::class)->name('group.tag.create');


        // Events...
        Route::get('/events',                        MCS\Workspace\Events\EventIndex::class)->name('event.index');
        Route::get('/events/create',                 MCS\Workspace\Events\EventCreate::class)->name('event.create');
        Route::post('/events',                       MCS\Workspace\Events\EventStore::class)->name('event.store');
        Route::get('/events/{eventID}/edit',         MCS\Workspace\Events\EventEdit::class)->name('event.edit');
        Route::get('/events/{eventID}',              MCS\Workspace\Events\EventShow::class)->name('event.show');
        Route::put('/events/{eventID}',              MCS\Workspace\Events\EventUpdate::class)->name('event.update');
        Route::delete('/events/{eventID}',           MCS\Workspace\Events\EventDelete::class)->name('event.delete');
        Route::post('/events/selected/{action}',     MCS\Workspace\Events\EventSelected::class)->name('event.selected');

        // Notifications...
        Route::get('/notifications',                        MCS\Workspace\Notifications\NotificationIndex::class)->name('notification.index');
        Route::get('/notifications/create',                 MCS\Workspace\Notifications\NotificationCreate::class)->name('notification.create');
        Route::post('/notifications',                       MCS\Workspace\Notifications\NotificationStore::class)->name('notification.store');
        Route::get('/notifications/{notificationID}/edit',  MCS\Workspace\Notifications\NotificationEdit::class)->name('notification.edit');
        Route::put('/notifications/{notificationID}',       MCS\Workspace\Notifications\NotificationUpdate::class)->name('notification.update');
        Route::delete('/notifications/{notificationID}',    MCS\Workspace\Notifications\NotificationDelete::class)->name('notification.delete');
        Route::post('/notifications/selected/{action}',     MCS\Workspace\Notifications\NotificationSelected::class)->name('notification.selected');

        // Pages...
        Route::get('/pages',                              [PageController::class, 'index'])->name('page.index');
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
    Route::get('/{slug}', MCS\Workspace\Front\Index::class)
        ->where('slug', '.*')
        ->name('front.index');
});
