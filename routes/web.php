<?php

use Illuminate\Support\Facades\Route;

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


Route::controller(App\Http\Controllers\NeoFeedController::class)->group(function () 
{
    //Neo Feed View Page
    Route::get('neo-feed-view', 'neoFeedView');

    //Get Neo Feed based on date
    Route::get('get-neo-feed', 'getNeoFeed');
});