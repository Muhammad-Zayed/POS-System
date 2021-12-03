<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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


        //Users Route 
        Route::resource('users', UserController::class)->except(['show']);

        
    });
});
