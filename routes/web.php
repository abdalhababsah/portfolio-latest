<?php

use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\ServiceController as UserServicesController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\HomeController;

Route::get('/lang/{locale}', [LocalizationController::class, 'switchLang'])->name('locale.switch');

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/projects', AdminProjectController::class)->names('admin.projects');
    Route::put('projects/{id}/toggle-featured', [AdminProjectController::class, 'toggleFeatured'])->name('admin.projects.toggle-featured');
    Route::put('projects/{id}/set-main-image', [AdminProjectController::class, 'setMainImage'])->name('admin.projects.set-main-image');
    Route::delete('projects/{id}/images/{imageId}', [AdminProjectController::class, 'deleteImage'])->name('admin.projects.delete-image');
    Route::delete('projects/{id}/videos/{videoId}', [AdminProjectController::class, 'deleteVideo'])->name('admin.projects.delete-video');
    Route::post('projects/temp-upload', [AdminProjectController::class, 'tempUpload'])
    ->name('admin.projects.temp-upload');
});

require __DIR__.'/auth.php';


// user view routes
Route::get('/',               [HomeController::class, 'index'])->name('home');
Route::get('/blog',           [HomeController::class, 'blog'])->name('blog');
Route::get('/blog-detail',    [HomeController::class, 'blogDetail'])->name('blog.detail');
Route::get('/services',       [UserServicesController::class, 'index'])->name('services.index');
Route::get('/services',       [UserServicesController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [UserServicesController::class, 'show'])->name('services.show');
Route::get('/service-detail', [HomeController::class, 'serviceDetail'])->name('service.detail');
Route::get('/projects',           [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}',    [ProjectController::class, 'show'])->name('projects.show');
Route::post('/contact', [ContactController::class, 'store'])
     ->name('contact.store');

