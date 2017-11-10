<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Lesson;
use App\Comment;
use App\Question;
use App\User; 

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.sidebar', function ($view) {      // View Composer feature
            $myQuestions = Question::getMyQuestionCount();
            $openQuestions = Question::getOpenQuestionCount();
            $newQuestions = Question::getNewQuestionCount();
            $myNewComments = Comment::getMyNewCommentCount();
            $myPastLessons = Lesson::getMyPastLessonCount();
            $myCurrentLessons = Lesson::getMyCurrentLessonCount();
            $myFutureLessons = Lesson::getMyFutureLessonCount();
            $newLessons = Lesson::getNewLessonCount();
            $allLessons = Lesson::getAllLessonCount();
            $newUsers = User::getNewUserCount();
            

            $view->with('myQuestions', $myQuestions)
            ->with('openQuestions', $openQuestions)
            ->with('myNewComments', $myNewComments)
            ->with('myPastLessons', $myPastLessons)
            ->with('myCurrentLessons', $myCurrentLessons)
            ->with('myFutureLessons', $myFutureLessons)
            ->with('newLessons', $newLessons)
            ->with('allLessons', $allLessons)
            ->with('newUsers', $newUsers)
            ->with('newQuestions', $newQuestions);
        });                 
        // whenever viewing partials.sidebar, this callback is executed
        // binding to the view
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
