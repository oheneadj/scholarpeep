<?php

use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Pages\Home::class)->name('home');
Route::get('/scholarships', \App\Livewire\Pages\ScholarshipIndex::class)->name('scholarships.index');
Route::get('/scholarships/{scholarship:slug}', \App\Livewire\Pages\ScholarshipShow::class)->name('scholarships.show');
Route::get('/blog', \App\Livewire\Pages\BlogIndex::class)->name('blog.index');
Route::get('/blog/{post:slug}', \App\Livewire\Pages\BlogShow::class)->name('blog.show');
Route::get('/resources', \App\Livewire\Pages\ResourceIndex::class)->name('resources.index');
Route::get('/tools', \App\Livewire\Pages\ToolsIndex::class)->name('tools.index');
Route::get('/faq', \App\Livewire\Pages\FaqIndex::class)->name('faq.index');

Route::get('/dashboard', \App\Livewire\Pages\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/resources/saved', \App\Livewire\Dashboard\SavedResources::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard.saved-resources');

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

require __DIR__ . '/settings.php';