<?php

use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\ForumApiController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
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

/**
 * TODO:
 * - EventController
 * - FilesController
 * - MemberController (not to be confused with Admin\MemberController)
 * - ApiController
 * - PublicFilesController
 * - Admin\EventController
 * - Admin\FilesController
 * - Admin\CommitteeController
 * - Admin\FamilyController
 * - Admin\SenateController
 * - Admin\Committees\MembersController
 * - Admin\Senates\MembersController
 * - Perhaps move forum controller to their own subdirectory
 */

Route::prefix('admin')
    ->middleware(['auth', 'can:member-or-reunist'])
    ->group(function() {
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/ik', [AdminController::class, 'redirectToMyProfile']);

        // Users
        Route::resource('users', UsersController::class);

        Route::prefix('leden')->group(function() {
            // Exporting data to Excel
            Route::get('leden.csv', [UsersController::class, 'exportMembers']);
            Route::get('sic-ontvangers.xlsx', [MemberController::class, 'exportNewspaperRecipients']);

            Route::prefix('{user}')
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

                    // Change membership status
                    Route::get('lidmaatschap',               'editMembershipStatus');
                    Route::post('lidmaatschap/maak-reunist', 'makeReunist');
                    Route::post('lidmaatschap/maak-oud-lid', 'makeExMember');
                    Route::post('lidmaatschap/maak-lid',     'makeMember');

                    // Deleting user data according to GDPR rules
                    Route::get('forget',  'setForget');
                    Route::post('forget', 'forget');
                });
        });
    });

// Forum routes that require authentication
Route::prefix('forum')
    ->middleware(['auth', 'approved'])
    ->group(function() {
        Route::controller(ThreadController::class)
            ->group(function() {
                // Create
                Route::get('nieuw-onderwerp',  'create');
                Route::post('nieuw-onderwerp', 'store');

                // Edit
                Route::get('bewerk-onderwerp/{thread}',  'edit');
                Route::post('bewerk-onderwerp/{thread}', 'update');

                // Destroy
                Route::delete('verwijder-onderwerp/{thread}', 'destroy');
                
                Route::get('prullenbak', 'indexTrashed');

                Route::get('stats', 'statistics');
            });
        
        Route::controller(ReplyController::class)
            ->group(function() {
                // Create
                Route::post('{slug}', 'store');

                // Edit
                Route::get('bewerk-reactie/{reply}',  'edit');
                Route::post('bewerk-reactie/{reply}', 'update');

                // Destroy
                Route::delete('verwijder-reactie/{reply}', 'destroy');
            });

        // Quotes
        Route::get('quote/{reply}', [ForumApiController::class, 'quoteReply']);

        // Likes
        Route::post('replies/{reply}/like', [ForumApiController::class, 'likeReply']);
        Route::delete('replies/{reply}/like', [ForumApiController::class, 'dislikeReply']);
    });

// Preview of converted markdown 
Route::get('preview', ['middleware' => 'auth', 'uses' => 'ForumApiController@preview']);

// Forum index, search, show comment, show thread
Route::get('forum',      [ThreadController::class, 'index']);
Route::get('forum/zoek', [ThreadController::class, 'getSearch']);
Route::get('forum/{slug}', [ThreadController::class, 'show']);

require __DIR__.'/auth.php';
