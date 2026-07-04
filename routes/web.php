<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FounderProfileController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CvTrashSettingsController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AboutController;

// 1) Root — redirect "/" to the current locale's home
Route::get('/', [HomeController::class, 'index'])->name('root.redirect');

// 2) Language switcher (no locale prefix here)
Route::get('/switch-language/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');

// Google OAuth (non-localized callback; uses session locale)
Route::middleware(['web', 'App\Http\Middleware\SetLocale'])->group(function () {
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

// 3) All localized routes
Route::group([
    'prefix' => '{lang}',
    'where' => ['lang' => 'en|ar|ur'],
    'middleware' => ['web', 'App\Http\Middleware\SetLocale'],
    'as'         => 'localized.',
], function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about-tfc', [AboutController::class, 'aboutTfc'])->name('about-tfc');
    
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send');
    Route::get('/founder-profile', [FounderProfileController::class, 'index'])->name('founder-profile');
    Route::get('/jobs', [\App\Http\Controllers\JobsController::class, 'index'])->name('jobs');

    // CV Builder Routes
    Route::get('/cv', [\App\Http\Controllers\CvController::class, 'index'])->name('cv.gallery');
    Route::get('/cv/create/{slug}', [\App\Http\Controllers\CvController::class, 'builder'])->name('cv.builder');
    
    // CV routes that require authentication
    Route::middleware('auth')->group(function () {
    Route::get('/cv/projects', [\App\Http\Controllers\CvController::class, 'projects'])->name('cv.projects');
    Route::get('/cv/trash', [\App\Http\Controllers\CvController::class, 'trash'])->name('cv.trash');
    Route::post('/cv/trash/{id}/restore', [\App\Http\Controllers\CvController::class, 'restoreTrashedCv'])->name('cv.trash.restore');
    Route::delete('/cv/trash/{id}', [\App\Http\Controllers\CvController::class, 'forceDeleteTrashedCv'])->name('cv.trash.force');
    Route::post('/cv/save', [\App\Http\Controllers\CvController::class, 'save'])->name('cv.save');
    Route::get('/cv/saved', [\App\Http\Controllers\CvController::class, 'getSavedCVs'])->name('cv.saved');
    Route::get('/cv/load/{id}', [\App\Http\Controllers\CvController::class, 'loadCV'])->name('cv.load');
    Route::post('/cv/import/upload', [\App\Http\Controllers\CvController::class, 'importUpload'])->name('cv.import.upload');
    Route::post('/cv/import/{importId}/extract', [\App\Http\Controllers\CvController::class, 'importExtract'])->name('cv.import.extract');
    Route::post('/cv/import/{importId}/parse', [\App\Http\Controllers\CvController::class, 'importParse'])->name('cv.import.parse');
    Route::post('/cv/{id}/title', [\App\Http\Controllers\CvController::class, 'updateTitle'])->name('cv.updateTitle');
    Route::post('/cv/{id}/duplicate', [\App\Http\Controllers\CvController::class, 'duplicateSaved'])->name('cv.duplicate');
    Route::delete('/cv/{id}/permanent', [\App\Http\Controllers\CvController::class, 'permanentDeleteSaved'])->name('cv.permanent');
    Route::delete('/cv/{id}', [\App\Http\Controllers\CvController::class, 'deleteSaved'])->name('cv.delete');
    Route::get('/cv/preview/{id}', [\App\Http\Controllers\CvController::class, 'previewSaved'])->name('cv.preview');
    Route::get('/cv/export/{id}/pdf', [\App\Http\Controllers\CvController::class, 'exportPDF'])->name('cv.export.pdf');
    Route::post('/cv/export/{slug}/pdf', [\App\Http\Controllers\CvController::class, 'exportCurrentPDF'])->name('cv.export.current.pdf');
    Route::get('/cv/export/{id}/png', [\App\Http\Controllers\CvController::class, 'exportPNG'])->name('cv.export.png');
    Route::post('/cv/export/{slug}/png', [\App\Http\Controllers\CvController::class, 'exportCurrentPNG'])->name('cv.export.current.png');
    });

    //Blogs
    Route::get('/blogs', [BlogsController::class, 'index'])->name('blogs');
    Route::get('/blogs/category/{slug}', [BlogsController::class, 'category'])->name('blogs.by-category');
    Route::get('/blog/{slug}', [BlogsController::class, 'blogDetails'])->name('blog-details');
    Route::get('/books', [\App\Http\Controllers\BooksController::class, 'index'])->name('books');

    //subscribe
    Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

    //services 
    Route::get('/services', [ServiceController::class, 'index'])->name('services');

    // like and comment
    Route::post('/blog/{blog}/comments', [BlogsController::class, 'comment'])->name('blog.comment');
    Route::post('/blog/{blog}/like', [BlogsController::class, 'like'])->name('blog.like');

    //user login and register routes - only accessible to guests (not logged in)
    Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
        // Login POST route with rate limiting: 5 attempts per minute
        // Uses custom throttle middleware that redirects to login page instead of showing 429 error
        Route::post('/login', [UserController::class, 'login'])->middleware('throttle.login:5,1');
    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [UserController::class, 'register']);
        
        // Password reset routes
        // Show forgot password form
        Route::get('/password/reset', [UserController::class, 'showForgotPasswordForm'])->name('password.request');
        // Send password reset link via email
        Route::post('/password/email', [UserController::class, 'sendResetLink'])->name('password.email');
        // Show password reset form (with token from email)
        Route::get('/password/reset/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
        // Process password reset
        Route::post('/password/reset', [UserController::class, 'reset'])->name('password.update');
    });
    
    // Logout route - requires authentication
    Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

    
    //profile routes - protected with auth middleware
    Route::middleware('auth')->group(function () {
    Route::get('/profile/published-blogs', [ProfileController::class, 'showPublicProfile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile-edit');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile-update');
    Route::get('/profile/request-blogs', [BlogController::class, 'requestBlogs'])->name('profile-request-blogs');
    Route::get('/profile/draft-blogs', [BlogController::class, 'draftBlogs'])->name('profile-draft-blogs');
    Route::get('/profile/rejected-blogs', [BlogsController::class, 'rejectedBlogs'])->name('profile-rejected-blogs');
    Route::get('/create-blog', [BlogController::class, 'create'])->name('blog-create');
    });

    // show blogs of user whose profile is cliked
    // Route::get('user-blogs/{id}', [BlogController::class, 'userBlogs'])->name('user-blogs');
    Route::get('user-profile/{id}', [ProfileController::class, 'userProfile'])->name('user-profile');
   


   // Admin protected routes - require authentication
    Route::group([
        'prefix' => 'admin',
        'middleware' => ['web', 'App\Http\Middleware\SetLocale', 'auth'],
        'as' => 'admin.',
    ], function () {

        //DASHBOARD only accessable after login
       Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');   
       
        //blogs admin routes
        Route::get('/create', [BlogController::class, 'create'])->name('blog-create'); 
        Route::get('/blog', [BlogController::class, 'showBlog'])->name('blog'); 
        Route::get('/blog/request', [BlogController::class, 'requestBlogs'])->name('request-blogs');  
        Route::post('/blog', [BlogController::class, 'store'])->name('blog.store'); 
        Route::get('/blog/{blog}/edit', [BlogController::class, 'editBlog'])->name('blog.edit'); 
        Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update'); 
        Route::delete('/blog/{id}', [BlogController::class, 'delete'])->name('blog.destroy'); 
        Route::post('ckeditor/upload/', [CKEditorController::class, 'uploadImage'])->name('ckeditor.upload');
        Route::post('/blog/{blog}/approve', [BlogController::class, 'approveBlog'])->name('blog.approve');
        Route::post('/blog/{blog}/reject', [BlogController::class, 'rejectBlog'])->name('blog.reject');
        Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile-update');

        // categories routes
        Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

        // CV Templates admin routes
        Route::get('/cv-templates', [\App\Http\Controllers\Admin\CVTemplateController::class, 'index'])->name('cv-templates.index');
        Route::get('/cv-templates/create', [\App\Http\Controllers\Admin\CVTemplateController::class, 'create'])->name('cv-templates.create');
        Route::post('/cv-templates', [\App\Http\Controllers\Admin\CVTemplateController::class, 'store'])->name('cv-templates.store');
        Route::get('/cv-templates/{cvTemplate}/edit', [\App\Http\Controllers\Admin\CVTemplateController::class, 'edit'])->name('cv-templates.edit');
        Route::put('/cv-templates/{cvTemplate}', [\App\Http\Controllers\Admin\CVTemplateController::class, 'update'])->name('cv-templates.update');
        Route::delete('/cv-templates/{cvTemplate}', [\App\Http\Controllers\Admin\CVTemplateController::class, 'destroy'])->name('cv-templates.destroy');
        Route::post('/cv-templates/{cvTemplate}/toggle', [\App\Http\Controllers\Admin\CVTemplateController::class, 'toggleActive'])->name('cv-templates.toggle');

        Route::get('/settings', [SiteSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SiteSettingsController::class, 'update'])->name('settings.update');

        Route::get('/cv-trash-settings', [CvTrashSettingsController::class, 'edit'])->name('cv-trash-settings.edit');
        Route::put('/cv-trash-settings', [CvTrashSettingsController::class, 'update'])->name('cv-trash-settings.update');

        // Founder section routes
        Route::prefix('founder')->name('founder.')->group(function () {
            // Experiences routes
            Route::get('/experiences', [\App\Http\Controllers\Admin\FounderController::class, 'experiencesIndex'])->name('experiences.index');
            Route::get('/experiences/create', [\App\Http\Controllers\Admin\FounderController::class, 'experiencesCreate'])->name('experiences.create');
            Route::post('/experiences', [\App\Http\Controllers\Admin\FounderController::class, 'experiencesStore'])->name('experiences.store');
            Route::get('/experiences/{id}/edit', [\App\Http\Controllers\Admin\FounderController::class, 'experiencesEdit'])->name('experiences.edit');
            Route::put('/experiences/{id}', [\App\Http\Controllers\Admin\FounderController::class, 'experiencesUpdate'])->name('experiences.update');
            Route::delete('/experiences/{id}', [\App\Http\Controllers\Admin\FounderController::class, 'experiencesDestroy'])->name('experiences.destroy');
            Route::post('/experiences/{id}/remove-media', [\App\Http\Controllers\Admin\FounderController::class, 'experiencesRemoveMedia'])->name('experiences.removeMedia');
            
            // Skills routes (placeholder for future implementation)
            Route::get('/skills', [\App\Http\Controllers\Admin\FounderController::class, 'skillsIndex'])->name('skills.index');
            Route::get('/skills/create', [\App\Http\Controllers\Admin\FounderController::class, 'skillsCreate'])->name('skills.create');
            Route::post('/skills', [\App\Http\Controllers\Admin\FounderController::class, 'skillsStore'])->name('skills.store');
            Route::get('/skills/{id}/edit', [\App\Http\Controllers\Admin\FounderController::class, 'skillsEdit'])->name('skills.edit');
            Route::put('/skills/{id}', [\App\Http\Controllers\Admin\FounderController::class, 'skillsUpdate'])->name('skills.update');
            Route::delete('/skills/{id}', [\App\Http\Controllers\Admin\FounderController::class, 'skillsDestroy'])->name('skills.destroy');
        });

       
    });
    
});
