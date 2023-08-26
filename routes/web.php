<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[ClientController::class,'index']);
Route::post('/save',[ClientController::class,'store']);
Route::get('/get_data',[ClientController::class,'get_data']);
Route::get('/edit_data',[ClientController::class,'edit']);
Route::post('/update/{id}',[ClientController::class,'update']);
Route::post('/delete/{id}',[ClientController::class,'destroy']);
