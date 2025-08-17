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
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Ajax\ReviewController as AjaxReviewController;
use App\Http\Controllers\Ajax\CartController as AjaxCartController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\OrderController as AjaxOrderController;
use App\Http\Controllers\Backend\User\UserController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\Customer\CustomerController;
use App\Http\Controllers\Frontend\AgencyAuthController as FeAgencyAuthController;
use App\Http\Controllers\Frontend\CustomerController as FeCustomerController;
use App\Http\Controllers\Frontend\AgencyController as FeAgencyController;
use App\Http\Controllers\Frontend\AuthController as FeAuthController;
use App\Http\Controllers\Backend\Crm\AgencyController;
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


Route::get('customer/login'.config('apps.general.suffix'), [FeAuthController::class, 'index'])->name('fe.auth.login'); 
Route::get('customer/check/login'.config('apps.general.suffix'), [FeAuthController::class, 'login'])->name('fe.auth.dologin');

Route::get('customer/password/forgot'.config('apps.general.suffix'), [FeAuthController::class, 'forgotCustomerPassword'])->name('forgot.customer.password');
Route::get('customer/password/email'.config('apps.general.suffix'), [FeAuthController::class, 'verifyCustomerEmail'])->name('customer.password.email');
Route::get('customer/register'.config('apps.general.suffix'), [FeAuthController::class, 'register'])->name('customer.register');
Route::post('customer/reg'.config('apps.general.suffix'), [FeAuthController::class, 'registerAccount'])->name('customer.reg');


Route::get('customer/password/update'.config('apps.general.suffix'), [FeAuthController::class, 'updatePassword'])->name('customer.update.password');
Route::post('customer/password/change'.config('apps.general.suffix'), [FeAuthController::class, 'changePassword'])->name('customer.password.reset');

/* AGENCY  */
Route::get('agency/login' . config('apps.general.suffix'), [FeAgencyAuthController::class, 'indexAgency'])->name('fe.auth.agency.login');
Route::get('agency/check/login' . config('apps.general.suffix'), [FeAgencyAuthController::class, 'login'])->name('fe.auth.agency.dologin');
Route::get('agency/password/forgot' . config('apps.general.suffix'), [FeAgencyAuthController::class, 'forgotAgencyPassword'])->name('forgot.agency.password');
Route::get('agency/password/email' . config('apps.general.suffix'), [FeAgencyAuthController::class, 'verifyAgencyEmail'])->name('agency.password.email');
Route::get('agency/password/update' . config('apps.general.suffix'), [FeAgencyAuthController::class, 'updatePassword'])->name('agency.update.password');
Route::post('agency/password/change' . config('apps.general.suffix'), [FeAgencyAuthController::class, 'changePassword'])->name('agency.password.reset');


Route::group(['middleware' => ['customer']], function () {
    Route::get('customer/profile' . config('apps.general.suffix'), [FeCustomerController::class, 'profile'])->name('customer.profile');
    Route::post('customer/profile/update' . config('apps.general.suffix'), [FeCustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('customer/password/reset' . config('apps.general.suffix'), [FeCustomerController::class, 'passwordForgot'])->name('customer.password.change');
    Route::post('customer/password/recovery' . config('apps.general.suffix'), [FeCustomerController::class, 'recovery'])->name('customer.password.recovery');
    Route::get('customer/logout' . config('apps.general.suffix'), [FeCustomerController::class, 'logout'])->name('customer.logout');
    Route::get('customer/construction' . config('apps.general.suffix'), [FeCustomerController::class, 'construction'])->name('customer.construction');
    Route::get('customer/construction/{id}/product' . config('apps.general.suffix'), [FeCustomerController::class, 'constructionProduct'])->name('customer.construction.product')->where(['id' => '[0-9]+']);
    Route::get('customer/warranty/check' . config('apps.general.suffix'), [FeCustomerController::class, 'warranty'])->name('customer.check.warranty');
    Route::post('customer/warranty/active', [FeCustomerController::class, 'active'])->name('customer.active.warranty');

    Route::get('customer/order' . config('apps.general.suffix'), [FeCustomerController::class, 'order'])->name('customer.order');
    Route::get('customer/order/{code}' . config('apps.general.suffix'), [FeCustomerController::class, 'orderDetail'])->name('customer.order.detail');
    Route::post('customer/order/{code}/cancel', [FeCustomerController::class, 'cancelOrder'])->name('customer.order.cancel');

//    Route::post('customer/order/{code}/cancel', [CustomerController::class, 'cancelOrder'])->name('customer.order.cancel');?

});

Route::group(['middleware' => ['admin', 'locale', 'backend_default_locale']], function () {
   Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    /* USER */
   Route::group(['prefix' => 'user'], function () {
      Route::get('index', [UserController::class, 'index'])->name('user.index');
      Route::get('create', [UserController::class, 'create'])->name('user.create');
      Route::post('store', [UserController::class, 'store'])->name('user.store');
      Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
      Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update');
      Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
      Route::delete('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy');
   });

    Route::group(['prefix' => 'customer'], function () {
      Route::get('index', [CustomerController::class, 'index'])->name('customer.index');
      Route::get('create', [CustomerController::class, 'create'])->name('customer.create');
      Route::post('store', [CustomerController::class, 'store'])->name('customer.store');
      Route::get('{id}/edit', [CustomerController::class, 'edit'])->where(['id' => '[0-9]+'])->name('customer.edit');
      Route::post('{id}/update', [CustomerController::class, 'update'])->where(['id' => '[0-9]+'])->name('customer.update');
      Route::get('{id}/delete', [CustomerController::class, 'delete'])->where(['id' => '[0-9]+'])->name('customer.delete');
      Route::delete('{id}/destroy', [CustomerController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('customer.destroy');
   });

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

      Route::group(['prefix' => 'agency'], function () {
      Route::get('index', [AgencyController::class, 'index'])->name('agency.index');
      Route::get('create', [AgencyController::class, 'create'])->name('agency.create');
      Route::post('store', [AgencyController::class, 'store'])->name('agency.store');
      Route::get('{id}/edit', [AgencyController::class, 'edit'])->where(['id' => '[0-9]+'])->name('agency.edit');
      Route::post('{id}/update', [AgencyController::class, 'update'])->where(['id' => '[0-9]+'])->name('agency.update');
      Route::get('{id}/delete', [AgencyController::class, 'delete'])->where(['id' => '[0-9]+'])->name('agency.delete');
      Route::delete('{id}/destroy', [AgencyController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('agency.destroy');
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

     Route::group(['prefix' => 'construction'], function () {
      Route::get('index', [ConstructionController::class, 'index'])->name('construction.index');
      Route::get('create', [ConstructionController::class, 'create'])->name('construction.create');
      Route::post('store', [ConstructionController::class, 'store'])->name('construction.store');
      Route::get('{id}/edit', [ConstructionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('construction.edit');
      Route::post('{id}/update', [ConstructionController::class, 'update'])->where(['id' => '[0-9]+'])->name('construction.update');
      Route::get('{id}/delete', [ConstructionController::class, 'delete'])->where(['id' => '[0-9]+'])->name('construction.delete');
      Route::delete('{id}/destroy', [ConstructionController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('construction.destroy');
      Route::get('warranty', [ConstructionController::class, 'warranty'])->name('construction.warranty');
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

   Route::group(['prefix' => 'review'], function () {
      Route::get('index', [ReviewController::class, 'index'])->name('review.index');
      Route::get('{id}/delete', [ReviewController::class, 'delete'])->where(['id' => '[0-9]+'])->name('review.delete');
      
   });

    Route::group(['prefix' => 'report'], function () {
      Route::get('time', [ReportController::class, 'time'])->name('report.time');
   });


   Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');
   Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');
   Route::get('ajax/dashboard/getMenu', [AjaxDashboardController::class, 'getMenu'])->name('ajax.dashboard.getMenu');
   
   Route::get('ajax/dashboard/findPromotionObject', [AjaxDashboardController::class, 'findPromotionObject'])->name('ajax.dashboard.findPromotionObject');
   Route::get('ajax/dashboard/getPromotionConditionValue', [AjaxDashboardController::class, 'getPromotionConditionValue'])->name('ajax.dashboard.getPromotionConditionValue');
   Route::get('ajax/attribute/getAttribute', [AjaxAttributeController::class, 'getAttribute'])->name('ajax.attribute.getAttribute');
   Route::get('ajax/attribute/loadAttribute', [AjaxAttributeController::class, 'loadAttribute'])->name('ajax.attribute.getAttribute');
   Route::post('ajax/menu/createCatalogue', [AjaxMenuController::class, 'createCatalogue'])->name('ajax.menu.createCatalogue');
   Route::post('ajax/menu/drag', [AjaxMenuController::class, 'drag'])->name('ajax.menu.drag');
   Route::post('ajax/menu/deleteMenu', [AjaxMenuController::class, 'deleteMenu'])->name('ajax.menu.deleteMenu');
   Route::post('ajax/slide/order', [AjaxSlideController::class, 'order'])->name('ajax.slide.order');
   Route::get('ajax/product/loadProductPromotion', [AjaxProductController::class, 'loadProductPromotion'])->name('ajax.loadProductPromotion');
   
   Route::get('ajax/source/getAllSource', [AjaxSourceController::class, 'getAllSource'])->name('ajax.getAllSource');
   Route::post('ajax/order/update', [AjaxOrderController::class, 'update'])->name('ajax.order.update');
   Route::get('ajax/order/chart', [AjaxOrderController::class, 'chart'])->name('ajax.order.chart');

   Route::post('ajax/construct/createAgency', [AjaxConstructController::class,'createAgency'])->name('ajax.construct.createAgency');
   Route::post('ajax/construct/createCustomer', [AjaxCustomerController::class,'createCustomer'])->name('ajax.construct.createCustomer');
   Route::post('ajax/product/deleteProduct', [AjaxConstructController::class, 'deleteProduct'])->name('ajax.product.deleteProduct');
   Route::get('ajax/dashboard/findInformationObject', [AjaxDashboardController::class, 'findInformationObject'])->name('ajax.findInformationObject');
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


Route::post('ajax/review/create', [AjaxReviewController::class, 'create'])->name('ajax.review.create');

Route::post('ajax/cart/create', [AjaxCartController::class, 'create'])->name('ajax.cart.create');
Route::post('ajax/cart/update', [AjaxCartController::class, 'update'])->name('ajax.cart.update');
Route::post('ajax/cart/delete', [AjaxCartController::class, 'delete'])->name('ajax.cart.delete');

Route::post('ajax/order/update', [AjaxOrderController::class, 'update'])->name('ajax.order.update');
Route::get('ajax/order/chart', [AjaxOrderController::class, 'chart'])->name('ajax.order.chart');