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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/clients', 'Admin\User2Controller');
Route::get('/clients/editStatus/{id}', 'Admin\User2Controller@editClientStatus')->name('editClientStatus');
Route::get('/shopss', 'Admin\User2Controller@index2');
Route::get('/admins', 'Admin\User2Controller@indexAdmin');

Route::resource('/countriess', 'Admin\CountryController');
Route::post('/countriess/edit', 'Admin\CountryController@edit_country')->name('editCountry');

Route::resource('/govs', 'Admin\GovController');
Route::post('/govs/edit', 'Admin\GovController@edit_gov')->name('editGov');

Route::resource('/cities', 'Admin\CityController');
Route::post('/cities/edit', 'Admin\CityController@edit_city')->name('editCity');

Route::resource('/cats', 'Admin\CategoryController');
Route::post('/cats/edit', 'Admin\CategoryController@edit_cat')->name('editCat');
Route::get('/cats/editStatus/{id}', 'Admin\CategoryController@editCatStatus')->name('editCatStatus');

Route::resource('/offs', 'Admin\OfferController');
Route::get('/offs/editStatus/{id}', 'Admin\OfferController@editOfferStatus')->name('editOfferStatus');

Route::resource('/notifications', 'Admin\NotificationController');
Route::get('/notifications/delet/{id}', 'Admin\NotificationController@delete_not');

Route::resource('/reviews', 'Admin\ReviewController');
Route::get('/reviews/delet/{id}', 'Admin\ReviewController@delete_review');

Route::resource('/terms', 'Admin\TermController');
Route::post('/terms/edit', 'Admin\TermController@edit_terms')->name('editTerm');

Route::resource('/abouts', 'Admin\AboutController');
Route::post('/abouts/edit', 'Admin\AboutController@edit_abouts')->name('editAbout');


//reports
Route::get('reports',"Admin\ReportController@reports")->name('reports');
Route::post('Report',"Admin\ReportController@makeReport")->name('makeReport');

Route::post('usersReport',"Admin\ReportController@usersReport")->name('usersReport');
Route::get('usersInvoice',"Admin\ReportController@usersInvoice")->name('usersInvoice');

Route::post('shopsReport',"Admin\ReportController@shopsReport")->name('shopsReport');
Route::get('shopsInvoice',"Admin\ReportController@shopsInvoice")->name('shopsInvoice');

Route::post('offersReport',"Admin\ReportController@offersReport")->name('offersReport');
Route::get('offersInvoice',"Admin\ReportController@offersInvoice")->name('offersInvoice');

