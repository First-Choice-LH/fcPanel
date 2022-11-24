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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/client', 'ApiController@getClientDetail');
Route::delete('/client', 'ApiController@removeClient');
Route::post('/client/notes', 'ApiController@updateClientNotes');
Route::delete('/client/document', 'ApiController@removeClientDocument');

Route::get('/job', 'ApiController@getJobDetail');
Route::post('/job', 'ApiController@createJob');
Route::get('/jobs', 'ApiController@getJobs');
Route::get('/jobsites', 'ApiController@getJobsites');
Route::get('/supervisors', 'ApiController@getSupervisors');
Route::get('/calendar/events/jobs', 'ApiController@getCalendarJobEvents');

Route::get('/employees', 'ApiController@getEmployees');
Route::post('/employee', 'ApiController@addEmployee');
Route::post('/employee/job', 'ApiController@assignJobToEmployee');

Route::get("/encrypt/project","ApiController@encryptProject");
