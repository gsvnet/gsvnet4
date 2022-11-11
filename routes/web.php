<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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




});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';
