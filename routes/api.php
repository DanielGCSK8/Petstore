<?php

use Illuminate\Http\Request;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pet',[PetController::class, 'index'])->name('pet.index');
Route::post('/pet',[PetController::class, 'store'])->name('pet.store');
Route::get('/pet/{id}',[PetController::class, 'show'])->name('pet.show');
Route::get('/pets/findByStatus',[PetController::class, 'findByStatus'])->name('pets.findByStatus');
Route::post('/pet/{id}',[PetController::class, 'update'])->name('pet.update');
Route::put('/pet', [PetController::class, 'updatePet'])->name('pet.updatePet');
Route::delete('/pet/{id}',[PetController::class, 'destroy'])->name('pets.destroy');
