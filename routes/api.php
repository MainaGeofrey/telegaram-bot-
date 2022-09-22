<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Bot\TeleBotController;
use App\Http\Controllers\Api\Auth\AuthController;

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

Route::prefix('v1')->group(function () {
    Route::prefix('bot')->group(function () {
      Route::post('info', [TeleBotController::class, 'botInfo'])->name('bot.info');
      Route::post('send-message', [TeleBotController::class, 'sendMessage'])->name('bot.send-message');
      Route::post('updates', [TeleBotController::class, 'getUpdates'])->name('bot.updates');
      Route::post('chat-id', [TeleBotController::class, 'getChadId'])->name('bot.chat-id');

    });
});

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
