<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\DashboardController;

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

    //Blogs
    Route::get('/blogs', [BlogsController::class, 'blog'])->name('blogs');
    Route::get('/blogs-details/{blog}', [BlogsController::class, 'blogDetails'])->name('blog-details');

    // like and comment
    Route::post('/blog/{blog}/comments', [BlogsController::class, 'comment'])->name('blog.comment');
    Route::post('/blog/{blog}/like', [BlogsController::class, 'like'])->name('blog.like');

    //user login and register routes
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    
    //profile routes
    Route::get('/profile/published-blogs', [ProfileController::class, 'showPublicProfile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile-edit');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile-update');
    Route::get('/profile/request-blogs', [BlogController::class, 'requestBlogs'])->name('profile-request-blogs');
    Route::get('/profile/draft-blogs', [BlogController::class, 'draftBlogs'])->name('profile-draft-blogs');
    Route::get('/profile/rejected-blogs', [BlogController::class, 'rejectedBlogs'])->name('profile-rejected-blogs');
    Route::get('/create-blog', [BlogController::class, 'create'])->name('blog-create');

    // show blogs of user whose profile is cliked
    Route::get('user-blogs/{id}', [BlogController::class, 'userBlogs'])->name('user-blogs');
    Route::get('user-profile/{id}', [ProfileController::class, 'userProfile'])->name('user-profile');
   


   // Admin protected routes
    Route::group([
        'prefix' => 'admin',
        'middleware' => ['web', 'App\Http\Middleware\SetLocale'],
    ], function () {

        //DASHBOARD only accessable after login
       Route::get('/dashboard', [DashboardController::class,'index'])->name('admin.dashboard');   
       
        //blogs admin routes
        Route::get('/create', [BlogController::class, 'create'])->name('admin.blog-create'); 
        Route::get('/blog', [BlogController::class, 'showBlog'])->name('admin.blog'); 
        Route::get('/blog/request', [BlogController::class, 'requestBlogs'])->name('admin.request-blogs');  
        Route::post('/blog', [BlogController::class, 'store'])->name('admin.blog.store'); 
        Route::get('/blog/{blog}/edit', [BlogController::class, 'editBlog'])->name('admin.blog.edit'); 
        Route::put('/blog/{id}', [BlogController::class, 'update'])->name('admin.blog.update'); 
        Route::delete('/blog/{id}', [BlogController::class, 'delete'])->name('admin.blog.destroy'); 
        Route::post('ckeditor/upload/', [CKEditorController::class, 'uploadImage'])->name('admin.ckeditor.upload');
        Route::post('/blog/{blog}/approve', [BlogController::class, 'approveBlog'])->name('admin.blog.approve');
        Route::post('/blog/{blog}/reject', [BlogController::class, 'rejectBlog'])->name('admin.blog.reject');
        Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('admin.profile');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile-update');
       
    });
    
});
