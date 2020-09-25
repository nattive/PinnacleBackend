<?php

namespace App\Providers;

use App\Course;
use App\Observers\CourseObserver;
use App\Observers\UserQuizResultObserver;
use App\UserQuizResult;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Course::observe(CourseObserver::class);
        UserQuizResult::observe(UserQuizResultObserver::class);
    }
}
