<?php




$router->group(['middleware' => ['auth:api','client']], function ($router) {

    /** @var TYPE_NAME $router */
    $router->resources([
        "files" => "FileController",
        "bookings" => "BookingController",
        "services" => "ServiceController",
        "visitor-logs" => "VisitorLogController",
        "event-announcements" => "EventAnnouncementController",
        "advertisements" => "AdvertisementController",
        "documents" => "DocumentController",
        "user-settings" => "UserSettingController",
        "inquiries" => "InquiryController",
        "user-details" => "UserDetailController",
        "answers" => "AnswerController",
        "options" => "OptionController",
        "questions" => "QuestionController",
        "responses" => "ResponseController",
        "surveys" => "SurveyController",
    ]);

    $router->get('services/date-availabilities/{id}', 'ServiceController@dateAvailabilities');
    // $router->get('payments', 'PaymentContoller@test');
    $router->group(['prefix' => "files"], function ($router) {

        $router->post('upload', 'FileController@upload');
    });
});
$router->resources([
    "advertisements" => "AdvertisementController"
]);
