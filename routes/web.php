<?php

use App\Http\Controllers\Admin\MemberController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ForumController;
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


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::prefix('intern')->group(function () {
        Route::get('profiel', [UserController::class, 'showProfile'])
            ->name('showProfile');
        Route::get('profiel/bewerken', [UserController::class, 'editProfile']);
        Route::post('profiel/bewerken', [UserController::class, 'updateProfile'])
            ->name('updateProfile');

        Route::get('sponsorprogramma', [HomeController::class, 'sponsorProgram']);
    });

    // Add a route for creating a new forum post -- Denk nog overzetten naar Post of Thread controller
    Route::get('forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('forum/store', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/{thread}/reply', 'ForumController@storeReply')->name('forum.storeReply');



    Route::get('jaarbundel', [UserController::class, 'showUsers']);

    Route::get('commissies', [AboutController::class, 'showCommittees']);
    Route::get('commissies/{id}', [AboutController::class, 'showCommittee']);

    Route::get('senaten', [AboutController::class, 'showSenates']);
    Route::get('senaten/{id}', [AboutController::class, 'showSenate']);
});


Route::prefix('admin')->group(function() {
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/ik', [AdminController::class, 'redirectToMyProfile']);

    // Users
    Route::resource('users', UsersController::class);

    // Exporting data to Excel
    Route::get('leden/leden.csv', [UsersController::class, 'exportMembers']);

    Route::prefix('leden/{user}')
        ->controller(MemberController::class)
        ->group(function() {
        // Each part of the profile
        Route::get('contact',       'editContactDetails');
        Route::put('contact',       'updateContactDetails');
        Route::get('email',         'editEmail');
        Route::put('email',         'updateEmail');
        Route::get('wachtwoord',    'editPassword');
        Route::put('wachtwoord',    'updatePassword');
        Route::get('geboortedatum', 'editBirthDay');
        Route::put('geboortedatum', 'updateBirthDay');
        Route::get('geslacht',      'editGender');
        Route::put('geslacht',      'updateGender');
        Route::get('jaarverband',   'editYearGroup');
        Route::put('jaarverband',   'updateYearGroup');
        Route::get('naam',          'editName');
        Route::put('naam',          'updateName');
        Route::get('gebruikersnaam','editUsername');
        Route::put('gebruikersnaam','updateUsername');
        Route::get('werk',          'editBusiness');
        Route::put('werk',          'updateBusiness');
        Route::get('foto',          'editPhoto');
        Route::put('foto',          'updatePhoto');
        Route::get('ouders',        'editParentContactDetails');
        Route::put('ouders',        'updateParentContactDetails');
        Route::get('studie',        'editStudy');
        Route::put('studie',        'updateStudy');
        Route::get('regio',         'editRegion');
        Route::put('regio',         'updateRegion');
        Route::get('tijd-van-lidmaatschap', 'editMembershipPeriod');
        Route::put('tijd-van-lidmaatschap', 'updateMembershipPeriod');
        Route::get('in-leven',      'editAlive');
        Route::put('in-leven',      'updateAlive');
        Route::get('sic-ontvangen', 'editNewspaper');
        Route::put('sic-ontvangen', 'updateNewspaper');
    });
});


require __DIR__.'/auth.php';
