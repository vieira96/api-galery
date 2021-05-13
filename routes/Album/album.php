<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Album\AlbumController;

Route::group([
    'namespace' => 'App\Http\Controllers\Api\Album',
    'middleware' => ['api', 'JWT', 'cors', 'localization'],
], function () {
    Route::apiResource(
        '/album',
        'AlbumController'
    );

    Route::post('/album/{id}/photo', [AlbumController::class, 'addPhoto']);
});
