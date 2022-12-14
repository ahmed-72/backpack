<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('order', 'OrderCrudController');
    Route::crud('vendor', 'VendorCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('product-option', 'ProductOptionCrudController');
    Route::crud('discount', 'DiscountCrudController');
    Route::crud('invitation-card', 'InvitationCardCrudController');
    Route::crud('card-theme', 'CardThemeCrudController');
    Route::crud('flexible-invitation', 'FlexibleInvitationCrudController');
    Route::crud('fixed-invitation', 'FixedInvitationCrudController');
    Route::crud('order-product', 'OrderProductCrudController');
    Route::crud('order-product-option', 'OrderProductOptionCrudController');
}); // this should be the absolute last line of this file