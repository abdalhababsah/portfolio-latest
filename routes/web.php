<?php

use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Admin\TestimonialController;
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
    Route::resource('experiences', ExperienceController::class)->names('admin.experiences');
    Route::resource('technologies', TechnologyController::class)->names('admin.technologies');
    Route::resource('educations', EducationController::class)->names('admin.educations');
    Route::resource('social-links', SocialLinkController::class)->names('admin.social-links');
    Route::resource('skills', SkillController::class)->names('admin.skills');
    Route::resource('site-settings', controller: SiteSettingsController::class)->names('admin.site-settings');

    Route::resource('faqs', FaqController::class)->names(names: 'admin.faqs');
    Route::post('faqs/reorder', [FaqController::class, 'reorder'])->name('admin.faqs.reorder');
    Route::resource('testimonials', TestimonialController::class)->names(names: 'admin.testimonials');
    Route::resource('tags', TagController::class)->names(names: 'admin.tags');
    Route::resource('services', AdminServiceController::class)->names(names: 'admin.services');

    Route::resource('certificates', CertificateController::class)->names('admin.certificates');
    Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])->name('admin.certificates.download');


    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy'])->names('admin.contacts');
    Route::post('contacts/mark-read', [AdminContactController::class, 'markAsRead'])->name('admin.contacts.mark-read');
    Route::get('contacts/unread-count', [AdminContactController::class, 'getUnreadCount'])->name('admin.contacts.unread-count');
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

