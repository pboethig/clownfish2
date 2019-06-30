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

use Illuminate\Support\Facades\Route;

Use \App\Repositories\TemplateRepository;

/**
 * Templates
 */
Route::get('templates', 'Api\TemplatesController@index');
Route::post('templates', 'Api\TemplatesController@store');
Route::post('templates/{template}/upload', 'Api\TemplatesController@upload');
Route::post('templates/{template}/processUploadedFile', 'Api\TemplatesController@processUploadedFile');
Route::put('templates/{template}', 'Api\TemplatesController@update');
Route::delete('templates/{template}', 'Api\TemplatesController@destroy');

Route::get('templates/{id}', function(TemplateRepository $templateRepository, int $id) {
    return $templateRepository->getById($id);
});

Use \App\Repositories\GroupsRepository;

Route::get('groups', function(GroupsRepository $groupsRepository) {
    return $groupsRepository->all();
});


Use \App\Repositories\ProjectRepository;

Route::get('projects', function(ProjectRepository $projectRepository) {
    return $projectRepository->all();
});

Use \App\Repositories\ConditionRepository;

Route::get('conditions', function(ConditionRepository $conditionRepository) {
    return $conditionRepository->all();
});
