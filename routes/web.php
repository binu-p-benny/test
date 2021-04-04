<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });



Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/','Frontend\FrontController@index');

// backend
Route::get('/admin','Backend\DashboardController@index');

Route::get('/calender','Backend\DashboardController@calender');

Route::post('add/attendance','Backend\DashboardController@store');

Route::post('find/attendance','Backend\DashboardController@find')->name('ajaxRequest.date');

Route::get('/edit-attendance/{att_date}','Backend\DashboardController@edit_attendance');

Route::post('/edit-attendance','Backend\DashboardController@edit_attendance');


//admin/manage-estate
//admin/manage-estate

Route::get('admin/manage-estate','Backend\EstateController@manage');

Route::post('admin/add-estate','Backend\EstateController@store');

Route::get('/admin/remove-estate/{id}','Backend\EstateController@remove');

// admin/works

Route::get('admin/manage-work','Backend\WorkController@manage');

Route::post('admin/add-work','Backend\WorkController@store');

Route::get('/admin/remove-work/{id}','Backend\WorkController@remove');

// admin/holiday

Route::get('admin/manage-holiday','Backend\HolidayController@manage');

Route::post('admin/add-holiday','Backend\HolidayController@store');

Route::get('/admin/remove-holiday/{id}','Backend\HolidayController@destroy');

// admin/employee

Route::get('/admin/manage-employee','Backend\EmployeeController@index');

Route::post('admin/add-employee','Backend\EmployeeController@store');

Route::get('/admin/remove-employee/{id}','Backend\EmployeeController@destroy');

// employee-salary-reports


Route::get('/admin/employee-salary-reports','Backend\ReportsController@emp_sal_reports');
Route::post('/admin/employee-salary-reports','Backend\ReportsController@str_emp_sal_reports');
Route::post('/admin/print-employee-salary-reports','Backend\ReportsController@print_emp_sal_reports');
