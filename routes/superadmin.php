<?php

use Illuminate\Support\Facades\Route;


Route::view("/", "superadmin.index")->name("welcome");

Route::get('login', 'AuthController@show_login_form')->name('login');
Route::post('login', 'AuthController@authenticate');

Route::view('register_contractor', 'superadmin.register_contractor')->name("contractors.register");

Route::post('contractors', "ContractorController@store")->name("contractors.store");

Route::group(['middleware' => 'superadminauth'], function () {
    Route::view('dashboard', 'superadmin.dashboard')->name('dashboard');
    Route::post('logout', 'AuthController@logout')->name('logout');

    Route::resource("floorplans", "FloorPlanController");

    Route::resource("contractors", "ContractorController")->except(["store"]);

    Route::resource("products", "ProductController");

    Route::resource("productgroups", "ProductGroupController");

    Route::resource("users", "UserController");
});
