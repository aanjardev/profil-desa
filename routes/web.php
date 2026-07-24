<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\VillageIdentityController;
use App\Http\Controllers\Admin\VillageOfficialController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\InstitutionController as PublicInstitutionController;
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
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\EmergencyContactController;
use App\Http\Controllers\Admin\HomepageFeaturedController;
use App\Http\Controllers\Admin\RtRwController;

Route::redirect('/', '/beranda');

use App\Http\Controllers\User\HomeController;

// User Routes
Route::get('/beranda', [HomeController::class, 'index'])->name('beranda');
Route::view('/about', 'user.about')->name('about');
Route::get('/kelembagaan', [PublicInstitutionController::class, 'index'])->name('kelembagaan');
Route::get('/kelembagaan/{institution}', [PublicInstitutionController::class, 'show'])->name('kelembagaan.show');
Route::view('/index-coming-soon', 'user.index_coming_soon')->name('index-coming-soon');

// DATA DESA
use App\Http\Controllers\User\VillageDataController as PublicVillageDataController;
Route::get('/profil-desa', [PublicVillageDataController::class, 'profil'])->name('profil-desa');
Route::get('/sotk-desa', [PublicVillageDataController::class, 'sotk'])->name('sotk-desa');
Route::get('/visi-misi', [PublicVillageDataController::class, 'visiMisi'])->name('visi-misi');
Route::get('/monografi-desa', [PublicVillageDataController::class, 'monografi'])->name('monografi-desa');
Route::get('/data-penduduk', [\App\Http\Controllers\User\PopulationController::class, 'index'])->name('data-penduduk');


// POTENSI DESA
use App\Http\Controllers\User\TourismController as PublicTourismController;
Route::get('/pariwisata', [PublicTourismController::class, 'index'])->name('pariwisata');
Route::get('/pariwisata/{slug}', [PublicTourismController::class, 'show'])->name('pariwisata.show');
use App\Http\Controllers\User\UmkmController as PublicUmkmController;
Route::get('/umkm', [PublicUmkmController::class, 'index'])->name('umkm');
Route::get('/umkm/{slug}', [PublicUmkmController::class, 'show'])->name('umkm.show');

// INFORMASI
use App\Http\Controllers\User\PostController as PublicPostController;
Route::get('/berita-desa', [PublicPostController::class, 'index'])->name('berita-desa');
Route::get('/berita-desa/{slug}', [PublicPostController::class, 'show'])->name('berita-desa.show');
use App\Http\Controllers\User\AgendaController as PublicAgendaController;
Route::get('/agenda-kegiatan', [PublicAgendaController::class, 'index'])->name('agenda-kegiatan');
use App\Http\Controllers\User\GalleryController as PublicGalleryController;
Route::get('/galeri', [PublicGalleryController::class, 'index'])->name('galeri');
Route::get('/galeri/{gallery}', [PublicGalleryController::class, 'show'])->name('galeri.show');
use App\Http\Controllers\User\PpidDocumentController as PublicPpidDocumentController;
Route::get('/dokumen-ppid', [PublicPpidDocumentController::class, 'index'])->name('dokumen-ppid');

// PELAYANAN\
Route::get('/layanan-surat', [\App\Http\Controllers\User\ServiceLetterController::class, 'index'])->name('layanan-surat');
Route::get('/administrasi-online', [\App\Http\Controllers\User\OnlineAdministrationController::class, 'index'])->name('administrasi-online');
Route::get('/faq', [\App\Http\Controllers\User\FaqController::class, 'index'])->name('faq');
Route::get('/kontak-darurat', [\App\Http\Controllers\User\EmergencyContactController::class, 'index'])->name('kontak-darurat');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/register/check-email', [AuthController::class, 'checkEmail'])->name('register.check-email');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Web Settings
    Route::get('/web-settings', [WebSettingController::class, 'show'])->name('web-settings.show');
    Route::get('/web-settings/edit', [WebSettingController::class, 'edit'])->name('web-settings.edit');
    Route::put('/web-settings', [WebSettingController::class, 'update'])->name('web-settings.update');

    // Resources
    Route::get('village-identities/edit-key/{key}', [VillageIdentityController::class, 'editKey'])->name('village-identities.edit-key');
    Route::resource('village-identities', VillageIdentityController::class);
    Route::get('village-officials/builder', [\App\Http\Controllers\Admin\SotkBuilderController::class, 'index'])->name('village-officials.builder');
    Route::post('village-officials/builder/save', [\App\Http\Controllers\Admin\SotkBuilderController::class, 'save'])->name('village-officials.builder.save');
    Route::post('village-officials/builder/settings', [\App\Http\Controllers\Admin\SotkBuilderController::class, 'saveSettings'])->name('village-officials.builder.settings');
    Route::post('village-officials/reorder', [VillageOfficialController::class, 'reorder'])->name('village-officials.reorder');
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
    Route::resource('rt-rws', RtRwController::class);
    Route::resource('service-letters', ServiceLetterController::class);
    Route::resource('complaints', ComplaintController::class);
    Route::post('faqs/reorder', [FaqController::class, 'reorder'])->name('faqs.reorder');
    Route::resource('faqs', FaqController::class);
    Route::get('agendas/archives', [AgendaController::class, 'archives'])->name('agendas.archives');
    Route::resource('agendas', AgendaController::class);
    Route::resource('tourisms', TourismController::class);
    Route::resource('umkms', UmkmController::class);
    Route::resource('contact-services', ContactServiceController::class);
    Route::resource('emergency-contacts', EmergencyContactController::class);
    Route::get('homepage-featured', [HomepageFeaturedController::class, 'index'])->name('homepage-featured.index');
    Route::post('homepage-featured', [HomepageFeaturedController::class, 'update'])->name('homepage-featured.update');
    
    Route::middleware(['role:superadmin'])->group(function () {
        Route::post('users/email', [UserController::class, 'storeEmail'])->name('users.email.store');
        Route::delete('users/email/{pendingRegistration}', [UserController::class, 'destroyEmail'])->name('users.email.destroy');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::resource('users', UserController::class);
    });
});