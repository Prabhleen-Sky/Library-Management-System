<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Facade;
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

Route::get('/register', [SignUpController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [SignUpController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::get('/test-mongodb-connection', function () {
    try {
        DB::connection('mongodb')->getPdo();
        return "Connected to MongoDB!";
    } catch (\Exception $e) {
        return "Unable to connect to MongoDB. Error: " . $e->getMessage();
    }
});
