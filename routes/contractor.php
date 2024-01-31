<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::view('/invalid_contractor', '404')->name('invalid');

// Route::get('login', 'AuthController@login')->name('login');
// Route::post('login', 'AuthController@authenticate');

Route::group(["middleware" => "checkContractor"], function () {
    Route::get('/', "HomeController@index")->name('home');

    Route::get('floorplans', "FloorPlanController@index")->name("floorplans.index");
    Route::get('floorplans/{floorplan}', "FloorPlanController@show")->name("floorplans.show");

    Route::get('floorplans/{floorplan}/productgroups', "ProductGroupController@index")->name('productgroups.index');
    Route::get('floorplans/{floorplan}/productgroups/{productgroup}', "ProductGroupController@show")->name('productgroups.show');
    Route::post('floorplans/{floorplan}/items', "ProductGroupController@add_item")->name('items.store');
    Route::post('items/colors', "ProductGroupController@update_items_colors")->name('items.colors.store');
    Route::delete('items/{item}', "ProductGroupController@delete_item")->name('items.destroy');

    Route::get('floorplans/{floorplan}/email/create', 'ExportController@create_email')->name('email.create');
    Route::post('email', 'ExportController@store_email')->name('email.store');

    Route::get('floorplans/{floorplan}/pdf/create', 'ExportController@create_pdf')->name('pdf.create');
    Route::post('pdf', 'ExportController@store_pdf')->name('pdf.store');

    Route::get('forgot-password', "AuthController@show_forgot_password_form")->name('password.request');

    Route::post('forgot-password', "AuthController@forgot_password");

    Route::get('reset-password/{token}', "AuthController@show_reset_password_form")->name('password.reset');

    Route::post('reset-password', "AuthController@reset_password")->name('password.update');

    Route::group(['prefix' => 'admin', 'middleware' => 'customauth', 'namespace' => 'Admin'], function () {
        Route::get("/", "AuthController@welcome")->name("admin.welcome");

        Route::get('dashboard', "AuthController@dashboard")->name("admin.dashboard");

        Route::get('floorplans', "FloorPlanController@index")->name("admin.floorplans.index");
        Route::put('floorplans/{floorplan}/selection', "FloorPlanController@update_selection")->name("admin.floorplans.update_selection");

        Route::get('productgroups', "ProductGroupController@index")->name("admin.productgroups.index");
        Route::put('productgroups/{productgroup}/selection', "ProductGroupController@update_selection")->name("admin.productgroups.update_selection");

        Route::get('customers', "CustomerController@index")->name("admin.customers.index");
        Route::get('customers/{customer}', "CustomerController@show")->name("admin.customers.show");

        Route::get('products', "ProductController@index")->name("admin.products.index");
        Route::put('products/{product}/selection', "ProductController@update_selection")->name("admin.products.update_selection");

        Route::get('thanks', "AuthController@showThanks")->name("admin.thanks");

        Route::get('login', 'AuthController@login')->name('admin.login');
        Route::post('login', 'AuthController@authenticate')->name('admin.login');
        Route::post('logout', 'AuthController@logout')->name('admin.logout');

        // floor plans management
        Route::get('floorplans/list', "FloorPlanController@list_floorplans")->name("admin.floorplans.list");
        Route::get('floorplans/create', "FloorPlanController@create_floorplan")->name("admin.floorplans.create");
        Route::post('floorplans/store', "FloorPlanController@store_floorplan")->name("admin.floorplans.store");
        Route::get('floorplans/edit/{floorplan}', "FloorPlanController@edit_floorplan")->name("admin.floorplans.edit");
        Route::put('floorplans/update/{floorplan}', "FloorPlanController@update_floorplan")->name("admin.floorplans.update");
        Route::delete('floorplans/delete/{floorplan}', "FloorPlanController@destroy_floorplan")->name("admin.floorplans.destroy");

        // product groups management
        Route::get('productgroups/list', "ProductGroupController@list_productgroups")->name("admin.productgroups.list");
        Route::get('productgroups/create', "ProductGroupController@create_productgroup")->name("admin.productgroups.create");
        Route::post('productgroups/store', "ProductGroupController@store_productgroup")->name("admin.productgroups.store");
        Route::get('productgroups/edit/{productgroup}', "ProductGroupController@edit_productgroup")->name("admin.productgroups.edit");
        Route::put('productgroups/update/{productgroup}', "ProductGroupController@update_productgroup")->name("admin.productgroups.update");
        Route::delete('productgroups/delete/{productgroup}', "ProductGroupController@destroy_productgroup")->name("admin.productgroups.destroy");

        // products management
        Route::get('products/list', "ProductController@list_products")->name("admin.products.list");
        Route::get('products/create', "ProductController@create_product")->name("admin.products.create");
        Route::post('products/store', "ProductController@store_product")->name("admin.products.store");
        Route::get('products/edit/{product}', "ProductController@edit_product")->name("admin.products.edit");
        Route::put('products/update/{product}', "ProductController@update_product")->name("admin.products.update");
        Route::delete('products/delete/{product}', "ProductController@destroy_product")->name("admin.products.destroy");

    });
});
