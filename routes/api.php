<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\userController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/me', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::put('/update', [UserController::class, 'update']);
});

Route::prefix('boards')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', [BoardController::class, 'getBoards']);
    Route::post('/', [BoardController::class, 'store']);
    Route::get('/{id}', [BoardController::class, 'show']);
    Route::put('/{id}', [BoardController::class, 'update']);
});

Route::prefix('columns')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/', [ColumnController::class, 'store']);
    Route::put('/move', [ColumnController::class, 'moveColumnInBoard']);
    Route::put('/{id}', [ColumnController::class, 'update']);
    Route::delete('/{id}', [ColumnController::class, 'delete']);
});

Route::prefix('cards')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/', [CardController::class, 'store']);
    Route::put('/move-to-different-column', [CardController::class, 'moveCardToDifferentColumn']);
    Route::put('/move', [CardController::class, 'moveCardInColumn']);
});
