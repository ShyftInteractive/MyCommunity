<?php

use Illuminate\Support\Facades\Route;

Route::get('/registration', fn () => redirect()->route('register.basic-info'));
Route::get('/signup', fn () => redirect()->route('register.basic-info'));
Route::get('/sign-up', fn () => redirect()->route('register.basic-info'));

Route::domain(config('app.domain'))->group(function (): void {
    // Legal
    Route::get('legal/privacy', Rebase\Guest\Legal\Privacy::class)->name('privacy');
    Route::get('legal/terms',   Rebase\Guest\Legal\Terms::class)->name('terms');

    // Registration Step 1
    Route::get('register', Rebase\Guest\Registers\RegisterBasicInfo::class)->name('register.basic-info');
    Route::post('register', Rebase\Guest\Registers\RegisterBasicInfoProcess::class)->name('register.basic-info.process');

    // Registration Step 2
    Route::get('register/plan',  Rebase\Guest\Registers\RegisterPickPlan::class)->name('register.pick-plan');
    Route::post('register/plan', Rebase\Guest\Registers\RegisterPickPlanProcess::class)->name('register.pick-plan.process');

    // Registration Step 3
    Route::get('register/cc', Rebase\Guest\Registers\RegisterPayCC::class)->name('register.pay.cc');
    Route::get('register/ach', Rebase\Guest\Registers\RegisterPayACH::class)->name('register.pay.ach');
    Route::post('register/payment', Rebase\Guest\Registers\RegisterPay::class)->name('register.pay.process');

    // Registration Step 4
    // Route::get('register/complete');

    // Search
    Route::get('search',            Rebase\Guest\CustomerSearch\SearchIndex::class)->name('search.index');
    Route::post('search',           Rebase\Guest\CustomerSearch\SearchProcess::class)->name('search.process');
    Route::get('search/results',    Rebase\Guest\CustomerSearch\SearchResults::class)->name('search.show');
});
