<?php

use Api\Users\Actions\ChangeUserController;
use Api\Users\Actions\ExcludeUserController;
use Api\Users\Actions\ListUserController;
use Api\Users\Actions\StoredUserController;
use Api\WalletKeep\Actions\ChangeWalletKeepController;
use Api\WalletKeep\Actions\ExcludeWalletKeepController;
use Api\WalletKeep\Actions\ListWalletKeepController;
use Api\WalletKeep\Actions\ReportHTMLWalletKeepController;
use Api\WalletKeep\Actions\ReportWalletKeepController;
use Api\WalletKeep\Actions\StoredWalletkeepController;
use Api\WalletTrack\Actions\ChangeWalletTrackController;
use Api\WalletTrack\Actions\StoredWalletTrackController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    
    Route::get('/users', [ListUserController::class, 'action']);
    Route::post('/users', [StoredUserController::class, 'action'])->withoutMiddleware(EnsureTokenIsValid::class);
    Route::get('/users/{id}', [ListUserController::class, 'action']);
    Route::put('/users/{id}', [ChangeUserController::class, 'action']);    
    Route::delete('/users/{id}', [ExcludeUserController::class, 'action']);

    Route::post('/user/wallet', [StoredWalletTrackController::class, 'action']);
    Route::put('/user/wallet/{id}', [ChangeWalletTrackController::class, 'action']);

    Route::get('/keep/wallet/track/{cTrack}', [ListWalletKeepController::class, 'action']);
    Route::get('/keep/wallet/track/{cTrack}/{id}', [ListWalletKeepController::class, 'action']);
    Route::post('/keep/wallet/open', [StoredWalletkeepController::class, 'action']);
    Route::put('/keep/wallet/as/before/{id}', [ChangeWalletKeepController::class, 'action']);
    Route::delete('/keep/wallet/{id}', [ExcludeWalletKeepController::class, 'action']);

    Route::get('/csv/report', [ReportWalletKeepController::class, 'action']);
    Route::get('/csv/report/html', [ReportHTMLWalletKeepController::class, 'action']); // para testar junto ao POSTMAN com Aba VISUALIZE

});