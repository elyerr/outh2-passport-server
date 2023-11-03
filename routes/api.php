<?php

use App\Enum\EnumType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserRoleController;
use App\Http\Controllers\OAuth\CredentialsController;
use App\Http\Controllers\Auth\AuthorizationController; 
use App\Http\Controllers\OAuth\PasspotConnectController;
use Laravel\Passport\Http\Controllers\AccessTokenController;

//gateways
Route::prefix('gateway')->group(function () {
    Route::get('/check-authentication', [PasspotConnectController::class, 'check_authentication']);
    Route::get('/check-scope', [PasspotConnectController::class, 'check_scope']);
    Route::get('/check-scopes', [PasspotConnectController::class, 'check_scopes']);
    Route::get('/check-client-credentials', [PasspotConnectController::class, 'check_client_credentials']);
    Route::get('/token-can', [PasspotConnectController::class, 'token_can']);
    Route::get('/user', [PasspotConnectController::class, 'auth']);

});

Route::prefix('oauth')->group(function () {
    Route::post('/token', [AccessTokenController::class, 'issueToken'])
        ->name('passport.token')
        ->middleware('passport.csrf');

    Route::delete('/credentials/revoke', [CredentialsController::class, "revokeCredentiasl"])
        ->name('passport.revoke-credentials');
});

//Valores absolutos
Route::get('document-type', [EnumType::class, 'documento_type']);

Route::post('login', [AuthorizationController::class, 'store'])->name('signin');
Route::post('logout', [AuthorizationController::class, 'destroy']);

//Roles
Route::resource('roles', RoleController::class)->only('index', 'store', 'update', 'destroy');

//Employees
Route::delete('users/{user}/disable', [UserController::class, 'disable'])->name('users.disable');
Route::get('users/{id}/enable', [UserController::class, 'enable'])->name('users.enable');
Route::resource('users', UserController::class)->except('edit', 'create', 'destroy');
Route::resource('users.roles', UserRoleController::class)->only('index', 'store', 'destroy');

//credenciales
