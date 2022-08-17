<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Listing;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */
// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing

//Getting All Listings
Route::get('/',[ListingController::class, 'index']);


//Creating a Listing

Route::get('/listings/create',[ListingController::class, 'create'])->middleware('auth');

//Storing Listing Data

Route::post('/listings',[ListingController::class, 'store'])->middleware('auth');

//Getting a Single Listing
Route::get('/listings/{listing}',[ListingController::class, 'show']);

//Show edit form
Route::get('/listings/{listing}/edit',[ListingController::class, 'edit'])->middleware('auth');

//update listing
Route::put('/listings/{listing}',[ListingController::class, 'update'])->middleware('auth');

//delete listing
Route::delete('/listings/{listing}',[ListingController::class, 'destroy'])->middleware('auth');


//Manage Listing
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');



//Show register/create

Route::get('/register', [UserController::class, 'create'])->middleware('guest');


//Storing new user

Route::post('/users',[UserController::class, 'store']);

//Log out User
Route::post('/logout',[UserController::class, 'logout'])->middleware('auth');

//Show Login Form
Route::get('/login',[UserController::class, 'login'])->name('login')->middleware('guest');

//Authenticate User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);




?>
