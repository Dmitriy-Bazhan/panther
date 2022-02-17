<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Clients\ClientDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Nurses\NurseDashboardController;
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
| nurse - медсестра
*/

Route::get('/', [MainPageController::class, 'index']);

Route::prefix('dashboard')->group(function () {

    /*
     * admin
     */
    Route::prefix('admin')->middleware(['auth:sanctum', 'checkAdmin'])->group(function () {

    });
    Route::resource('admin', AdminDashboardController::class)->middleware(['auth:sanctum', 'checkAdmin']);


    /*
     * client
     */
    Route::prefix('client')->middleware(['auth:sanctum', 'checkClient', 'verified'])->group(function () {

    });
    Route::resource('client', ClientDashboardController::class)->middleware(['auth:sanctum', 'checkClient', 'verified']);


    /*
     * nurse
     */
    Route::prefix('nurse')->middleware(['auth:sanctum', 'checkNurse', 'verified'])->group(function () {

    });
    Route::resource('nurse', NurseDashboardController::class)->middleware(['auth:sanctum', 'checkNurse', 'verified']);
});


/*
 * Login , register, log out
 *
 */
Route::middleware('auth:sanctum')->get('/get-auth', [MainPageController::class, 'getAuth']);

//Login
Route::get('/login', [LoginController::class, 'logIn'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

//Register
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'registerAndAuthenticate']);

//NurseRegister
Route::get('/nurse-register', [RegisterController::class, 'nurseRegister']);
Route::post('/nurse-register', [RegisterController::class, 'nurseRegistration']);

//ClientRegister
Route::get('/client-register', [RegisterController::class, 'clientRegister']);
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

Route::get('change-lang', [MainPageController::class, 'changeLang']);


Route::get('/email/verify', function () {
    return view('main');
})->middleware('auth:sanctum')->name('verification.notice');



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/you-welcome');

//    if(auth()->user()->is_client){
//        return redirect('/dashboard/client');
//    }
//
//    if(auth()->user()->is_nurse){
//        return redirect('/dashboard/nurse');
//    }


})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/you-welcome', function (){
    return view('main');
});
