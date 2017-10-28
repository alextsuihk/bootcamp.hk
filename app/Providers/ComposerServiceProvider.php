<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Lesson;

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
            $myQuestions = 'wip';
            $myCurrentLessons = Lesson::getMyCurrentLessons();
            $myFutureLessons = Lesson::getMyFutureLessons();
            $newLessons = Lesson::getNewLessons();
            $newQuestions = 'wip3';

            $view->with('myQuestions', $myQuestions)
            ->with('myCurrentLessons', $myCurrentLessons)
            ->with('myFutureLessons', $myFutureLessons)
            ->with('newLessons', $newLessons)
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
