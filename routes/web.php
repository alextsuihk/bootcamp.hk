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
Route::view('contactus', 'pages/aboutus');
Route::view('support', 'pages/aboutus');
/**
 * Courses Controller
 */

Route::resource('courses', 'CourseController', ['only' =>[
    'create','store', 'edit','update'
]]);
Route::get('courselist/{type?}', 'CourseController@index')->name('courses.index');
Route::get('courses/{course}/{slug?}/{nav?}', 'CourseController@show')->name('courses.show');
Route::get('course_like/{id}', 'CourseController@like')->name('courses.like');
Route::get('course_follow/{id}', 'CourseController@follow')->name('courses.follow');

/**
 * Lesson Controller
 */
Route::get('lessons/{type?}', 'LessonController@index')->name('lessons.index');
Route::get('lessons/create/{course_id}', 'LessonController@create')->name('lessons.create');
Route::post('lessons/', 'LessonController@store')->name('lessons.store');
Route::get('lessons/{id}/edit', 'LessonController@edit')->name('lessons.edit');
Route::patch('lessons/{id}', 'LessonController@update')->name('lessons.update');
Route::get('lesson_enroll/{id}', 'LessonController@enroll')->name('lessons.enroll');
Route::get('lesson_cancel/{id}', 'LessonController@cancel')->name('lessons.cancel');

/**
 * File Attachment Controller: upload file attachment and assoicate to a course
 */
Route::post('attachments/upload', 'AttachmentController@store')->name('attachments.upload');
Route::post('attachments/action', 'AttachmentController@action')->name('attachments.action');  
                                                        //download, enable & disable
/**
 * Question Controller
 */
Route::get('questionlist/{nav?}', 'QuestionController@index')->name('questions.index');
Route::get('questions/{id}/{slug?}', 'QuestionController@show')->name('questions.show');
Route::post('questions', 'QuestionController@store')->name('questions.store');
Route::get('question_voteadmin/{id}/{action}', 'QuestionController@voteadmin')->name('questions.voteadmin');
Route::get('question_vote/{id}/{action}', 'QuestionController@vote')->name('questions.vote');

/**
 * Comment Controller
 */
Route::post('comments', 'CommentController@store')->name('comments.store');
Route::get('comment_voteadmin/{id}/{action}', 'CommentController@voteadmin')->name('comments.voteadmin');
Route::get('comment_vote/{id}/{action}', 'CommentController@vote')->name('comments.vote');

/**
 * User Profile
 */
Route::get('profile', 'ProfileController@edit')->name('profile.edit'); 
Route::post('profile', 'ProfileController@update')->name('profile.update');
Route::post('gitlab', 'ProfileController@gitLabAccount')->name('profile.gitLabAccount');
Route::get('sendemailverify', 'ProfileController@sendemailverify')->name('email.sendverify'); 
Route::get('email/verify/{token}', 'ProfileController@emailverify')->name('email.verify');
Route::get('password/change', 'Auth\ChangePasswordController@edit')->name('password.edit');
Route::post('password/change', 'Auth\ChangePasswordController@update')->name('password.update');
Route::get('auth/facebook', 'Auth\Oauth2Controller@redirectToProviderFacebook');
Route::get('auth/facebook/callback', 'Auth\Oauth2Controller@handleProviderCallbackFacebook');
Route::get('auth/linkedin', 'Auth\Oauth2Controller@redirectToProviderLinkedin');
Route::get('auth/linkedin/callback', 'Auth\Oauth2Controller@handleProviderCallbackLinkedin');
Route::get('auth/detach/{type}', 'ProfileController@detach')->name('profile.detach');
Route::redirect('logout', '/');
Auth::routes();


/**
 * Admin Controller
 */
Route::get('admin/users/', 'Admin\UserController@index')->name('admin.users.index'); 
Route::get('admin/users/{id}/edit', 'Admin\UserController@edit')->name('admin.users.edit');
Route::post('admin/users/{id}', 'Admin\UserController@update')->name('admin.users.update');
Route::get('admin/impersonate/{id}', 'Admin\UserController@impersonate')->name('admin.users.impersonate');
Route::get('admin/stopimpersonate', 'Admin\UserController@stopImpersonate')->name('admin.users.stopImpersonate');


Route::redirect('/', 'courselist')->name('home');            // redirect "/" to "/courses"

