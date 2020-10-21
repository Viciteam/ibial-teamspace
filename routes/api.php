<?php

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

/**
 * Teams
 */
Route::group([
    'prefix' => 'teams',
], function () {

    /**
     * Add Team 
     */
    Route::post("/", 'teamsController@inject');
    
    /**
     * Edit Team Details
     */
    Route::post("/{id}", 'teamsController@edit');

    /**
     * Delete Team
     */
    Route::delete("/{id}", 'teamsController@delete');

    /**
     * Get Team Details
     */

    Route::get("/{id}", 'teamsController@getTeam');
    
    /**
     * Members
     */
    Route::group([
        'prefix' => 'members',
    ], function () {

        /**
         * Add Member on Team
         */
        Route::post("add", 'teamsController@addMember');

        /**
         * remove Member on Team
         */
        Route::post("remove/{member_id}", 'teamsController@removeMember');
    });

});

// Projects
Route::group([
    'prefix' => 'projects',
], function () {
    // setters
    Route::post("/", 'ProjectsController@inject');
    Route::post("/{id}", 'ProjectsController@edit');

    Route::delete("/{id}", 'ProjectsController@delete');

    Route::get("/{id}/teams", 'ProjectsController@teams');

    
});

// Task
Route::group([
    'prefix' => 'task',
], function () {
    // setters
    Route::post("/", 'TaskController@inject');
    Route::post("/{id}", 'TaskController@edit');

    Route::delete("/{id}", 'TaskController@delete');
});

// Message History
Route::group([
    'prefix' => 'message',
], function () {
    // setters
    Route::post("/", 'MessageHistoryController@inject');
});