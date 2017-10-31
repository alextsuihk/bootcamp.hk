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
/*Route::get('aboutus', 'PageController@getAboutUs');
Route::get('contactus', 'PageController@getContactUs');*/
//AT-Pending: go ahead & remove PageController
Route::view('aboutus', 'pages/aboutus');
Route::view('contactus', 'pages/contactus');
/**
 * Courses Controller
 */

Route::resource('courses', 'CourseController', ['only' =>[
    'index','create','store', 'edit','update'
]]);
Route::get('courses/{course}/{slug?}', 'CourseController@show')->name('courses.show');

/**
 * Lesson Controller
 */
Route::get('lessons/{id}/enroll/{course}', 'LessonController@enroll')->name('lesson.enroll');
Route::get('lessons/{id}/cancel/{course}', 'LessonController@cancel')->name('lesson.cancel');
Route::get('lessons/create/{course_id}', 'LessonController@create')->name('lesson.create');
Route::post('lessons/', 'LessonController@store')->name('lesson.store');
Route::get('lessons/{id}/edit', 'LessonController@edit')->name('lesson.edit');
Route::patch('lessons/{id}', 'LessonController@update')->name('lesson.update');


/**
 * File Attachment Controller: upload file attachment and assoicate to a course
 */
Route::post('attachments/upload', 'AttachmentController@store')->name('attachment.upload');
Route::post('attachments/download', 'AttachmentController@download')->name('attachment.download');
Route::get('attachments/{id}/enable', 'AttachmentController@enable')->name('attachment.enable');
Route::get('attachments/{id}/disable', 'AttachmentController@disable')->name('attachment.disable');

/**
 * User Profile
 */
Route::get('profile/sendemailverify', 'ProfileController@sendemailverify')->name('email.sendverify'); 
Route::get('profile/{id?}', 'ProfileController@edit')->name('profile.edit'); 
Route::post('profile/{id?}', 'ProfileController@update');
Route::get('email/verify/{token}', 'ProfileController@emailverify')->name('email.verify');
Route::get('password/change', 'Auth\ChangePasswordController@edit');
Route::post('password/change', 'Auth\ChangePasswordController@update');
//Route::get('')
Auth::routes();

/*Route::get('admin/users', 'Admin\PageController@getContactUs');
*/


/*Route::get('/', function () {
    return redirect('courses');
})->name('home');
*/
Route::redirect('/', 'courses')->name('home');            // redirect "/" to "/courses"

Route::get('/home', 'HomeController@index')->name('home-old');
