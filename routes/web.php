<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{FormController, LoginController};

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

Route::get('/', function () {
    return view('welcome');
});

Route::post("/form/login", [FormController::class, "login"]);

Route::get("/form",[LoginController::class,"form"]);
Route::post("/form",[LoginController::class,"submitForm"]);