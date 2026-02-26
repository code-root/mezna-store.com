<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
  ProductController as ApiProductController,
  CategoryController as ApiCategoryController,
  BannerController as ApiBannerController,
  AuthController as ApiAuthController,
  VisitController as ApiVisitController,
};

Route::name('api.')->group(function () {

  // Authentication API
  Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register');
  });

  // Protected routes (require authentication)
  Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
      Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout');
      Route::get('/user', [ApiAuthController::class, 'user'])->name('user');
    });
  });

  // Products API
  Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ApiProductController::class, 'index'])->name('index');
    Route::get('/{id}', [ApiProductController::class, 'show'])->name('show');
  });

  // Categories API
  Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [ApiCategoryController::class, 'index'])->name('index');
    Route::get('/{id}', [ApiCategoryController::class, 'show'])->name('show');
  });

  // Banners API
  Route::prefix('banners')->name('banners.')->group(function () {
    Route::get('/', [ApiBannerController::class, 'index'])->name('index');
    Route::get('/main-page', [ApiBannerController::class, 'mainPageBanners'])->name('main-page');
    Route::get('/{id}', [ApiBannerController::class, 'show'])->name('show');
  });

  // Page contents (Shipping, Returns, FAQ, Meta Pixel ID)
  Route::prefix('page-contents')->name('page-contents.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\PageContentController::class, 'index'])->name('index');
    Route::get('/{key}', [\App\Http\Controllers\Api\PageContentController::class, 'show'])->name('show');
  });

  // Hero slides (carousel images - random order)
  Route::get('/hero-slides', [\App\Http\Controllers\Api\HeroSlideController::class, 'index'])->name('hero-slides.index');

  // Social media links (حسابات التواصل الاجتماعي)
  Route::get('/social-links', [\App\Http\Controllers\Api\SocialLinksController::class, 'index'])->name('social-links.index');

  // Record visit (category or product)
  Route::post('/visits', [ApiVisitController::class, 'store'])->name('visits.store');
});
