<?php

use Illuminate\Support\Facades\Route;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ActivityController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\NoticeController;
use App\Http\Controllers\Frontend\VolunteerController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use App\Http\Controllers\Frontend\ForgotPasswordController;
use App\Http\Controllers\Frontend\LanguageController;

// Admin Controllers
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PostCategoryController as AdminPostCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\GalleryCategoryController as AdminGalleryCategoryController;
use App\Http\Controllers\Admin\JoinSubmissionController as AdminJoinSubmissionController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\NavigationController as AdminNavigationController;
use App\Http\Controllers\Admin\FooterController as AdminFooterController;
use App\Http\Controllers\Admin\SeoController as AdminSeoController;
use App\Http\Controllers\Admin\SocialController as AdminSocialController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\MailSettingController as AdminMailSettingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/{slug}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/volunteer', [VolunteerController::class, 'index'])->name('volunteer.index');
Route::post('/volunteer', [VolunteerController::class, 'store'])->name('volunteer.store');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/notice', [NoticeController::class, 'index'])->name('notice.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/login', [FrontendAuthController::class, 'showLogin'])->name('login');

// cPanel Utility Route to create storage link without terminal access
Route::get('/storage-link', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return '<h3 style="color:green;font-family:sans-serif;padding:20px;">Storage linked successfully! Assets and upload paths are ready.</h3>';
    } catch (\Exception $e) {
        return '<h3 style="color:red;font-family:sans-serif;padding:20px;">Error linking storage: ' . htmlspecialchars($e->getMessage()) . '</h3>';
    }
});

// cPanel Utility Route to run migrations and seed data without SSH/Terminal
Route::get('/run-migration', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $seedOutput = \Illuminate\Support\Facades\Artisan::output();

        return '<div style="font-family:sans-serif;padding:30px;background:#f8fafc;color:#0f172a;max-width:800px;margin:30px auto;border-radius:10px;box-shadow:0 4px 15px rgba(0,0,0,0.08);">
            <h2 style="color:#16a34a;margin-top:0;">✅ Migrations & Seeders Completed Successfully!</h2>
            <p>All database tables, pages, services, settings, and navigation items have been created.</p>
            <h4 style="margin-bottom:8px;">Migration Log:</h4>
            <pre style="background:#1e293b;color:#38bdf8;padding:15px;border-radius:8px;overflow-x:auto;">' . htmlspecialchars($migrateOutput ?: 'All migrations already up to date.') . '</pre>
            <h4 style="margin-bottom:8px;">Seeder Log:</h4>
            <pre style="background:#1e293b;color:#a7f3d0;padding:15px;border-radius:8px;overflow-x:auto;">' . htmlspecialchars($seedOutput ?: 'Database seeding completed.') . '</pre>
            <p style="margin-top:20px;"><a href="/" style="display:inline-block;padding:10px 24px;background:#0284c7;color:#fff;text-decoration:none;border-radius:6px;font-weight:bold;">Go to Homepage →</a></p>
        </div>';
    } catch (\Exception $e) {
        return '<div style="font-family:sans-serif;padding:30px;background:#fff1f2;color:#991b1b;max-width:800px;margin:30px auto;border-radius:10px;">
            <h2 style="margin-top:0;">❌ Migration Error:</h2>
            <pre style="background:#fff;padding:15px;border-radius:8px;border:1px solid #fecdd3;color:#be123c;">' . htmlspecialchars($e->getMessage()) . '</pre>
        </div>';
    }
});
Route::post('/login', [FrontendAuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::get('/register', [FrontendAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [FrontendAuthController::class, 'register'])->middleware('throttle:5,1')->name('register.post');
Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('logout');

// Password Reset via Email
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('throttle:3,1')->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->middleware('throttle:5,1')->name('password.update');

// User Profile & Dashboard (Auth Protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [FrontendProfileController::class, 'index'])->name('user.profile');
    Route::put('/profile', [FrontendProfileController::class, 'update'])->name('user.profile.update');
    Route::post('/profile/avatar', [FrontendProfileController::class, 'updateAvatar'])->name('user.profile.avatar');
});

// Language Switcher
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Protected Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pages & SEO
    Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');

    // Blog & Categories
    Route::resource('posts', AdminPostController::class);
    Route::resource('post-categories', AdminPostCategoryController::class)->except(['create', 'show', 'edit']);

    // Services / Activities
    Route::resource('services', AdminServiceController::class)->except(['show']);

    // Notices
    Route::resource('notices', AdminNoticeController::class)->except(['show']);

    // Gallery (Images & Videos) & Categories
    Route::resource('gallery', AdminGalleryController::class)->except(['show']);
    Route::resource('gallery-categories', AdminGalleryCategoryController::class)->except(['create', 'show', 'edit']);

    // Join Now / Volunteer Form Submissions
    Route::get('/joins', [AdminJoinSubmissionController::class, 'index'])->name('joins.index');
    Route::get('/joins/{join}', [AdminJoinSubmissionController::class, 'show'])->name('joins.show');
    Route::put('/joins/{join}/status', [AdminJoinSubmissionController::class, 'updateStatus'])->name('joins.status');
    Route::delete('/joins/{join}', [AdminJoinSubmissionController::class, 'destroy'])->name('joins.destroy');

    // Contact Messages
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

    // Header & Navigation
    Route::get('/navigation', [AdminNavigationController::class, 'index'])->name('navigation.index');
    Route::post('/navigation', [AdminNavigationController::class, 'store'])->name('navigation.store');
    Route::get('/navigation/{navigation}/edit', [AdminNavigationController::class, 'edit'])->name('navigation.edit');
    Route::post('/navigation/reorder', [AdminNavigationController::class, 'reorder'])->name('navigation.reorder');
    Route::post('/navigation/{navigation}/move/{direction}', [AdminNavigationController::class, 'move'])->name('navigation.move');
    Route::put('/navigation/{navigation}', [AdminNavigationController::class, 'update'])->name('navigation.update');
    Route::delete('/navigation/{navigation}', [AdminNavigationController::class, 'destroy'])->name('navigation.destroy');

    // Footer Settings
    Route::get('/footer', [AdminFooterController::class, 'index'])->name('footer.index');
    Route::post('/footer', [AdminFooterController::class, 'update'])->name('footer.update');

    // SEO Settings
    Route::get('/seo', [AdminSeoController::class, 'index'])->name('seo.index');
    Route::post('/seo', [AdminSeoController::class, 'update'])->name('seo.update');

    // Social Links
    Route::get('/social', [AdminSocialController::class, 'index'])->name('social.index');
    Route::post('/social', [AdminSocialController::class, 'update'])->name('social.update');

    // General Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Mailing Settings
    Route::get('/mail', [AdminMailSettingController::class, 'index'])->name('mail.index');
    Route::post('/mail', [AdminMailSettingController::class, 'update'])->name('mail.update');
    Route::post('/mail/test', [AdminMailSettingController::class, 'sendTestMail'])->name('mail.test');

    // Profile Settings
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Users & Roles Management
    Route::resource('users', AdminUserController::class)->except(['show', 'create', 'edit']);
});
