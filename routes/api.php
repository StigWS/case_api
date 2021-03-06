<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\TranslationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get-page/{page_id}/{language_code?}', [PageController::class, 'getPage']);
Route::post('add-page', [PageController::class, 'addPage']);
Route::put('update-translation/{translation}', [TranslationController::class, 'updateTranslation']);
