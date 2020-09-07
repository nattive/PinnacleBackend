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


// Auth::routes();

    Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
    Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');

    Route::post('/login/admin', 'Auth\LoginController@adminLogin')->name('login');
    Route::post('/register/admin', 'Auth\RegisterController@createAdmin')->name('register');

    // Route::view('/home', 'home')->middleware('auth');
    // Route::view('/admin', 'admin');
Route::get('/', 'HomeController@index');
Route::get('/courses', 'HomeController@courses')->name('courses');
Route::get('/courses/edit/{id}', 'HomeController@updateCourse')->name('updateCourse');
Route::get('/courseModuleList/{id}', 'HomeController@courseModuleList')->name('courseModuleList');
Route::get('/courses/add-question/{courseMaterialId}', 'HomeController@AddQuestion')->name('AddQuestion');
Route::get('/courses/create', 'HomeController@addCourse')->name('addCourse');
Route::get('/AllCourses', 'HomeController@AllCourses')->name('AllCourses');
Route::get('/category', 'HomeController@category')->name('category');
// Route::get('/courses/edit/{id}', 'CourseController@edit')->name('courses-edit');
Route::get('/courses/modules/add/{id}', 'HomeController@modules')->name('modules');
Route::get('/courses/modules/edit/{id}', 'CourseMaterialsController@edit');

// Route::get('/home', 'HomeController@index')->name('home');