<?php

use App\Http\Controllers\Backend\User\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Product\ProductController;
use App\Http\Controllers\Backend\Product\ProductCatalogueController;
use App\Http\Controllers\Backend\Attribute\AttributeCatalogueController;
use App\Http\Controllers\Backend\Attribute\AttributeController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\Promotion\PromotionController;
use App\Http\Controllers\Frontend\ProductCatalogueController as FeProductCatalogueController;
use App\Http\Controllers\Backend\Post\PostCatalogueController;
use App\Http\Controllers\Backend\Post\PostController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\Payment\VnpayController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\SlideController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::group(['middleware' => ['admin', 'locale', 'backend_default_locale']], function () {
//    Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::group(['prefix' => 'product/catalogue'], function () {
        Route::get('index', [ProductCatalogueController::class, 'index'])->name('product.catalogue.index');
        Route::get('create', [ProductCatalogueController::class, 'create'])->name('product.catalogue.create');
        Route::post('store', [ProductCatalogueController::class, 'store'])->name('product.catalogue.store');
        Route::get('{id}/edit', [ProductCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('product.catalogue.edit');
        Route::post('{id}/update', [ProductCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('product.catalogue.update');
        Route::get('{id}/delete', [ProductCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('product.catalogue.delete');
        Route::delete('{id}/destroy', [ProductCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('product.catalogue.destroy');
    });

     Route::group(['prefix' => 'product'], function () {
      Route::get('index', [ProductController::class, 'index'])->name('product.index');
      Route::get('create', [ProductController::class, 'create'])->name('product.create');
      Route::post('store', [ProductController::class, 'store'])->name('product.store');
      Route::get('{id}/edit', [ProductController::class, 'edit'])->where(['id' => '[0-9]+'])->name('product.edit');
      Route::post('{id}/update', [ProductController::class, 'update'])->where(['id' => '[0-9]+'])->name('product.update');
      Route::get('{id}/delete', [ProductController::class, 'delete'])->where(['id' => '[0-9]+'])->name('product.delete');
      Route::delete('{id}/destroy', [ProductController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('product.destroy');
   });

    Route::group(['prefix' => 'attribute/catalogue'], function () {
        Route::get('index', [AttributeCatalogueController::class, 'index'])->name('attribute.catalogue.index');
        Route::get('create', [AttributeCatalogueController::class, 'create'])->name('attribute.catalogue.create');
        Route::post('store', [AttributeCatalogueController::class, 'store'])->name('attribute.catalogue.store');
        Route::get('{id}/edit', [AttributeCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.edit');
        Route::post('{id}/update', [AttributeCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.update');
        Route::get('{id}/delete', [AttributeCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.delete');
        Route::delete('{id}/destroy', [AttributeCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.destroy');
    });

    Route::group(['prefix' => 'attribute'], function () {
      Route::get('index', [AttributeController::class, 'index'])->name('attribute.index');
      Route::get('create', [AttributeController::class, 'create'])->name('attribute.create');
      Route::post('store', [AttributeController::class, 'store'])->name('attribute.store');
      Route::get('{id}/edit', [AttributeController::class, 'edit'])->where(['id' => '[0-9]+'])->name('attribute.edit');
      Route::post('{id}/update', [AttributeController::class, 'update'])->where(['id' => '[0-9]+'])->name('attribute.update');
      Route::get('{id}/delete', [AttributeController::class, 'delete'])->where(['id' => '[0-9]+'])->name('attribute.delete');
      Route::delete('{id}/destroy', [AttributeController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('attribute.destroy');
   });

    Route::group(['prefix' => 'promotion'], function () {
      Route::get('index', [PromotionController::class, 'index'])->name('promotion.index');
      Route::get('create', [PromotionController::class, 'create'])->name('promotion.create');
      Route::post('store', [PromotionController::class, 'store'])->name('promotion.store');
      Route::get('{id}/edit', [PromotionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('promotion.edit');
      Route::post('{id}/update', [PromotionController::class, 'update'])->where(['id' => '[0-9]+'])->name('promotion.update');
      Route::get('{id}/delete', [PromotionController::class, 'delete'])->where(['id' => '[0-9]+'])->name('promotion.delete');
      Route::delete('{id}/destroy', [PromotionController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('promotion.destroy');
   });

    Route::group(['prefix' => 'post/catalogue'], function () {
      Route::get('index', [PostCatalogueController::class, 'index'])->name('post.catalogue.index');
      Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
      Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
      Route::get('{id}/edit', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit');
      Route::post('{id}/update', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.catalogue.update');
      Route::get('{id}/delete', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete');
      Route::delete('{id}/destroy', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy');
   });

   Route::group(['prefix' => 'post'], function () {
      Route::get('index', [PostController::class, 'index'])->name('post.index');
      Route::get('create', [PostController::class, 'create'])->name('post.create');
      Route::post('store', [PostController::class, 'store'])->name('post.store');
      Route::get('{id}/edit', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.edit');
      Route::post('{id}/update', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.update');
      Route::get('{id}/delete', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete');
      Route::delete('{id}/destroy', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.destroy');
   });

    Route::group(['prefix' => 'order'], function () {
      Route::get('index', [OrderController::class, 'index'])->name('order.index');
      Route::get('{id}/detail', [OrderController::class, 'detail'])->where(['id' => '[0-9]+'])->name('order.detail');
   });

     Route::group(['prefix' => 'slide'], function () {
      Route::get('index', [SlideController::class, 'index'])->name('slide.index');
      Route::get('create', [SlideController::class, 'create'])->name('slide.create');
      Route::post('store', [SlideController::class, 'store'])->name('slide.store');
      Route::get('{id}/edit', [SlideController::class, 'edit'])->where(['id' => '[0-9]+'])->name('slide.edit');
      Route::post('{id}/update', [SlideController::class, 'update'])->where(['id' => '[0-9]+'])->name('slide.update');
      Route::get('{id}/delete', [SlideController::class, 'delete'])->where(['id' => '[0-9]+'])->name('slide.delete');
      Route::delete('{id}/destroy', [SlideController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('slide.destroy');
   });
});

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');
Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');
Route::get('ajax/dashboard/getMenu', [AjaxDashboardController::class, 'getMenu'])->name('ajax.dashboard.getMenu');
   
Route::get('ajax/dashboard/findPromotionObject', [AjaxDashboardController::class, 'findPromotionObject'])->name('ajax.dashboard.findPromotionObject');
Route::get('ajax/dashboard/getPromotionConditionValue', [AjaxDashboardController::class, 'getPromotionConditionValue'])->name('ajax.dashboard.getPromotionConditionValue');

Route::get('tim-kiem'.config('apps.general.suffix'), [FeProductCatalogueController::class, 'search'])->name('product.catalogue.search');
Route::get('danh-sach-yeu-thich'.config('apps.general.suffix'), [FeProductCatalogueController::class, 'wishlist'])->name('product.catalogue.wishlist');

Route::get('thanh-toan'.config('apps.general.suffix'), [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('cart/create', [CartController::class, 'store'])->name('cart.store');
Route::get('cart/{code}/success'.config('apps.general.suffix'), [CartController::class, 'success'])->name('cart.success')->where(['code' => '[0-9]+']);

/* VNPAY */
Route::get('return/vnpay'.config('apps.general.suffix'), [VnpayController::class, 'vnpay_return'])->name('vnpay.momo_return');
Route::get('return/vnpay_ipn'.config('apps.general.suffix'), [VnpayController::class, 'vnpay_ipn'])->name('vnpay.vnpay_ipn');
