<?php

use Illuminate\Support\Facades\Route;

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

/**
 *
 * Admins
 *
 */
Route::group(['prefix' => 'admin'], function () {
    Route::POST('approve/{id}', 'CourseController@approve');
    Route::get('admin/courses/index', 'CourseController@index');
    Route::post('tutor/create/{id}', 'TutorController@createTutorAdmin');

});
Route::post('login', 'AuthController@login');
Route::get('me', 'AuthController@me');
Route::get('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');

/**
 * Question
 */

/**
 * Modules
 */
Route::group(['prefix' => 'tutor', ['middleware' => ['verifyTutor', 'auth:api']]], function () {
    Route::post('/register', 'TutorController@store');
    Route::get('activities', 'CourseActivityController@tutor');
    Route::group(['prefix' => 'discount'], function () {
        Route::post('/', 'CourseDiscountController@store');
        Route::GET('/', 'CourseDiscountController@INDEX');

    });
    Route::group(['prefix' => 'courses'], function () {
        Route::get('{slug}', 'CourseController@show');
        Route::put('{id}', 'CourseController@update');
        Route::post('upload-course/basic', 'CourseController@basicCourseInfo');
        Route::delete('delete/{id}', 'CourseController@destroy');
        Route::get('my/{id}', 'TutorCourseController@myCourses');

        Route::group(['prefix' => 'module'], function () {
            Route::post('/', 'CourseModules@store');
            Route::get('show/{id}', 'CourseModules@show');
            Route::put('/update/{id}', 'CourseModules@update');
            Route::get('modules/get/{id}', 'CourseModules@index');
        });

        Route::group(['prefix' => 'courses/materials'], function () {
            Route::post('/', 'CourseMaterialsController@store');
            Route::get('{slug}', 'TutorCourseController@show');
            Route::get('show/{id}', 'CourseMaterialsController@show');

        });

        Route::group(['prefix' => 'quiz'], function () {
            Route::POST('add-question', 'CourseQuestionController@store');
            Route::post('/quiz/store', 'CourseQuestionController@update');
        });
    });

});

Route::POST('user/quiz-result/store', 'UserQuizResultController@store');
Route::get('user/progress-status', 'UserCourseProgressController@index');

/**
 * Main Category api
 */

Route::get('/courses/main_controller/all', 'MainCategoryController@index');
Route::get('/courses/main_controller/show/{id}', 'MainCategoryController@show');
Route::post('/courses/main_controller/store', 'MainCategoryController@store');
Route::post('/courses/main_controller/update', 'MainCategoryController@update');
Route::post('/courses/main_controller/destroy/{id}', 'MainCategoryController@destroy');

/**
 * Sub Category api
 */

Route::get('/courses/sub_controller/all', 'SubCategoryController@index');
Route::get('/courses/sub_controller/show/{id}', 'SubCategoryController@show');
Route::post('/courses/sub_controller/store', 'SubCategoryController@store');
Route::post('/courses/sub_controller/update', 'SubCategoryController@update');
Route::post('/courses/sub_controller/destroy/{id}', 'SubCategoryController@destroy');

// //////////////////////////////////////////////////////////////////////////////////

Route::POST('/courses/play', 'UserCourseController@play');

Route::get('/courses/get_enrolled_course', 'UserCourseController@getEnrolledCourse');
Route::POST('/courses/enroll', 'UserCourseController@enroll');

Route::post('/courses/check_enrolled', 'UserCourseController@checkIfEnrolled');

Route::post('/courses/review', 'ReviewController@store');
Route::get('/courses/review/{id}', 'ReviewController@show');
Route::post('/courses/review/check', 'ReviewController@check');
Route::delete('/courses/review/{id}', 'ReviewController@destroy');
/*
 *
 * FREE COURSES END POINT
 *
 */

Route::get('/course/tutor/{id}', 'UserCourseController@fetchByTutor');

// SHOW COURSE

Route::get('/courses/{slug}', 'UserCourseController@show');

// RATE COURSE

Route::post('/courses/rate', 'CourseController@Rating');

// FETCH COURSE

Route::get('/courses/get/{number}', 'UserCourseController@get');

// FETCH PINNACLE ONLINE COURSE

Route::get('/courses/get/PO/{number}', 'UserCourseController@getPO');

// FETCH ALL CAREER OF THE FUTURE COURSES

Route::get('/courses/get/COTF/{number}', 'UserCourseController@getCOTF');

// FETCH PINNACLE ONLINE FREE COURSE

Route::get('/courses/get/PO/FREE/{number}', 'UserCourseController@get_free_PO_courses');

// FETCH  FREE CAREER FOR THE FUTURE FREE COURSE

Route::get('/courses/get/Career/FREE/{number}', 'UserCourseController@get_free_Career_courses');

// FETCH FREE COURSES

Route::get('/courses/get/FREE/{number}', 'UserCourseController@getFREE');

// GET RECOMMENDED COURSES BY CATEGORY

Route::get('/courses/recommendations/{category}', 'UserCourseController@getRecommendedCourses');

// GET RECOMMENDED COURSES BY USER

Route::get('/courses/recommendations/user/{userId}', 'UserCourseController@getRecommendedCoursesByUser');

/****
 *
 * PAID COURSES END POINT
 *
 */
Route::get('/courses/get/PO/paid/{number}', 'PaidCourseController@get_paid_PO_courses');

// Admin
Route::get('/auth/admin', 'AdminController@getAdmin');
