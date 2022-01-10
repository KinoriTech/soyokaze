<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AJAX Routes
|--------------------------------------------------------------------------
|
| Here is where you can register AJAX routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "ajax" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| Generated AJAX Routes
|--------------------------------------------------------------------------
*/

/*
 * Register API routes using ajax middleware
 */
Route::middleware('ajax')->group(function () {
});

//Supplement the put method as Laravel does not distinguish between put and patch
// Your Model class should have a 'replace' method to handle puts.
//Route::put('/', [<Model>Controller::class, 'replace']);
