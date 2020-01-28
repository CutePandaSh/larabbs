<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function() {
    Route::middleware('throttle:' . config('api.rate_limits.sign'))
        ->group(function() {
            Route::post('captchas', 'CaptchasController@store')->name('captchas.store');
            Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
            Route::post('users', 'UsersController@store')->name('users.store');
            Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
                        ->where('social_type', 'weixin')
                        ->name('socials.authorizations.store');
            Route::post('authorizations', 'AuthorizationsController@store')->name('authorizations.store');
            Route::put('authorizations/current', 'AuthorizationsController@update')->name('authorizations.update');
            Route::delete('authorizations/current', 'AuthorizationsController@destroy')->name('authorizations.destroy');
        });
    Route::middleware('throttle:' . config('api.rate_limits.access'))
        ->group(function() {

            Route::get('users/{user}', 'UsersController@show')->name('users.show');

            Route::get('categories', 'CategoriesController@index')->name('categories.index');
            Route::resource('topics', 'TopicsController')->only(['index', 'show']);
            Route::get('users/{user}/topics', 'TopicsController@userIndex')->name('user.topics.index');
            Route::get('topics/{topic}/replies', 'RepliesController@index')->name('topics.replies.index');
            Route::get('users/{user}/replies', 'RepliesController@userIndex')->name('users.replies.index');

            Route::middleware('auth:api')->group(function() {
                Route::get('user', 'UsersController@me')->name('user.show');
                Route::patch('user', 'UsersController@update')->name('user.update');
                Route::post('images', 'ImagesController@store')->name('images.store');
                Route::resource('topics', 'TopicsController')->only(['store', 'update', 'destroy']);
                Route::post('topics/{topic}/replies', 'RepliesController@store')->name('topics.replies.store');
                Route::delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')->name('topics.replies.destroy');
                Route::get('notifications', 'NotificationsController@index')->name('notifications.index');
                Route::get('notifications/stats', 'NotificationsController@stats')->name('notifications.stats');
                Route::patch('user/notifications/read', 'NotificationsController@read')->name('user.notifications.read');
                Route::get('user/permissions', 'PermissionsController@index')->name('user.permissions.index');
            });

        });
});
