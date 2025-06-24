<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\UserController;

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

    //courses
    Route::get('/blogs', [BlogsController::class, 'index'])->name('blogs');
    Route::get('/blogs-details', [BlogsController::class, 'blogDetails'])->name('blog-details');

    //user login and register routes
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');


   // Admin protected routes
    Route::group([
        'prefix' => 'admin',
        'middleware' => ['web', 'App\Http\Middleware\SetLocale'],
    ], function () {

        //DASHBOARD only accessable after login
       // Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');     
       
    });
    
});
