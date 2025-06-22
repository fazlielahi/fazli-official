<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;

// 1) Root — redirect "/" to the current locale's home
    Route::get('/', [HomeController::class, 'index'])->name('root.redirect');

// 2) Language switcher (no locale prefix here)
Route::get('/switch-language/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');

// 3) All localized routes
Route::group([
    'prefix' => '{lang}',
    'where' => ['lang' => 'en|ar'],
    'middleware' => ['web', 'App\Http\Middleware\SetLocale'],
    'as'         => 'localized.', 
], function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/about', [AboutController::class, 'index'])->name('about');

   // Admin protected routes
    Route::group([
        'prefix' => 'admin',
        'middleware' => ['web', 'App\Http\Middleware\SetLocale'],
    ], function () {

        //DASHBOARD only accessable after login
       // Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');     
       
    });
    
});
