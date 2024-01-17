<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// All listings
// old version 
// Route::get('/', function () {
//     return view('listings', [
//         // 'heading' => 'Latest Listings',
//         'listings' => Listing::all() //because all is a static function so we use ::  we get our data from model 
//         //[
//         //     [
//         //         'id' => 1,
//         //         'title' => 'Listing One',
//         //         'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
//         //     ],
//         //     [
//         //         'id' => 2,
//         //         'title' => 'Listing Two',
//         //         'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'

//         //     ]
//         // ]
//     ]);
// });

// Single Listing

// Route::get(
//     '/listings/{id}',
//     function ($id) {
//         return view('listing', [
//             'listing' => Listing::find($id)
//         ]);
//     }

// );






//  Route::get('/hello', function () {
//      return response('<h1>hello world</h1>', 200)
//         ->header('Content-Type', 'text/plain')
//         ->header('foo', 'bar ');
//  });
//  Route::get('/posts/{id}', function ($id) {
//     // ddd($id);
//     return response('Post  ' . $id);
// })->where('id', '[0-9]+');
// Route::get('/search', function (Request $request) {
//     // dd($request->name . ' ' . $request->city);
//     return $request->name . ' ' . $request->city;
// });







//All listings (using controller)
Route::get('/', [ListingController::class, 'index']);
//Show Create Form 
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
//Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update Listing 
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// single listing wahdi
Route::get(
    '/listings/{listing}',
    [ListingController::class, 'show']
    // function (Listing $listing) {   
    //  return view('listing', [
    //         'listing' => $listing
    //     ]);
    // }
);

//Show Register/Create Form 
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create New User 
Route::post('/users', [UserController::class, 'store']);

//Log User Out 
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Show Login Form 
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
//Login User 
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::get('/email/verify-email/{verification_code}', [UserController::class, 'verify_email'])->name('verify_email');

// Route::get('/', function () {
//     return view('listings.index');
// })->middleware('verified')->name('home');
// Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
