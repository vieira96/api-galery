<?php

use App\Http\Controllers\Api\Photo\PhotoController;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'App\Http\Controllers\Api\Photo',
    'middleware' => ['api', 'JWT', 'cors', 'localization'],
], function () {
    Route::apiResource(
        '/photo',
        'PhotoController'
    )->except(['update']);

    Route::delete('/max-delete', [PhotoController::class, 'maxDelete']);
});
