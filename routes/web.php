<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| We will put everything in the forum subdomain.
|
*/

$rootDomain = preg_replace('/https?:\/\//', '', env('APP_URL'));

Route::domain('forum.'.$rootDomain)->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware('auth')->group(function () {

        Route::prefix('intern')->group(function () {
            Route::get('profiel', [UserController::class, 'showProfile'])
                ->name('showProfile');
            Route::get('profiel/bewerken', [UserController::class, 'editProfile']);
            Route::post('profiel/bewerken', [UserController::class, 'updateProfile'])
                ->name('updateProfile');
    
            Route::get('sponsorprogramma', [HomeController::class, 'sponsorProgram']);
        });
    
    
    
        Route::get('jaarbundel', [UserController::class, 'showUsers']);
        
        Route::get('commissies', [AboutController::class, 'showCommittees']);
        Route::get('commissies/{id}', [AboutController::class, 'showCommittee']);
    
        Route::get('senaten', [AboutController::class, 'showSenates']);
        Route::get('senaten/{id}', [AboutController::class, 'showSenate']);
    });
    
    
    Route::prefix('admin')  
            ->middleware(['auth','can:memberOrReunist,App\Models\User'])
            ->group(function() {
        
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/ik', [AdminController::class, 'redirectToMyProfile']);

        // Users
        Route::resource('gebruikers', UsersController::class);
    });
    
    
    
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');
});


require __DIR__.'/auth.php';
