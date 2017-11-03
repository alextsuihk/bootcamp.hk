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
            $myQuestions = Question::getMyQuestions();
            $openQuestions = Question::getOpenQuestions();
            $newQuestions = Question::getnewQuestions();
            $myNewComments = Comment::getMyNewComments();
            $myCurrentLessons = Lesson::getMyCurrentLessons();
            $myFutureLessons = Lesson::getMyFutureLessons();
            $newLessons = Lesson::getNewLessons();
            $allLessons = Lesson::getAllLessons();
            $newUsers = User::getNewUsers();
            

            $view->with('myQuestions', $myQuestions)
            ->with('openQuestions', $openQuestions)
            ->with('myNewComments', $myNewComments)
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
