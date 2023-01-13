<?php

use App\Http\Controllers\CompanyAdminController;
use App\User;

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

Auth::routes();

Route::get('/delete-user/{email}', function ($email) {
    $user = User::where('email', $email)->first();
    if ($user) {
        $user->forceDelete();
    }

    return redirect()->route('main');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth:company,web'])->prefix('admin')->group(function () {
    Route::get('/', 'CompanyAdminController@index');
    Route::get('/opportunities', 'CompanyAdminController@opportunities')->name('opportunities');
    Route::get('/opportunity/create', 'CompanyAdminController@create')->name('createOpportunity');
    Route::get('/opportunity/create/{id}', 'CompanyAdminController@createOpportunity')->name('create-new-opportunity');
    Route::post('/opportunity/store', 'CompanyAdminController@storeNew');
    Route::post('/opportunity/storeDraft', 'CompanyAdminController@storeDraft');
    Route::post('/opportunity/showPreview', 'CompanyAdminController@showPreview');
    Route::get('/opportunity/show/{id}', 'CompanyAdminController@show');
    Route::get('/opportunity/edit/{id}', 'CompanyAdminController@edit');
    Route::post('/opportunity/update/{id}', 'CompanyAdminController@update');
    Route::post('/opportunity/updateMedia/{id}', 'CompanyAdminController@uploadMediaFiles');
    Route::post('/opportunity/delete/', 'CompanyAdminController@destroy');
    Route::get('/opportunity/media/{id}', 'CompanyAdminController@media');
    Route::post('/opportunity/media/delete', 'CompanyAdminController@deleteMedia');
    Route::post('/opportunity/changeStatus', 'CompanyAdminController@changeStatus');
    Route::post('/opportunity/deleteFeedback', 'CompanyAdminController@deleteFeedback');
    Route::post('/opportunity/uploadImage', 'CompanyAdminController@uploadImage');

    Route::get('/profile', 'CompanyAdminController@companyProfile')->name('company-profile');
    Route::patch('/update-company', 'CompanyAdminController@updateCompany');

    Route::get('/opportunity/{oid}/attended-user/{uid}', 'CompanyAdminController@attendedUser');
    Route::get('/opportunity/{oid}/unattended-user/{uid}', 'CompanyAdminController@unattendedUser');

    Route::get('/opportunities/search', 'CompanyAdminController@searchOpportunities');

    Route::post('/update-company-cover', 'CompanyAdminController@updateCover');
});


Route::get('/test-mail', 'MainController@testMail')->name('testMail');

//New pages
Route::get('/abilities', 'AbilityController@abilities')->name('abilities');
Route::get('/library', 'LibraryController@index')->name('library');
Route::get('/library-in', 'LibraryController@in')->name('library_in');
Route::get('/get-literatures-by-category', 'LibraryController@getLibraryByCartegory')->name('getLiteraturesByCat');

Route::get('/add-library', 'LibraryController@addLibrary')->name('AddLibrary')->middleware('auth:web,company');
Route::post('/store-library', 'LibraryController@storeLibrary')->name('StoreLibrary')->middleware('auth:web,company');
Route::post('/store-research', 'LibraryController@StoreResearch')->name('StoreResearch')->middleware('auth:web,company');
Route::post('/store-study-cabinet', 'LibraryController@StoreStudyCabinet')->name('StoreStudyCabinet')->middleware('auth:web,company');

Route::post('/subscribe', 'SubsriberController@subscribe')->name('subscribe');
Route::get('/unsubscribe/{token}', 'SubsriberController@unsubscribe')->name('unsubscribe');
//

Route::post('/review', 'ReviewController@store')->name('review');

Route::get('/', 'MainController@index')->name('main');

Route::get('/about', 'AboutUsController@loadPage')->name('about');

Route::get('/contact', 'ContactController@loadPage')->name('contact');

Route::get('/search', 'SearchController@search')->name('search');

Route::get('/event/{id}', 'OpportunityController@innerRedirect') -> name('opportunity');
Route::get('/e/{id}', 'OpportunityController@innerRedirect');
Route::get('/event/{id}/{name}', 'OpportunityController@inner');
Route::get('/e/{id}/{name}', 'OpportunityController@inner');

Route::get('/events', 'OpportunityController@all')->name('events');

Route::get('/subscribed-events', 'OpportunityController@userOpportunities')->middleware('auth:web,company');

Route::get('/login', 'LoginController@loginPage')->name('login');

Route::get('/logout', 'LoginController@logout')->name('logout');

Route::post('/post-login', 'LoginController@login');

Route::get('/organization/{id}', 'CompanyController@innerRedirect') -> name('organization');
Route::get('/o/{id}', 'CompanyController@innerRedirect');
Route::get('/organization/{id}/{name}', 'CompanyController@inner');
Route::get('/o/{id}/{name}', 'CompanyController@inner');

Route::get('/user-registration', 'RegistrationController@userRegistration')->name('user-registration');

Route::get('/user-worker-registration', 'RegistrationController@userWorkerRegistration')->name('user-worker-registration');

Route::get('/org-registration', 'RegistrationController@companyRegistration')->name('org-registration');

Route::post('/register-user', 'RegistrationController@registerUser')->name('userRegistration');

Route::post('/register-young-worker', 'RegistrationController@registerYoungWorker')->name('youngWorkerRegistration');

Route::post('/register-company', 'RegistrationController@registerCompanyTMP');

Route::post('/ajax-send-code', 'RegistrationController@sendCode');
Route::post('/ajax-check-code', 'RegistrationController@checkCode');
Route::post('/ajax-check-email', 'RegistrationController@validateEmail');
Route::post('/ajax-check-private-number', 'RegistrationController@validatePrivateNumber');
Route::post('/ajax-check-registration-number', 'RegistrationController@validateRegistrationNumber');
Route::post('/ajax-check-phone-number', 'RegistrationController@validatePhoneNumber');

Route::get('/profile', 'UserController@profilePage')->name('profile')->middleware('auth:web,company');

Route::post('/update-profile-picture', 'UserController@updatePicture')->middleware('auth:web,company');

Route::post('/edit-user-info', 'UserController@editUserInfo')->middleware('auth:web');

Route::post('/edit-user-info-disabilities', 'UserController@editUserInfoDisabilities')->middleware('auth:web');

Route::post('/edit-user-info-occupations', 'UserController@editUserInfoOccupations')->middleware('auth:web');

Route::post('/edit-user-info-education', 'UserController@editUserInfoEducation')->middleware('auth:web');

Route::post('/edit-user-info-residence', 'UserController@editUserInfoResidence')->middleware('auth:web');

Route::post('/edit-user-password', 'UserController@editUserPassword')->middleware('auth:web,company');

Route::post('/unsubscribe-company', 'SubscriptionController@unsubscribeToCompany');

Route::post('/subscribe-company', 'SubscriptionController@subscribeToCompany');

Route::post('/unsubscribe-category', 'SubscriptionController@unsubscribeToCategory');

Route::post('/subscribe-category', 'SubscriptionController@subscribeToCategory');

Route::post('/ajax-filter-opportunities', 'OpportunityController@filterOpportunities');

Route::post('/ajax-filter-companies', 'CompanyController@filterCompanies');

Route::get('/category/{id}', 'CategoryController@category');

Route::get('/login/social/{driver}', 'LoginController@redirectToProvider');
Route::get('/login/social/{driver}/callback', 'LoginController@handleProviderCallback');

Route::get('password-reset/email-form', 'PasswordResetController@showEmailForm')->name('reset-email-form');
Route::get('password-reset/reset-form/{token}', 'PasswordResetController@showResetForm')->name('reset-form');

Route::post('password-reset/email', 'PasswordResetController@requestPasswordReset');
Route::post('password-reset/reset', 'PasswordResetController@resetPassword');

Route::get('/query/{opportunity_id}/{user_id}', 'QueryController@loadQuery');
Route::post('/query/{opportunity_id}', 'QueryController@saveQuery');

// favorites

Route::post('/ajax-add-opportunity-to-favorites', 'OpportunityController@addToFavorites')->middleware('auth:web,company');

Route::post('/ajax-remove-opportunity-from-favorites', 'OpportunityController@removeFromFavorites')->middleware('auth:web,company');

Route::post('/ajax-is-opportunity-favorite', 'OpportunityController@isFavorite')->middleware('auth:web,company');

// going

Route::post('/ajax-add-opportunity-to-going', 'OpportunityController@addToGoings')->middleware('auth:web,company');

Route::post('/ajax-remove-opportunity-from-going', 'OpportunityController@removeFromGoings')->middleware('auth:web,company');

Route::post('/ajax-is-opportunity-going', 'OpportunityController@isGoing')->middleware('auth:web,company');

// feedback

Route::post('/ajax-like-query-message', 'UserController@likeFeedback')->middleware('auth:web');

Route::get('/ajax-load-more-messages', 'OpportunityController@paginateFeedback');

// paginate,ajax
//Route::post('/ajax-opportunity-feedback-paginate', 'OpportunityController@paginateFeedback');

Route::post('/opportunity/comment/store', 'OpportunityCommentController@store');
Route::post('/opportunity/comment/update/{id}', 'OpportunityCommentController@update');
Route::post('/opportunity/comment/delete', 'OpportunityCommentController@destroy');
Route::post('/opportunity/comment/like', 'OpportunityCommentController@like');
Route::post('/ajax-opportunity-comment-paginate', 'OpportunityController@paginateComments');


// profile

Route::get('/ajax-load-more-goings', 'UserController@paginateGoingOpportunities');
Route::get('/ajax-load-more-favorites', 'UserController@paginateFavoriteOpportunities');
Route::get('/ajax-load-more-finished', 'UserController@paginateFinishedOpportunities');
Route::get('/ajax-load-more-subscribed-companies', 'UserController@paginateSubscribedCompanies');
Route::get('/ajax-load-more-subscribed-categories', 'UserController@paginateSubscribedCategories');

Route::get('/test-company-filter', 'CompanyController@filter');

Route::get('/organizations', 'CompanyController@all');

Route::post('/ajax-organization-feedback-paginate', 'CompanyController@paginateFeedbacks');

Route::post('/ck-upload-image', 'CKEditorUploadController@uploadImage');

Route::post('/set-cover-ajax', 'CompanyAdminController@setCover');
Route::post('/set-profile-ajax', 'CompanyAdminController@setProfile');
