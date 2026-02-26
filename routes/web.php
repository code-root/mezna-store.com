<?php
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\VisitLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

Route::get('/', function () {
    return redirect()->route('admin.login');
})->name('home');

// Admin Authentication Routes
Route::middleware(['guest'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// Fallback authentication routes (for Laravel compatibility)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return redirect()->route('admin.login');
    })->name('login');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Web Interface)
|--------------------------------------------------------------------------
|
| Routes for the admin web interface with views and server-side rendering.
| All routes require authentication and proper permissions.
|
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //Products Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

        // Variants Management
        Route::prefix('{product}/variants')->name('variants.')->group(function () {
            Route::get('/create', [ProductVariantController::class, 'create'])->name('create');
            Route::post('/', [ProductVariantController::class, 'store'])->name('store');
            Route::get('/{variant}/edit', [ProductVariantController::class, 'edit'])->name('edit');
            Route::put('/{variant}', [ProductVariantController::class, 'update'])->name('update');
            Route::delete('/{variant}', [ProductVariantController::class, 'destroy'])->name('destroy');
        });
    });

    //Categories Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Visit logs (analytics)
    Route::get('/visits', [VisitLogController::class, 'index'])->name('visits.index');

    // Page contents (Shipping, Returns, FAQ, Meta Pixel)
    Route::prefix('page-contents')->name('page-contents.')->group(function () {
        Route::get('/', [PageContentController::class, 'index'])->name('index');
        Route::get('/social/edit', [PageContentController::class, 'socialEdit'])->name('social.edit');
        Route::put('/social', [PageContentController::class, 'socialUpdate'])->name('social.update');
        Route::get('/{key}/edit', [PageContentController::class, 'edit'])->name('edit');
        Route::put('/{key}', [PageContentController::class, 'update'])->name('update');
    });

    // Hero slides (carousel at top)
    Route::prefix('hero-slides')->name('hero-slides.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\HeroSlideController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\HeroSlideController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\HeroSlideController::class, 'store'])->name('store');
        Route::get('/{hero_slide}/edit', [\App\Http\Controllers\Admin\HeroSlideController::class, 'edit'])->name('edit');
        Route::put('/{hero_slide}', [\App\Http\Controllers\Admin\HeroSlideController::class, 'update'])->name('update');
        Route::delete('/{hero_slide}', [\App\Http\Controllers\Admin\HeroSlideController::class, 'destroy'])->name('destroy');
    });

    //Banners Management
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/create', [BannerController::class, 'create'])->name('create');
        Route::post('/', [BannerController::class, 'store'])->name('store');
        Route::get('/{banner}', [BannerController::class, 'show'])->name('show');
        Route::get('/{banner}/edit', [BannerController::class, 'edit'])->name('edit');
        Route::put('/{banner}', [BannerController::class, 'update'])->name('update');
        Route::delete('/{banner}', [BannerController::class, 'destroy'])->name('destroy');
    });

    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/edit', [SettingsController::class, 'edit'])->name('edit');
        Route::put('/', [SettingsController::class, 'update'])->name('update');
    });


    // User Management - Using View Controller
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
    });

    // Role Management - Using View Controller
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('store');
        Route::get('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('destroy');
        Route::post('/{role}/assign-user', [\App\Http\Controllers\Admin\RoleController::class, 'assignUser'])->name('assign-user');
        Route::delete('/{role}/remove-user/{user}', [\App\Http\Controllers\Admin\RoleController::class, 'removeUser'])->name('remove-user');
    });
});

