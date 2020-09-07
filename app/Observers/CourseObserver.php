<?php

namespace App\Observers;

use App\Course;
use App\Tutor;

class CourseObserver
{
    /**
     * Handle the course "created" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function created(Course $course)
    {
        $user = \auth()->user();
        $tutor = \auth()->user()->tutor;
        $tutor = Tutor::findOrFail($tutor -> id);
        $user->tutor->courseActivities()->create([
            'title' => 'You created a new course',
            'body' => 'You created a new course: '. $course -> title .' with course code:'. $course -> courseCode  ,
        ]);
    }

    /**
     * Handle the course "updated" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function updated(Course $course)
    {
        //
    }

    /**
     * Handle the course "deleted" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function deleted(Course $course)
    {
        //
    }

    /**
     * Handle the course "restored" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function restored(Course $course)
    {
        //
    }

    /**
     * Handle the course "force deleted" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function forceDeleted(Course $course)
    {
        //
    }
}
