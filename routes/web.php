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

Route::get('aboutus', 'PageController@getAboutUs');
Route::get('contactus', 'PageController@getContactUs');

/*Route::resource('courses', 'CourseController', ['only' =>[
    'index','create','store','show','edit','update'
]]);*/

Route::resource('courses', 'CourseController', ['only' =>[
    'index','create','store', 'edit','update'
]]);
Route::get('courses/{course}/{slug?}', 'CourseController@show')->name('courses.show');


Route::get('/', function () {
    return redirect('courses');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
