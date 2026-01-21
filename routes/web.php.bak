<?php

use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Pages\Home::class)->name('home');
Route::get('/scholarships', \App\Livewire\Pages\ScholarshipIndex::class)->name('scholarships.index');
Route::get('/scholarships/{scholarship:slug}', \App\Livewire\Pages\ScholarshipShow::class)->name('scholarships.show');
Route::get('/user/change-password', \App\Livewire\Auth\ChangePassword::class)->name('password.change');
Route::get('/blog', \App\Livewire\Pages\BlogIndex::class)->name('blog.index');
Route::get('/blog/{post:slug}', \App\Livewire\Pages\BlogShow::class)->name('blog.show');
Route::get('/resources', \App\Livewire\Pages\ResourceIndex::class)->name('resources.index');
Route::get('/resources/{resource:slug}/download', \App\Http\Controllers\ResourceDownloadController::class)
    ->middleware(['auth'])
    ->name('resources.download');
Route::get('/resources/{resource:slug}/view', \App\Http\Controllers\ResourceViewController::class)
    ->name('resources.view');
Route::get('/resources/{resource:slug}', \App\Livewire\Pages\ResourceShow::class)->name('resources.show');
Route::get('/tools', \App\Livewire\Pages\ToolsIndex::class)->name('tools.index');
Route::get('/faq', \App\Livewire\Pages\FaqIndex::class)->name('faq.index');
Route::get('/success-stories', \App\Livewire\Pages\SuccessStoriesIndex::class)->name('success-stories.index');


Route::get('/dashboard', \App\Livewire\Pages\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/my-applications', \App\Livewire\Pages\MyApplications::class)
    ->middleware(['auth', 'verified'])
    ->name('my-applications');

Route::get('/dashboard/resources/saved', \App\Livewire\Dashboard\SavedResources::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard.saved-resources');

Route::get('/admin/email-templates/{record}/preview', [\App\Http\Controllers\Admin\EmailTemplatePreviewController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('email-templates.preview');

Route::get('/dashboard/documents', \App\Livewire\Dashboard\DocumentManager::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard.documents');

Route::get('/dashboard/success-stories/submit', \App\Livewire\Dashboard\StorySubmission::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard.success-stories.submit');

Route::get('/dashboard/searches', \App\Livewire\Dashboard\SavedSearches::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard.saved-searches');


// Socialite OAuth Routes
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');

// Ad Click Tracking
Route::get('/ads/{ad}/click', [\App\Http\Controllers\AdClickController::class, 'track'])
    ->name('ads.track');
Route::post('/ads/{ad}/impression', [\App\Http\Controllers\AdClickController::class, 'trackImpression'])
    ->name('ads.impression');

// Google Calendar Integration
Route::group(['middleware' => ['auth']], function () {
    Route::get('/auth/google', [\App\Http\Controllers\GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [\App\Http\Controllers\GoogleController::class, 'handleGoogleCallback']);
});

// Affiliate Redirect Tracking
Route::get('/go/{slug}', \App\Http\Controllers\AffiliateRedirectController::class)->name('affiliate.go');

require __DIR__ . '/settings.php';