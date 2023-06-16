<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;


//Route::view('/', 'welcome');
Route::get('/', [WelcomeController::class, 'index']);


Route::view('/thank-you', 'thank-you');







Route::controller(EventController::class)->group(function () {
    Route::get('events', 'index')->name('events.index');
    Route::get('events/search_results', 'eventSearchResults')->name('events.search_results');
});




Auth::routes(
// ['register' => false] // disable register link
);
Route::prefix('user')->name('user.')->group(function () {
    // 'PreventBackHistory'


    Route::middleware(['guest:web', 'PreventBackHistory'])->group(function () {
        Route::view('/login', 'dashboard.user.login')->name('login');
        Route::get('/register', [UserController::class, 'index'])->name('register');
        Route::post('/create', [UserController::class, 'create'])->name('create');
        Route::post('/check', [UserController::class, 'check'])->name('check');
    });

    Route::middleware(['auth:web', 'PreventBackHistory'])->group(function () {
        Route::get('/', [UserController::class, 'dashboard'])->name('home');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::get('/add-new', [UserController::class, 'add'])->name('add');
        Route::get('/showEvent/{id}', [UserController::class, 'showEventDetails'])->name('app');
        Route::post('/bookEvent', [UserController::class, 'bookEvent'])->name('bookEvent');



    });

});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function () {
        Route::view('/login', 'dashboard.admin.login')->name('login');
        Route::post('/check', [AdminController::class, 'check'])->name('check');
        Route::get('/register', [AdminController::class, 'register'])->name('register');
        Route::post('/create', [AdminController::class, 'create'])->name('create');




    });

    Route::middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('home');

        Route::get('/addEvent', [AdminController::class, 'addEvent'])->name('addEvent');
        Route::get('/addUser', [AdminController::class, 'addUser'])->name('addUser');

        Route::post('/createEvent', [AdminController::class, 'createEvent'])->name('createEvent');
        Route::get('/editEvent/{id}', [AdminController::class, 'editEvent'])->name('editEvent');
        Route::put('/updateEvent/{id}', [AdminController::class, 'updateEvent'])->name('updateEvent');
        Route::delete('/deleteEvent/{id}', [AdminController::class, 'deleteEvent'])->name('deleteEvent');
        Route::delete('/deleteUser/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');



        Route::get('/editCustomer/{id}', [AdminController::class, 'editCustomer'])->name('edit_customer');
        Route::put('/updateCustomer/{id}', [AdminController::class, 'updateCustomer'])->name('updateCustomer');

        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');


    });

});