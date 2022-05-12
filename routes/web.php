<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\FeedbackController;

use App\Http\Controllers\TestController;
use App\Http\Controllers\PaymentsController;


use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\Clients\ClientDashboardController;
use App\Http\Controllers\Clients\ClientMessageController;
use App\Http\Controllers\Clients\ClientBookingsController;
use App\Http\Controllers\Clients\ClientPaymentsController;
use App\Http\Controllers\Clients\ClientMyInformationController;

use App\Http\Controllers\Nurses\NurseDashboardController;
use App\Http\Controllers\Nurses\NurseController;
use App\Http\Controllers\Nurses\NursesMyInformationController;
use App\Http\Controllers\Nurses\NursesPaymentsController;
use App\Http\Controllers\Nurses\NursesMessageController;
use App\Http\Controllers\Nurses\NurseBookingController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::prefix('payment')->middleware('auth:sanctum', 'checkClient')->group(function(){
    Route::get('get-stripe-api-token', [PaymentsController::class, 'getStripeApiToken']);
    Route::post('method/store', [PaymentsController::class, 'storePaymentMethod'])->name('payment.store');
    Route::post('method/remove', [PaymentsController::class, 'removePaymentMethod']);
    Route::post('payment-pay', [PaymentsController::class, 'paymentPay']);
    Route::get('payment-methods', [PaymentsController::class, 'getPaymentMethods']);
});




Route::get('/', [MainPageController::class, 'index']);
Route::get('/send-booking-message', [MainPageController::class, 'index']);
Route::get('/get-nurse-profile/{id}', [NurseController::class, 'show'])->middleware(['auth:sanctum', 'checkClient', 'verified']);
Route::get('/nurse/{id}', [MainPageController::class, 'index'])->middleware(['auth:sanctum', 'checkClient', 'verified']);
Route::post('/set-user-rate', [RateController::class, 'setUserRate'])->middleware(['auth:sanctum', 'verified']);
Route::get('/booking/verification/{booking_id}/{client_id}', [BookingController::class, 'clientVerificationBooking']);
Route::get('/dashboard/admin/get-page/{page}', [AdminDashboardController::class, 'getPage']);

Route::get('get-translate', [MainPageController::class, 'getTranslate']);
Route::get('get-translate/{lang}', [MainPageController::class, 'getTranslate']);
Route::post('save-translates', [MainPageController::class, 'saveTranslates'])->middleware(['auth:sanctum', 'checkAdmin']);

Route::resource('/feedback', FeedbackController::class)->middleware(['auth:sanctum']);;

Route::prefix('finder')->middleware(['auth:sanctum', 'checkClient', 'verified'])->group(function () {
    Route::get('/', [MainPageController::class, 'index']);
    Route::get('/get-client-search-info', [ListingController::class, 'getClientSearchInfo']);
    Route::post('/save-client-search-info', [ListingController::class, 'saveClientSearchInfo']);
    Route::post('/get-nurses-to-listing-after-sort', [ListingController::class, 'listingFilterAndSort']);
    Route::post('send-private-message', [ListingController::class, 'sendPrivateMessage']);
    Route::get('get-private-chats/{nurse_id}', [ListingController::class, 'getPrivateChats']);
});

Route::get('/listing/{id}', [ListingController::class, 'getNursesToListing']);
Route::get('/listing', [MainPageController::class, 'index']);

/*
 *booking
 */

Route::resource('booking', BookingController::class)->middleware(['auth:sanctum', 'checkClient', 'verified']);

Route::prefix('dashboard')->group(function () {

    /*
     * admin
     */
    Route::prefix('admin')->middleware(['auth:sanctum', 'checkAdmin'])->group(function () {
        Route::get('/settings', [AdminDashboardController::class, 'index']);
        Route::get('/translation', [AdminDashboardController::class, 'index']);
        //media
        Route::get('/media', [AdminDashboardController::class, 'index']);
        Route::post('/save-media', [AdminDashboardController::class, 'saveMedia']);
        Route::get('/get-media', [AdminDashboardController::class, 'getMedia']);
        Route::post('/delete-media', [AdminDashboardController::class, 'deleteMedia']);
        //pages
        Route::get('/pages', [AdminDashboardController::class, 'index']);
        Route::get('/pages/{page}', [AdminDashboardController::class, 'index']);
        Route::post('/save-page/{page}', [AdminDashboardController::class, 'savePage']);

        Route::get('/nurses', [AdminDashboardController::class, 'index']);
        Route::get('/clients', [AdminDashboardController::class, 'index']);
        Route::get('/get-nurses', [AdminDashboardController::class, 'getNurses']);
        Route::get('/get-clients', [AdminDashboardController::class, 'getClients']);
        Route::post('/approve-nurse', [AdminDashboardController::class, 'approveNurse']);
        Route::post('/dismiss-nurse', [AdminDashboardController::class, 'dismissNurse']);
        //settings
        Route::get('/get-hear-about-us', [AdminDashboardController::class, 'getHearAboutUs']);
        Route::post('/set-hear-about-us', [AdminDashboardController::class, 'setHearAboutUs']);
        Route::get('/remove-hear-about-us/{id}', [AdminDashboardController::class, 'removeHearAboutUs']);
        Route::get('change-hear-about-us-show/{id}', [AdminDashboardController::class, 'changeHearAboutUsShow']);

        Route::get('/get-site-settings', [AdminDashboardController::class, 'getSiteSettings']);
        Route::post('/set-site-settings', [AdminDashboardController::class, 'setSiteSettings']);

        Route::get('/get-type-of-learning', [AdminDashboardController::class, 'getTypeOfLearning']);
        Route::post('/set-type-of-learning', [AdminDashboardController::class, 'setTypeOfLearning']);
        Route::get('/remove-type-of-learning/{id}', [AdminDashboardController::class, 'removeTypeOfLearning']);

        Route::post('/set-time-intervals', [AdminDashboardController::class, 'setTimeIntervals']);
        Route::get('/set-default-time-intervals', [AdminDashboardController::class, 'setDefaultTimeIntervals']);

    });
    Route::resource('admin', AdminDashboardController::class)->middleware(['auth:sanctum', 'checkAdmin']);


    /*
     * client
     */
    Route::prefix('client')->middleware(['auth:sanctum', 'checkClient', 'verified'])->group(function () {
        Route::get('messages', [ClientDashboardController::class, 'index']);
        Route::get('ratings', [ClientDashboardController::class, 'index']);
        Route::get('bookings', [ClientDashboardController::class, 'index']);
        Route::get('bookings/get-private-chats/{nurse_id}', [ClientBookingsController::class, 'getPrivateChat']);
        Route::get('payments', [ClientDashboardController::class, 'index']);
        Route::get('my-information', [ClientDashboardController::class, 'index']);
        Route::get('help-end-service', [ClientDashboardController::class, 'index']);
        Route::get('send-booking-message', [ClientDashboardController::class, 'index']);

    });
    Route::resource('client', ClientDashboardController::class)->middleware(['auth:sanctum', 'checkClient', 'verified']);

    //client payments
    Route::resource('client-payments', ClientPaymentsController::class)->middleware(['auth:sanctum', 'checkClient', 'verified']);

    //client bookings
    Route::prefix('client-bookings')->middleware(['auth:sanctum', 'checkClient', 'verified'])->group(function () {
        Route::get('agree-with-alternative/{id}', [ClientBookingsController::class, 'agreeWithAlternative']);
        Route::get('send-booking-again/{id}', [ClientBookingsController::class, 'sendBookingAgain']);
    });
    Route::resource('client-bookings', ClientBookingsController::class)->middleware(['auth:sanctum', 'checkClient', 'verified']);

    //client my information
    Route::prefix('client-my-information')->middleware(['auth:sanctum', 'checkClient', 'verified'])->group(function () {
        Route::post('{id}', [ClientMyInformationController::class, 'update']);
    });
    Route::resource('client-my-information', ClientMyInformationController::class)->middleware(['auth:sanctum', 'checkClient', 'verified']);

    //client messages
    Route::prefix('client-private-chats')->middleware(['auth:sanctum', 'checkClient', 'verified'])->group(function () {
        Route::post('mark-as-read', [ClientMessageController::class, 'markAsRead']);
    });
    Route::resource('client-private-chats', ClientMessageController::class)->middleware(['auth:sanctum', 'checkClient', 'verified']);


    /*
     * nurse
     */
    Route::prefix('nurse')->middleware(['auth:sanctum', 'checkNurse', 'verified'])->group(function () {
        Route::get('messages', [NurseDashboardController::class, 'index']);
        Route::get('ratings', [NurseDashboardController::class, 'index']);
        Route::get('bookings', [NurseDashboardController::class, 'index']);
        Route::get('bookings/get-private-chats/{client_id}', [NurseBookingController::class, 'getPrivateChat']);
        Route::get('payments', [NurseDashboardController::class, 'index']);
        Route::get('my-information', [NurseDashboardController::class, 'index']);
        Route::get('help-end-service', [NurseDashboardController::class, 'index']);
        Route::post('get-time-calendar', [NurseDashboardController::class, 'getTimeCalendar']);

    });
    Route::resource('nurse', NurseDashboardController::class)->middleware(['auth:sanctum', 'checkNurse', 'verified']);

    //nurse bookings
    Route::prefix('nurse-bookings')->middleware(['auth:sanctum', 'checkNurse', 'verified'])->group(function () {
        Route::post('nurse-refuse-booking', [NurseBookingController::class, 'nurseRefuseBooking']);
    });

    Route::resource('nurse-bookings', NurseBookingController::class)->middleware(['auth:sanctum', 'checkNurse', 'verified']);

    //nurse my information
    Route::prefix('nurse-my-information')->middleware(['auth:sanctum', 'checkNurse', 'verified'])->group(function () {
        Route::post('update-files-and-photo/{id}', [NursesMyInformationController::class, 'updateFilesAndPhoto']);
        Route::post('remove-certificate', [NursesMyInformationController::class, 'removeCertificate']);
    });
    Route::resource('nurse-my-information', NursesMyInformationController::class)->middleware(['auth:sanctum', 'checkNurse', 'verified']);

    //nurse payments
    Route::prefix('nurse-payments')->middleware(['auth:sanctum', 'checkNurse', 'verified'])->group(function () {
    });
    Route::resource('nurse-payments', NursesPaymentsController::class)->middleware(['auth:sanctum', 'checkNurse', 'verified']);

    //nurse message
    Route::prefix('nurse-private-chats')->middleware(['auth:sanctum', 'checkNurse', 'verified'])->group(function () {
        Route::post('mark-as-read', [NursesMessageController::class, 'markAsRead']);
    });

    Route::resource('nurse-private-chats', NursesMessageController::class)->middleware(['auth:sanctum', 'checkNurse', 'verified']);
});


/*
 * Login , register, log out
 *
 */

//Login
Route::get('/login', [LoginController::class, 'logIn'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

//Register
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'registerAndAuthenticate']);

//NurseRegister
//Route::get('/nurse-register', [RegisterController::class, 'nurseRegister']);
Route::post('/nurse-register', [RegisterController::class, 'nurseRegistration']);

//ClientRegister
//Route::get('/client-register', [RegisterController::class, 'clientRegister']);
Route::post('/client-register', [RegisterController::class, 'clientRegistration']);

//Log out
Route::get('/log-out', [LoginController::class, 'logOut']);

/*
 * 404
 */
Route::get('/404', function () {
    return view('404');
});

/*
 * test
 */
Route::get('/test', [TestController::class, 'index']);
Route::post('test/message', [TestController::class, 'testSetMessage'])->middleware('auth:sanctum');

/*
 * Change languages
 */
Route::get('change-lang/{lang}', [MainPageController::class, 'changeLang']);

/*
 * Email verify
 */
Route::get('/email/verify', function () {
    return view('main');
})->middleware('auth:sanctum')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/you-welcome');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/you-welcome', function () {
    return view('main');
});

Route::get('/booking-verify', function () {
    return view('main');
});

Route::get('/booking-not-exists', function () {
    return view('main');
});
