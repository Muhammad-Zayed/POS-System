<?php

use App\Http\Controllers\Dashboard\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProductController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes For Dashboard
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your Dashboard. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group has prefix (dashboard) and
| name (dashboard.)
|
*/


// mcamara laravel-localization package https://github.com/mcamara/laravel-localization#installation

Route::group([  'prefix' => LaravelLocalization::setLocale(),
                'middleware' => [
                'localeSessionRedirect',
                'localizationRedirect',
                'localeViewPath' ]],
function()
{
    Route::group(['prefix' => 'dashboard'],function()
    {
        Route::get('/',[DashboardController::class , 'index'])->name('index');


        //Users Routes
        Route::resource('users', UserController::class)->except(['show']);

        //Categories Routes
        Route::resource('categories', CategoryController::class)->except(['show']);

        //Products Routes
        Route::resource('products',ProductController::class)->except(['show']);


        //Clients Routes
        Route::resource('clients',ClientController::class)->except(['show']);
        //Orders Routes
        Route::resource('clients.orders',OrderController::class)->except(['show']);
    });
});
