<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\VillageIdentityController;
use App\Http\Controllers\Admin\VillageOfficialController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\TourismUmkmController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PpidDocumentController;
use App\Http\Controllers\Admin\ServiceLetterController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ContactServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\TourismController;

Route::get('/', function () {
    return view('welcome');
});

// Template 23 (Megakit) - preview routes untuk halaman yang baru dikonversi dari .html ke .blade.php
Route::prefix('template23')->name('template23.')->group(function () {
    Route::view('/', '23.index')->name('index');
    Route::view('/about', '23.about')->name('about');
    Route::view('/services', '23.services')->name('services');
    Route::view('/team', '23.team')->name('team');
    Route::view('/events', '23.events')->name('events');
    Route::view('/contacts', '23.contacts')->name('contacts');
    Route::view('/faq', '23.faq')->name('faq');
    Route::view('/index-lawyer', '23.index_lawyer')->name('index-lawyer');
    Route::view('/index-portfolio', '23.index_portfolio')->name('index-portfolio');
    Route::view('/index-app-landing', '23.index_app_landing')->name('index-app-landing');
    Route::view('/index-events', '23.index_events')->name('index-events');
    Route::view('/index-coming-soon', '23.index_coming_soon')->name('index-coming-soon');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Web Settings
    Route::get('/web-settings', [WebSettingController::class, 'show'])->name('web-settings.show');
    Route::get('/web-settings/edit', [WebSettingController::class, 'edit'])->name('web-settings.edit');
    Route::put('/web-settings', [WebSettingController::class, 'update'])->name('web-settings.update');

    // Resources
    Route::resource('village-identities', VillageIdentityController::class);
    Route::resource('village-officials', VillageOfficialController::class);
    Route::resource('institutions', InstitutionController::class);
    
    // Posts / Berita
    Route::get('posts/archives', [PostController::class, 'archives'])->name('posts.archives');
    Route::patch('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore')->withTrashed();
    Route::delete('posts/{post}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete')->withTrashed();
    Route::resource('posts', PostController::class);
    Route::resource('tourisms', TourismUmkmController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('ppid-documents', PpidDocumentController::class);
    Route::resource('service-letters', ServiceLetterController::class);
    Route::resource('complaints', ComplaintController::class);
    Route::post('faqs/reorder', [FaqController::class, 'reorder'])->name('faqs.reorder');
    Route::resource('faqs', FaqController::class);
    Route::get('agendas/archives', [AgendaController::class, 'archives'])->name('agendas.archives');
    Route::resource('agendas', AgendaController::class);
    Route::resource('tourisms', TourismController::class);
    Route::resource('contact-services', ContactServiceController::class);
    Route::resource('users', UserController::class);
});
