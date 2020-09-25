<?php

namespace App\Observers;

use App\CourseMaterials;
use App\userCourseProgress;
use App\UserQuizResult;

class UserQuizResultObserver
{
    /**
     * Handle the user quiz result "created" event.
     *
     * @param  \App\UserQuizResult  $userQuizResult
     * @return void
     */
    public function created(UserQuizResult $userQuizResult)
    {
        $CourseMaterials = CourseMaterials::where('id', $userQuizResult->module_id)->with('Module')->first();
        $userCourseProgress = auth()->user()->userCourseProgress()->where('course_id', $userQuizResult->module_id)->first();
        $userCourseProgress->update([
            'current' => $userQuizResult->module_id,
            'finished' => $userCourseProgress->total_module == count($CourseMaterials) ? true : false,
        ]);

    }

    /**
     * Handle the user quiz result "updated" event.
     *
     * @param  \App\UserQuizResult  $userQuizResult
     * @return void
     */
    public function updated(UserQuizResult $userQuizResult)
    {
        //
    }

    /**
     * Handle the user quiz result "deleted" event.
     *
     * @param  \App\UserQuizResult  $userQuizResult
     * @return void
     */
    public function deleted(UserQuizResult $userQuizResult)
    {
        //
    }

    /**
     * Handle the user quiz result "restored" event.
     *
     * @param  \App\UserQuizResult  $userQuizResult
     * @return void
     */
    public function restored(UserQuizResult $userQuizResult)
    {
        //
    }

    /**
     * Handle the user quiz result "force deleted" event.
     *
     * @param  \App\UserQuizResult  $userQuizResult
     * @return void
     */
    public function forceDeleted(UserQuizResult $userQuizResult)
    {
        //
    }
}
