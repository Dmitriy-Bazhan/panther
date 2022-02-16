<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\TestController;

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
| nurse - медсестра
*/

Route::get('/', [MainPageController::class, 'index']);

/*
 * admin
 *
 */
Route::prefix('admin')->middleware(['auth:sanctum','checkAdmin'])->group(function(){
        Route::get('/', function (){
            dd('admin');
        });
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
Route::post('/nurse-register', [RegisterController::class, 'registerAndAuthenticateNurse']);

//ClientRegister
Route::get('/client-register', [RegisterController::class, 'clientRegister']);
Route::post('/client-register', [RegisterController::class, 'registerAndAuthenticateClient']);

//Log out
Route::get('/log-out', [LoginController::class, 'logOut']);

Route::get('/test', [TestController::class, 'index']);
