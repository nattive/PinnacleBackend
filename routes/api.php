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

    /**
     * category
     */
    Route::post('main_controller/store', 'MainCategoryController@store');
    Route::post('main_controller/update', 'MainCategoryController@update');
    Route::post('main_controller/destroy/{id}', 'MainCategoryController@destroy');

    Route::post('/', 'SubCategoryController@store');
    Route::put('/{id}', 'SubCategoryController@update');
    Route::delete('/{id}', 'SubCategoryController@destroy');

    Route::group(['prefix' => 'testimonial'], function () {
        Route::get('/', 'TestimonialController@index');
        Route::post('/', 'TestimonialController@store');
        Route::delete('{id}', 'TestimonialController@destroy');
    });

    Route::group(['prefix' => 'blog'], function () {
        Route::post('/', 'BlogPostController@store');
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'BlogCategoryController@index');
            Route::get('{category}', 'BlogCategoryController@show');
            Route::post('/', 'BlogCategoryController@store');
        });

    });

    Route::group(['prefix' => 'course'], function () {
        Route::get('/', 'AdminCourseController@courses');

    });

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
        Route::GET('/', 'CourseDiscountController@index');

    });
    Route::group(['prefix' => 'courses'], function () {
        Route::get('{slug}', 'CourseController@show');
        Route::put('{id}', 'CourseController@update');
        Route::post('upload-course/basic', 'CourseController@basicCourseInfo');
        Route::delete('delete/{id}', 'CourseController@destroy');
        Route::get('/', 'TutorCourseController@myCourses');

        Route::group(['prefix' => 'module'], function () {
            Route::post('/', 'CourseModules@store');
            Route::get('show/{id}', 'CourseModules@show');
            Route::put('/update/{id}', 'CourseModules@update');
            Route::get('get/{id}', 'CourseModules@index');
        });

        Route::group(['prefix' => 'materials'], function () {
            Route::post('/', 'CourseMaterialsController@store');
            Route::get('{slug}', 'TutorCourseController@show');
            Route::get('show/{id}', 'CourseMaterialsController@show');

        });

        Route::group(['prefix' => 'quiz'], function () {
            Route::POST('/', 'CourseQuestionController@store');
            Route::put('/', 'CourseQuestionController@update');
        });
    });

});

/**
 *
 * All End point pretending to the user side
 *
 */

Route::group(['prefix' => 'user', ['middleware' => ['auth:api']]], function () {
    Route::group(['prefix' => 'message'], function () {
        Route::post('send', 'UserMessageController@send');

    });
    Route::group(['prefix' => 'notification'], function () {
        Route::get('/', 'userNotificationController@index');
        Route::get('/read/{id}', 'userNotificationController@read');

    });
    Route::group(['prefix' => 'Coachee'], function () {
        Route::post('/', 'MenteeController@store');
    });

    Route::group(['prefix' => 'course'], function () {
        Route::group(['prefix' => 'quiz'], function () {
            Route::POST('/', 'UserQuizResultController@store');
            Route::get('userHasTakenQuiz/{id}', 'UserQuizResultController@userHasTakenQuiz');
        });
        Route::get('top-rated', 'UserCourseController@topRated');
        Route::get('progress', 'UserCourseProgressController@index');
        Route::get('/', 'CourseController@index');
        Route::get('play/{id}', 'UserCourseController@play');
        Route::group(['prefix' => 'enroll'], function () {
            Route::get('/', 'CourseEnrollController@index');
            Route::POST('/', 'CourseEnrollController@store');
            Route::post('check', 'UserCourseController@checkIfEnrolled');
        });
        Route::group(['prefix' => 'review'], function () {
            Route::post('/', 'ReviewController@store');
            Route::get('{id}', 'ReviewController@show');
            Route::post('/check', 'ReviewController@check');
            Route::delete('/{id}', 'ReviewController@destroy');
        });
        Route::group(['prefix' => 'comment'], function () {
            Route::post('/', 'CommentController@store');
            Route::put('{id}', 'CommentController@update');
            Route::get('{id}', 'CommentController@index');
            Route::delete('{id}', 'CommentController@destroy');
        });
        Route::group(['prefix' => 'reply'], function () {
            Route::post('/', 'ReplyController@store');
            Route::delete('{id}', 'ReplyController@destroy');
        });
        Route::group(['prefix' => 'wishlist'], function () {
            Route::get('/', 'WishlistController@index');
            Route::post('/', 'WishlistController@store');
            Route::delete('{id}', 'WishlistController@destroy');
        });

    });

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/', 'CourseCartController@index');
        Route::get('/{id}', 'CourseCartController@store');
    });
});

Route::group(['prefix' => 'volunteer'], function () {
    Route::get('/', 'TestimonialController@index');
});
Route::group(['prefix' => 'testimonial'], function () {
    Route::get('{location}', 'TestimonialController@show');
});

Route::group(['prefix' => 'post'], function () {
    Route::get('search/{query}', 'SearchController@searchBlog');
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'BlogPostController@category');
    });
    Route::get('/', 'BlogPostController@index');
    Route::get('{slug}', 'BlogPostController@show');
});

/**
 * Main Category api
 */
Route::group(['prefix' => 'course'], function () {
    Route::get('recommendations/user/{userId}', 'UserCourseController@getRecommendedCoursesByUser');
    Route::get('get/PO/paid/{number}', 'PaidCourseController@get_paid_PO_courses');
    Route::get('/', 'CourseController@index');
    Route::get('search/{query}', 'SearchController@search');
    Route::get('category/main', 'MainCategoryController@index');
    Route::get('category/sub', 'SubCategoryController@index');
    Route::get('category/main/{id}', 'MainCategoryController@show');
    Route::get('coft/categories', 'CoFCategoryController@index');
    Route::get('{slug}', 'UserCourseController@show');
    Route::get('tutor/{id}', 'UserCourseController@fetchByTutor');
    Route::group(['prefix' => 'sub_category'], function () {
        Route::get('/', 'SubCategoryController@index');
        Route::get('/{id}', 'SubCategoryController@show');
    });
    Route::post('recommendations', 'UserCourseController@recommendations');
    Route::post('rate', 'CourseController@Rating');

});

// RATE COURSE

// FETCH COURSE

// Route::get('/courses/get/{number}', 'UserCourseController@get');

// // FETCH PINNACLE ONLINE COURSE

// Route::get('/courses/get/PO/{number}', 'UserCourseController@getPO');

// // FETCH ALL CAREER OF THE FUTURE COURSES

// Route::get('/courses/get/COTF/{number}', 'UserCourseController@getCOTF');

// // FETCH PINNACLE ONLINE FREE COURSE

// Route::get('/courses/get/PO/FREE/{number}', 'UserCourseController@get_free_PO_courses');

// // FETCH  FREE CAREER FOR THE FUTURE FREE COURSE

// Route::get('/courses/get/Career/FREE/{number}', 'UserCourseController@get_free_Career_courses');

// // FETCH FREE COURSES

// Route::get('/courses/get/FREE/{number}', 'UserCourseController@getFREE');

// GET RECOMMENDED COURSES BY CATEGORY

// GET RECOMMENDED COURSES BY USER

/****
 *
 * PAID COURSES END POINT
 *
 */

// Admin
Route::get('/auth/admin', 'AdminController@getAdmin');
