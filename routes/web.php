<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	$user = Auth::user();

	if(Auth::id() > 0 && $user->hasRole('admin')){
    	return redirect('/dashboard');
	}

	if(Auth::id() > 0 && $user->hasRole('client')){
    	return redirect('/clients/jobsites/');
	}

	if(Auth::id() > 0 && $user->hasRole('supervisor')){
    	return redirect('/supervisors/dashboard/');
	}

	if(Auth::id() > 0 && $user->hasRole('employee')){
    	return redirect('/employees/dashboard/');
	}

	return redirect('/login');

});

//Auth::routes();
Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','facebook|google');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','facebook|google');
Route::get('/{social}/account','EmployeeController@saveEmployeeAfterSocial')->name('saveEmployeeAfterSocial');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('getUsername/{email}', 'Auth\LoginController@getUsername');
Route::get('getUserEmail/{username}', 'Auth\LoginController@getUserEmail');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('/employee/create', 'EmployeeController@createEmployee');
Route::post('addEmployee', 'EmployeeController@saveEmployee');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('/changepassword', 'DashboardController@change_password')->name('changepassword');
Route::post('/changepassword', 'DashboardController@post_change_password')->name('savechangepassword');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/download', 'HomeController@getDownload');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/test', 'ActivityController@test');

# Api
Route::get('/api/client_jobsites/{id}','ApiController@client_jobsites')->name('api.client_jobsites');

Route::group(['middleware' => ['role:admin']], function () {

	#Dashboard
	Route::get('/dashboard','DashboardController@index')->name('dashboard');

    #Activity
    Route::get('/activity/','ActivityController@index')->name('activity');

	# Clients
	Route::get('/clients/', 'ClientController@index')->name('clients');
	Route::get('/clients/create/', 'ClientController@create')->name('clients.create');
	Route::get('/clients/update/{id}', 'ClientController@update')->name('clients.update');
	Route::post('/clients/save/', 'ClientController@save')->name('clients.save');

	# Supervisors
	Route::get('/supervisors/', 'SupervisorController@index')->name('supervisors');
	Route::get('/supervisors/create/', 'SupervisorController@create')->name('supervisors.create');
	Route::get('/supervisors/update/{id}', 'SupervisorController@update')->name('supervisors.update');
	Route::post('/supervisors/save/', 'SupervisorController@save')->name('supervisors.save');
	Route::get('/supervisors/jobsite/{id}', 'SupervisorController@jobsite')->name('supervisors.jobsite');
	Route::get('/supervisors/jobsites/assign/{id}', 'SupervisorController@assign')->name('supervisors.assign');
	Route::post('/supervisors/jobsites/assign/', 'SupervisorController@assign_save')->name('supervisors.assign.save');
	Route::get('/supervisors/jobsites/unassign/{supervisor_id}/{jobsite_id}', 'SupervisorController@unassign')->name('supervisors.unassign');


	# Employees
	Route::get('/employees/', 'EmployeeController@index')->name('employees');
	Route::get('/employees/create/', 'EmployeeController@create')->name('employees.create');
	Route::get('/employees/update/{id}', 'EmployeeController@update')->name('employees.update');
	Route::post('/employees/save/', 'EmployeeController@save')->name('employees.save');
	Route::get('/employees/jobsite/{id}', 'EmployeeController@jobsite')->name('employees.jobsite');
	Route::get('/employees/jobsites/assign/{id}', 'EmployeeController@assign')->name('employees.assign');
	Route::post('/employees/jobsites/assign/', 'EmployeeController@assign_save')->name('employees.assign.save');
	Route::get('/employees/jobsites/unassign/{employee_id}/{jobsite_id}', 'EmployeeController@unassign')->name('employees.unassign');
	Route::get('/remove/{id}', 'EmployeeController@remove_image');

	# Positions
	Route::get('/positions/', 'PositionController@index')->name('positions');
	Route::get('/positions/create/', 'PositionController@create')->name('positions.create');
	Route::get('/positions/update/{id}', 'PositionController@update')->name('positions.update');
	Route::post('/positions/save/', 'PositionController@save')->name('positions.save');

	# Jobsite
	Route::get('/jobsites/', 'JobsiteController@index')->name('jobsites');
	Route::get('/jobsites/create/', 'JobsiteController@create')->name('jobsites.create');
	Route::get('/jobsites/update/{id}', 'JobsiteController@update')->name('jobsites.update');
	Route::post('/jobsites/save/', 'JobsiteController@save')->name('jobsites.save');

	# Timesheets
	Route::get('/timesheets/', 'TimesheetController@index')->name('timesheets');
	Route::get('/timesheets/create/', 'TimesheetController@create')->name('timesheets.create');
	Route::post('/timesheets/save/', 'TimesheetController@save')->name('timesheets.save');
	Route::get('/timesheets/employee/{employee_id}/{jobsite_id}', 'TimesheetController@employee')->name('timesheets.employee');
	Route::get('/timesheets/dump/{id}/{date}','TimesheetController@dump')->name('timesheets.dump');
	Route::get('/timesheets/dump/{id}','TimesheetController@dump')->name('timesheets.dump');
    Route::get('/timesheets/{emp_id}/{jobsite_id}', 'TimesheetController@getTimesheet');

    #Request
    Route::get('/requests/','JobsiteController@pendingRequest');
    Route::post('/requests/','JobsiteController@approveRequest');
});

# Clients
Route::get('/clients/jobsites/', 'ClientController@jobsites')->name('clients.jobsites');
Route::get('/clients/jobsites/employees/{jobsite_id}', 'ClientController@employees')->name('clients.jobsites.employees');
Route::get('/clients/jobsites/employees/timesheet/{jobsite_id}/{employee_id}', 'ClientController@timesheet')->name('clients.jobsites.employees.timesheet');
Route::post('/clients/jobsites/employees/timesheet/', 'ClientController@timesheet_save')->name('clients.jobsites.employees.timesheet.save');

Route::group(['middleware' => ['role:supervisor']], function () {

    Route::get('/supervisors/dashboard', 'SupervisorController@dashboard');

	# Supervisors
	Route::get('/supervisors/jobsites/', 'SupervisorController@jobsites')->name('supervisors.jobsites');
	Route::get('/supervisors/jobsites/employees/timesheet/thankyou','SupervisorController@thankyou')->name('supervisors.jobsites.employees.timesheet.thankyou');

	Route::get('/supervisors/jobsites/employees/{client_id}/{jobsite_id}', 'SupervisorController@employees')->name('supervisors.jobsites.employees');

	//Route::get('/supervisors/jobsites/employees/timesheet/{client_id}/{jobsite_id}/{employee_id}', 'SupervisorController@timesheet')->name('supervisors.jobsites.employees.timesheet');
	//Route::post('/supervisors/jobsites/employees/timesheet/', 'SupervisorController@timesheet_save')->name('supervisors.jobsites.employees.timesheet.save');

	 Route::get('/supervisors/activity','SupervisorController@activity')->name('supervisors.activity');

    Route::get('/supervisors/employee/', 'SupervisorController@employee')->name('supervisors.employee');
    Route::get('/supervisors/timesheets/', 'SupervisorController@employeeTimesheet')->name('supervisors.timesheets');
    Route::get('/supervisors/timesheets/{emp_id}/{jobsite_id}', 'SupervisorController@getTimesheet');

    Route::get('/supervisors/myaccount/', 'SupervisorController@myaccount')->name('supervisors.myaccount');
    Route::post('/supervisors/Update/', 'SupervisorController@Update1')->name('supervisors.Update');

    Route::get('/supervisors/jobsites/request', 'SupervisorController@jobsiteRequest');
    Route::post('/supervisors/addRequest', 'SupervisorController@addRequest');

    Route::get('/supervisors/pending/timesheets/', 'SupervisorController@sup_pending_req')->name('supervisors.sup_pending_req');
    Route::post('/supervisors/requests/','SupervisorController@approveRequest');

});

Route::group(['middleware' => ['role:employee']], function () {

    Route::get('/employees/dashboard', 'EmployeeController@dashboard');
	# Employees
	Route::get('/employees/jobsites/', 'EmployeeController@jobsites')->name('employees.jobsites');
	//Route::get('/employees/jobsites/timesheet/{jobsite_id}/{client_id}', 'EmployeeController@timesheet')->name('employees.jobsites.timesheet');
	//Route::post('/employees/jobsites/timesheet/', 'EmployeeController@timesheet_save')->name('employees.jobsites.timesheet.save');
	Route::get('/employees/jobsites/timesheet/thankyou','EmployeeController@thankyou')->name('employees.jobsites.timesheet.thankyou');

    # timesheet
    Route::get('/employees/timesheets/', 'EmployeeController@timesheetList');
    Route::get('/employees/client_jobsites/{client_id}', 'EmployeeController@getJobsite');

    Route::get('/employees/myaccount/', 'EmployeeController@myAccount');
    Route::get('/employee/jobsites/request', 'EmployeeController@jobsiteRequest')->name('employees.jobsites.request');
    Route::post('addRequest', 'EmployeeController@addRequest');
});

	Route::group(['middleware' => ['role:supervisor|employee']], function () {
    Route::get('/employee/jobsites/timesheet/{client_id}/{jobsite_id}/{employee_id}', 'SupervisorController@timesheet')->name('emp.timesheets');
    Route::post('/employee/jobsites/Supervisortimesheet/', 'SupervisorController@timesheet_save')->name('employee.jobsites.Supervisortimesheet.save');
    Route::post('/employee/jobsites/timesheet/', 'EmployeeController@timesheet_save')->name('employee.jobsites.Employeetimesheet.save');
});

# Positions

# Jobsite

# Timesheets
