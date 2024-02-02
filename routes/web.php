<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\IssuedBookController;
use App\Http\Controllers\ManageStudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Panels\AdminController;
use App\Http\Controllers\Panels\StudentController;

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

//// Routes for register
Route::get('/register', [SignUpController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [SignUpController::class, 'register']);

//// Routes for Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class,'logout'])->name('logout');

////Routes for Admin Panel
Route::get('/adminpanel', [AdminController::class, 'index'])->name('adminpanel');

////Routes for Student Panel
Route::group(['middleware' => ['auth']], function(){
    Route::get('/studentpanel', [StudentController::class, 'index'])->name('studentpanel');
});


//// Routes for books
Route::get('/manage-books', [BookController::class,'index'])->name('manage.books');
Route::get('/add-books', [BookController::class,'addBook'])->name('add.book');
Route::post('/create-new-book',[BookController::class,'storeBook'])->name('store.book');
Route::get('/delete-book/{id}', [BookController::class,'deleteBook'])->name('delete.book');
Route::get('/edit-book/{id}', [BookController::class,'editBook'])->name('edit.book');
Route::put('/edit-book/{id}', [BookController::class,'storeUpdatedBook'])->name('store.updated.book');

/// Routes for manage student 
Route::get('/manage-students', [ManageStudentController::class,'index'])->name('manage.students');
Route::get('/add-student', [ManageStudentController::class,'addStudent'])->name('add.student');
Route::post('/create-new-student', [ManageStudentController::class,'storeStudent'])->name('store.student');
Route::get('/delete-student/{id}', [ManageStudentController::class,'deleteStudent'])->name('delete.student');
Route::get('/edit-student/{id}', [ManageStudentController::class,'editStudent'])->name('edit.student');
Route::put('/edit-student/{id}', [ManageStudentController::class,'storeUpdatedStudent'])->name('store.updated.student');
Route::get('/issue-book/{id}', [ManageStudentController::class,'issueBook'])->name('issue.book');

/// Routes for issued books
Route::get('/manage-issued-book', [IssuedBookController::class,'index'])->name('manage.issued.books');
Route::get('/issue-book',[IssuedBookController::class,'issueBook'])->name('issue.book.id');
Route::post('/issue-book',[IssuedBookController::class,'storeIssuedBook'])->name('store.issued.book');

Route::get('/test-mongodb-connection', function () {
    try {
        DB::connection('mongodb')->getPdo();
        return "Connected to MongoDB!";
    } catch (\Exception $e) {
        return "Unable to connect to MongoDB. Error: " . $e->getMessage();
    }
});
