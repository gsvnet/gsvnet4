<?php

use App\Http\Controllers\Admin\MemberController;
use App\Models\User;
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
*/


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

        Route::get('/default-topic', function () {
            return view('forum.index');
        });

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

    Route::prefix('leden')
        ->controller(MemberController::class)
        ->group(function() {
            Route::get('sic-ontvangers.xlsx', 'exportNewspaperRecipients');
        });
});

Route::prefix('forum')
    ->middleware(['auth', 'approved'])
    ->group(function() {
        // TODO: Add all forum routes
    });


require __DIR__.'/auth.php';
