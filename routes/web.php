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

/**
 * Static Pages Controller
 */
Route::get('aboutus', 'PageController@getAboutUs');
Route::get('contactus', 'PageController@getContactUs');

/**
 * Courses Controller
 */
/*Route::resource('courses', 'CourseController', ['only' =>[
    'index','create','store','show','edit','update'
]]);*/
Route::resource('courses', 'CourseController', ['only' =>[
    'index','create','store', 'edit','update'
]]);
Route::get('courses/{course}/{slug?}', 'CourseController@show')->name('courses.show');


/**
 * User Profile
 */
Route::get('profile/sendemailverify', 'ProfileController@sendemailverify')->name('email.sendverify'); 
Route::get('profile/{id?}', 'ProfileController@edit')->name('profile.edit'); 
Route::post('profile/{id?}', 'ProfileController@update');
Route::get('email/verify/{token}', 'ProfileController@emailverify')->name('email.verify');
Route::get('password/change', 'Auth\ChangePasswordController@edit');
Route::post('password/change', 'Auth\ChangePasswordController@update');
Auth::routes();

/*Route::get('admin/users', 'Admin\PageController@getContactUs');
*/


Route::get('/', function () {
    return redirect('courses');
})->name('home');



Route::get('/home', 'HomeController@index')->name('home-old');
