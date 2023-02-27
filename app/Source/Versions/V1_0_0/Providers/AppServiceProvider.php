<?php

namespace Api\V1_0_0\Providers;

use Api\V1_0_0\Models\Advertisement;
use Api\V1_0_0\Models\Document;
use Api\V1_0_0\Models\EventAnnouncement;
use Api\V1_0_0\Models\Service;
use Api\V1_0_0\Models\User;
use Api\V1_0_0\Models\VisitorLog;
use Api\V1_0_0\Models\Answer;
use Api\V1_0_0\Models\Option;
use Api\V1_0_0\Models\Question;
use Api\V1_0_0\Models\Response;
use Api\V1_0_0\Models\Survey;
use Illuminate\Database\Eloquent\Relations\Relation;
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

        Relation::morphMap([
            'services' => Service::class,
            'users' => User::class,
            'visitor_logs' => VisitorLog::class,
            'event_announcements' => EventAnnouncement::class,
            'advertisements' => Advertisement::class,
            'documents' => Document::class,
            'answers' => Answer::class,
            'options' => Option::class,
            'questions' => Question::class,
            'responses' => Response::class,
            'surveys' => Survey::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


    }
}
