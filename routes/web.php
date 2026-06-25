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

Route::get('/', function () {
    return view('welcome');
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
    Route::resource('posts', PostController::class);
    Route::resource('tourisms', TourismUmkmController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('ppid-documents', PpidDocumentController::class);
    Route::resource('service-letters', ServiceLetterController::class);
    Route::resource('complaints', ComplaintController::class);
    Route::post('faqs/reorder', [FaqController::class, 'reorder'])->name('faqs.reorder');
    Route::resource('faqs', FaqController::class);
    Route::resource('contact-services', ContactServiceController::class);
    Route::resource('users', UserController::class);
});
