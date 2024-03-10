<?php

use Admin\FilesController as AdminFilesController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\Committees\MembersController as CommitteeMembersController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\SenateController;
use App\Http\Controllers\Admin\Senates\MembersController as SenateMembersController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ForumApiController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PublicFilesController;
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
| By and large, there are five route groups:
| - Auth: Allows access to things like GSVdocs and the jaarbundel.
| - Word-lid: Handles potential sign-ups.
| - Admin: Manage files, senates, user profiles, and more.
| - Forum: Manage threads and replies.
| - Miscellaneous: Some loose stuff.
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
        // Profiles
        Route::get('profiel', [UserController::class, 'showProfile'])
            ->name('showProfile');
        Route::get('profiel/bewerken', [UserController::class, 'editProfile']);
        Route::post('profiel/bewerken', [UserController::class, 'updateProfile'])
            ->name('updateProfile');

        // GSVdocs
        Route::get('bestanden', [FilesController::class, 'index']);
        Route::get('bestanden/{file}', [FilesController::class, 'show']);

        // Ads
        Route::get('sponsorprogramma', [HomeController::class, 'sponsorProgram']);
    });

    // TODO: Decide whether all this should be locked by auth or public
    Route::get('jaarbundel', [UserController::class, 'showUsers']);
    Route::get('jaarbundel/{user}', [UserController::class, 'showUser']);
    
    Route::get('commissies', [AboutController::class, 'showCommittees']);
    Route::get('commissies/{id}', [AboutController::class, 'showCommittee']);

    Route::get('senaten', [AboutController::class, 'showSenates']);
    Route::get('senaten/{senate}', [AboutController::class, 'showSenate']);

    Route::get('gebruikers/{profile}/{type?}', [MemberController::class, 'showPhoto']);
});

Route::prefix('word-lid')
    ->controller(MemberController::class)
    ->group(function() {
        Route::get('/',             'index');
        Route::get('inschrijven',   'becomeMember');
        Route::post('inschrijven',  'store');
    });

Route::prefix('admin')
    ->middleware(['auth', 'can:member-or-reunist'])
    ->group(function() {
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/ik', [AdminController::class, 'redirectToMyProfile']);

        // Events
        Route::resource('events', AdminEventController::class);

        // Files
        Route::resource('files', AdminFilesController::class)->except(['create']);

        // Committees
        Route::resource('committees', CommitteeController::class)->except(['create']);
        // Manages memberships
        Route::resource('committees.members', CommitteeMembersController::class)
            ->except(['index', 'create', 'show']);

        // Senates
        Route::resource('senates', SenateController::class)->except(['create']);
        // Manages memberships
        Route::resource('senates.members', SenateMembersController::class)
            ->only(['store', 'destroy']);

        // Family
        Route::get('family/{user}', [FamilyController::class, 'show']);
        Route::post('family/{user}', [FamilyController::class, 'store']);

        // Users
        Route::resource('users', UsersController::class);

        Route::prefix('gebruikers')
            ->controller(UsersController::class)
            ->group(function() {
                Route::post('{user}/activeren',      'activate');
                Route::post('{user}/accepteer-lid',  'accept');
                Route::post('{user}/profiel/create', 'storeProfile');
                Route::put('{user}/profiel',         'updateProfile');
                Route::delete('{user}/profiel',      'destroyProfile');
        
                Route::get('gasten',     'showGuests');
                Route::get('novieten',   'showPotentials');
                Route::get('leden',      'showMembers');
                Route::get('oud-leden',  'showFormerMembers');
            });

        Route::prefix('leden')->group(function() {
            // Exporting data to Excel
            Route::get('leden.csv', [UsersController::class, 'exportMembers']);
            Route::get('sic-ontvangers.xlsx', [MemberController::class, 'exportNewspaperRecipients']);

            // List of profile modifications
            Route::get('updates', [MemberController::class, 'latestUpdates']);

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

// Public API, for instance for gsvgroningen.nl
Route::prefix('api')
    ->middleware('cors')
    ->group(function() {
        Route::get('events', [ApiController::class, 'events']);
    });

Route::get('privacy-statement', [PublicFilesController::class, 'showPrivacyStatement']);

require __DIR__.'/auth.php';
